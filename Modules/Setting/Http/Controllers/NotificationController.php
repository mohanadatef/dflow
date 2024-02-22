<?php

namespace Modules\Setting\Http\Controllers;

use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Service\NotificationService;
use Illuminate\Http\Request;
class NotificationController extends BasicController
{
    protected $service;

    public function __construct(NotificationService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin')->except('getNotification');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $request->merge(['receiver_id' => user()->id]);
        $data = $this->service->findBy($request, true, $this->perPage() );
        if($request->ajax())
        {
            return view(checkView('setting::notification.table'), compact('data', 'request'));
        }
        return view(checkView('setting::notification.index'), compact('data', 'request'));
    }

    public function getNotification(Request $request)
    {
        $request->merge(['receiver_id' => user()->id]);
        $data = $this->service->findBy($request, false,limit:10 ,latest:'latest');
        return view(checkView('setting::notification.get'), compact('data'));
    }

    public function readNotification(Request $request)
    {
        $request->merge(['is_read'=>1]);
        $this->service->update($request, $request->id);
    }

    public function store(Request $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return response()->json(['Message' =>  getCustomTranslation('contact_created_successfully')]);
        }
        return response()->json(['Message' => getCustomTranslation('something_went_wrong')]);
    }
}
