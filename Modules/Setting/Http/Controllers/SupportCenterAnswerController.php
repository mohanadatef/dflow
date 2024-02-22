<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Acl\Service\UserService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Requests\SupportCenterAnswer\CreateRequest;
use Modules\Setting\Service\SupportCenterAnswerService;

class SupportCenterAnswerController extends BasicController
{

    protected $service;
    public function __construct(SupportCenterAnswerService $service) {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:create_answer_support_center')->only(['store']);
        $this->service = $service;
    }

    public function index(Request $request) {
        $answers = $this->service->findBy($request);
        return view(checkView('setting::support_center.answers.table'), get_defined_vars());
    }

    public function store(CreateRequest $request) {
        $data = $this->service->store($request);
        $answers = $this->service->findBy(new Request(['support_center_question_id' => $data->support_center_question_id]));
        if($data) {
            return view(checkView('setting::support_center.answers.table'), get_defined_vars());
        }
        return redirect()->back()->with(getCustomTranslation('problem'));
    }


    public function delete()
    {
        $data = $this->service->delete(request('id'));
        if($data) {
            return response()->json($data, 200);
        }
        return response()->json(['message', getCustomTranslation('problem')], 400);
    }

}
