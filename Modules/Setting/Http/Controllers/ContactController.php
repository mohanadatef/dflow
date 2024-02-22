<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Requests\Contact\CreateRequest;
use Modules\Setting\Service\ContactService;

class ContactController extends BasicController
{
    protected $service;

    public function __construct(ContactService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $Service;
    }

    public function create()
    {
        return view('setting::support_center.contact_us');
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            $this->service->store($request);
            $data = array(
                'name' => user()->name,
                'content' => $request->all()['message']
            );
            Mail::send('setting::support_center.mail', $data, function ($message) use ($request) {
                $message->to(env("SUPPORT_MAIL_ADDRESS"), user()->name)->subject
                ($request->all()['subject']);
            });
            return response()->json(['Message' =>  getCustomTranslation('contact_created_successfully')]);
        }
        return response()->json(['Message' => getCustomTranslation('something_went_wrong')]);
    }
}
