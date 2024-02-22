<?php

namespace Modules\Record\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Service\RequestAdMediaAccessLogService;

class RequestAdMediaAccessLogController extends BasicController
{
    protected $service;

    public function __construct(RequestAdMediaAccessLogService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:log_request_ad_media_access')->only('index');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $created_at = $request->created_at ?? Carbon::today();
        $datas = $this->service->findBy($request, true, $this->perPage(), ['request_ad_media_access']);
        if($request->ajax())
        {
            return view('record::request_ad_media_access_log.table', get_defined_vars());
        }
        return view(checkView('record::request_ad_media_access_log.index'), get_defined_vars());
    }

    public function client(Request $request)
    {
        if(isset($request->ad_record_id))
        {
            $request->merge(['client_id' => user()->id]);
            $datas = $this->service->findBy($request, true, $this->perPage(), ['request_ad_media_access']);
            if($request->ajax())
            {
                return view('record::request_ad_media_access_log.client.table', get_defined_vars());
            }
            return view(checkView('record::request_ad_media_access_log.client.index'), get_defined_vars());
        }
        return redirect(route('ad_record.index'));
    }
}
