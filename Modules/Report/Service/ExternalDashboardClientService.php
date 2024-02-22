<?php

namespace Modules\Report\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\UserService;
use Modules\Basic\Service\BasicService;
use Modules\Report\Repositories\ExternalDashboardClientRepository;

class ExternalDashboardClientService extends BasicService
{
    protected $repo, $userService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(ExternalDashboardClientRepository $repository,UserService $userService)
    {
        $this->repo = $repository;
        $this->userService = $userService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $relation = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, relation: $relation);
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
        $data = $this->repo->save($request, $id);
        return $data;
    }

    public function search_client($request)
    {
        $client = $this->repo->findBy($request, pluck: ['user_id', 'user_id'])->toArray();
        $moreConditionForFirstLevel = [];
        if(count($client))
        {
            $moreConditionForFirstLevel = ['whereNotIn' => ['id' => $client]];
        }
        $recursiveRel =
            ['role' => [
                'type' => 'whereHas',
                'where' => ['type' => 1]
                ],
            ];
        return $this->userService->findBy(new Request(['active' => activeType()['as']]), recursiveRel: $recursiveRel,
            moreConditionForFirstLevel: $moreConditionForFirstLevel);
    }
}
