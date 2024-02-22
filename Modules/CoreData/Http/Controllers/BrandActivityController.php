<?php

namespace Modules\CoreData\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportBrandActivity;
use Modules\CoreData\Http\Requests\BrandActivity\CreateRequest;
use Modules\CoreData\Http\Requests\BrandActivity\EditRequest;
use Modules\CoreData\Service\BrandActivityService;

class BrandActivityController extends BasicController
{
    protected $service;

    public function __construct(BrandActivityService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_brand_activity')->only('index');
        $this->middleware('permission:create_brand_activity')->only(['create','store']);
        $this->middleware('permission:update_brand_activity')->only(['edit','update']);
        $this->middleware('permission:delete_brand_activity')->only('destroy');
        $this->middleware('permission:export_brand_activity')->only('export');
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
        if(isset($request->sponsorship))
        {
            $sponsorship_data = $this->service->sponsorshipList(new request(['id' => $request->sponsorship]));
        }
        $dates = $this->service->findBy($request, true, $this->perPage(),withRelations:['influencer','platform','sponsorship','country','tag']);
        $platforms = $this->service->platformList(new request());
        if($request->ajax())
        {
            return view(checkView('coredata::brand_activity.table'), get_defined_vars());
        }
        return view(checkView('coredata::brand_activity.index'), get_defined_vars());
    }

    public function create(Request $request)
    {
        $country = $this->service->countryList();
        $platform = $this->service->platformList(new Request());
        $tag = $this->service->tagList(new Request());
        return view(checkView('coredata::brand_activity.create'),get_defined_vars());
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('brand_activity.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('brand_activity.create'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $country = $this->service->countryList();
        $platform = $this->service->platformList(new Request());
        $tag = $this->service->tagList(new Request());
        $data = $this->service->show($id);
        return view(checkView('coredata::brand_activity.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id)
    {
        if($this->service->update($request, $id))
        {
            return redirect(route('brand_activity.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('brand_activity.edit'))->with(getCustomTranslation('problem'));
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportBrandActivity($request), "brand_activity.xlsx");
    }

}
