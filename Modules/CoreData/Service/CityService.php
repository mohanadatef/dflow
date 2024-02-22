<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\City\CityListResource;
use Modules\CoreData\Http\Resources\City\CityResource;
use Modules\CoreData\Repositories\CityRepository;

class CityService extends BasicService
{
    protected $repo;
    protected $countryService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(CityRepository $repository, CountryService $countryService)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel, $relation);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new CityResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return CityListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage));
    }

    public function countriesList(Request $request)
    {
        return $this->countryService->findBy($request);
    }
}
