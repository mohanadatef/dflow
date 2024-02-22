<?php

namespace Modules\Acl\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Acl\Repositories\InfluencerGroupScheduleRepository;
use Modules\Basic\Service\BasicService;
use Modules\Record\Repositories\AdRecordRepository;
use Modules\Record\Service\AdRecordService;

class InfluencerGroupScheduleService extends BasicService
{
    protected $repo, $userService, $influencerGroupService, $reseacherInfluencersDailyService, $adRecordRepository;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerGroupScheduleRepository $repo, UserService $userService,
        InfluencerGroupService $influencerGroupService, ReseacherInfluencersDailyService $reseacherInfluencersDailyService
    ,AdRecordRepository $adRecordRepository)
    {
        $this->repo = $repo;
        $this->userService = $userService;
        $this->influencerGroupService = $influencerGroupService;
        $this->reseacherInfluencersDailyService = $reseacherInfluencersDailyService;
        $this->adRecordRepository = $adRecordRepository;
    }

    public function findBy(
        Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*'], $pagination = false,
        $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = []
    )
    {
        $data = $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination,
            $perPage, $recursiveRel, null, $orderBy);
        return $data;
    }

    public function store(Request $request)
    {

        foreach($request->influencer_group_id as $influencer_group_id)
        {
           $newRequest =  new Request($request->except(['influencer_group_id']));
            $data = $this->repo->save($newRequest->merge(['influencer_group_id'=>$influencer_group_id]));
        }
        if($data)
        {
            return true;
        }
        return false;
    }

    public function update(Request $request)
    {
        $data = $this->reseacherInfluencersDailyService->chaneg($request,$request->id);
        if($data)
        {
            return $data;
        }
        return false;
    }

    public function researcherData($researcher_id)
    {
        return $this->reseacherInfluencersDailyService->findBy(new Request(['researcher_id' => $researcher_id, 'is_complete' => 0]),
            moreConditionForFirstLevel: ['whereBetween' => ['date' => [Carbon::today()->startOfDay(), Carbon::today()
                ->endOfDay()]]]);
    }

    public function researcherList($moreConditionForFirstLevel=[])
    {
        return $this->userService->list(new Request(['role_id' => 3, 'active' => activeType()['as']]),moreConditionForFirstLevel:$moreConditionForFirstLevel);
    }

    public function influencerGroupRemainder(Request $request)
    {
        $group_day = $this->repo->findBy($request, pluck: ['influencer_group_id', 'influencer_group_id']);
        return $this->influencerGroupService->findBy(new Request(),
            moreConditionForFirstLevel: ['whereNotIn' => ['id' => $group_day->toArray()]]);
    }

    public function scanTable() {
        if(Carbon::now()->format('H') >= '00' && Carbon::now()->format('H') <= '08')
        {
            $start = Carbon::parse('yesterday 9am');
            $end = Carbon::parse('today 9am');
        }else
        {
            $start = Carbon::parse('today 9am');
            $end = Carbon::parse('tomorrow 9am');
        }
        $day = weekScheduleKey()[strtolower(Carbon::today()->format('l'))];
        $influencer_groups = $this->findBy(new Request(['day' => $day]));
        $old=$this->reseacherInfluencersDailyService->findBy(new Request(['is_complete' => 0,
            'date' => Carbon::today()->format('Y-m-d H:i:s')]));
        foreach ($old as  $item){
            $ad_count = $this->adRecordRepository->findBy(request: $this->prepareRequest($item),
                moreConditionForFirstLevel:['whereBetween' => ['created_at' => [$start, $end]]],
                get:'count');
            if($ad_count == 0)
            {
                $item->delete();
            }

        }
        foreach ($influencer_groups as $group){
            foreach ($group->influencer_group->influencer_follower_platform as $follower)
            {
                $data = $this->reseacherInfluencersDailyService->findBy(new Request(['influencer_follower_platform_id' => $follower->id,
                    'date' => Carbon::today()->format('Y-m-d H:i:s')]),get:'count');
                if($data == 0) {
                    $this->reseacherInfluencersDailyService->store(new Request(
                        [
                            'influencer_follower_platform_id' => $follower->id,
                            'researcher_id' => $group->researcher_id,
                            'shift' => $group->shift,
                            'date' => Carbon::today()->format('Y-m-d H:i:s')
                        ]
                    ));
                }
            }
        }
    }

    /**
     * @param $item
     * @return Request
     */
    public function prepareRequest($item): Request
    {
        return new Request([
            'platform_id' => $item->influencer_follower_platform->platform_id,
            'user_id' => $item->researcher_id,
            'influencer_id' => $item->influencer_follower_platform->influencer_id]);
    }
}
