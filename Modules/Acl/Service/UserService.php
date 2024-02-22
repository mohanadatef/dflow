<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\User\UserListResource;
use Modules\Acl\Repositories\UserRepository;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Service\CategoryService;

/**
 * @method getAccount()
 * @method getSheetDrive($account, $id)
 */
class UserService extends BasicService
{

    protected $categoryService;
    protected $roleService;
    protected $repo;
    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository, RoleService $roleService, CategoryService $categoryService)
    {
        $this->repo = $repository;
        $this->roleService = $roleService;
        $this->categoryService = $categoryService;
    }

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*'], $pagination = false,
        $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = [], $pluck = [])
    {
        return $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get,
            $column, $pagination, $perPage, $recursiveRel, null, $orderBy, $pluck);
    }

    public function store(Request $request)
    {
        $data = $this->repo->save($request);
        if($data)
        {
            return true;
        }
        return false;
    }

    public function update(Request $request, $id)
    {
        if(!user()->can('update_users'))
        {
            $request->request->remove('role_id');
        }
        $data = $this->repo->save($request, $id);
        if($data)
        {
            return $data;
        }
        return false;
    }

    public function roleList()
    {
        return $this->roleService->list(new Request(['active' => activeType()['as'], 'type' => 0]));
    }

    public function list(Request $request,$moreConditionForFirstLevel=[])
    {
        return UserListResource::collection($this->repo->findBy($request,moreConditionForFirstLevel:$moreConditionForFirstLevel));
    }

    public function toggleSearch()
    {
        return $this->repo->toggleSearch();
    }

    public function categoryList()
    {
        return $this->categoryService->list(new Request(['active' => activeType()['as']]));
    }

}
