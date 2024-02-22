<?php

namespace Modules\Record\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\CompanyService;
use Modules\Basic\Service\BasicService;
use Modules\Acl\Service\InfluencerService;
use Modules\CoreData\Service\PlatformService;
use Modules\Record\Repositories\ContentRecordRepository;
use Modules\Record\Http\Resources\ContentRecord\ContentRecordResource;
use Modules\Record\Http\Resources\ContentRecord\ContentRecordListResource;

class ContentRecordService extends BasicService
{
    protected
        $repo,
        $platformService,
        $influencerService,
        $companyService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(
        ContentRecordRepository $repository,
        PlatformService $platformService,
        InfluencerService $influencerService,
        CompanyService $companyService
    )
    {
        $this->repo = $repository;
        $this->platformService = $platformService;
        $this->influencerService = $influencerService;
        $this->companyService = $companyService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel,
            $recursiveRel, $relation);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new ContentRecordResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return ContentRecordListResource::collection($this->repo->findBy($request));
    }

    public function companyList()
    {
        return $this->companyService->list(new Request());
    }

    public function platformList()
    {
        return $this->platformService->list(new Request());
    }

    public function influencerList(Request $request)
    {
        $request->merge(['active'=>activeType()['as']]);
        return $this->influencerService->list($request);
    }
}
