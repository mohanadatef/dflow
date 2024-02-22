<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\Role\RoleListResource;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Basic\Service\BasicService;

class RoleService extends BasicService
{
    protected $repo;
    protected $permissionService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $repository, PermissionService $permissionService)
    {
        $this->repo = $repository;
        $this->permissionService = $permissionService;
    }

    public function findBy(Request $request)
    {
        return $this->repo->findBy($request);
    }

    public function store(Request $request)
    {
        $data = $this->repo->save($request);
        if ($data) {
            return $data;
        }
        return false;
    }

    public function update(Request $request)
    {
        $data = $this->repo->save($request, $request->id);
        if ($data) {
            return $data;
        }
        return false;
    }

    public function destroy(Request $request)
    {
        $data = $this->repo->save($request, $request->id);
        if ($data) {
            return $data;
        }
        return false;
    }

    public function permissionList(Request $request)
    {
        return $this->permissionService->findBy($request);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return RoleListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage));
    }

    public function toggleActive(): bool
    {
        return $this->repo->toggleActive();
    }
}
