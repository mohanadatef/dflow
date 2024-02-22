<?php

namespace Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Acl\Service\InfluencerGroupLogService;
use Modules\Basic\Http\Controllers\BasicController;
use Yajra\DataTables\Facades\DataTables;

/**
 * @extends BasicController
 * controller user about web function
 */
class InfluencerGroupLogController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(InfluencerGroupLogService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $Service;
    }

    /**
     * @param Request $request
     * @return View
     * get all user to manage it
     */
    public function index(Request $request)
    {
        $datas = $this->service->findBy($request,pagination:true,perPage:$this->perPage());
        if($request->ajax())
        {
            return view('acl::influencer_group_log.table', compact('datas'));
        }
        return view('acl::influencer_group_log.index', compact('datas'));
    }

}
