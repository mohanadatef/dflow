<?php

namespace Modules\Record\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Record\Service\CampaignService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Http\Requests\Campaign\EditRequest;
use Modules\Record\Http\Requests\Campaign\CreateRequest;

class CampaignController extends BasicController
{
    protected $service;

    public function __construct(CampaignService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_campaigns')->only('index');
        $this->middleware('permission:create_campaigns')->only('create');
        $this->middleware('permission:create_campaigns')->only('store');
        $this->middleware('permission:update_campaigns')->only('edit');
        $this->middleware('permission:update_campaigns')->only('update');
        $this->middleware('permission:delete_campaigns')->only('destroy');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $datas = $this->service->findBy($request, true, $this->perPage(), ['company', 'influencer']);
        return view(checkView('record::campaign.index'), compact('datas'));
    }

    public function create(Request $request)
    {
        $influencer = $this->service->influencerList(new Request());
        $company = $this->service->companyList();
        return view(checkView('record::campaign.create'), compact('influencer', 'company'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('campaign.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('campaign.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        $influencer = $this->service->influencerList(new Request());
        $company = $this->service->companyList();

        return view(checkView('record::campaign.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('campaign.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('campaign.edit'))->with(getCustomTranslation('problem'));
    }

}
