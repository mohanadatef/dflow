<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportPlatform;
use Modules\CoreData\Export\MissingPlatformsExport;
use Modules\CoreData\Http\Requests\Import\ImportRequest;
use Modules\CoreData\Http\Requests\Platform\CreateRequest;
use Modules\CoreData\Http\Requests\Platform\EditRequest;
use Modules\CoreData\Import\PlatformImport;
use Modules\CoreData\Service\PlatformService;
use Yajra\DataTables\Facades\DataTables;

class PlatformController extends BasicController
{
    protected $service;

    public function __construct(PlatformService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_platforms')->only('index');
        $this->middleware('permission:create_platforms')->only('create');
        $this->middleware('permission:create_platforms')->only('store');
        $this->middleware('permission:update_platforms')->only('edit');
        $this->middleware('permission:update_platforms')->only('update');
        $this->middleware('permission:delete_platforms')->only('destroy');
        $this->middleware('permission:export_platforms')->only('export');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(checkView('coredata::platform.index'));
    }

    public function create(Request $request)
    {
        $service = $this->service->listService();
        return view(checkView('coredata::platform.create'), compact('service'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('platform.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('platform.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        $service = $this->service->listService();
        return view(checkView('coredata::platform.edit'), compact('data', 'service'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('platform.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('platform.edit'))->with(getCustomTranslation('problem'));
    }

    public function importView(Request $request)
    {
        $request = $request->all();
        if (isset($request['check_status'])) {
            return response()->json(
                [
                    "importing_in_progress" => session()->get('importing_in_progress'),
                    "error" => session()->get('bad'),
                ]
            );
        }
        return view(checkView('coredata::platform.importFile'));
    }

    public function import(ImportRequest $request)
    {
        try {
            $platformImport = new PlatformImport;
            Excel::import($platformImport, $request->file('file')->store('files'));
            if ($platformImport->rows) {
                return Excel::download(new MissingPlatformsExport($platformImport->rows), 'missing_data.xlsx');
            } else {
                session()->put('message', getCustomTranslation('importing_is_finished_successfully'));
                return redirect()->to("/coredata/platform/files/import");
            }
        } catch (\Exception $e) {
            session()->put('bad', $e->getMessage());
            return redirect()->to("/coredata/platform/files/import");
        }
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportPlatform($request), "platform.xlsx");
    }
}
