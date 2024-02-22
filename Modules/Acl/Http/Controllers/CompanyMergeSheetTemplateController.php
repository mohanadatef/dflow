<?php

namespace Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Entities\CompanyMergeSheetTemplate;
use Modules\Acl\Service\CompanyMergeTemplateService;
use Modules\Basic\Http\Controllers\BasicController;

class CompanyMergeSheetTemplateController extends BasicController
{
    protected $service;

    public function __construct(CompanyMergeTemplateService $Service)
    {
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $data = $this->service->findBy($request, true, $this->perPage());
        if($request->ajax())
        {
            return view(checkView('acl::company.company_merge_template.table'), compact('data', 'request'));
        }
        return view(checkView('acl::company.company_merge_template.index'), compact('data', 'request'));
    }

    public function importView(Request $request)
    {
        $data = $this->service->findBy($request, false, get: 'count');
        if($data == 0)
        {
            $import_in_progress = 0;
            /** @noinspection PhpUndefinedMethodInspection */
            if(Storage::has("companies_merge_import_in_progress.txt"))
            {
                session()->put('message', getCustomTranslation('importing_is_still_in_progress_please_wait'));
                $import_in_progress = 1;
            }
            $request = $request->all();
            if(isset($request['check_status']))
            {
                return response()->json(["importing_in_progress" => session()->get('importing_in_progress')]);
            }
            return view(checkView('acl::company.company_merge_template.import_file'), compact('import_in_progress'));
        }
        return redirect(route('company_merge_template.index'));
    }

    public function status()
    {
        /** @noinspection PhpUndefinedMethodInspection "Storage::has" */
        if(Storage::has("companies_import_in_progress.txt"))
        {
            return response()->json(['done' => 0, "message" => getCustomTranslation('import_in_progress_please_wail_until_finish')]);
        }else
        {
            return response()->json(["done" => 1, "message" => getCustomTranslation('import_is_done_successfully')]);
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), ['file' => 'required']);
        if($validator->fails())
        {
            return response()->json(['error' => true]);
        }
        executionTime();
        Storage::put('companies_merge_import.txt', $request->file('file')->store('files'));
        Storage::put('companies_merge_import_in_progress.txt', date('m-d-Y_hia'));
        $companiesMergeImport = new \Modules\Acl\Import\CompaniesTemplateImport;
        session()->put('companies', []);
        $content = Storage::get("companies_merge_import.txt");
        Excel::import($companiesMergeImport, $content);
        Storage::delete('companies_import.txt');
        return redirect()->route('/')->with('success', getCustomTranslation('uploading'));
    }

    public function checkDuplicates(Request $request)
    {
        $this->service->checkDuplicates($request);
        return redirect()->back()->with('success', getCustomTranslation('success'));
    }

    public function DeleteAll()
    {
        $this->service->DeleteAll();
        return redirect(route('company_merge_template.import-view'));
    }

    public function merge($id)
    {
        $bool = $this->service->merge($id);
        if($bool) {
            return redirect()->route('company_merge_template.index')->with(['message' => getCustomTranslation('success')]);
        }

        return redirect()->route('company_merge_template.index')->with(['message' => getCustomTranslation('problem')]);
    }

    public function mergeAll()
    {
        $this->service->mergeAll();
        return redirect(route('company_merge_template.index'));
    }
}
