<?php

namespace Modules\Report\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Report\Http\Requests\ExternalDashboardClient\CreateRequest;
use Modules\Report\Service\ExternalDashboardClientService;

class ExternalDashboardClientController extends BasicController
{
    protected $service;

    public function __construct(ExternalDashboardClientService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:assign_external_dashboard')->only('index');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $datas = $this->service->findBy($request,true,$this->perPage(),relation:['client']);
        if($request->ajax())
        {
            return view(checkView('report::external_dashboard_client.table'), get_defined_vars());
        }
        return view(checkView('report::external_dashboard_client.index'), get_defined_vars());
    }

    public function listAssign(Request $request)
    {
        return response()->json($this->service->search_client($request));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return response()->json([]);
        }
        return response()->json([]);
    }

    public function update(CreateRequest $request,$id)
    {
        $data = $this->service->update($request,$id);
        if($data)
        {
            return response()->json([]);
        }
        return response()->json([]);
    }
}
