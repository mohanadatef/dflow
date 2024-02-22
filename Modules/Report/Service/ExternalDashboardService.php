<?php

namespace Modules\Report\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Service\CategoryService;
use Modules\Report\Repositories\ExternalDashboardRepository;
use Modules\Acl\Service\UserService;
class ExternalDashboardService extends BasicService
{
    protected $repo, $userService,$categoryService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(ExternalDashboardRepository $repository, UserService $userService, CategoryService $categoryService)
    {
        $this->repo = $repository;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
      $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [], $column = ['*'],
        $orderBy = [], $latest = '')
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel,
            $recursiveRel, $relation, $column, $orderBy, $latest);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function show($id,$withRelations=[])
    {
        return $this->repo->findOne($id,$withRelations);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return $data;
    }

    public function list(Request $request)
    {
        return $this->repo->list($request);
    }

    public function toggleActive(): bool
    {
        return $this->repo->toggleActive();
    }

    public function search_users($request) {

        $recursiveRel =
            ['role' => [
                'type' => 'whereHas',
                'recursive' => [
                    'permissions' => [
                        'type' => 'whereHas',
                        'where' => ['name' => 'update_external_dashboard']
                    ]
                ],
            ]
            ];

        return $this->userService->findBy(new Request(['active' => activeType()['as']]), recursiveRel: $recursiveRel);
    }

    public function categoryList()
    {
        return $this->categoryService->list(new Request(['active' => activeType()['as']]));
    }
}
