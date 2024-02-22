<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\City\CityListResource;
use Modules\CoreData\Http\Resources\Country\CountryListResource;
use Modules\CoreData\Http\Resources\Country\CountryResource;
use Modules\CoreData\Repositories\LocationRepository;

class LocationService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(LocationRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = [])
    {
        if(isset($request->search) && $request->search != null)
        {
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['name_en' => $request->search], ['name_ar' => $request->search]
                    ]],
            ];
        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel, $withRelations);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new CountryResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        $request->merge(['parent_id'=>0]);
        return CountryListResource::collection($this->repo->list($request,[],$recursiveRel));
    }

    public function listSpecific(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {

        return CountryListResource::collection($this->repo->listSpecific($request));
    }
    public function cityList(Request $request, $pagination = false, $perPage = 10)
    {
        return CityListResource::collection($this->repo->list($request));
    }


    public function delete($id)
    {
        $this->repo->delete($id);
        return true;
    }

}
