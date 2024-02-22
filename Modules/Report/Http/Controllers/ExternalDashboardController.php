<?php

namespace Modules\Report\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Acl\Service\CompanyService;
use Modules\Acl\Service\UserService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Service\CategoryService;
use Modules\Report\Http\Requests\ExternalDashboard\CreateRequest;
use Modules\Report\Http\Requests\ExternalDashboard\EditRequest;
use Modules\Report\Service\ExternalDashboardService;

class ExternalDashboardController extends BasicController
{
    protected $service, $categoryService, $companyService, $userService;

    public function __construct(ExternalDashboardService $service, CategoryService $categoryService, CompanyService $companyService, UserService $userService) {
        $this->service = $service;
        $this->categoryService = $categoryService;
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->middleware('permission:view_external_dashboard')->only('index');
        $this->middleware('permission:create_external_dashboard')->only('create');
        $this->middleware('permission:create_external_dashboard')->only('store');
        $this->middleware('permission:update_external_dashboard')->only('edit');
        $this->middleware('permission:update_external_dashboard')->only('update');
        $this->middleware('permission:delete_external_dashboard')->only('destroy');
    }

    public function index(Request $request) {
        $datas = $this->service->findBy($request, true, $this->perPage(),relation:['company','category','assignedUser']);
        $categories = $this->service->categoryList();
        if($request->ajax())
        {
            return view('report::external_dashboard.table', get_defined_vars());
        }
        return view(checkView('report::external_dashboard.index'), get_defined_vars());
    }


    public function create() {

        return view(checkView('report::external_dashboard.create'), get_defined_vars());
    }

    public function store(CreateRequest $request) {
        $data = $this->service->store($request);
        if($data) {
            return redirect(route('external_dashboard.index'))->with('message', getCustomTranslation('done'));
        }
        return redirect(route('external_dashboard.create'))->with('message_false', getCustomTranslation('problem'));
    }


    public function edit($id)
    {
        $data = $this->service->show($id,['external_dashboard_category','external_dashboard_company','external_dashboard_version']);
        if(in_array(user()->role_id, [1,10]) || in_array(user()->id, $data->assignedUser->pluck('id')->toArray())){
            return view(checkView('report::external_dashboard.edit'), get_defined_vars());
        }
        return view(checkView('report::external_dashboard.show'), get_defined_vars());
    }

    public function update(EditRequest $request, $id) {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('external_dashboard.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('external_dashboard.edit'))->with(getCustomTranslation('problem'));
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        if($data) {
            return view(checkView('report::external_dashboard.show'), compact('data'));
        }
        return redirect(route('external_dashboard.index'));
    }

    public function delete($id)
    {
        $data = $this->service->delete($id);
        if($data)
        {
            return redirect(route('external_dashboard.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('external_dashboard.show', $id))->with(getCustomTranslation('problem'));
    }


    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }

    public function listAssign(Request $request)
    {
        return response()->json($this->service->search_users($request));
    }
}
