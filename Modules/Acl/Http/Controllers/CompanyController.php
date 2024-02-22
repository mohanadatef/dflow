<?php

namespace Modules\Acl\Http\Controllers;

use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Export\ExportCompany;
use Modules\Acl\Http\Requests\Company\CreateRequest;
use Modules\Acl\Http\Requests\Company\EditRequest;
use Modules\Acl\Http\Requests\Company\MergeRequest;
use Modules\Acl\Http\Resources\Company\CompanyResource;
use Modules\Acl\Http\Resources\Company\CompanySearchResource;
use Modules\Acl\Service\CompanyService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Http\Requests\AdRecordDraft\CreateRequest as cRequest;
use Modules\CoreData\Entities\Category;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Export\ExportAdRecord;
use Illuminate\Support\Facades\DB;
use Modules\Record\Http\Requests\AdRecord\FixCategoryRequest;
use Modules\Record\Http\Requests\AdRecord\IndexRequest;
use Modules\Record\Service\AdRecordService;
 use Modules\Acl\Entities\Company;
class CompanyController extends BasicController
{
    protected $service;
    protected $module = "acl";

    public function __construct(CompanyService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_companies')->only('index');
        $this->middleware('permission:create_companies')->only(['create', 'store']);
        $this->middleware('permission:update_companies')->only(['edit', 'update']);
        $this->middleware('permission:delete_companies')->only('destroy');
        $this->middleware('permission:export_companies')->only('export');
        $this->middleware('permission:merge_template_companies')
            ->only(['merge', 'mergeGetCompany', 'mergeGet', 'mergeSearch', 'mergeInfo']);
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $data = $this->service->findBy($request, true, $this->perPage(), with: ['industry', 'company_website']);
        if($request->ajax())
        {
            return view(checkView('acl::company.table'), compact('data', 'request'));
        }
        return view(checkView('acl::company.index'), compact('data', 'request'));
    }

    public function create()
    {
        $industry = $this->service->listIndustry();
        $request = new Request();
        $sites = $this->service->getWebsites($request);
        return view(checkView('acl::company.create'), compact('industry', 'sites'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('company.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('company.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show((int)$id);
        if($data == null)
        {
            return redirect()->back()->with("message", getCustomTranslation('problem'));
        }
        $sites = $this->service->getWebsites(new Request());
        $industry = $this->service->listIndustry();
        return view(checkView('acl::company.edit'), compact('data', 'industry', 'sites'));
    }

    public function update(EditRequest $request, $id)
    { 
        $data = $this->service->update($request, $id);
        if($data)
        {
            if($request->ajax())
            {
                return new CompanyResource($data);
            }
            return redirect(route('company.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('company.edit', ['id' => $id]))->with(getCustomTranslation('problem'));
    }

    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }

    public function importView(Request $request)
    {
        $path = storage_path('app');
        $filesInFolder = file_exists($path . '/companies_import_in_progress.txt') ? \File::files($path) : [];
        $count = count($filesInFolder);
        $import_in_progress = 0;
        /** @noinspection PhpUndefinedMethodInspection */
        if(file_exists($path) and $count)
        {
            session()->put('message', getCustomTranslation('importing_is_still_in_progress_please_wait'));
            $import_in_progress = 1;
        }
        $request = $request->all();
        if(isset($request['check_status']))
        {
            return response()->json(["importing_in_progress" => session()->get('importing_in_progress')]);
        }
        return view(checkView($this->module . '::company.import_file'), compact('import_in_progress'));
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), ['file' => 'required']);
        if($validator->fails())
        {
            return response()->json(['error' => true]);
        }
        executionTime();
        if(!\File::isDirectory(storage_path('app')))
        {
            \File::makeDirectory(storage_path('app'), 0777, true, true);
        }
        $request->file('file')->move(storage_path('app'), 'companies_import.txt');
        $fileLocation = storage_path('app') . "/companies_import_in_progress.txt";
        $file = fopen($fileLocation, "w");
        $content = " ";
        fwrite($file, $content);
        fclose($file);
        shell_exec("php " . base_path() . "/artisan import:companies &");
        return response()->json(["message" => getCustomTranslation('import_in_progress_please_wail_until_finish')]);
    }

    public function download()
    {
        $path = storage_path('app/missing/companies');
        $filesInFolder = file_exists($path) ? \File::files($path) : [];
        $count = count($filesInFolder);
        if(file_exists($path) and $count)
        {
            $array = pathinfo($filesInFolder[$count - 1]);
            return response()->download($path . "/" . $array['basename']);
        }else
        {
            return redirect(route('company.import'))->with("message", getCustomTranslation('no_missing_data_found'));
        }
    }

    public function status()
    {
        $path = storage_path('app');
        $filesInFolder = file_exists($path . '/companies_import_in_progress.txt') ? \File::files($path) : [];
        $count = count($filesInFolder);
        $import_in_progress = 0;
        /** @noinspection PhpUndefinedMethodInspection */
        if(file_exists($path) and $count)
        {
            return response()->json(['done' => 0, "message" => getCustomTranslation('import_in_progress_please_wail_until_finish')]);
        }else
        {
            return response()->json(["done" => 1, "message" => getCustomTranslation('import_is_done_successfully')]);
        }
    }

    public function allBrands(Request $request)
    {
        if(empty($request->company))
        {
            return redirect(route('reports.competitive_analysis'));
        }
        $data = $this->service->getBrands($request);
        if($request->ajax())
        {
            return view(checkView('acl::company.brands_table'), compact('data', 'request'));
        }
        return view(checkView('acl::company.all-brands'), compact('data', 'request'));
    }

    public function companyByid(Request $request)
    {
        $data = $this->service->companyByid($request);
        return view(checkView('acl::company.companyByids'), compact('data', 'request'));
    }

    public function company_in_categories(Request $request)
    {
        $data = $this->service->company_in_categories($request);
        return response()->json($data);
    }

    public function mergeInfo()
    {
        $industry = $this->service->listIndustry();
        return view(checkView('acl::company.merge.merge'), compact('industry'));
    }
 public function duplicatecompanymergeInfo()
    {
        $industry = $this->service->listIndustry();
        return view(checkView('acl::company.merge.merge'), compact('industry'));
    }

    public function mergeSearch(Request $request)
    {
        $data = $this->service->search($request);
        return response()->json(CompanySearchResource::collection($data));
    }

    public function mergeGet(Request $request)
    {
        $data = $this->service->show($request->id);
        if($data == null)
        {
            return redirect()->back()->with("message", getCustomTranslation('problem'));
        }
        $industry = $this->service->listIndustry();
        $sites = $this->service->getWebsites(new Request());
        return view('acl::company.merge.main', compact('data', 'industry', 'sites'));
    }

    public function mergeGetCompany(Request $request)
    {
        $data = $this->service->findBy($request);
        $sites = $this->service->getWebsites(new Request());
        return view('acl::company.merge.company', compact('data', 'sites'));
    }

    public function merge(MergeRequest $request)
    {
        $this->service->merge($request);
        return redirect(route('company.index'))->with("message", getCustomTranslation('merge_done'));
    } 
	
	
public function mergeduplicate(Request $request)
    { echo "<pre>"; var_dump($request); die(); 
        $validator = Validator::make($request->all());
        if($validator->fails())
        {
            return response()->json(['error' => true]);
        }
        // executionTime();
        // Storage::put('companies_merge_import.txt', $request->file('file')->store('files'));
        // Storage::put('companies_merge_import_in_progress.txt', date('m-d-Y_hia'));
        // $companiesMergeImport = new \Modules\Acl\Import\CompaniesTemplateImport;
        // session()->put('companies', []);
        // $content = Storage::get("companies_merge_import.txt");
        // Excel::import($companiesMergeImport, $content);
        // Storage::delete('companies_import.txt');
        // return redirect()->route('/')->with('success', getCustomTranslation('uploading'));
    }
    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportCompany($request), "company.xlsx");
    }

    public function getEdit(Request $request)
    {
        $data = $this->service->show($request->id);
        if($data == null)
        {
            return redirect()->back()->with("message", getCustomTranslation('problem'));
        }
        $data->url_form = route('company.update', $data->id);
        $sites = $this->service->getWebsites(new Request());
        $industry = $this->service->listIndustry();
        return view('acl::company.ad.form', get_defined_vars());
    }

public function duplicateCompany(Request $request)
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
        // $categories = $this->service->categoryList();
        // $platforms = $this->service->platformList();
        $duplicates = DB::table('companies');
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
		  $data = $this->service->findBy($request, true, $this->perPage(), with: ['industry', 'company_website']);
        $duplicates=$duplicates->select('*')
            ->havingRaw('COUNT(*) > 1')
            ->groupBy('name_en')
            ->paginate($this->perPage());

        $datas=['duplicates'=>$duplicates,'table'=>[]];
        if ($duplicates->isNotEmpty()) {
            foreach ($duplicates as $duplicate) {
                // Append additional columns to the duplicate rows
                $datas['table'][] = Company::where('name_en', $duplicate->name_en)
                    
                    ->get();
            }
        }
		
	 // echo "<pre>";print_r($datas); die();
        if($request->ajax())
        {
          return view(checkView('acl::company.duplicate.table'), get_defined_vars());
        }
        return view(checkView('acl::company.duplicate.index'), get_defined_vars(),compact('data'));
    }

    public function checkCompany(CreateRequest $request)
    {
        return 1;
    }
}
