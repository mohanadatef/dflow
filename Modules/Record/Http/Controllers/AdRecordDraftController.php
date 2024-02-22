<?php

namespace Modules\Record\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Http\Requests\AdRecordDraft\CreateRequest;
use Modules\Record\Http\Requests\AdRecord\CreateRequest as CreateRequestAd;
use Modules\Record\Http\Requests\AdRecordDraft\EditRequest;
use Modules\Record\Service\AdRecordDraftService;

class AdRecordDraftController extends BasicController
{
    protected $service;

    public function __construct(AdRecordDraftService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_ad_record_draft')->only(['index', 'show']);
        $this->middleware('permission:create_ad_record_draft')->only('store');
        $this->middleware('permission:update_ad_record_draft')->only(['edit', 'update']);
        $this->middleware('permission:delete_ad_record_draft')->only('destroy');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $range_start = $this->service->range_start_date();
        if($request->start)
        {
            $request->request->add(['start' => $range_start]);
        }
        $range_end = $this->service->range_end_date();
        if($request->end)
        {
            $request->request->add(['end' => $range_end]);
        }
        $range_creation_start = $this->service->range_creation_start_date();
        if($request->creation_start || $request->creationD_start)
        {
            $request->request->add(['creation_start' => $range_creation_start]);
        }
        $range_creation_end = $this->service->range_creation_end_date();
        if($request->creation_end || $request->creationD_end)
        {
            $request->request->add(['creation_end' => $range_creation_end]);
        }
        $datas = $this->service->findBy($request, true, $this->perPage(),
            relation: ['company', 'category', 'influencer'],
            orderBy: ['order' => 'desc', 'column' => 'id']);
        $researchers = $this->service->usersList();
        $categories = $this->service->categoryList();
        $platforms = $this->service->platformList();
        if($request->influencer_id)
        {
            $influencers_data = $this->service->influencerList(new request(['id' => $request->influencer_id]));
        }
        if($request->ajax())
        {
            return view(checkView('record::ad_record_draft.table'), get_defined_vars());
        }
        return view(checkView('record::ad_record_draft.index'), get_defined_vars());
    }

    public function show(Request $request, $id)
    {
        $data = $this->service->show($id);
        if($data)
        {
            $data->ad_record_draft_log()->create(['type' => 2, 'user_id' => user()->id]);
            if($data->date)
            {
                $data->date = Carbon::parse($data->date)->format('d-m-Y');
            }
            return view(checkView('record::ad_record_draft.show'), compact('data'));
        }
        return redirect(route('ad_record_draft.index'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('ad_record.create', ['draft' => 1]))->with('message', getCustomTranslation('done'));
        }
        return redirect(route('ad_record.create'))->with('message_false', getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        if($data)
        {
            $country = $this->service->countryList();
            $countrygcc = $this->service->countryListGcc();
            $promotion_type = $this->service->promotionTypeList();
            $industry = $this->service->listCompanyIndustry();
            $sites = $this->service->websiteList();
            return view(checkView('record::ad_record_draft.edit'), get_defined_vars());
        }
        return redirect(route('ad_record_draft.index'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('ad_record_draft.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('ad_record_draft.edit'))->with(getCustomTranslation('problem'));
    }

    public function getFiles(Request $request)
    {
        $files = [];
        $mediaS3 = $request->mediaS3 ?? [];
        $influencer = $this->service->getInfluencer($request->influencer_id);
        if($influencer)
        {
            $platform_id = $this->service->getPlatform();
            $userName = $influencer->influencer_follower_platform()->where('platform_id', $platform_id)->first();
            if($userName)
            {
                $userName = $userName->url;
                $date = $request->date;
                $directory = '/' . $userName . '/' . $date;
                $files = Storage::disk('s3')->allFiles($directory);
            }
            if($request->ad_record_id)
            {
                $ad = $this->service->show($request->ad_record_id);
                if($ad)
                {
                    $mediaS3 = $ad->mediasS3->count() ? $ad->mediasS3->pluck('file')->toArray() : [];
                }
            }
        }
        return view(checkView('record::ad_record.displayDataFromS3'), ['files' => $files, 'mediaS3' => $mediaS3]);
    }

    public function deleteOne($id)
    {
        $data = $this->service->delete($id);
        if($data)
        {
            return redirect(route('ad_record_draft.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('ad_record_draft.index', $id))->with(getCustomTranslation('problem'));
    }

    public function convertToAdRecord(CreateRequestAd $request)
    {
        $success = $this->service->convertToAdRecord($request);
        return redirect()->route('ad_record.show', ['id' => $success['ad_id']]);
    }

    public function checkDuplicates(Request $request)
    {
        $datas = $this->service->checkDuplicates($request);
        if(count($datas) == 0)
        {
            return null;
        }else
        {
            return view(checkView('record::ad_record.ads_table'), ['datas' => $datas]);
        }
    }
}
