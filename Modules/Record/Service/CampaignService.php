<?php

namespace Modules\Record\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\CompanyService;
use Modules\Basic\Service\BasicService;
use Modules\Acl\Service\InfluencerService;
use Modules\Record\Repositories\CampaignRepository;
use Modules\Record\Http\Resources\Campaign\CampaignResource;
use Modules\Record\Http\Resources\Campaign\CampaignListResource;

class CampaignService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(CampaignRepository $repository, InfluencerService $influencerService, CompanyService $companyService)
    {
        $this->repo = $repository;
        $this->influencerService = $influencerService;
        $this->companyService = $companyService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $withRelations = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $withRelations);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new CampaignResource($data);
    }

    public function list(Request $request)
    {
        return CampaignListResource::collection($this->repo->findBy($request));
    }

    public function companyList()
    {
        return $this->companyService->list(new Request());
    }

    public function influencerList(Request $request)
    {
        $request->merge(['active'=>activeType()['as']]);
        return $this->influencerService->list($request);
    }
}
