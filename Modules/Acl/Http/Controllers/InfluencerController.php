<?php

namespace Modules\Acl\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Export\InfluencerExport;
use Modules\Acl\Export\MissingInfluencersExport;
use Modules\Acl\Http\Requests\Influencer\CreateRequest;
use Modules\Acl\Http\Requests\Influencer\EditRequest;
use Modules\Acl\Http\Requests\Influencer\MergeRequest;
use Modules\Acl\Import\InfluencerImport;
use Modules\Acl\Service\InfluencerService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller user about web function
 */
class InfluencerController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(InfluencerService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_influencers')->only('index');
        $this->middleware('permission:export_influencers')->only('export');
        $this->middleware('permission:create_influencers')->only('create');
        $this->middleware('permission:create_influencers')->only('store');
        $this->middleware('permission:update_influencers')->only('edit');
        $this->middleware('permission:update_influencers')->only('update');
        $this->middleware('permission:delete_influencers')->only('destroy');
        $this->middleware('permission:upload_image_influencers')->only('getImage');
        $this->service = $Service;
    }

    /**
     * @param Request $request
     * @return View
     * get all user to manage it
     */
    public function index(Request $request)
    {
        if(gettype($request->country_id) == 'string')
        {
            $request->merge(['country_id' => json_decode($request->country_id, 1)]);
        }
        if(gettype($request->category) == 'string')
        {
            $request->merge(['category' => json_decode($request->category, 1)]);
        }
        if(gettype($request->size) == 'string' || gettype($request->size) == 'int')
        {
            $request->merge(['size' => json_decode($request->size, 1)]);
        }
        $perPage = !isset(Request()->perPage) ? 12 : Request()->perPage;
        $condation = [];
        if(!empty($request->search))
        {
            if(substr($request->search, 0, 1) === "i" || substr($request->search, 0, 1) === "I")
            {
                $condation = [
                    'where' => [
                        'id' => substr($request->search, 1)
                    ]
                ];
            }else
            {
                $condation = [
                    'where' => [
                        'name_en' => $request->search
                    ],
                    'orWhere' => [
                        'name_ar' => $request->search
                    ]
                ];
            }
        }
        $datas = $this->service->findBy($request, $condation
            , '', ['*'], true, $perPage, [], ['ad_record']);
        $countries = $this->service->countryListCreated();
        $category = $this->service->categoryListCreated();
        $size = $this->service->sizeList();
        if($request->ajax())
        {
            return view(checkView('acl::influencer.table'), compact('datas', 'countries', 'category', 'size'));
        }
        return view(checkView('acl::influencer.index'), compact('datas', 'countries', 'category', 'size'));
    }

    public function create(Request $request)
    {
        $country = $this->service->countryList();
        $category = $this->service->categoryList($request);
        $platform = $this->service->platformList();
        $size = $this->service->sizeList();
        $industry = $this->service->industryList($request);
        return view('acl::influencer.create',
            compact('country', 'category', 'platform', 'industry', 'size'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('influencer.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer.edit'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $country = $this->service->countryList();
        $category = $this->service->categoryList($request);
        $industry = $this->service->industryList($request);
        $platform = $this->service->platformList();
        $size = $this->service->sizeList();
        $data = $this->service->show($id);
        return view('acl::influencer.edit',
            compact('country', 'category', 'platform', 'size', 'industry', 'data'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('influencer.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer.edit'))->with(getCustomTranslation('problem'));
    }

    public function show(Request $request, $id)
    {
        if(user()->can('view_influencers'))
        {
        $data = $this->service->show($id);
        if(empty($request->rang_data_analysis))
        {
            $start_access = user()->start_access;
            $end_access = user()->end_access;
            if($start_access && $end_access)
            {
                $s =  Carbon::now()->subDays(14)->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::now()->subDays(14);
                $request->merge(['rang_data_analysis' => $s->format('m/d/Y') . " - " . $end_access]);
            }elseif($start_access)
            {
                $s =  Carbon::now()->subDays(14)->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::now()->subDays(14);
                $request->merge(['rang_data_analysis' => $s->format('m/d/Y') . " - " . Carbon::today()->format('m/d/Y')]);
            }elseif($end_access)
            {
                $e =  Carbon::now()->isAfter($end_access) ? Carbon::parse($end_access) : Carbon::now();
                $request->merge(['rang_data_analysis' => $e->subDays(14)->format('m/d/Y') . " - " . $e]);
            }else{
            $request->merge(['rang_data_analysis' => Carbon::now()->subDays(30)
                    ->format('m/d/Y') . " - " . Carbon::today()->format('m/d/Y')]);
            }
        }
        if($data)
        {
            $data->influencer_follower_platform = $data->influencer_follower_platform->sortBy('platform.order');
            $data = $this->service->adRecordInsight($request, $data);
            return view(checkView('acl::influencer.show'), compact('data'));
        }
        return view('errors.404');
        }
        abort(403);
    }

    public function discover(Request $request)
    {
        $countries = $this->service->countryListCreated();
        $genders = genderType();
        $sizes = $this->service->sizeList();
        $categories = $this->service->categoryList($request);
        $platforms = $this->service->platformList();
        $influencers = $this->service->search($request, true, $this->perPage());
        $search = $request->search ?? "";
        $campaigns = $this->service->campaignList();
        return view(checkView('acl::influencer.discover'),
            compact('influencers', 'search', 'campaigns', 'countries', 'sizes', 'genders', 'platforms', 'categories'));
    }

    public function uniqueInfluencers(Request $request)
    {
        // Url shold have atleast company id
        if(!$request->company_id || $request->company_id == null)
        {
            return redirect(route('reports.competitive_analysis'));
        }
        $start_date = $this->service->range_start_date();
        $end_date = $this->service->range_end_date();
        $sorting = $request->sorting ?? 'desc';
        // this to get for fix issue and we can update this logic after discuss about it
        if(!$request->ranges || $request->ranges == null)
        {
            $start_date = Carbon::createFromFormat('Y-m-d', '2000-01-01');
            $end_date = now();
        }
        $perPage = $this->perPage();
        $datas = $this->service->getUniqueInfluencers($request, $start_date, $end_date, $perPage);
        if($request->ajax())
        {
            return view(checkView('acl::influencer.unique.tableuniqueInfluencers'),
                compact('datas', 'start_date', 'end_date','sorting'));
        }
        return view(checkView('acl::influencer.unique.uniqueInfluencers'), compact('datas','sorting', 'start_date', 'end_date'));
    }

    public function InfluencersByids(Request $request)
    {
        $page = $request->page ?? 1;
        $datas = $this->service->getInfluencersByids($request,perPage:$this->perPage(),page:$page);
        $sorting = $request->sorting ?? 'desc';
        if($request->ajax())
        {
            return view(checkView('acl::influencer.byIds.table'),
                compact('datas','sorting'));
        }
        return view(checkView('acl::influencer.byIds.influencersByids'), compact('datas','sorting'));
    }

    public function searchDiscover(Request $request)
    {
        $data = $this->service->searchDiscover($request);
        return response()->json($data);
    }

    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }

    public function linkTracker(Request $request)
    {
        return $this->service->linkTracker($request);
    }

    public function discoverExport(Request $request)
    {
        return Excel::download(new InfluencerExport($request), date("d-m-y") . '-' . time() . '-InfluencerExport.xlsx');
    }

    public function discoverCalander(Request $request)
    {
        return $this->service->discoverCalander($request);
    }

    public function importView(Request $request)
    {
        $request = $request->all();
        if(isset($request['check_status']))
        {
            return response()->json(["importing_in_progress" => session()->get('importing_in_progress')]);
        }
        return view(checkView('acl::influencer.importFile'));
    }

    public function import(Request $request)
    {
        // todo remove validation from the controller
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        if($validator->fails())
        {
            session()->put('bad', getCustomTranslation('you_must_import_the_file_first'));
            return redirect()->to("/acl/influencer/files/import");
        }
        try
        {
            $influencerImport = new InfluencerImport;
            Excel::import($influencerImport, $request->file('file')->store('files'));
            if($influencerImport->rows)
            {
                return Excel::download(new MissingInfluencersExport($influencerImport->rows), 'missing_data.xlsx');
            }else
            {
                session()->put('message', getCustomTranslation('importing_is_finished_successfully'));
                return redirect()->to("/acl/influencer/files/import");
            }
        }catch(\Exception $e)
        {
            session()->put('bad', $e->getMessage());
            return redirect()->to("/acl/influencer/files/import");
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new InfluencerExport($request), 'influencers.xlsx');
    }

    public function search(Request $request)
    {
        $data = $this->service->search($request, all: true);
        return response()->json($data);
    }

    /**
     * @return void
     */
    public function delete_all()
    {
        DB::statement("SET foreign_key_checks=0");
        Influencer::truncate();
        DB::statement("SET foreign_key_checks=1");
    }

    public function mergeInfo(Request $request, $id)
    {
        $country = $this->service->countryList();
        $category = $this->service->categoryList($request);
        $industry = $this->service->industryList($request);
        $platform = $this->service->platformList();
        $size = $this->service->sizeList();
        $data = $this->service->show($id);
        return view('acl::influencer.merge.merge',
            compact('country', 'category', 'platform', 'size', 'industry', 'data'));
    }

    public function mergeGet(Request $request)
    {
        $country = $this->service->countryList();
        $category = $this->service->categoryList(new Request());
        $industry = $this->service->industryList(new Request());
        $platform = $this->service->platformList();
        $size = $this->service->sizeList();
        $data = $this->service->show($request->id);
        return view('acl::influencer.merge.influencer',
            compact('country', 'category', 'platform', 'size', 'industry', 'data'));
    }

    public function mergeSearch(Request $request)
    {
        $data = $this->service->searchMerge($request);
        return response()->json($data);
    }

    public function merge(MergeRequest $request,$id)
    {
        $this->service->merge($request,$id);
        return redirect(route('influencer.index'))->with("message", getCustomTranslation('merge_done'));
    }

    public function getImage()
    {
        return view('acl::influencer.image.get');
    }

    public function uploadImage(Request $request)
    {
        $data = $this->service->uploadImage($request);
        if($data)
        {
            return redirect(route('influencer.image.get'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer.image.get'))->with(getCustomTranslation('problem'));
    }
}
