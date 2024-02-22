<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Report\Service\ExternalDashboardVersionService;

class ExternalDashboardVersionController extends BasicController
{
    protected $service;

    public function __construct(ExternalDashboardVersionService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:change_version_external_dashboard')->only('index');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $datas = $this->service->findBy($request,true,$this->perPage(),relation:['external_dashboard'],
            );
        if($request->ajax())
        {
            return view(checkView('report::external_dashboard_version.table'), get_defined_vars());
        }
        return view(checkView('report::external_dashboard_version.index'), get_defined_vars());
    }

    public function change(Request $request,$id)
    {
        $data = $this->service->change($request,$id);
        if($data) {
            return redirect(route('external_dashboard.index'))->with('message', getCustomTranslation('done'));
        }
        return redirect()->back()->with('message_false', getCustomTranslation('problem'));
    }
}
