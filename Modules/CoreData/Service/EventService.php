<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\InfluencerService;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Repositories\EventRepository;

class EventService extends BasicService
{
    protected $repo,$countryService,$influencerService,$categoryService,$tagService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(EventRepository $repository,LocationService $countryService,InfluencerService $influencerService,
        CategoryService $categoryService,TagService $tagService)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
        $this->influencerService = $influencerService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
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
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['subject' => [$operator, $s]], ['brief' => [$operator, $s]]
                    ]],
            ];
            $recursiveRel = ['tag' =>
                [
                    'type' => 'whereHas',
                    'orWhere' => ['name_en' =>  [$operator, $s]],
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
    public function categoryList(Request $request)
    {
        $request->merge(['active'=>activeType()['as']]);
        return $this->categoryService->list($request);
    }
    public function tagList(Request $request)
    {
        $request->merge(['active'=>activeType()['as']]);
        return $this->tagService->list($request);
    }
}
