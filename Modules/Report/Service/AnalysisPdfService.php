<?php

namespace Modules\Report\Service;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\Size;
use Modules\Record\Entities\AdRecord;

class AnalysisPdfService extends BasicService
{
    protected $monthly = true;

    public function __construct()
    {

    }

    public function get_current_company()
    {
        if(request('company_id')) {
            return Company::find(request('company_id'));
        }

        $record = DB::table('ad_records')
            ->select('company_id', DB::raw('count(*) as total'))
            ->groupBy('company_id')
            ->orderBy('total', 'desc')->first();

        return Company::find($record->company_id);
    }

    public function get_date_range()
    {
        return $this->range_start_date()->format('Y-m-d') . " to " . $this->range_end_date()->format('Y-m-d');
    }

    public function range_start_date()
    {
        $start_access = user()->start_access;
        if(request('ranges'))
        {
            $this->monthly = false;
            $ranges = explode('-', request('ranges'));
            if($start_access)
            {
                if(Carbon::parse(trim($ranges[0]))->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return  Carbon::parse($start_access);
                }else
                {
                    return Carbon::parse(trim($ranges[0]));
                }
            }else
            {
                return Carbon::parse(trim($ranges[0]));
            }
        }
        if($start_access)
        {
            return Carbon::now()->subDays(30)->startOfDay()->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::now()->subDays(30)->startOfDay();
        }else
        {
            return Carbon::now()->subDays(30)->startOfDay();
        }
    }

    public function range_end_date()
    {
        $end_access = user()->end_access;
        if(request('ranges'))
        {
            $this->monthly = false;
            $ranges = explode('-', request('ranges'));
            if($end_access)
            {
                if(\Carbon\Carbon::parse(trim($ranges[1]))->isAfter($end_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return Carbon::parse($end_access);
                }else
                {
                    return Carbon::createFromFormat('m/d/Y', trim($ranges[1]))->setTime(23, 59, 59);
                }
            }else
            {
                return Carbon::createFromFormat('m/d/Y', trim($ranges[1]))->setTime(23, 59, 59);
            }
        }
        if($end_access)
        {
            return Carbon::now()->isAfter($end_access) ? Carbon::parse($end_access) : Carbon::now();
        }else
        {
            return Carbon::now();
        }
    }

    public function range_last_month_start_date()
    {
        $start_access = user()->start_access;
        if(request('ranges'))
        {
            $this->monthly = false;
            $ranges = explode('-', request('ranges'));
            if($start_access)
            {
                if(Carbon::parse(trim($ranges[0]))->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return  Carbon::parse($start_access);
                }else
                {
                    return Carbon::parse(trim($ranges[0]));
                }
            }else
            {
                return Carbon::parse(trim($ranges[0]));
            }
        }
        if($start_access)
        {
            return Carbon::now()->subDays(60)->startOfDay()->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::now()->subDays(60)->startOfDay();
        }else
        {
            return Carbon::now()->subDays(60)->startOfDay();
        }
    }

    public function range_last_month_end_date()
    {
        $end_access = user()->end_access;
        if(request('ranges'))
        {
            $this->monthly = false;
            $ranges = explode('-', request('ranges'));
            if($end_access)
            {
                if(\Carbon\Carbon::parse(trim($ranges[1]))->isAfter($end_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return Carbon::parse($end_access);
                }else
                {
                    return Carbon::createFromFormat('m/d/Y', trim($ranges[1]))->setTime(23, 59, 59);
                }
            }else
            {
                return Carbon::createFromFormat('m/d/Y', trim($ranges[1]))->setTime(23, 59, 59);
            }
        }
        if($end_access)
        {
            return Carbon::now()->isAfter($end_access) ? Carbon::parse($end_access) : Carbon::now();
        }else
        {
            return Carbon::now();
        }
    }

    public function get_top_companies()
    {
        $companys = [];

        $ids = AdRecord::whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', '!=', $this->get_current_company()->id)
            ->whereHas('category', function ($query) {
                $query->whereIn('category_id', $this->get_current_company()->industry->pluck('id'));
            })
            ->select('company_id')
            ->selectRaw(DB::raw('count(*) as total'))
            ->groupBy('company_id')
            ->orderBy('total', 'desc')->take(5)->pluck('company_id', 'total');

        foreach ($ids as $key => $id) {
            $company = Company::find($id);
            $company->ad_count = $key;
            $company->analysis = $this->get_analysis_company($company);
            $companys[] = $company;
        }

        return $companys;
    }

    public function get_primary_categories()
    {
        return $this->get_current_company()->ad_record()
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->with('category')
            ->get()
            ->groupBy('category.*.name_en');
    }

    public function get_promotion_type_chart()
    {
        $records = $this->get_current_company()->ad_record()
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->with('promotion_type')
            ->get()
            ->groupBy('promotion_type.*.name_en');

        $result = [];

        foreach ($records as $key => $record) {
            $result[] = [
                'name' => $key,
                'y' => $record->count(),
            ];
        }

        return $result;
    }

    public function get_top_companies_data()
    {
        $data = [];
        $companies = $this->get_top_companies();

        foreach ($companies as $index => $company) {
            $data[$company->id] = $this->get_analysis_company($company);
        }

        return $data;
    }

    private function get_monthly_estimated_cost($company)
    {
        $ads = $company->ad_record()
        ->whereBetween('date', [$this->range_last_month_start_date(), $this->range_last_month_end_date()]);

        $costs = $ads->selectRaw(DB::raw('sum(price) as cost'))->pluck('cost');

        $result = 0;
        foreach ($costs as $key => $value) {
            $result += $value;
        }

        return $result;
    }

    private function get_monthly_ad_count($company)
    {
        return $company->ad_record()
        ->whereBetween('date', [$this->range_last_month_start_date(), $this->range_last_month_end_date()])
        ->count();
    }


    public function get_analysis_company($company)
    {
        $analysis = [];
        $ad = $company->ad_record()
            ->with(
                'influencer.influencer_follower_platform.size', 'promotion_type', 'promotion_type', 'influencer', 'platform', 'service'
            )
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);

        $ad_rush = $ad->clone();
        $ad_i_i = $ad_i_p = $ad_c = $ad_i = $ad;
        $ad_p = $ad_i_g = $ad_i_sv = $ad_i_c = $ad_promoted_cloud = $ad = $ad->get();
        $ad_i = $ad_i->select('influencer_id')
            ->selectRaw(DB::raw('count(*) as total'))
            ->groupBy('influencer_id')->pluck('influencer_id', 'total')->sort()->flip()->last();

        $influencer = Influencer::find($ad_i);
        $analysis['top_influencer'] = $influencer ? $influencer->name_en : "";

        $costs = $ad_c->selectRaw(DB::raw('sum(price) as cost'))->pluck('cost');

        $analysis['Campaign_Estimated_Cost'] = 0;
        foreach ($costs as $key => $value) {
            $analysis['Campaign_Estimated_Cost'] += $value;
        }

        if($this->monthly) {
            $monthly_cost = $this->get_monthly_estimated_cost($company);

            $analysis['Campaign_Estimated_Cost_last_month'] = $monthly_cost;

            $monthly_ad_count = $this->get_monthly_ad_count($company);

            $analysis['last_month_ad_count'] = $monthly_ad_count;
        }

        $analysis['rush_days'] = $ad_rush->select('date')
            ->selectRaw(DB::raw('count(*) as total'))
            ->groupBy('date')->orderBy('total', 'desc')->pluck('date', 'total')->flip()->take(2);


        $analysis['ad_record'] = $ad;
        $analysis['promotion_type'] = $ad_p->groupBy('promotion_type.*.name_en');
        $result = [];
        foreach ($analysis['promotion_type'] as $key => $record) {
            $result[] = [
                'name' => $key,
                'y' => $record->count(),
            ];
        }
        $analysis['promotion_type_chart'] = $result;
        $result = [];

        $result[0] = [
            'name' => 'female',
            'y' => 0
        ];

        $result[1] = [
            'name' => 'male',
            'y' => 0
        ];

        foreach ($ad_i_g->groupBy('influencer.gender') as $key => $record) {
            if($key == 'female') {
                $result[0] = [
                    'name' => $key,
                    'y' => $record->count(),
                ];
            }else {
                $result[1] = [
                    'name' => $key,
                    'y' => $record->count(),
                ];
            }

        }
        $analysis['influencer_gender'] = $result;
        $result = [];
        foreach ($ad_i_sv->groupBy('service.name_en') as $key => $record) {
            $result[] = [
                'name' => $key,
                'y' => $record->count(),
            ];
        }
        $analysis['ad_type'] = $result;
        $analysis['number_of_influencer'] = $ad_i_i->groupBy('influencer_id')->count();
        $data = [];
        foreach (Size::all() as $size) {
            $data[$size->name_en] = 0;
        }
        foreach ($ad_i_p->whereHas('influencer.influencer_follower_platform')->get() as $record) {
            $influencer_follower_platform = $record->influencer->influencer_follower_platform;
            foreach ($influencer_follower_platform as $item) {
                if(isset($item->size->name_en))
                {
                    $data[$item->size->name_en] = $data[$item->size->name_en] + 1;
                }
            }
        }
        $analysis['influencer_size'] = $data;
        $categories = [];
        $result = [];
        foreach ($ad_i_c->groupBy('influencer_id') as $key => $value) {
            $influencer = Influencer::find($key);
            if ($influencer){
                foreach ($influencer->category as $category) {
                    $categories[$category->name_en] = isset($categories[$category->name_en]) ? $categories[$category->name_en] + 1 : 1;
                }
            }
        }
        foreach ($categories as $key => $value) {
            $result['keys'][] = $key;
            $result['values'][] = $value;
        }
        $analysis['influencer_content'] = $result;
        $analysis['company'] = $company;

        $analysis['socials'] = $company->company_socials;

        // promotion type chart

        $result = [];

        foreach ($ad_promoted_cloud->groupBy('promoted_products') as $key => $record) {
            if($key != '') {
                $result[] = [
                    'name' => $key,
                    'y' => $record->count(),
                ];
            }
        }
        $analysis['promotion_cloud'] = $result;

        $result = [];

        foreach ($ad_promoted_cloud->groupBy('promoted_offer') as $key => $record) {
            if($key != '') {
                $result[] = [
                    'name' => $key,
                    'y' => $record->count(),
                ];
            }
        }
        $analysis['discount_cloud'] = $result;

        return $analysis;
    }

    public function get_platforms()
    {
        return Platform::all();
    }

    public function get_max_discount_count()
    {
        return DB::table('ad_records')
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $this->get_current_company()->id)
            ->select(DB::raw('count(*) as count'),"promoted_offer as name")
            ->whereNotNull('promoted_offer')
            ->where('promoted_offer', '!=', '')
            ->groupBy('promoted_offer')
            ->orderBy("count",'DESC')
            ->limit(1)
            ->get()->first();
    }

    public function get_min_discount_count()
    {
        return DB::table('ad_records')
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $this->get_current_company()->id)
            ->select(DB::raw('count(*) as count'),"promoted_offer as name")
            ->whereNotNull('promoted_offer')
            ->where('promoted_offer', '!=', '')
            ->groupBy('promoted_offer')
            ->orderBy("count",'ASC')
            ->limit(1)
            ->get()->first();
    }
}
