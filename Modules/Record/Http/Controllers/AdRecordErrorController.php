<?php

namespace Modules\Record\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Http\Requests\AdRecordErrors\CreateRequest;
use Modules\Record\Service\AdRecordErrorService;

class AdRecordErrorController extends BasicController
{
    protected $service;

    public function __construct(AdRecordErrorService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_errors_ad_record')->only('index');
        $this->middleware('permission:create_errors_ad_record')->only('store');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $range_creation_start = $this->service->range_creation_start_date();
        if($request->creation_start)
        {
            $request->request->add(['creation_start' => $range_creation_start]);
        }
        $range_creation_end = $this->service->range_creation_end_date();
        if($request->creation_end)
        {
            $request->request->add(['creation_end' => $range_creation_end]);
        }
        $datas = $this->service->findBy($request, true, $this->perPage(), relation: ['action_by', 'created_by']);


        $researchers = $this->service->researcherList();

        if($request->ajax())
        {
            return view(checkView('record::ad_record_errors.table'), get_defined_vars());
        }
        return view(checkView('record::ad_record_errors.index'), get_defined_vars());
    }


    public function update()
    {
        $this->service->update(new Request());
        return redirect()->back()->with('success', 'Success!');
    }


    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return response()->json(["message" => getCustomTranslation(  'your_request_has_been_sent_successfully')]);
        }
        return response()->json(["message_false" => getCustomTranslation(  'problem_call_Admin')]);
    }

    public function cancel()
    {
        $this->service->cancel();
        return redirect()->back()->with(['success' => 'Successfully Canceled']);
    }

}
