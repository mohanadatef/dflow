<?php

namespace Modules\Setting\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Setting\Repositories\SupportCenterAnswerRepository;

class SupportCenterAnswerService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(SupportCenterAnswerRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
                           $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [], $column = ['*'],
                           $orderBy = [], $latest = '')
    {
        $moreConditionForFirstLevel = [];
        if($request->created_at)
        {
            $created = Carbon::parse($request->created_at)->startOfDay();
            $created_end = Carbon::parse($request->created_at)->endOfDay();
            $moreConditionForFirstLevel += ['whereBetween' => ['created_at' => [$created, $created_end]]];
        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel,
            $recursiveRel, $relation, $column, $orderBy, $latest);
    }

    public function store(Request $request)
    {
        $data = $this->repo->save($request);
        $users = $data->question->answers->pluck('user_id')->toArray();
        $users [] = $data->user_id;
        foreach ($users as $user) {
            if($user != $data->user_id) {
                notificationStore('create_answer', $data->question, $user, $data->id);
            }
        }
        return $data;
    }

}
