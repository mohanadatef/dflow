<?php

namespace Modules\Record\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Record\Repositories\RequestAdMediaAccessRepository;

class RequestAdMediaAccessService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(RequestAdMediaAccessRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $withRelations = [])
    {
        $moreConditionForFirstLevel = [];
        if(isset($request->created_at) && !empty($request->created_at))
        {
            $moreConditionForFirstLevel=['whereBetween'=>['created_at'=>[Carbon::parse($request->created_at)->format('Y-m-d 00:00:00'),Carbon::parse($request->created_at)->format('Y-m-d 23:59:59')]]];
        }
        return $this->repo->findBy($request, $pagination, $perPage, relation:$withRelations,orderBy:['column' => 'created_at', 'order' => 'desc'],moreConditionForFirstLevel:$moreConditionForFirstLevel);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request,$id = null)
    {
        return $this->repo->save($request,$id);
    }
}
