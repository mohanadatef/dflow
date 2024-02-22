<?php

namespace Modules\Setting\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Setting\Repositories\SupportCenterQuestionRepository;

class SupportCenterQuestionService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(SupportCenterQuestionRepository $repository)
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
        return $this->repo->save($request);
    }

    public function show($id,$withRelations=[])
    {
        return $this->repo->findOne($id,$withRelations);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return $data;
    }

    public function list(Request $request)
    {
        return $this->repo->list($request);
    }


    public function toggleAnswer()
    {
        return $this->repo->toggleAnswer();
    }
    public function readFiles(Request $request)
    {
        $request->merge(['module' => createFileNameServer($this->repo->model(),$request->id)]);
        return $this->repo->readFiles($request);
    }
}
