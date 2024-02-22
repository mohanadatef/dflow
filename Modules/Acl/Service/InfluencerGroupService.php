<?php

namespace Modules\Acl\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\InfluencerGroup\InfluencerGroupListResource;
use Modules\Acl\Import\InfluencerGroupCreate;
use Modules\Acl\Repositories\InfluencerGroupRepository;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Service\PlatformService;
use Maatwebsite\Excel\Facades\Excel;

class InfluencerGroupService extends BasicService
{
    protected $repo, $platformService, $influencerFollowerPlatformService, $influencerGroupLogService,$influencerService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerGroupRepository $repository,InfluencerService  $influencerService,
        PlatformService $platformService, InfluencerGroupLogService $influencerGroupLogService,
        InfluencerFollowerPlatformService $influencerFollowerPlatformService)
    {
        $this->repo = $repository;
        $this->platformService = $platformService;
        $this->influencerService = $influencerService;
        $this->influencerFollowerPlatformService = $influencerFollowerPlatformService;
        $this->influencerGroupLogService = $influencerGroupLogService;
    }

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*']
        , $pagination = false, $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = [])
    {
        if(isset($request->search) && !empty($request->search))
        {
            $moreConditionForFirstLevel += [
                'whereCustom' => [
                    'orWhere' => [
                        ['name_en' => $request->search], ['name_ar' => $request->search]
                    ]],
            ];
        }
        return $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination,
            $perPage, $recursiveRel, null, $orderBy);
    }

    public function store(Request $request)
    {
        $data = $this->repo->save($request);
        $this->influencerAndLog($data->id, $request, $data);
        if($data)
        {
            return true;
        }
        return false;
    }

    public function show($id)
    {
        $data = $this->repo->findOne($id);
        $lang = user()->lang ?? "en";
        foreach($data->influencer_follower_platform as $influencer_group_platform)
        {
            $data->countInfluencer++;
            $count = $influencer_group_platform->influencer->ad_record
                    ->whereBetween('date',
                        [Carbon::yesterday()->subDays(30)->startOfDay(), Carbon::yesterday()->endOfDay()])
                    ->where('platform_id', $influencer_group_platform->platform_id)->count() / 30;
            $data->countAd += ceil($count);
            $influencer_group_platform->count = $count;
            $influencer_group_platform->line = $influencer_group_platform->influencer->{'name_'.$lang} . '     ' . $influencer_group_platform->platform->{'name_'.$lang} . '     ' . ceil($count);
        }
        return $data;
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        $this->influencerAndLog($id, $request, $data);
        if($data)
        {
            return $data;
        }
        return false;
    }

    public function influencerAndLog($id, $request, $data)
    {
        $requestData = $request->influencer_Platform;
        $oldData = $this->repo->findOne($id)->influencer_follower_platform->pluck('id')->toArray();
        $someData = array_intersect($requestData, $oldData);
        $requestData = array_diff($requestData, $someData);
        $oldData = array_diff($oldData, $someData);
        foreach($requestData as $influencer_Platform)
        {
            $this->influencerGroupLogService->store(new Request(['influencer_group_id' => $data->id, 'influencer_follower_platform_id' => $influencer_Platform]));
            $d = $this->influencerFollowerPlatformService->show($influencer_Platform);
            if($d->influencer_group_id != 0)
            {
                $this->influencerGroupLogService->store(new Request(['influencer_group_id' => $d->influencer_group_id, 'influencer_follower_platform_id' => $influencer_Platform, 'type' => 2,'new_influencer_group_id'=>$id]));
            }
            $this->influencerFollowerPlatformService->update(new Request(['influencer_group_id' => $data->id]),
                $influencer_Platform);
        }
        foreach($oldData as $influencer_Platform)
        {
            $this->influencerGroupLogService->store(new Request(['influencer_group_id' => $data->id, 'influencer_follower_platform_id' => $influencer_Platform, 'type' => 0]));
            $this->influencerFollowerPlatformService->update(new Request(['influencer_group_id' => 0]),
                $influencer_Platform);
        }
    }

    public function list(Request $request)
    {
        return InfluencerGroupListResource::collection($this->repo->findBy($request));
    }

    public function platformList()
    {
        return $this->platformService->list(new Request(['active' => activeType()['as']]));
    }

    public function influencerSearch(Request $request)
    {
        $moreConditionForFirstLevel = [];
        if(!empty($request->platform_id))
        {
            $newRequest = new Request(['platform_id' => $request->platform_id]);
            if(user()->match_search)
            {
                $s = '%' . $request->term . '%';
                $operator = 'like';
            }else
            {
                $s = $request->term;
                $operator = '=';
            }
            $recursiveRel = ['influencer' => [
                'type' => 'whereHas',
                'where' => ['active' => activeType()['as']],
                'whereCustom' => [
                    'orWhere' => [
                        ['name_en' => [$operator, $s]], ['name_ar' => [$operator, $s]]
                    ]],
            ]
            ];
            if($request->influencer)
            {
                $moreConditionForFirstLevel = ['whereNotIn' => ['id' => $request->influencer]];
            }
            return $this->influencerFollowerPlatformService->findBy($newRequest, recursiveRel: $recursiveRel,
                moreConditionForFirstLevel: $moreConditionForFirstLevel,withRelations:['influencer.ad_record','platform','influencer_group']);
        }
        return [];
    }

    public function uploadInfluencer(Request $request)
    {
        $moreConditionForFirstLevel = [];
        $newRequest = new Request(['platform_id' => $request->platform]);
        if($request->file)
        {
            $influencer=$this->uploadFile($request->file);
            $id = $this->influencerService->findBy(new Request(),moreConditionForFirstLevel:[
                'whereCustom' => [
                    'orWhereIn' => [
                        ['name_en' => $influencer], ['name_ar' => $influencer]
                    ]],
            ],pluck:['id','id']);
            $moreConditionForFirstLevel =[
                'whereCustom' => [
                    'orWhereIn' => [
                        ['influencer_id' => $id->toArray()],['url'=>$influencer]
                    ]],
            ];
        }
        if($request->key)
        {
            $influencer = \Arr::pluck(json_decode($request->key,1),'value');
            $moreConditionForFirstLevel =[
                    'whereIn' => [
                        'url'=>$influencer
                    ],
            ];
        }
        if($request->influencer_id)
        {
            $infId=explode(',',$request->influencer_id);
            $moreConditionForFirstLevel += ['whereNotIn' => ['id' => $infId]];
        }
        return $this->influencerFollowerPlatformService->findBy($newRequest, moreConditionForFirstLevel: $moreConditionForFirstLevel);
    }
    public function uploadInfluencerCheck(Request $request)
    {
        $moreConditionForFirstLevel = [];
        $newRequest = new Request(['platform_id' => $request->platform]);
        if($request->key)
        {
            $influencer = \Arr::pluck(json_decode($request->key,1),'value');
            $moreConditionForFirstLevel =[
                'whereIn' => [
                    'url'=>$influencer
                ],
            ];
        }
        $old = $this->influencerFollowerPlatformService->findBy($newRequest, moreConditionForFirstLevel: $moreConditionForFirstLevel,pluck:['url','id'])->toArray();
        return array_diff($influencer ?? [],$old);
    }


    public function uploadFile($file)
    {
        $array= Excel::toArray(new InfluencerGroupCreate, $file);
        return array_unique(array_merge(...array_merge(...$array)));
    }

    public function delete($id)
    {
        $data = false;
        if(is_array($id))
        {
            foreach($id as $i)
            {
                $g = $this->repo->findOne($i);
                $g->influencer_follower_platform()->update(['influencer_group_id' => 0]);
                $data = $this->repo->delete($i);
            }
        }else
        {
            $g = $this->repo->findOne($id);
            if($g)
            {
            $g->influencer_follower_platform()->update(['influencer_group_id' => 0]);
            $data = $this->repo->delete($id);
            }
        }
        return $data;
    }
}
