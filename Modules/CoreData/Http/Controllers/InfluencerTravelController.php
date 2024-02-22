<?php

namespace Modules\CoreData\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportInfluencerTravel;
use Modules\CoreData\Http\Requests\InfluencerTravel\CreateRequest;
use Modules\CoreData\Http\Requests\InfluencerTravel\EditRequest;
use Modules\CoreData\Service\InfluencerTravelService;

class InfluencerTravelController extends BasicController
{
    protected $service;

    public function __construct(InfluencerTravelService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_influencer_travel')->only('index');
        $this->middleware('permission:create_influencer_travel')->only(['create','store']);
        $this->middleware('permission:update_influencer_travel')->only(['edit','update']);
        $this->middleware('permission:delete_influencer_travel')->only('destroy');
        $this->middleware('permission:export_influencer_travel')->only('export');
        $this->service = $Service;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if(isset($request->influencer_id))
        {
            $influencers_data = $this->service->influencerList(new request(['id' => $request->influencer_id]));
        }
        $dates = $this->service->findBy($request, true, $this->perPage(),withRelations:['influencer','country','city']);
        if($request->ajax())
        {
            return view(checkView('coredata::influencer_travel.table'), get_defined_vars());
        }
        return view(checkView('coredata::influencer_travel.index'), get_defined_vars());
    }

    public function create(Request $request)
    {
        $country = $this->service->countryList();
        return view(checkView('coredata::influencer_travel.create'),get_defined_vars());
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('influencer_travel.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer_travel.create'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $country = $this->service->countryList();
        $data = $this->service->show($id);
        return view(checkView('coredata::influencer_travel.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id)
    {
        if($this->service->update($request, $id))
        {
            return redirect(route('influencer_travel.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer_travel.edit'))->with(getCustomTranslation('problem'));
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportInfluencerTravel($request), "influencer_travel.xlsx");
    }

}
