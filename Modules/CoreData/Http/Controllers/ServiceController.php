<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportService;
use Modules\CoreData\Http\Requests\Service\CreateRequest;
use Modules\CoreData\Http\Requests\Service\EditRequest;
use Modules\CoreData\Service\ServiceService;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends BasicController
{
    protected $service;

    public function __construct(ServiceService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_services')->only('index');
        $this->middleware('permission:create_services')->only('create');
        $this->middleware('permission:create_services')->only('store');
        $this->middleware('permission:update_services')->only('edit');
        $this->middleware('permission:update_services')->only('update');
        $this->middleware('permission:delete_services')->only('destroy');
        $this->middleware('permission:export_services')->only('export');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(checkView('coredata::service.index'));
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function create(Request $request)
    {
        return view(checkView('coredata::service.create'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('service.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('service.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        return view(checkView('coredata::service.edit'), compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('service.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('service.edit'))->with(getCustomTranslation('problem'));
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportService($request), "service.xlsx");
    }
}
