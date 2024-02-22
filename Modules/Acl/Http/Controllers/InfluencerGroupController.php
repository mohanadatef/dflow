<?php

namespace Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Export\ExportInfluencerGroup;
use Modules\Acl\Http\Requests\InfluencerGroup\CreateRequest;
use Modules\Acl\Http\Requests\InfluencerGroup\EditRequest;
use Modules\Acl\Http\Resources\InfluencerGroup\InfluencerSearchResource;
use Modules\Acl\Service\InfluencerGroupService;
use Modules\Basic\Http\Controllers\BasicController;
use Yajra\DataTables\Facades\DataTables;

/**
 * @extends BasicController
 * controller user about web function
 */
class InfluencerGroupController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(InfluencerGroupService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_influencer_group')->only('index');
        $this->middleware('permission:create_influencer_group')->only('create');
        $this->middleware('permission:create_influencer_group')->only('store');
        $this->middleware('permission:update_influencer_group')->only('edit');
        $this->middleware('permission:update_influencer_group')->only('update');
        $this->middleware('permission:delete_influencer_group')->only('destroy');
        $this->middleware('permission:export_influencer_group')->only('export');
        $this->service = $Service;
    }

    /**
     * @param Request $request
     * @return View
     * get all user to manage it
     */
    public function index(Request $request)
    {
        $datas = $this->service->findBy($request, pagination: true,perPage:$this->perPage(),withRelations:['influencer_follower_platform.platform',
            'influencer_follower_platform.reseacher_influencers_daily']);
        if($request->ajax())
        {
            return view('acl::influencer_group.table', compact('datas'));
        }
        return view('acl::influencer_group.index', compact('datas'));
    }

    public function create()
    {
        $platform = $this->service->platformList();
        return view('acl::influencer_group.create', compact( 'platform'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('influencer_group.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer_group.edit'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        $platform = $this->service->platformList();
        return view('acl::influencer_group.edit', compact('data', 'platform'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('influencer_group.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer_group.edit'))->with(getCustomTranslation('problem'));
    }

    public function show($id)
    {
        $data = $this->service->show($id);
        return view(checkView('acl::influencer_group.show'), compact('data'));
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportInfluencerGroup($request), "influencerGroup.xlsx");
    }

    public function influencerSearch(Request $request)
    {
        $data = $this->service->influencerSearch($request);
        return response()->json(InfluencerSearchResource::collection($data));
    }

    public function uploadInfluencer(Request $request)
    {
        $data = $this->service->uploadInfluencer($request);
        return response()->json(InfluencerSearchResource::collection($data));
    }

    public function uploadInfluencerCheck(Request $request)
    {
        $data = $this->service->uploadInfluencerCheck($request);
        return response()->json(implode(',',$data));
    }
}
