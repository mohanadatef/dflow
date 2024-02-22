<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\PromotionType\PromotionTypeListResource;
use Modules\CoreData\Http\Resources\PromotionType\PromotionTypeResource;
use Modules\CoreData\Repositories\PromotionTypeRepository;

class PromotionTypeService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(PromotionTypeRepository $repository)
    {
        $this->repo = $repository;
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
        return new PromotionTypeResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return PromotionTypeListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage));
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return true;
    }

}
