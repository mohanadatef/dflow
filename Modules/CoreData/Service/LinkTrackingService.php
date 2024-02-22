<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\LinkTracking\LinkTrackingListResource;
use Modules\CoreData\Http\Resources\LinkTracking\LinkTrackingResource;
use Modules\CoreData\Repositories\LinkTrackingRepository;

class LinkTrackingService extends BasicService
{
    protected $repo, $countryService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(LinkTrackingRepository $repository, LocationService $countryService)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [])
    {
        if(!in_array(user()->role_id ,[ 1 , 10]))
        {
            $request->merge(['user_id'=>user()->id]);
        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel);
    }

    public function findByLinkId($linkId)
    {
        return $this->repo->findByLinkId($linkId);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new LinkTrackingResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return LinkTrackingListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage));
    }

    public function listCountries()
    {
        return $this->countryService->findBy(new Request(['parent_id'=>0]));
    }
}
