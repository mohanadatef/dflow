<?php

namespace Modules\Acl\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Repositories\UserRepository;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Service\PlatformService;
use Modules\Record\Repositories\AdRecordRepository;
use Modules\Basic\Traits\S3Trait;
use Modules\Record\Service\AdRecordErrorService;
use Modules\Record\Service\AdRecordLogService;

/**
 * @method getAccount()
 * @method getSheetDrive($account, $id)
 */
class ResearcherDashboardService extends BasicService
{
    use S3Trait;

    protected $seenMediaService, $repo, $adRecordRepository, $adRecordLogService, $platformService,
        $influencerPlatformService, $reseacherInfluencersDailyService, $adRecordErrorService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository, PlatformService $platformService,
        ReseacherInfluencersDailyService $reseacherInfluencersDailyService, AdRecordRepository $adRecordRepository,
        InfluencerFollowerPlatformService $influencerPlatformService, SeenMediaService $seenMediaService,
        AdRecordLogService $adRecordLogService, AdRecordErrorService $adRecordErrorService)
    {
        $this->repo = $repository;
        $this->seenMediaService = $seenMediaService;
        $this->adRecordRepository = $adRecordRepository;
        $this->influencerPlatformService = $influencerPlatformService;
        $this->reseacherInfluencersDailyService = $reseacherInfluencersDailyService;
        $this->adRecordLogService = $adRecordLogService;
        $this->adRecordErrorService = $adRecordErrorService;
        $this->platformService = $platformService;
    }

    public function getResearcherData($request, $range_start, $range_end)
    {
        $ads = DB::table('ad_records')->where('user_id', $request->user_id)
            ->select('created_at')->get();
        $data['cards']['allTime'] = $ads->count();
        $data['cards']['today'] = $ads->whereBetween('created_at', [$range_start, $range_end])->count();
        return $data;
    }

    public function getResearcherDraftData($request, $range_start, $range_end)
    {
        $ads = DB::table('ad_record_drafts')->where('user_id', $request->user_id)
            ->select('created_at')->get();
        $data['cards']['allTime'] = $ads->count();
        $data['cards']['today'] = $ads->whereBetween('created_at', [$range_start, $range_end])->count();
        return $data;
    }

    public function get_chart_data($request)
    {
        $user = $this->repo->findOne($request->user_id);
        if($user)
        {
            $dates = collect();
            foreach(range(14, 0) as $i)
            {
                $date = !empty(Carbon::parse($request->search_day)) ? Carbon::parse($request->search_day)->subDays($i)
                    ->format('Y-m-d') : Carbon::yesterday()->subDays($i)->format('Y-m-d');
                $dates->put($date, 0);
            }
            $records = $user->adRecords()->whereBetween('created_at', [$dates->keys()->first(), $dates->keys()->last()])
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                ->orderBy('created_at')
                ->get([
                    DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d')) as date"),
                    DB::raw('COUNT( * ) as "count"')
                ])
                ->pluck('count', 'date');
            $records = $dates->merge($records);
            return ['first' => $dates->keys()->first(), 'last' => $dates->keys()->last(), 'records' => $records];
        }
    }

    public function get_completed_chart_data($request)
    {
        $recursiveRel = [];
        if(!empty($request->platform_id))
        {
            $recursiveRel = ['influencer_follower_platform' => ['type' => 'whereHas'
                , 'where' => ['platform_id' => $request->platform_id]]];
        }
        $newRequest=new Request(['researcher_id' => $request->user_id]);
        if(Carbon::now()->format('H') >= '09' && Carbon::now()->format('H') <= '18')
        {
            $newRequest->merge(['shift'=>0]);
        }
        $influencerGroups = $this->reseacherInfluencersDailyService->findBy($newRequest,
            column: ['id', 'is_complete'], pluck: ['is_complete', 'id'], recursiveRel: $recursiveRel,
            moreConditionForFirstLevel: ['whereBetween' => ['date' => [Carbon::parse($request->search_day)
                ->format('Y-m-d 00:00:00'), Carbon::parse($request->search_day)->format('Y-m-d 23:59:00')]]])
            ->toArray();
        $c = array_count_values($influencerGroups);
        if(count($c))
        {
            $completed['completed'] = $c[1] ?? 0 + $c[0] ?? 0;
            $completed['completed_ads'] = $c[1] ?? 0;
            $completed['incompleted_ads'] = $c[0] ?? 0;
        }else
        {
            $completed['completed'] = 0;
            $completed['completed_ads'] = 0;
            $completed['incompleted_ads'] = 0;
        }
        return $completed;
    }

    public function getResearcherChart($request)
    {
        $start = Carbon::parse($request->search_day)->startOfDay();
        $end = Carbon::parse($request->search_day)->endOfDay();
        $datas = $this->adRecordRepository->findBy($request, relation: ['company', 'category', 'influencer'],
            moreConditionForFirstLevel: ['whereBetween' => ['created_at' => [$start, $end]]],
            orderBy: ['column' => 'id', 'order' => 'desc']);
        return $datas;
    }

    public function getInfluencerTable(Request $request, $range_start, $range_end, $perPage,$page=1)
    {
        $recursiveRel = [];
        if(!empty($request->platform_id))
        {
            $recursiveRel = ['influencer_follower_platform' => ['type' => 'whereHas'
                , 'where' => ['platform_id' => $request->platform_id]]];
        }
        $newRequest=new Request(['researcher_id' => $request->user_id]);
        if(Carbon::now()->format('H') >= '09' && Carbon::now()->format('H') <= '18')
        {
            $newRequest->merge(['shift'=>0]);
        }
        $influencerGroups = $this->reseacherInfluencersDailyService->findBy($newRequest,recursiveRel:$recursiveRel,
            moreConditionForFirstLevel:['whereBetween' => ['date' => [Carbon::parse($request->search_day)
                ->format('Y-m-d 00:00:00'), Carbon::parse($request->search_day)->format('Y-m-d 23:59:00')]]] );
        $platforms = $this->influencerPlatformService->findBy(new Request(), withRelations: ['influencer', 'platform'],
            moreConditionForFirstLevel: ['whereIn' => ['id' => $influencerGroups->pluck('influencer_follower_platform_id')
                ->toArray()]]);
        $request->merge(['date' => Carbon::parse($range_start)
            ->format('Y-m-d'), 'url' => $platforms->where('platform_id', 1)->pluck('url')->toArray()]);
        $adsCount = $this->adRecordRepository->findBy(new Request([
            'influencer_id' => array_unique($platforms->pluck('influencer_id')->toArray()),
            'platform_id' => array_unique($platforms->pluck('platform_id')->toArray())]),
            moreConditionForFirstLevel: ['whereBetween' => ['created_at' => [$range_start, $range_end]]]);
        //handle trait and get files from smd to files key below
        $files = $this->getFiles($request);
        $seen = $this->seenMediaService->findBy(new Request(),
            moreConditionForFirstLevel: ['where' => ['created_at' => ['>=', Carbon::parse($request->search_day)
                ->subDays(30)
                ->format('Y-m-d 00:00:00')]], 'whereIn' => ['name' => array_merge(...array_values($files))]]);
        foreach($platforms as $platform)
        {
            $platform->files = 0;
            $platform->files_count_seen = 0;
            if($platform->platform_id == 1)
            {
                if(isset($files[$platform->url]))
                {
                    $platform->files_count_seen = $seen->whereIn('name', $files[$platform->url])->count();
                    $platform->files = count($files[$platform->url]);
                }
                $request->merge([
                    'id' => $platform->id,
                    'date' => Carbon::parse($request->search_day)
                        ->format('Y-m-d')
                ]);
            }
            $bool = $influencerGroups->where('influencer_follower_platform_id', $platform->id)->first()->is_complete ? 1 : 0;
            if($platform->files)
            {
                if($bool == 0 && $platform->files == $platform->files_count_seen)
                {
                    $this->toggleComplete(new Request(['id' => $platform->id, 'search_day' => Carbon::parse($request->search_day)->format('Y-m-d')]));
                    $bool = 1;
                }
            }
            $platform->is_complete = $bool;
            $platform->ads_count = $adsCount->where('influencer_id', $platform->influencer_id)
                ->where('platform_id', $platform->platform_id)->count();
        }
        $platforms = $platforms->sortBy('is_complete');
        return new LengthAwarePaginator($platforms->forPage($page, $perPage), $platforms->count(),
            $perPage, $page, ['path' => route('researcher_dashboard.researcherDashboard')]);
    }

    public function media_seen_chart_data($request)
    {
        $recursiveRel = [];
        if(!empty($request->platform_id))
        {
            $recursiveRel = ['influencer_follower_platform' => ['type' => 'whereHas'
                , 'where' => ['platform_id' => $request->platform_id]]];
        }
        $newRequest=new Request(['researcher_id' => $request->user_id]);
        if(Carbon::now()->format('H') >= '09' && Carbon::now()->format('H') <= '18')
        {
            $newRequest->merge(['shift'=>0]);
        }
        $influencerGroups = $this->reseacherInfluencersDailyService->findBy($newRequest,
            column: ['influencer_follower_platform_id'],recursiveRel:$recursiveRel,
            moreConditionForFirstLevel: ['whereBetween' => ['date' => [Carbon::parse($request->search_day)
                ->format('Y-m-d 00:00:00'), Carbon::parse($request->search_day)->format('Y-m-d 23:59:00')]]]);
        $platforms = $this->influencerPlatformService->findBy(new Request(),
            moreConditionForFirstLevel: ['whereIn' => ['id' => $influencerGroups->pluck('influencer_follower_platform_id')
                ->toArray()]]);
        $request->merge(['date' => Carbon::parse($request->search_day)
            ->format('Y-m-d'), 'url' => $platforms->where('platform_id', 1)->pluck('url')->toArray()]);
        $files = $this->getFiles($request);
        $files = array_merge(...array_values($files));
        $seen = $this->seenMediaService->findBy(new Request(),
            moreConditionForFirstLevel: ['where' => ['created_at' => ['>=', Carbon::parse($request->search_day)
                ->subDays(30)
                ->format('Y-m-d 00:00:00')]], 'whereIn' => ['name' => $files]])->count();
        $media['total'] = count($files);
        $media['seen'] = $seen;
        $media['unseen'] = $media['total'] - $seen;
        return $media;
    }

    public function error_count($request, $range_start, $range_end)
    {
        $moreConditionForFirstLevel = [
            'where' =>
                ['action' => 0]
            , 'whereBetween' => ['created_at' => [$range_start, $range_end]]
        ];
        return $this->adRecordErrorService->findBy($request, moreConditionForFirstLevel: $moreConditionForFirstLevel,
            get: 'count');
    }

    public function getLogsTable(Request $request, $start, $end, $perPage = 10)
    {
        return $this->adRecordLogService->findBy($request, relation: ['user'], perPage: $perPage, pagination: true,
            moreConditionForFirstLevel: ['whereBetween' => ['created_at' => [$start, $end]]]);
    }

    public function toggleComplete(Request $request)
    {
        return $this->reseacherInfluencersDailyService->toggleComplete($request);
    }

    public function mediaFileSeen(Request $request)
    {
        return $this->seenMediaService->store($request);
    }

    public function media_seen_file(Request $request)
    {
        $filestd = [];
        $files = $this->getFiles(new Request(['date' => Carbon::parse($request->search_day)
            ->format('Y-m-d'), 'url' => $request->url]));
        $seen = $this->seenMediaService->findBy(new Request(),
            moreConditionForFirstLevel: ['where' => ['created_at' => ['>=', Carbon::parse($request->search_day)
                ->subDays(30)
                ->format('Y-m-d 00:00:00')]], 'whereIn' => ['name' => $files]]);
        foreach($files as $file)
        {
            $filestd[] = [
                'file' => $file, 'seen' => $seen->where('name', $file)->first() ? 1 : 0
            ];
        }
        return $filestd;
    }

    public function platformList()
    {
        return $this->platformService->list(new Request(['active' => activeType()['as']]));
    }
}
