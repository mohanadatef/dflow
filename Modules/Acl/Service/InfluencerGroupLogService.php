<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Repositories\InfluencerGroupLogRepository;
use Modules\Basic\Service\BasicService;

class InfluencerGroupLogService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerGroupLogRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*']
        , $pagination = false, $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = [])
    {
        $withRelations=['user','influencer_follower_platform.influencer','influencer_follower_platform.platform'];
        $orderBy=['column' => 'created_at', 'order' => 'desc'];
        return $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination,
            $perPage, $recursiveRel, null, $orderBy);
    }

    public function store(Request $request)
    {
        $request->merge(['user_id'=>user()->id]);
        $data = $this->repo->save($request);
        if($data)
        {
            return true;
        }
        return false;
    }

}
