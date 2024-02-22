<?php

namespace Modules\CoreData\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Import\InfluencerCategoryImport;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportCategory;
use Modules\CoreData\Export\MissingIndustryCategoryExport;
use Modules\CoreData\Export\MissingInfluenceCategoryExport;
use Modules\CoreData\Http\Requests\Category\CreateRequest;
use Modules\CoreData\Http\Requests\Category\EditRequest;
use Modules\CoreData\Import\CategoriesImport;
use Modules\CoreData\Service\CategoryService;

class CategoryController extends BasicController
{
    protected $service;
    private $params = "";

    public function __construct(CategoryService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_categories')->only('index');
        $this->middleware('permission:create_categories')->only('create');
        $this->middleware('permission:create_categories')->only('store');
        $this->middleware('permission:update_categories')->only('edit');
        $this->middleware('permission:update_categories')->only('update');
        $this->middleware('permission:delete_categories')->only('destroy');
        $this->middleware('permission:export_categories')->only('export');
        $this->service = $Service;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        $categories = $this->service->findBy($request, true, $this->perPage(), [], '', [], [], ['parents']);
        if($request->ajax())
        {
            return view(checkView('coredata::category.table'), get_defined_vars());
        }
        return view(checkView('coredata::category.index'), get_defined_vars());
    }

    public function parent(Request $request)
    {
        return $this->service->parent($request);
    }

    public function search(Request $request)
    {
        $request->merge(['search'=>$request->term]);
        $this->service->findBy($request);
        return $this->service->findBy($request,column:['id', 'name_en']);
    }

    public function create(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        $category = $this->service->findBy($request,
            moreConditionForFirstLevel: ['where' => ['parent_id' => null], 'orWhere' => ['parent_id' => 0]]);
        return view(checkView('coredata::category.create'), compact('category'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('category.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('category.create'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $data = $this->service->show($id);
        $category = $this->service->findBy($request,
            moreConditionForFirstLevel: ['where' => ['parent_id' => null,'active' => 1], 'orWhere' => ['parent_id' => 0]]);
        return view(checkView('coredata::category.edit'), compact('data', 'category'));
    }

    public function update(EditRequest $request, $id)
    {
        if($this->service->update($request, $id))
        {
            return redirect(route('category.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('category.edit'))->with(getCustomTranslation('problem'));
    }

    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }

    public function importView(Request $request)
    {
        $request = $request->all();
        if(isset($request['check_status']))
        {
            return response()->json(["importing_in_progress" => session()->get('importing_in_progress')]);
        }
        return view(checkView('coredata::category.importFileIndustryCategory'));
    }

    public function importViewInfCa(Request $request)
    {
        $request = $request->all();
        if(isset($request['check_status']))
        {
            return response()->json(["importing_in_progress" => session()->get('importing_in_progress')]);
        }
        return view(checkView('coredata::category.importFileInfCa'));
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        if($validator->fails())
        {
            session()->put('bad', getCustomTranslation('you_must_import_the_file_first'));
            if($request->industry == 1)
            {
                return redirect()->to("/coredata/category/files/import" . $this->params);
            }else
            {
                return redirect()->to("/coredata/category/files/import/inf-ca" . $this->params);
            }
        }
        if(request('industry')) $this->params = "?industry=1";
        try
        {
            if($request->industry == 1)
            {
                $categoryImport = new CategoriesImport;
            }else
            {
                $categoryImport = new InfluencerCategoryImport;
            }
            Excel::import($categoryImport, $request->file('file')->store('files'));
            if(!empty($categoryImport->rows))
            {
                if($request->industry == 1)
                {
                    return Excel::download(
                        new MissingIndustryCategoryExport($categoryImport->rows),
                        'category_missing_data.xlsx'
                    );
                }else
                {
                    return Excel::download(
                        new MissingInfluenceCategoryExport($categoryImport->rows),
                        'category_missing_data.xlsx'
                    );
                }
            }else
            {
                session()->put('message',getCustomTranslation('importing_is_finished_successfully'));
                if($request->industry == 1)
                {
                    return redirect()->to("/coredata/category/files/import" . $this->params);
                }else
                {
                    return redirect()->to("/coredata/category/files/import/inf-ca" . $this->params);
                }
            }
        }catch(Exception $e)
        {
            session()->put('bad', $e->getMessage());
            if($request->industry == 1)
            {
                return redirect()->to("/coredata/category/files/import" . $this->params);
            }else
            {
                return redirect()->to("/coredata/category/files/import/inf-ca" . $this->params);
            }
        }
    }

    public function search_categories(Request $request)
    {
        $request->merge(['search'=>$request->term,'active' => activeType()['as'],'group' => [groupType()['igc'], groupType()['igp']]]);
        $data = $this->service->findBy($request);
        return response()->json($data);
    }
    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportCategory($request), "category.xlsx");
    }

    public function child_categories(Request $request)
    {
        $data = $this->service->list($request);
        return response()->json($data);
    }

    public function listIndustry()
    {
        return $this->service->list(new Request(['group' => [groupType()['igc'], groupType()['igp']], 'active' => activeType()['as']]));
    }
}
