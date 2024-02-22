<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Acl\Service\UserService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Requests\SupportCenterQuestion\EditRequest;
use Modules\Setting\Service\SupportCenterQuestionService;
use Modules\Setting\Http\Requests\SupportCenterQuestion\CreateRequest;
class SupportCenterQuestionController extends BasicController
{

    protected $service, $userService;
    public function __construct(SupportCenterQuestionService $service, UserService $userService) {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_support_center')->only(['index', 'show']);
        $this->middleware('permission:create_support_center')->only(['create', 'store']);
        $this->middleware('permission:update_support_center')->only(['edit', 'update']);
        $this->middleware('permission:delete_support_center')->only('delete');
        $this->middleware('permission:hidden_questions_support_center')->only('getHiddenQuestions');

        $this->service = $service;
        $this->userService = $userService;
    }

    public function index(Request $request) {
        $request->merge(['active' => 1]);
        $users = $this->userService->findBy(new Request());
        $datas = $this->service->findBy($request, true, $this->perPage(),
            relation: ['answers', 'user', 'medias']);
        if($request->ajax())
        {
            return view('setting::support_center.table', compact('datas'));
        }
        return view(checkView('setting::support_center.index'), get_defined_vars());
    }

    public function myQuestions(Request $request) {
        $request->merge(['active' => 1 , 'user_id' => user()->id]);
        $datas = $this->service->findBy($request, true, $this->perPage(),
            relation: ['answers', 'user', 'medias']);
        if($request->ajax()) {
            return view('setting::support_center.table', compact('datas'));
        }
        return view(checkView('setting::support_center.my_questions'), get_defined_vars());
    }

    public function getHiddenQuestions(Request $request) {
        $request->merge(['active' => 0]);
        $users = $this->userService->findBy(new Request());
        $datas = $this->service->findBy($request, true, $this->perPage(),
            relation: ['answers', 'user', 'medias']);
        if($request->ajax()) {
            return view('setting::support_center.table', compact('datas'));
        }
        return view(checkView('setting::support_center.hidden_questions'), get_defined_vars());
    }

    public function create() {
        return view(checkView('setting::support_center.create'));
    }

    public function store(CreateRequest $request) {
        $data = $this->service->store($request);
        if($data) {
            return redirect(route('support_center.create'))->with('message', getCustomTranslation('done'));
        }
        return redirect(route('support_center.create'))->with('message_false', getCustomTranslation('problem'));
    }


    public function edit($id)
    {
        $data = $this->service->show($id);

        return view(checkView('setting::support_center.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id) {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('support_center.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('question.edit'))->with(getCustomTranslation('problem'));
    }

    public function toggleAnswer() {
        return response()->json(['status' => $this->service->toggleAnswer() ? 'true' : 'false']);
    }

    public function show($id)
    {
        $data = $this->service->show($id,['medias']);
        if($data) {
            return view(checkView('setting::support_center.show'), compact('data'));
        }
        return redirect(route('support_center.index'));
    }

    public function delete($id)
    {
        $data = $this->service->delete($id);
        if($data)
        {
            return redirect(route('support_center.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('support_center.show', $id))->with(getCustomTranslation('problem'));
    }

    public function readFiles(Request $request)
    {
        return $this->service->readFiles($request);
    }

}
