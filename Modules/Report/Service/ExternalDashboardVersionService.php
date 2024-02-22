<?php

namespace Modules\Report\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Report\Repositories\ExternalDashboardVersionRepository;

class ExternalDashboardVersionService extends BasicService
{
    protected $repo,$externalDashboardService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(ExternalDashboardVersionRepository $repository,ExternalDashboardService $externalDashboardService)
    {
        $this->repo = $repository;
        $this->externalDashboardService = $externalDashboardService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $relation = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, relation:$relation);
    }

    public function change(Request $request,$id)
    {
        $data = $this->repo->findOne($id);
        $newRequest = new Request(['major' => $data->major, 'minor' => $data->minor, 'batch' => $data->batch,'change_version'=>1]);
        $newRequest->merge((array)json_decode($data->dashboard_data));
        return $this->externalDashboardService->update($newRequest,$data->external_dashboard_id);
    }
}
