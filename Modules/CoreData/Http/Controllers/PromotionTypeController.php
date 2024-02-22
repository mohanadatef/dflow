<?php

namespace Modules\CoreData\Http\Controllers;


use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportPromotion;
use Modules\CoreData\Export\MissingPromotionsExport;
use Modules\CoreData\Http\Requests\Import\ImportRequest;
use Modules\CoreData\Http\Requests\PromotionType\CreateRequest;
use Modules\CoreData\Http\Requests\PromotionType\EditRequest;
use Modules\CoreData\Import\PromotionImport;
use Modules\CoreData\Service\PromotionTypeService;
use Yajra\DataTables\Facades\DataTables;

class PromotionTypeController extends BasicController
{
    protected  $service;

    public function __construct(PromotionTypeService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_promotions')->only('index');
        $this->middleware('permission:create_promotions')->only('create');
        $this->middleware('permission:create_promotions')->only('store');
        $this->middleware('permission:update_promotions')->only('edit');
        $this->middleware('permission:update_promotions')->only('update');
        $this->middleware('permission:delete_promotions')->only('destroy');
        $this->middleware('permission:export_promotions')->only('export');

        $this->service = $Service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(checkView('coredata::promotion_type.index'));
    }

    public function create(Request $request)
    {
        return view(checkView('coredata::promotion_type.create'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('promotion_type.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('promotion_type.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        return view(checkView('coredata::promotion_type.edit'), compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('promotion_type.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('promotion_type.edit'))->with(getCustomTranslation('problem'));
    }

    public function importView(Request $request)
    {
        $request = $request->all();
        if (isset($request['check_status'])) {
            return response()->json(["importing_in_progress" => session()->get('importing_in_progress')]);
        }
        return view(checkView('coredata::promotion_type.importFile'));
    }

    public function import(ImportRequest $request)
    {
        try {
            $promotionImport = new PromotionImport;
            Excel::import($promotionImport, $request->file('file')->store('files'));
            if ($promotionImport->rows) {
                return Excel::download(new MissingPromotionsExport($promotionImport->rows), 'missing_data.xlsx');
            } else {
                session()->put('message', getCustomTranslation('importing_is_finished_successfully'));
                return redirect()->to("/coredata/promotion_type/files/import");
            }
        } catch (\Exception $e) {
            session()->put('bad', $e->getMessage());
            return redirect()->to("/coredata/promotion_type/files/import");
        }
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportPromotion($request), "promotion.xlsx");
    }
}
