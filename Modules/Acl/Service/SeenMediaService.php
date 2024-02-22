<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Repositories\SeenMediaRepository;
use Modules\Basic\Service\BasicService;

class SeenMediaService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(SeenMediaRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*']
        , $pagination = false, $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = [],$pluck=[])
    {
        return $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination,
            $perPage, $recursiveRel, null, $orderBy,$pluck);
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

}
