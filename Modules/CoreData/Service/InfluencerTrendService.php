<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\InfluencerService;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Repositories\InfluencerTrendRepository;

class InfluencerTrendService extends BasicService
{
    protected $repo, $countryService, $influencerService, $platformService, $tagService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerTrendRepository $repository, CountryService $countryService,
        InfluencerService $influencerService, PlatformService $platformService, TagService $tagService)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
        $this->influencerService = $influencerService;
        $this->platformService = $platformService;
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
        return $this->countryService->list(new Request());
    }

    public function influencerList(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->influencerService->list($request);
    }

    public function platformList(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->platformService->list($request);
    }

    public function tagList(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->tagService->list($request);
    }
}