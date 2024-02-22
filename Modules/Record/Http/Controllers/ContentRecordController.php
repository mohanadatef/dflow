<?php

namespace Modules\Record\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Modules\Record\Service\ContentRecordService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Entities\ShortLink;
use Modules\Record\Http\Requests\ContentRecord\EditRequest;
use Modules\Record\Http\Requests\ContentRecord\CreateRequest;
use Modules\Record\Service\ShortLinkService;

class ContentRecordController extends BasicController
{
    protected $service;
    protected $shortLinkService;

    public function __construct(ContentRecordService $Service ,ShortLinkService $shortLinkService)
    {
        $this->middleware('auth')->except('shortLinkCode');
        $this->middleware('permission:view_content_record')->only('index');
        $this->middleware('permission:create_content_record')->only('create');
        $this->middleware('permission:create_content_record')->only('store');
        $this->middleware('permission:update_content_record')->only('edit');
        $this->middleware('permission:update_content_record')->only('update');
        $this->middleware('permission:delete_content_record')->only('destroy');
        $this->service = $Service;
        $this->shortLinkService = $shortLinkService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $builder = $this->service->findBy($request, false, 10, [], '', [], [], ['company', 'platform', 'influencer']);

            return DataTables::of($builder)->make(true);
        }

        $datas = $this->service->findBy($request, false, 10, [], '', [], [], ['company', 'platform', 'influencer']);

        return view(checkView('record::content_record.index'), compact('datas'));
    }

    public function create(Request $request)
    {
        $influencer = $this->service->influencerList($request);
        $company = $this->service->companyList();
        $platform = $this->service->platformList();
        return view(checkView('record::content_record.create'), get_defined_vars());
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('content_record.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('content_record.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        $influencer = $this->service->influencerList(new Request());
        $company = $this->service->companyList();
        $platform = $this->service->platformList();
        return view(checkView('record::content_record.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('content_record.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('content_record.edit'))->with(getCustomTranslation('problem'));
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortLinkCode($code)
    {
        $shortLink = $this->shortLinkService->findBy(new Request(['code' => $code]), get: 'first');
        if ($shortLink) {
            return view(checkView('record::content_record.showVideo'), compact('shortLink'));
        }
        abort(404);
    }
}
