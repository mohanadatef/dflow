<?php

namespace Modules\Acl\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Acl\Http\Requests\InfluencerGroupSchedule\CreateRequest;
use Modules\Acl\Http\Resources\InfluencerGroup\InfluencerGroupListResource;
use Modules\Acl\Service\InfluencerGroupScheduleService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller user about web function
 */
class InfluencerGroupScheduleController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(InfluencerGroupScheduleService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_influencer_group_schedule')->only('index');
        $this->middleware('permission:create_influencer_group_schedule')->only('store');
        $this->middleware('permission:delete_influencer_group_schedule')->only('destroy');
        $this->service = $Service;
    }

    /**
     * @param Request $request
     * @return View
     * get all user to manage it
     */
    public function index(Request $request)
    {
        $today = weekScheduleKey()[strtolower(Carbon::today()->format('l'))];
        $day = $request->day ?? $today;
        $datas = $this->service->findBy(new Request(), pagination: $this->pagination(),perPage:$this->perPage(),withRelations:['influencer_group']);
        $researchers = $this->service->researcherList();
        if($request->ajax())
        {
            return view('acl::influencer_group_schedule.table', get_defined_vars());
        }
        return view('acl::influencer_group_schedule.index', get_defined_vars());
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return response()->json([]);
        }
        return response()->json([]);
    }

    public function edit(Request $request,$researcher_id)
    {
        $datas = $this->service->researcherData($researcher_id);
        $researchers = $this->service->researcherList(moreConditionForFirstLevel:['where'=>['id'=>['!=',$researcher_id]]]);
        if($request->ajax())
        {
            return view('acl::influencer_group_schedule.daily.table', get_defined_vars());
        }
        return view('acl::influencer_group_schedule.daily.index', get_defined_vars());
    }

    public function influencerGroupRemainder(Request $request)
    {
        return response()->json(InfluencerGroupListResource::collection($this->service->influencerGroupRemainder($request)));
    }
    public function scanTable() {
        $this->service->scanTable();
        return redirect()->back()->with('success', 'Success!');
    }
}
