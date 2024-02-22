<?php

namespace Modules\Acl\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Export\ExportUser;
use Modules\Acl\Export\ExportUserMissing;
use Modules\Acl\Http\Requests\User\ChangePasswordRequest;
use Modules\Acl\Http\Requests\User\CreateRequest;
use Modules\Acl\Http\Requests\User\EditRequest;
use Modules\Acl\Import\ImportUser;
use Modules\Acl\Service\UserService;
use Modules\Basic\Http\Controllers\BasicController;

class UserController extends BasicController
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_users')->only('index');
        $this->middleware('permission:create_users')->only('create');
        $this->middleware('permission:create_users')->only('store');
        $this->middleware('permission:update_users')->only('edit');
        $this->middleware('permission:update_users')->only('update');
        $this->middleware('permission:delete_users')->only('destroy');
        $this->middleware('permission:export_users')->only('export');
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $moreConditionForFirstLevel=[];
        if(isset($request->search) && !empty($request->search))
        {
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['name' => $request->search], ['email' => $request->search]
                    ]],
            ];
            $recursiveRel = [
                'role' => [
                    'type' => 'whereHas',
                    'where' => ['type' => 0]
                ]
            ];
        }else
        {
            $recursiveRel = [
                'role' => [
                    'type' => 'whereHas',
                    'where' => ['type' => 0]
                ]
            ];
        }
        $datas = $this->service->findBy($request, pagination: true, perPage:$this->perPage(), moreConditionForFirstLevel:$moreConditionForFirstLevel, recursiveRel:$recursiveRel);
        if($request->ajax())
        {
            return view(checkView('acl::users.table'), compact('datas'));
        }
        return view(checkView('acl::users.index'), compact('datas'));
    }

    public function create()
    {
        $role = $this->service->roleList();
        $category = $this->service->categoryList();
        return view('acl::users.create', compact('role', 'category'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('user.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('user.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        $role = $this->service->roleList();
        $category = $this->service->categoryList();
        return view(checkView('acl::users.edit'), compact('data', 'role', 'category'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('user.edit', $id))->with("message", 'Done');
        }
        return redirect(route('user.edit', $id))->with(getCustomTranslation('problem'));
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        return view(checkView('acl::users.show'), compact('data'));
    }

    public function toggleSearch()
    {
        return response()->json(['match_search' => $this->service->toggleSearch() ? 1 : 0]);
    }

    public function importView(Request $request)
    {
        $request = $request->all();
        if(isset($request['check_status']))
        {
            return response()->json(
                [
                    "importing_in_progress" => session()->get('importing_in_progress'),
                    "error" => session()->get('bad'),
                ]
            );
        }
        return view(checkView('acl::users.importFile'));
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required'
        ]);
        if($validator->fails())
        {
            session()->put('bad', getCustomTranslation('you_must_import_the_file_first'));
            return redirect()->to("/acl/user/files/import");
        }
        try
        {
            $userImport = new ImportUser;
            Excel::import($userImport, $request->file('file')->store('files'));
            if($userImport->rows)
            {
                return Excel::download(new ExportUserMissing($userImport->rows), 'missing_data.xlsx');
            }else
            {
                session()->put('message', getCustomTranslation('importing_is_finished_successfully'));
                return redirect()->to("/acl/user/files/import");
            }
        }catch(Exception $e)
        {
            session()->put('bad', $e->getMessage());
            return redirect()->to("/acl/user/files/import");
        }
    }

    public function changePassword(Request $request)
    {
        $data = $this->service->show($request->id);
        return view('acl::users.changePassword', compact('data'));
    }

    public function updatePassword(ChangePasswordRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if(user()->id == $data->id)
        {
            return redirect(route('user.show', $data->id))->with(getCustomTranslation('done'));
        }else
        {
            return redirect(route('user.index'))->with(getCustomTranslation('done'));
        }
    }

    public function update_user_layout(Request $request)
    {
        $data = $this->service->update(new Request(['influencer_list' => $request->name]), user()->id);
        return response()->json($data->influencer_list);
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportUser($request), "user.xlsx");
    }
}
