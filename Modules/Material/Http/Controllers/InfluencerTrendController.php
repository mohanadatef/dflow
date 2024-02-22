<?php

namespace Modules\Material\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Material\Export\ExportInfluencerTrend;
use Modules\Material\Http\Requests\InfluencerTrend\CreateRequest;
use Modules\Material\Http\Requests\InfluencerTrend\EditRequest;
use Modules\Material\Service\InfluencerTrendService;

class InfluencerTrendController extends BasicController
{
    protected $service;

    public function __construct(InfluencerTrendService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_influencer_trend')->only('index');
        $this->middleware('permission:create_influencer_trend')->only(['create','store']);
        $this->middleware('permission:update_influencer_trend')->only(['edit','update']);
        $this->middleware('permission:delete_influencer_trend')->only('destroy');
        $this->middleware('permission:export_influencer_trend')->only('export');
        $this->service = $Service;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if(isset($request->influencer))
        {
            $influencers_data = $this->service->influencerList(new request(['id' => $request->influencer_id]));
        }
        $dates = $this->service->findBy($request, true, $this->perPage(),withRelations:['influencer','platform','country','tag']);
        if($request->ajax())
        {
            return view(checkView('material::influencer_trend.table'), get_defined_vars());
        }
        return view(checkView('material::influencer_trend.index'), get_defined_vars());
    }

    public function create(Request $request)
    {
        $country = $this->service->countryList();
        $tag = $this->service->tagList(new Request());
        return view(checkView('material::influencer_trend.create'),get_defined_vars());
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('influencer_trend.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer_trend.create'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $country = $this->service->countryList();
        $tag = $this->service->tagList(new Request());
        $data = $this->service->show($id);
        return view(checkView('material::influencer_trend.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id)
    {
        if($this->service->update($request, $id))
        {
            return redirect(route('influencer_trend.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer_trend.edit'))->with(getCustomTranslation('problem'));
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportInfluencerTrend($request), "influencer_trend.xlsx");
    }

}
