<?php

namespace Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Acl\Entities\Permission;
use Modules\Acl\Entities\Role;
use Modules\Acl\Service\RoleService;
use Modules\Basic\Http\Controllers\BasicController;

class RoleController extends BasicController
{
    protected $service;

    public function __construct(RoleService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_roles')->only('index');
        $this->middleware('permission:create_roles')->only('create');
        $this->middleware('permission:create_roles')->only('store');
        $this->middleware('permission:update_roles')->only('edit');
        $this->middleware('permission:update_roles')->only('update');
        $this->middleware('permission:delete_roles')->only('destroy');
        $this->service = $Service;
        $this->models = array_merge(modelPermission(), ['setting', 'request_ad_media_access', 'page']);
    }

    public function index(Request $request)
    {
        can('view_roles');
        return view(checkView('acl::roles.index'), [
            'roles' => $this->service->findBy($request),
            'models' => $this->models,
            'permissions' => $this->service->permissionList($request),
        ]);
    }

    public function create()
    {
        return view('acl::create');
    }

    public function store(Request $request)
    {
        can('create_roles');
        $role = Role::create(['name' => $request->name, 'type' => $request->type ?? 0, 'share_calender' => $request->share_calender ?? 0]);
        $permissions = Permission::get();
        foreach($permissions as $permissions)
        {
            if(request($permissions->name) == "on")
            {
                $role->permissions()->attach($permissions->id);
            }
        }
        return response()->json($role);
    }

    public function show(int $id)
    {
        can('show_roles');
        $role = Role::findOrFail($id);
        return view('acl::roles.show', [
            'role' => $role,
            'models' => $this->models,
            'permissions' => Permission::all(),
            'role_permissions' => $role->permissions,
        ]);
    }

    public function edit(Request $request)
    {
        can('update_roles');
        $role = Role::findOrFail($request->id);
        return view(checkView('acl::roles.edit'), [
            'role' => $role,
            'models' => $this->models,
            'permissions' => Permission::all(),
            'role_permissions' => $role->permissions,
        ]);
    }

    public function update(Request $request)
    {
        can('update_roles');
        $role = Role::findOrFail($request->role_id);
        $permissions = Permission::get();
        foreach($permissions as $permission)
        {
            if(request($permission->name) == "on" && !$role->permissions->contains($permission))
            {
                $role->permissions()->attach($permission->id);
            }elseif(!isset($request[$permission->name]) && $role->permissions->contains($permission))
            {
                $role->permissions()->detach($permission->id);
            }
        }
        $role->name = $request->name;
        $role->type = $request->type ?? 0;
        $role->share_calender = $request->share_calender ?? 0;
        $role->save();
        $role = Role::findOrFail($request->role_id);
        return $role;
    }

    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }
}
