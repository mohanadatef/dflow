<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanySearchResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Service\CompetitiveAnalysisService;
use Modules\Basic\Http\Controllers\BasicController;

class CompetitiveAnalysisController extends BasicController
{
    protected  $service;

    /**
     * @required must user be login
     *
     * @return void
     */
    public function __construct(CompetitiveAnalysisService $service)
    {
        $this->service = $service;
         $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('admin');
    }

    /**
     * @result page main in system
     */
    public function index(Request $request)
    {
        $companies_indirect = $this->service->get_companies_indirect();
        $companies_direct = $this->service->get_companies_direct();
        $range_start = $this->service->range_start_date();
        $range_end = $this->service->range_end_date();
        $discount_cloud = $this->service->get_discount_cloud();
        $promoted_products_cloud = $this->service->get_promoted_products_cloud();
        $ad_type_chart = $this->service->get_ad_type_chart();
        $promotion_type_chart = $this->service->get_promotion_type_chart();
        $ads_count_chart = $this->service->get_ads_count_chart();
        $current_company = $this->service->get_current_company();
        $top_companies_direct = $this->service->get_top_companies_direct();
        $top_companies_indirect = $this->service->get_top_companies_indirect();
        $get_cruent_categories = $this->service->get_cruent_categories();
        $estimated_cost = $this->service->get_campaign_estimated_cost();
        $total_ads = $this->service->get_total_ads();
        $unique_influencers = $this->service->get_unique_influencers();
        $influencers = $this->service->get_influencers($current_company);
        $influencer_size = $this->service->get_influencer_size();
        $influencer_gender = $this->service->get_influencer_gender();
        $content_category = $this->service->get_content_category_chart();
        if($request->ajax())
        {
            return view('dashboard.mainContent', get_defined_vars());
        }
        return view('dashboard.competitive', get_defined_vars());
    }

    public function search_companies(Request $request): JsonResponse
    {
        $data = $this->service->search($request);
        return response()->json(CompanySearchResource::collection($data));
    }

    public function getdatechartbycompany(Request $request)
    {
        $datas = $this->service->getdatechartbycompany($request) ?? [];
        return view(checkView('dashboard.charts.ads_chart_by_company'), get_defined_vars());
    }

    public function getdatechartbypromotedProducts(Request $request)
    {
        $datas = $this->service->getdatechartbypromotedProducts($request) ?? [];
        return view(checkView('dashboard.charts.ads_chart_by_promoted_products'), get_defined_vars());
    }

    public function getdatechartbydiscount(Request $request)
    {
        $datas = $this->service->getdatechartbydiscount($request) ?? [];
        return view(checkView('dashboard.charts.ads_chart_by_promoted_products'), get_defined_vars());
    }
}
