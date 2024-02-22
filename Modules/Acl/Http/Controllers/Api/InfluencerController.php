<?php

namespace Modules\Acl\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Acl\Http\Resources\Influencer\HanderInfluencerListResource;
use Modules\Acl\Service\InfluencerService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller user about web function
 */
class InfluencerController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(InfluencerService $Service)
    {
        $this->service = $Service;
    }

    public function listHander(Request $request)
    {
        $data= $this->service->listHander($request);
       return $this->apiResponse($data, 'Done');
    }
}
