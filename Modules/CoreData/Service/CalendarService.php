<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Repositories\CalendarRepository;
use Modules\CoreData\Http\Resources\Calendar\CalendarResource;

class CalendarService extends BasicService
{
    protected  $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(CalendarRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Support\Collection|array|null
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel, $withRelations);
    }

    public function store(Request $request,bool $sync_influencers = false)
    {
        return $this->repo->save($request,sync_influencers:$sync_influencers);
    }

    public function update(Request $request, $id,bool $sync_influencers = false)
    {
        $data = $this->repo->save($request, $id,sync_influencers:$sync_influencers);
        return new CalendarResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return CalendarResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage));
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return true;
    }
}
