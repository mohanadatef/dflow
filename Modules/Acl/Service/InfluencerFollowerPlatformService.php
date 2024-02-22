<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Repositories\InfluencerFollowerPlatformRepository;
use Modules\Basic\Service\BasicService;

class InfluencerFollowerPlatformService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerFollowerPlatformRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*'],
        $pagination = false, $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = [],$pluck=[])
    {
        return $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination,
            $perPage, $recursiveRel, null, $orderBy,$pluck);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        if($data)
        {
            return $data;
        }
        return false;
    }
}
