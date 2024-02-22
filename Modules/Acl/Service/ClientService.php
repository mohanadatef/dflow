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
class ClientService extends BasicService
{
    protected  $categoryService;
    protected  $roleService;
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

    public function findBy(
        Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*'], $pagination = false,
                $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = []
    )
    {
        if (!empty($request->search)) {
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'whereHas' => [['company' =>
                            [
                                'type' => 'whereHas',
                                'where' => ['name_en' =>  $request->search ],
                                'orWhere' => ['name_ar' => $request->search ]
                            ],
                    ]]
                ,
                'orWhere' => [
                   [ 'name' => $request->search],  [ 'email' =>  $request->search ]
                ]],
            ];
            $recursiveRel = [
                'role' => [
                    'type' => 'whereHas',
                    'where' => ['type' => 1]
                ]
            ];
        } else {
            $recursiveRel = [
                'role' => [
                    'type' => 'whereHas',
                    'where' => ['type' => 1]
                ]
            ];
        }


        return $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination, $perPage, $recursiveRel, null, $orderBy);

    }

    public function store(Request $request)
    {
        $request->merge(['match_search' => 1]);
        $data = $this->repo->save($request);
        if ($data) {
            return true;
        }
        return false;
    }

    public function update(Request $request, $id)
    {
        if (!user()->can('update_clients')) {
            $request->request->remove('role_id');
        }
        $data = $this->repo->save($request, $id);
        if ($data) {
            return $data;
        }
        return false;
    }

    public function roleList()
    {
        return $this->roleService->list(new Request(['active' => activeType()['as'],'type' => 1]));
    }

    public function list(Request $request)
    {
        return UserListResource::collection($this->repo->findBy($request));
    }

    public function toggleActive()
    {
        return $this->repo->toggleActive();
    }

    public function categoryParentList()
    {
        return $this->categoryService->list(new Request(['group' => groupType()['igp'],'active' => activeType()['as']]));
    }
}
