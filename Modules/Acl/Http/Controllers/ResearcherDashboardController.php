<?php

namespace Modules\Acl\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Acl\Service\ResearcherDashboardService;
use Modules\Basic\Http\Controllers\BasicController;

/**
 * @extends BasicController
 * controller user about web function
 */
class ResearcherDashboardController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(ResearcherDashboardService $service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:show_researcher_dashboard_users')->only('researcherDashboard');
        $this->cards_start = '';
        $this->cards_end = '';
        if(!empty(request('search_day')))
        {
            $this->cards_start = Carbon::parse(request('search_day') . ' 9am');
            $this->cards_end = Carbon::parse($this->cards_start->addDay());
            $this->cards_start->subDay();
        }else
        {
            if(Carbon::now()->format('H') == '00')
            {
                $this->cards_start = Carbon::parse('yesterday 9am');
                $this->cards_end = Carbon::parse('today 9am');
            }else
            {
                $this->cards_start = Carbon::parse('today 9am');
                $this->cards_end = Carbon::parse('tomorrow 9am');
            }
        }
        $this->service = $service;
    }

    public function researcherDashboard(Request $request)
    {
        if(empty($request->user_id))
        {
            $request->merge(['user_id' => user()->id]);
        }
        $name = $this->service->show($request->user_id)->name ?? "";
        $range_start = $this->cards_start;
        $range_end = $this->cards_end;
        $platforms = $this->service->platformList();
        $perPage = $this->perPage() ?? 10;
        $page = $request->page ?? 1;
        $table = $this->service->getInfluencerTable($request, range_start: $range_start, range_end: $range_end, perPage:$perPage,page:$page);
        if($request->ajax())
        {
            return view(checkView('acl::users.researcherDashboard.table'), get_defined_vars());
        }
        return view(checkView('acl::users.researcherDashboard.index'), get_defined_vars());
    }
    public function logResearcherDashboard(Request $request)
    {
        $range_start = $this->cards_start;
        $range_end = $this->cards_end;
        $perPage = $this->perPage() ?? 10;
        $logsTable = $this->service->getLogsTable($request, $range_start, $range_end ,$perPage);
        return view(checkView('acl::users.researcherDashboard.log_table'), get_defined_vars());
    }
    public function adsCount(Request $request)
    {
        if(empty($request->user_id))
        {
            $request->merge(['user_id' => user()->id]);
        }
        $range_start = $this->cards_start;
        $range_end = $this->cards_end;
        $ads_count = $this->service->getResearcherData($request, range_start: $range_start, range_end: $range_end);
        return response()->json($ads_count);
    }

    public function draftsCount(Request $request)
    {
        if(empty($request->user_id))
        {
            $request->merge(['user_id' => user()->id]);
        }
        $range_start = $this->cards_start;
        $range_end = $this->cards_end;
        $ads_count = $this->service->getResearcherDraftData($request, range_start: $range_start, range_end: $range_end);
        return response()->json($ads_count);
    }
    public function adsChart(Request $request)
    {
        if(empty($request->user_id))
        {
            $request->merge(['user_id' => user()->id]);
        }
        $ads_count_chart = $this->service->get_chart_data($request) ?? [];
        return view(checkView('acl::users.researcherDashboard.basic_chart'), get_defined_vars());
    }

    public function completedAdsChart(Request $request)
    {
        if(empty($request->user_id))
        {
            $request->merge(['user_id' => user()->id]);
        }
        $completed = $this->service->get_completed_chart_data($request) ?? [];
        return view(checkView('acl::users.researcherDashboard.completed_ads_chart'), get_defined_vars());
    }

    public function mediaSeenChart(Request $request)
    {
        if(empty($request->user_id))
        {
            $request->merge(['user_id' => user()->id]);
        }
        $mediaSeen = $this->service->media_seen_chart_data($request) ?? [];
        return view(checkView('acl::users.researcherDashboard.media_seen_chart'), get_defined_vars());
    }

    public function mediaFileHtml(Request $request)
    {
        $mediaSeen = $this->service->media_seen_file($request) ?? [];
        $request->merge(['files'=>$mediaSeen]);
        return view(checkView('acl::users.researcherDashboard.seen_media'), ['request' => $request->all()]);
    }

    public function mediaFileSeen(Request $request)
    {
        $this->service->mediaFileSeen($request);
    }
    public function getResearcherChart(Request $request)
    {
        $datas = $this->service->getResearcherChart($request) ?? [];
        return view(checkView('dashboard.charts.ads_chart'), get_defined_vars());
    }

    public function markAdComplete(Request $request)
    {
        $this->service->toggleComplete($request);
        return redirect()->back()->with('success', getCustomTranslation('success'));
    }

    public function error_count(Request $request){
        $range_start = $this->cards_start;
        $range_end = $this->cards_end;
        return response()->json($this->service->error_count($request,$range_start,$range_end));
    }
}
