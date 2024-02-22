<?php

namespace Modules\Record\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Service\AdRecordLogService;

class AdRecordLogController extends BasicController
{
    protected $service;

    public function __construct(AdRecordLogService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:log_ad_record')->only('index');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $created_at = $request->created_at ?? Carbon::today();
        $datas = $this->service->findBy($request,true,$this->perPage(),relation:['ad_record', 'user'],
            orderBy:['order'=>'desc','column'=>'id']);
        if($request->ajax())
        {
            return view(checkView('record::ad_record_log.table'), get_defined_vars());
        }
        return view(checkView('record::ad_record_log.index'), get_defined_vars());
    }

}
