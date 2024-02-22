<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Report\Service\HomeService;

class HomeController extends BasicController
{
    protected  $service;

    /**
     * @required must user be login
     *
     * @return void
     */
    public function __construct(HomeService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:market_overview_page')->only(['index']);
    }

    /**
     * @result page main in system
     */
    public function index()
    {
        if(!user()->can('market_overview_page'))
        {
            return abort(403);
        }
        $client_categories = $this->service->get_categories() ?? [];
        $current_category = $this->service->get_current_category() ?? [];
        $range_start = $this->service->range_start_date() ?? [];
        Cache::put('market_start_' . user()->id, $range_start);
        $range_end = $this->service->range_end_date() ?? [];
        Cache::put('market_end_' . user()->id, $range_end);
        $number_of_influencers = $this->service->number_of_influencers() ?? [];
        $number_of_brands = $this->service->number_of_brands() ?? [];
        $estimated_spent = $this->service->estimated_spent() ?? [];
        $number_of_ads = $this->service->number_of_ads() ?? [];
        $ads_count_chart = $this->service->get_chart_data() ?? [];
        $ads_price_chart = $this->service->get_chart_data_by_price() ?? [];
        $top_brands = $this->service->get_top_brands() ?? [];
        $top_influencers = $this->service->get_top_influencers() ?? [];
        return view('report::market_overview.index', get_defined_vars());
    }
    public function getdatechart(Request $request){

        $datas = $this->service->getdatechart($request) ?? [];
        return view(checkView('dashboard.charts.ads_chart'), get_defined_vars());
    }

    /**
     * @result page 404
     */
    public function error_404()
    {
        //return view(checkView('errors.404'));
    }

    public function home()
    {
        if(user()->role_id == 3 && permissionShow('show_researcher_dashboard_users'))
        {
            return redirect(route('researcher_dashboard.researcherDashboard'));
        }

        if(permissionShow('admin_dashboard_users'))
        {
            return redirect(route('admin.dashboard'));
        }
        return redirect(route('dashboard'));
    }
}
