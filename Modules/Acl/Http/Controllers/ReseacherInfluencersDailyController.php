<?php

namespace Modules\Acl\Http\Controllers;

use Modules\Acl\Http\Requests\ReseacherInfluencersDaily\EditRequest;
use Modules\Acl\Service\ReseacherInfluencersDailyService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller user about web function
 */
class ReseacherInfluencersDailyController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(ReseacherInfluencersDailyService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:update_influencer_group_schedule')->only('update');
        $this->service = $Service;
    }

    public function changeResearcher(EditRequest $request)
    {
        $data = $this->service->update($request, $request->id);
        if($data)
        {
            return redirect(route('influencer_group_schedule.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('influencer_group_schedule.edit'))->with(getCustomTranslation('problem'));
    }
}
