<?php

namespace Modules\Record\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Acl\Service\UserService;
use Modules\Basic\Service\BasicService;
use Modules\Record\Repositories\AdRecordErrorRepository;
use Modules\Setting\Service\NotificationService;

class AdRecordErrorService extends BasicService
{
    protected $repo, $userService, $notificationService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(AdRecordErrorRepository $repository, UserService $userService, NotificationService $notificationService)
    {
        $this->repo = $repository;
        $this->userService = $userService;
        $this->notificationService = $notificationService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [], $column = ['*'], $orderBy = [],
        $latest = '')
    {
        if(!user()->can('create_errors_ad_record'))
        {
            $request->merge(['ad_record_owner_id' => user()->id]);
        }
        if(isset($request->creation_start) && !empty($request->creation_start) && isset($request->creation_end) && !empty($request->creation_end))
        {
            $moreConditionForFirstLevel += ['whereBetween' => ['created_at' => [$request->creation_start, $request->creation_end]]];
        }elseif(isset($request->creation_end) && !empty($request->creation_end)){
            $moreConditionForFirstLevel += ['where' => ['created_at' => ['<=',$request->creation_end]]];

        }elseif(isset($request->creation_end) && !empty($request->creation_end)){
            $moreConditionForFirstLevel += ['where' => ['created_at' => ['>=',$request->creation_end]]];

        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel,
            $recursiveRel, $relation, $column, $orderBy, $latest);
    }

    public function store(Request $request)
    {
        $request->merge(['created_by_id' => user()->id]);
        $data = $this->repo->save($request);
        notificationStore('create_error', $data->ad_record, $data->ad_record->user_id, $data->ad_record->id);
        return $data;
    }

    public function researcherList()
    {
        return $this->userService->list(new Request(['role_id' => 3]));
    }

    public function update(Request $request)
    {
        $new_request = new Request(['action_at' => Carbon::now(), 'action_by_id' => user()->id,'action'=>1]);
        $data = $this->repo->save($new_request,$request->error_id ?? request('error_id'));
        notificationStore('solve_error', $data->ad_record, $data->ad_record->user_id, $data->ad_record->id);
        return $data;
    }

    public function cancel(){
        $data = $this->repo->cancel(request('error_id'));
        notificationStore('cancel_error', $data->ad_record, $data->ad_record->user_id, $data->ad_record->id);
        return $data;
    }
}
