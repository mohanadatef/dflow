<?php

namespace Modules\Material\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\InfluencerService;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Service\LocationService;
use Modules\CoreData\Service\TagService;
use Modules\Material\Repositories\InfluencerTrendRepository;

class InfluencerTrendService extends BasicService
{
    protected $repo, $countryService, $influencerService, $tagService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerTrendRepository $repository, LocationService $countryService,
        InfluencerService $influencerService,  TagService $tagService)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
        $this->influencerService = $influencerService;
        $this->tagService = $tagService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = [], $column = ['*'])
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
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['subject' => [$operator, $s]], ['brief' => [$operator, $s]]],
                ]];
            $recursiveRel = ['tag' =>
                [
                    'type' => 'whereHas',
                    'orWhere' => ['name_en' => [$operator, $s], 'name_ar' => [$operator, $s]],
                ]];
        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel,
            $recursiveRel, $withRelations, $column);
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
        $request->merge(['active' => activeType()['as']]);
        return $this->influencerService->list($request);
    }

    public function tagList(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->tagService->list($request);
    }
}
