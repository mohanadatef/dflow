<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\InfluencerService;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Repositories\InfluencerTravelRepository;

class InfluencerTravelService extends BasicService
{
    protected $repo,$countryService,$influencerService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerTravelRepository $repository,LocationService $countryService,InfluencerService $influencerService)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
        $this->influencerService = $influencerService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = [],$column=['*'])
    {
        if(isset($request->search) && $request->search != null)
        {
            if(user()->match_search)
            {
                $s = '%' . $request->search . '%';
                $operator = 'like';
            }else
            {
                $s = $request->link;
                $operator = '=';
            }
            $recursiveRel = ['influencer' =>
                [
                    'type' => 'whereHas',
                    'where' => ['name_en' =>  [$operator, $s]],
                    'orWhere' => ['name_ar' =>  [$operator, $s]],
                ]];
        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel, $withRelations, $column);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        return $this->repo->save($request, $id);
    }

    public function delete($id): bool
    {
        $this->repo->delete($id);
        return true;
    }

    public function countryList()
    {
        return $this->countryService->list(new Request(['active'=>activeType()['as']]));
    }

    public function influencerList(Request $request)
    {
        $request->merge(['active'=>activeType()['as']]);
        return $this->influencerService->list($request);
    }
}
