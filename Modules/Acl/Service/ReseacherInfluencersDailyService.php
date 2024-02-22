<?php

namespace Modules\Acl\Service;

use Carbon\Carbon;
use Modules\Acl\Entities\ReseacherInfluencersDaily;
use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Acl\Repositories\ReseacherInfluencersDailyRepository;

class ReseacherInfluencersDailyService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(ReseacherInfluencersDailyRepository $repo)
    {
        $this->repo = $repo;
    }

    public function findBy(
        Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*'], $pagination = false,
                $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = [],$pluck=[]
    )
    {
        $data = $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination,
            $perPage, $recursiveRel, null, $orderBy,$pluck);
        return $data;
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
        $ids = explode(',',$id);
        foreach($ids as $id)
        {
            $data = $this->repo->find($id);
            if($data->owner_researcher_id)
            {
                if($data->owner_researcher_id == $request->researcher_id)
                {
                    $owner = null;
                }else{
                    $owner = $data->owner_researcher_id;
                }
            }else
            {
                $owner = $data->researcher_id;
            }
            $newRequest = new Request(['owner_researcher_id'=>$owner,
                'researcher_id'=>$request->researcher_id]);
            $data = $this->repo->save($newRequest,$id);
        }
        if($data)
        {
            return $data;
        }
        return false;
    }

    public function toggleComplete(Request $request)
    {
       $data= $this->repo->findBy(new Request(['influencer_follower_platform_id'=>$request->id,'date'=>$request->search_day]),get:'first');
       $newRequest = new Request(['is_complete'=>$data->is_complete ? 0 : 1]);
        return $this->repo->save($newRequest,$data->id);
    }

}
