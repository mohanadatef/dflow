<?php

namespace Modules\Report\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Report\Service\ExternalDashboardLogService;

class ExternalDashboardLogController extends BasicController
{
    protected $service;

    public function __construct(ExternalDashboardLogService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:log_external_dashboard')->only('index');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $created_at = $request->created_at ?? Carbon::today();
        $datas = $this->service->findBy($request,true,$this->perPage(),relation:['external_dashboard', 'user'],
            orderBy:['order'=>'desc','column'=>'id']);
        if($request->ajax())
        {
            return view(checkView('report::external_dashboard_log.table'), get_defined_vars());
        }
        return view(checkView('report::external_dashboard_log.index'), get_defined_vars());
    }

}
