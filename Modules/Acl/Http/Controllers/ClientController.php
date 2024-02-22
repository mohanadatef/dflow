<?php

namespace Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Export\ExportClient;
use Modules\Acl\Http\Requests\User\ChangePasswordRequest;
use Modules\Acl\Http\Requests\Client\CreateRequest;
use Modules\Acl\Http\Requests\Client\EditRequest;
use Modules\Acl\Service\ClientService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller user about web function
 */
class ClientController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(ClientService $service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_clients')->only('index');
        $this->middleware('permission:create_clients')->only('create');
        $this->middleware('permission:create_clients')->only('store');
        $this->middleware('permission:update_clients')->only('edit');
        $this->middleware('permission:update_clients')->only('update');
        $this->middleware('permission:delete_clients')->only('destroy');
        $this->middleware('permission:export_clients')->only('export');
        $this->service = $service;
    }


    public function index(Request $request)
    {
        $datas = $this->service->findBy($request, [], '', ['*'], true, 10, [], ['company']);
        if($request->ajax())
        {
            return view(checkView('acl::clients.table'), compact('datas'));
        }
        return view(checkView('acl::clients.index'), compact('datas'));
    }

    public function create()
    {
        $role = $this->service->roleList();
        $category = $this->service->categoryParentList();
        return view('acl::clients.create', compact('role', 'category'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('client.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('client.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        $role = $this->service->roleList();
        $category = $this->service->categoryParentList();
        return view(checkView('acl::clients.edit'), compact('data', 'role', 'category'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('client.edit', $id))->with("message", getCustomTranslation('done'));
        }
        return redirect(route('client.edit', $id))->with(getCustomTranslation('problem'));
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        return view(checkView('acl::clients.show'), compact('data'));
    }

    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }

    public function changePassword(Request $request)
    {
        $data = $this->service->show($request->id);
        return view('acl::clients.changePassword', compact('data'));
    }

    public function updatePassword(ChangePasswordRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if(user()->id == $data->id)
        {
            return redirect(route('client.show', $data->id))->with(getCustomTranslation('done'));
        }else
        {
            return redirect(route('client.index'))->with(getCustomTranslation('done'));
        }
    }
    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportClient($request), "client.xlsx");
    }
}
