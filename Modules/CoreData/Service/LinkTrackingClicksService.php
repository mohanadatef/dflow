<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\LinkTracking\LinkTrackingListResource;
use Modules\CoreData\Repositories\LinkTrackingClicksRepository;

class LinkTrackingClicksService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(LinkTrackingClicksRepository $repository, LocationService $countryService)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel);
    }

    public function findByLinkId($linkId)
    {
        return $this->repo->findByLinkId($linkId);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return LinkTrackingListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage));
    }

    public function listCountries()
    {
        return $this->countryService->findBy(new Request(['parent_id'=>0]));
    }

    public function get(string $name,int $id,int $limit=0,array $more_columns=[])
    {
        return $this->repo->get($name,$id,$limit,$more_columns);
    }

    public function countriesCount(int $id): int
    {
        return $this->repo->countriesCount($id);
    }

    public function count($id)
    {
        return $this->repo->count($id);
    }

    public function otherCountriesCount($id,$countries_clicks){
        $top_countries = array();
        foreach ($countries_clicks as $item) {
            if ($item->category){
                $top_countries[] = $item->category;
            }
        }
        return $this->repo->otherCountriesCount($id,$top_countries);
    }
}
