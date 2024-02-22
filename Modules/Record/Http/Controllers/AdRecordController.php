<?php

namespace Modules\Record\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Entities\Category;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Export\ExportAdRecord;
use Modules\Record\Http\Requests\AdRecord\CreateRequest;
use Modules\Record\Http\Requests\AdRecord\EditRequest;
use Modules\Record\Http\Requests\AdRecord\FixCategoryRequest;
use Modules\Record\Http\Requests\AdRecord\IndexRequest;
use Modules\Record\Service\AdRecordService;

class AdRecordController extends BasicController
{
    protected $service;

    public function __construct(AdRecordService $Service)
    {
        $this->middleware('permission:view_ad_record')->only(['index', 'show']);
        $this->middleware('permission:export_ad_record')->only('export');
        $this->middleware('permission:create_ad_record')->only(['create','store']);
        $this->middleware('permission:update_ad_record')->only(['edit','update']);
        $this->middleware('permission:delete_ad_record')->only('destroy');
        $this->middleware('permission:duplicate_ad_record')->only('duplicateAd');
        $this->middleware('permission:fix_category_ad_record')->only('fixCategoryAd','fixCategory');
        $this->service = $Service;
    }

    public function index(IndexRequest $request)
    {
        executionTime();
        $range_start = $this->service->range_start_date();
        if($request->start)
        {
            $request->merge(['start' => $range_start]);
        }
        $range_end = $this->service->range_end_date();
        if($request->end)
        {
            $request->merge(['end' => $range_end]);
        }
        $range_creation_start = $this->service->range_creation_start_date();
        if($request->creation_start || $request->creationD_start)
        {
            $request->merge(['creation_start' => $range_creation_start]);
        }
        $range_creation_end = $this->service->range_creation_end_date();
        if($request->creation_end || $request->creationD_end)
        {
            $request->merge(['creation_end' => $range_creation_end]);
        }
        $datas = $this->service->findBy($request, true, $this->perPage(),
            relation: ['company', 'category', 'influencer'],
            orderBy: ['order' => 'desc', 'column' => 'id']);
        $researchers = $this->service->usersList();
        $categories = $this->service->categoryList();
        $platforms = $this->service->platformList();
        if(isset($request->influencer_id))
        {
            $influencers_data = $this->service->influencerList(new request(['id' => $request->influencer_id]));
        }
        if(user()->role->type)
        {
            $categoriesClient = '';
            $categoriesClient = implode(',', $this->service->getCategoriesnamesByUserId());
        }
        if($request->ajax())
        {
            return view(checkView('record::ad_record.table'), get_defined_vars());
        }
        return view(checkView('record::ad_record.index'), get_defined_vars());
    }

    public function show(Request $request, $id)
    {
        $data = $this->service->show($id, withRelations: ['ad_record_errors']);
        if($data)
        {
            $accsseAdReqcord = user()->role->type ? $this->service->accsseAdReqcord($data) : true;
            if($accsseAdReqcord)
            {
                $data->ad_record_log()->create(['type' => 2, 'user_id' => user()->id]);
                $data->date = Carbon::parse($data->date)->format('d-m-Y');
                return view(checkView('record::ad_record.show'), compact('data'));
            }
        }
        return redirect(route('ad_record.index'));
    }

    public function create(Request $request)
    {
        $promotion_type = $this->service->promotionTypeList();
        $country = $this->service->countryListGcc();
        $industry = $this->service->listCompanyIndustry();
        $sites = $this->service->websiteList();
        $data=[];
        if(isset($request->draft) && $request->draft == 1) {
            $data = $this->service->getLastDraft();
        }elseif(isset($request->duplicate_id) && $request->duplicate_id != 0){
            $data = $this->service->show($request->duplicate_id);
            $request->merge(['duplicate_id' => 0]);
        }elseif(isset($request->duplicate_draft_id) && $request->duplicate_draft_id != 0){
            $data = $this->service->show($request->duplicate_draft_id);
            $request->merge(['duplicate_draft_id' => 0]);
        } else {
            $data = $this->service->findBy(new Request(['user_id' => user()->id]), get: 'first', latest: 'latest');
        }
        return view(checkView('record::ad_record.create'), get_defined_vars());
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('ad_record.create'))->with('message', getCustomTranslation('done'));
        }
        return redirect(route('ad_record.create'))->with('message_false', getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id, withRelations: ['ad_record_errors', 'service']);
        $country = $this->service->countryList();
        $countrygcc = $this->service->countryListGcc();
        $promotion_type = $this->service->promotionTypeList();
        $industry = $this->service->listCompanyIndustry();
        $sites = $this->service->websiteList();
        return view(checkView('record::ad_record.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            if(isset($request->duplicate) && $request->duplicate == 1){
                return redirect(route('ad_record.create',['duplicate_id' => $id]));
            }
            if(isset($request->duplicate_draft)  && $request->duplicate_draft == 1){
                return redirect(route('ad_record.create',['duplicate_draft_id' => $id]));
            }
            return redirect(route('ad_record.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('ad_record.edit'))->with(getCustomTranslation('problem'));
    }

    public function importView(Request $request)
    {
        $path = storage_path('app');
        $filesInFolder = file_exists($path . '/ad_record_import_in_progress.txt') ? \File::files($path) : [];
        $count = count($filesInFolder);
        $import_in_progress = 0;
        /** @noinspection PhpUndefinedMethodInspection */
        if(file_exists($path) and $count) {
            session()->put('message', getCustomTranslation('importing_is_still_in_progress_please_wait'));
            $import_in_progress = 1;
        }
        $request = $request->all();
        if(isset($request['check_status']))
        {
            return response()->json(["importing_in_progress" => session()->get('importing_in_progress')]);
        }
        return view(checkView('record::ad_record.importFIle'), compact('import_in_progress'));
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), ['file' => 'required']);
        if($validator->fails())
        {
            return response()->json(['error' => true]);
        }
        executionTime();
        Storage::put('ad_record_import_in_progress.txt', date('m-d-Y_hia'));
        Storage::put('records_import.txt', $request->file('file')->store('files'));
        shell_exec("php " . base_path() . "/artisan import:record &");
        return response()->json(["message" => getCustomTranslation('import_in_progress_please_wail_until_finish')]);
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportAdRecord($request), "ad_records.xlsx");
    }

    public function download(Request $request)
    {
        $path = storage_path('app/missing/records');
        $filesInFolder = \File::files($path);
        $count = count($filesInFolder);
        if(file_exists($path) and $count)
        {
            $array = pathinfo($filesInFolder[$count - 1]);
            return response()->download($path . "/" . $array['basename']);
        }else
        {
            return redirect(route('ad_record.import'))->with("message", getCustomTranslation('no_missing_data_found'));
        }
    }

    public function file_names()
    {
        $path = storage_path('app/missing/records');
        $filesInFolder = \File::files($path);
        foreach($filesInFolder as $path)
        {
            $file = pathinfo($path);
            echo "<pre/>";
            var_dump($file);
        }
    }

    public function status()
    {
        $path = storage_path('app');
        $filesInFolder = file_exists($path . '/ad_record_import_in_progress.txt') ? \File::files($path) : [];
        $count = count($filesInFolder);
        /** @noinspection PhpUndefinedMethodInspection */
        if(file_exists($path) and $count) {
            return response()->json(['done' => 0, "message" => getCustomTranslation('import_in_progress_please_wail_until_finish')]);
        }else
        {
            return response()->json(["done" => 1, "message" => getCustomTranslation('import_is_done_successfully')]);
        }
    }

    public function getFiles(Request $request)
    {
        $influencer = $this->service->getInfluencer($request->influencer_id);
        $platform_id = $this->service->getPlatform();
        $userName = $influencer->influencer_follower_platform()->where('platform_id', $platform_id)->first();
        $files = [];
        if($userName)
        {
            $userName = $userName->url;
            $date = $request->date;
            $directory = '/' . $userName . '/' . $date;
            $files = Storage::disk('s3')->allFiles($directory);
        }
        $mediaS3 = $request->mediaS3 ?? [];
        if($request->ad_record_id)
        {
            $ad = $this->service->show($request->ad_record_id);
            $mediaS3=$ad->mediasS3->count() ? $ad->mediasS3->pluck('file')->toArray() : [];
        }
        return view(checkView('record::ad_record.displayDataFromS3'), ['files' => $files, 'mediaS3' => $mediaS3]);
    }

    public function deleteOne($id)
    {
        $data = $this->service->delete($id);
        if($data)
        {
            return redirect(route('ad_record.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('ad_record.show', $id))->with(getCustomTranslation('problem'));
    }

    public function checkDuplicates(Request $request)
    {
        $datas = $this->service->checkDuplicates($request);
        if(count($datas) == 0){
            return null;
        } else {
            return view(checkView('record::ad_record.ads_table'), ['datas' => $datas]);
        }
    }
    #todo change Code
    public function duplicateAd(Request $request)
    {
        executionTime();
        $range_start = $this->service->range_start_date();
        if($request->start)
        {
            $request->request->add(['start' => $range_start]);
        }
        $range_end = $this->service->range_end_date();
        if($request->end)
        {
            $request->request->add(['end' => $range_end]);
        }
        $categories = $this->service->categoryList();
        $platforms = $this->service->platformList();
        $duplicates = DB::table('ad_records');
        if(isset($request->platform_id) && !empty($request->platform_id))
        {
            $duplicates=$duplicates->whereIn('platform_id',$request->platform_id);
        }
        if(isset($request->start) && !empty($request->start) && isset($request->end) && !empty($request->end))
        {
            $duplicates = $duplicates->whereBetween('date' , [$request->start, $request->end]);
        }
        if(isset($request->influencer_id) && !empty($request->influencer_id))
        {
            $duplicates=$duplicates->whereIn('influencer_id',$request->influencer_id);
        }
        if(isset($request->company_ids) && !empty($request->company_ids))
        {
            $duplicates=$duplicates->whereIn('company_id',$request->company_ids);
        }
        if(isset($request->category) && !empty($request->category))
        {

            $duplicates=$duplicates->join('ad_record_categories', 'ad_records.id', '=', 'ad_record_categories.ad_record_id')
                ->wherein('ad_record_categories.category_id', $request->category);
        }
        $duplicates=$duplicates->select('date', 'influencer_id', 'company_id','platform_id')
            ->havingRaw('COUNT(*) > 1')
            ->groupBy('date', 'influencer_id', 'company_id','platform_id')
            ->paginate($this->perPage());

        $datas=['duplicates'=>$duplicates,'table'=>[]];
        if ($duplicates->isNotEmpty()) {
            foreach ($duplicates as $duplicate) {
                // Append additional columns to the duplicate rows
                $datas['table'][] = AdRecord::where('date', $duplicate->date)
                    ->where('influencer_id', $duplicate->influencer_id)
                    ->where('company_id', $duplicate->company_id)
                    ->where('platform_id', $duplicate->platform_id)
                    ->get();
            }
        }
        if($request->ajax())
        {
            return view(checkView('record::ad_record.duplicate.table'), get_defined_vars());
        }
        return view(checkView('record::ad_record.duplicate.index'), get_defined_vars());
    }

    public function readFiles(Request $request)
    {
        return $this->service->readFiles($request);
    }

    public function fixCategoryAd()
    {
        $categories = $this->service->categoryList();
        return view(checkView('record::ad_record.fix.category.index'), get_defined_vars());
    }

    public function fixCategory(FixCategoryRequest $request)
    {
        $this->service->fixCategory($request);
        $categories = $this->service->categoryList();
        return view(checkView('record::ad_record.fix.category.index'), get_defined_vars())->with('message', getCustomTranslation('done'));
    }
}
