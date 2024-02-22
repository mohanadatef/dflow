<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Repositories\PermissionRepository;
use Modules\Basic\Service\BasicService;

class PermissionService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(PermissionRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request)
    {
        return $this->repo->findBy($request);
    }

    public function store(Request $request)
    {
        $data = $this->repo->save($request);
        if ($data) {
            return true;
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
        $data = $this->repo->delete($request->id);
        if ($data) {
            return $data;
        }
        return false;
    }
}
