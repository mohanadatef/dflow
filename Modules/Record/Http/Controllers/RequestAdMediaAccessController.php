<?php

namespace Modules\Record\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Service\RequestAdMediaAccessService;

class RequestAdMediaAccessController extends BasicController
{
    protected $service;

    public function __construct(RequestAdMediaAccessService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_request_ad_media_access')->only('index');
        $this->middleware('permission:status_request_ad_media_access')->only('update');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $created_at = $request->created_at ?? Carbon::today();
        if(user()->can('my_request_ad_media_access'))
        {
            $request->merge(['client_id'=>user()->id]);
        }
        $datas = $this->service->findBy($request, true, $this->perPage(), ['ad_record', 'client', 'user']);
        if($request->ajax())
        {
            return view('record::request_ad_media_access.system.table', get_defined_vars());
        }
        return view(checkView('record::request_ad_media_access.system.index'), get_defined_vars());
    }

    public function store(Request $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return response()->json(["message" => getCustomTranslation(  'your_request_has_been_sent_successfully')]);
        }
        return response()->json(["message_false" => getCustomTranslation(  'problem_call_Admin')]);
    }

    public function update(Request $request)
    {
        $data = $this->service->update($request, $request->id);
        if(isset($data['status']) && $data['status'] == 0)
        {
            return response()->json(["message_false" => getCustomTranslation(  'problem_this_external'),'status'=>0]);
        }elseif($data)
        {
            return response()->json(["data" => $data,'status'=>1]);
        }
        return response()->json(["message_false" => getCustomTranslation(  'problem_call_Admin'),'status'=>0]);
    }

    public function cancellation(Request $request)
    {
        $data = $this->service->update($request);
        if($data)
        {
            return response()->json(["message" => getCustomTranslation(  'your_request_has_been_canceled_by_you')]);
        }else
        {
            return redirect(route('ad_record.show', $request->ad_record_id));
        }
        return response()->json(["message_false" => getCustomTranslation(  'problem_call_Admin'),'status'=>0]);
    }

    public function myRequest(Request $request)
    {
        $request->merge(['client_id' => user()->id]);
        $created_at = $request->created_at ?? Carbon::today();
        $datas = $this->service->findBy($request, true, $this->perPage(), ['ad_record']);
        if($request->ajax())
        {
            return view('record::request_ad_media_access.client.table', get_defined_vars());
        }
        return view(checkView('record::request_ad_media_access.client.index'),  get_defined_vars());
    }

    public function myRequestِAvailable(Request $request)
    {
        $request->merge(['client_id' => user()->id,'status'=>2]);
        $datas = $this->service->findBy($request, true, $this->perPage(), ['ad_record']);
        if($request->ajax())
        {
            return view('record::request_ad_media_access.client.table', get_defined_vars());
        }
        return view(checkView('record::request_ad_media_access.client.index'), compact('datas'));
    }
}
