<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\Platform\PlatformListResource;
use Modules\CoreData\Http\Resources\Platform\PlatformResource;
use Modules\CoreData\Repositories\PlatformRepository;

class PlatformService extends BasicService
{
    protected $repo, $serviceService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(PlatformRepository $repository, ServiceService $serviceService)
    {
        $this->repo = $repository;
        $this->serviceService = $serviceService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new PlatformResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return PlatformListResource::collection($this->repo->findBy($request, [], $recursiveRel, $pagination, $perPage, withRelations:['icon', 'service']));
    }

    public function listService()
    {
        return $this->serviceService->list(new Request());
    }
}
