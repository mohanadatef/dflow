<?php

namespace Modules\Acl\Service;

use Modules\Acl\Repositories\UserRepository;
use Modules\Acl\Repositories\UserWorkingTimeRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Modules\Basic\Service\BasicService;
use Modules\Record\Repositories\AdRecordRepository;

class AdminDashboardService extends BasicService
{
    protected $adRecordRepository;
    protected $userRepository;
    protected $roleService;
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(UserWorkingTimeRepository $repo, AdRecordRepository $adRecordRepository,
        UserRepository $userRepository, RoleService $roleService)
    {
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
        $this->repo = $repo;
        $this->adRecordRepository = $adRecordRepository;
    }

    public function getAdminDashboard($request, $page = 1, $perPage = 10, $date = null)
    {
        $moreConditionForFirstLevel = [];
        if(!empty($request->search))
        {
            $moreConditionForFirstLevel += [
                'whereCustom' => [
                    'where' => [
                        ['name' => $request->search], ['email' => $request->search]
                    ]],
            ];
        }
        if(empty($request->role))
        {
            $recursiveRel = [
                'role' => [
                    'type' => 'whereHas',
                    'where' => ['type' => 0]
                ]
            ];
        }else
        {
            $recursiveRel = [
                'role' => [
                    'type' => 'whereHas',
                    'where' => ['type' => 0, 'id' => $request->role]
                ]
            ];
        }
        $arr = $this->userRepository->findBy($request, moreConditionForFirstLevel: $moreConditionForFirstLevel,
            withRelations: ['role'], recursiveRel: $recursiveRel,
            orderBy: ['column' => 'last_seen_at', 'order' => 'desc']);
        $data = $this->decorateObjects($arr, $request->is_online ?? 0, 0, $date);
        $data['table'] = new LengthAwarePaginator($data['table']->forPage($page, $perPage), $data['table']->count(),
            $perPage, $page, ['path' => route('admin.dashboard')]);
        return $data;
    }

    public function getAdminDashboardLogs($request, $page = 1, $perPage = 10, $date = null)
    {
        $moreConditionForFirstLevel = ['where' => ['date' => Carbon::parse($date['start'])->setTime(0, 0, 0)]];
        $recursiveRel = [];
        if(!empty($request->search))
        {
            if(user()->match_search)
            {
                $s = '%' . $request->search . '%';
                $operator = 'like';
            }else
            {
                $s = $request->search;
                $operator = '=';
            }
            $recursiveRel += ['user' => [
                'type' => 'whereHas',
                'recursive' => [
                    'role' => [
                        'type' => 'whereHas',
                        'where' => ['type' => 0]
                    ]
                ],
                'where' => ['active' => activeType()['as']],
                'whereCustom' => [
                    'orWhere' => [
                        ['name' => [$operator, $s]], ['email' => [$operator, $s]]
                    ]]
            ]];
        }
        if(empty($request->role))
        {
            $recursiveRel += ['user' => [
                'type' => 'whereHas',
                'recursive' => [
                    'role' => [
                        'type' => 'whereHas',
                        'where' => ['type' => 0]
                    ]
                ],
            ]];
        }else
        {
            $recursiveRel += ['user' => [
                'type' => 'whereHas',
                'recursive' => [
                    'role' => [
                        'type' => 'whereHas',
                        'where' => ['type' => 0, 'id' => $request->role]
                    ]
                ],
            ]];
        }
        $arr = $this->repo->findBy($request, $moreConditionForFirstLevel, ['user'], recursiveRel: $recursiveRel,
            orderBy: ['column' => 'last_seen_at', 'order' => 'desc']);
        $data = $this->decorateObjects($arr, 0, 1, $date);
        $data['table'] = new LengthAwarePaginator($data['table']->forPage($page, $perPage), $data['table']->count(),
            $perPage, $page, ['path' => route('admin.dashboard.log')]);
        return $data;
    }

    public function roleList()
    {
        return $this->roleService->list(new Request(['active' => activeType()['as'], 'type' => 0]));
    }

    public function decorateObjects($dat, $is_online = 0, $logs = 0, $date = null)
    {
        $adRecords = $this->adRecordRepository->findBy(new Request(),
            moreConditionForFirstLevel: ['whereBetween' => ['created_at' => [$date['start'], $date['end']]]]);
        $data['cards']['totalAds'] = 0;
        $data['cards']['onlineUsersCount'] = 0;
        $data['cards']['offlineUsersCount'] = 0;
        $data['cards']['awayUsersCount'] = 0;
        foreach($dat as $key => $value)
        {
            if(!$logs)
            {
                if($value->last_seen_at != null || $value->last_seen_at != "")
                {
                    $diff = Carbon::now()->diffInMinutes(Carbon::parse($value->last_seen_at));
                    if($diff <= 10 && Cache::get('user_' . $value['id']) == true)
                    {
                        $data['cards']['onlineUsersCount']++;
                        if(!in_array($is_online, [1, 0]))
                        {
                            unset($dat[$key]);
                            continue;
                        }
                        $value->is_online = 1;
                    }elseif($diff > 20 && Cache::get('user_' . $value['id']) == true)
                    {
                        $data['cards']['awayUsersCount']++;
                        if(!in_array($is_online, [3, 0]))
                        {
                            unset($dat[$key]);
                            continue;
                        }
                        $value->is_online = 3;
                    }elseif(Cache::get('user_' . $value['id']) == false || Cache::get('user_' . $value['id']) == null)
                    {
                        $data['cards']['offlineUsersCount']++;
                        if(!in_array($is_online, [2, 0]))
                        {
                            unset($dat[$key]);
                            continue;
                        }
                        $value->is_online = 2;
                    }
                }else
                {
                    $data['cards']['offlineUsersCount']++;
                    if(!in_array($is_online, [2, 0]))
                    {
                        unset($dat[$key]);
                        continue;
                    }
                    $value->is_online = 2;
                }
            }
            $adRecord = $adRecords->where('user_id', $value->user_id ?? $value->id);
            $first_ad = $adRecord->first();
            $value->first_ad = !empty($first_ad) ? $first_ad->created_at : '--:--';
            $last_ad = $adRecord->last();
            $value->last_ad = !empty($last_ad) ? $last_ad->created_at : '--:--';
            $total_user_records = $adRecord->count();
            $data['cards']['totalAds'] += $total_user_records;
            $value->total_user_records = $total_user_records;
        }
        $data['table'] = $dat;
        return $data;
    }
}
