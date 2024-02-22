<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Acl\Entities\Company;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\InfluencerCategory;
use Modules\Acl\Entities\InfluencerFollowerPlatform;
use Modules\CoreData\Entities\Size;
use Modules\Acl\Entities\Influencer;
use Modules\Record\Entities\AdRecord;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Entities\Category;

class CompetitiveAnalysisService extends BasicService
{
    public $companies_records = null;
    public $company = null;
    public $records = null;

    public function get_companies_indirect()
    {
        return Company::WhereHas('ad_record', function($qu)
        {
            $qu->whereHas('category', function($query)
            {
                $query->whereIn('category_id', $this->get_cruent_categories()->toArray());
            });
        })->WhereHas('company_industry', function($query)
        {
            $query->whereNotIn('industry_id', Category::getCategoriesIdsByUserId());
        })->select('name_en', 'id')->get();
    }

    public function get_companies_direct()
    {
        return Company::WhereHas('company_industry', function($query)
        {
            $query->whereIn('industry_id', Category::getCategoriesIdsByUserId());
        })->select('name_en', 'id')->get();
    }

    public function get_current_company()
    {
        if(request('company'))
        {
            return Company::find(request('company'));
        }
        if(request('company_name'))
        {
            return Company::where("name_en", request('company_name'))->first();
        }
        if(!$this->companies_records)
        {
            if(user()->role->role->type == 1)
            {
                $this->companies_records = DB::table('ad_records')
                    ->join('company_industries', 'ad_records.company_id', '=', 'company_industries.company_id')
                    ->wherein('company_industries.industry_id', Category::getCategoriesIdsByUserId())
                    ->whereBetween('ad_records.date', [$this->range_start_date(), $this->range_end_date()])
                    ->select('ad_records.company_id', DB::raw('count(*) as total'))
                    ->groupBy('ad_records.company_id', 'company_industries.company_id')->orderBy('total', 'desc')
                    ->first();
            }else
            {
                $this->companies_records = DB::table('ad_records')->select('company_id', DB::raw('count(*) as total'))
                    ->whereBetween('ad_records.date', [$this->range_start_date(), $this->range_end_date()])
                    ->groupBy('company_id')->orderBy('total', 'desc')->first();
            }
        }
        if(!$this->company)
        {
            if(isset($this->companies_records->company_id))
            {
                $this->company = Company::find($this->companies_records->company_id);
            }else
            {
                $this->company = Company::first();
            }
        }
        return $this->company;
    }

    public function range_start_date()
    {
        if(request('ranges'))
        {
            $ranges = explode('-', request('ranges'));
            return Carbon::createFromFormat('m/d/Y', trim($ranges[0]))->setTime(0, 0, 0);
        }
        return Carbon::now()->subDays(30)->startOfDay();
    }

    public function range_end_date()
    {
        if(request('ranges'))
        {
            $ranges = explode('-', request('ranges'));
            return Carbon::createFromFormat('m/d/Y', trim($ranges[1]))->setTime(23, 59, 59);
        }
        return Carbon::now();
    }

    public function get_top_companies_direct(): array
    {
        if(!$this->get_current_company()) return [];
        $companies = [];
        $ids = AdRecord::whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', '!=', $this->get_current_company()->id)
            ->whereHas('company', function($query)
            {
                $query->whereHas('industry', function($query)
                {
                    $query->whereIn('industry_id', $this->get_cruent_categories()->toArray());
                });
            })
            ->whereHas('category', function($query)
            {
                $query->whereIn('category_id', $this->get_cruent_categories()->toArray());
            })
            ->select('company_id')->selectRaw(DB::raw('count(*) as total'))->groupBy('company_id')
            ->orderBy('total', 'desc')->take(5)->get();
        foreach($ids as $id)
        {
            $company = Company::find($id->company_id);
            $company->ad_count = $id->total;
            $companies[] = $company;
        }
        return $companies;
    }

    public function get_top_companies_indirect(): array
    {
        if(!$this->get_current_company()) return [];
        $companies = [];
        $ids = AdRecord::whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', '!=', $this->get_current_company()->id)
            ->whereHas('company', function($query)
            {
                $query->whereHas('industry', function($query)
                {
                    $query->whereNotIn('industry_id', $this->get_cruent_categories()->toArray());
                });
            })
            ->whereHas('category', function($query)
            {
                $query->whereIn('category_id', $this->get_cruent_categories()->toArray());
            })
            ->select('company_id')->selectRaw(DB::raw('count(*) as total'))->groupBy('company_id')
            ->orderBy('total', 'desc')->take(5)->get();
        foreach($ids as $id)
        {
            $company = Company::find($id->company_id);
            $company->ad_count = $id->total;
            $companies[] = $company;
        }
        return $companies;
    }

    public function get_cruent_categories()
    {
        return $this->get_current_company()->industry->pluck('id');
    }

    public function get_campaign_estimated_cost()
    {
        if(!$this->get_current_company()) return 0;
        return $this->get_current_company()->ad_record->whereBetween('date',
            [$this->range_start_date(), $this->range_end_date()])->sum('price');
    }

    public function get_total_ads()
    {
        return $this->get_current_company()->ad_record->whereBetween('date',
            [$this->range_start_date(), $this->range_end_date()])->count();
    }

    public function get_unique_influencers()
    {
        return $this->get_current_company()->ad_record->whereBetween('date',
            [$this->range_start_date(), $this->range_end_date()])->groupBy('influencer_id')->count();
    }

    public function get_influencers($company)
    {
        $influencerss = [];
        $influencers = AdRecord::where('company_id', $company->id)
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])->groupBy('influencer_id')
            ->select('influencer_id', DB::raw('COUNT(*) as ad_count'))->orderByDesc('ad_count')->take(3)->get();
        foreach($influencers->toArray() as $influe)
        {
            $influencer = Influencer::with('country', 'category')->find($influe['influencer_id']);
            $influencer->images = in_array($influencer->gender,
                ['Male', 'male']) ? asset('dashboard/assets/media/avatars/blank.png') : asset('dashboard/assets/media/avatars/blank-girl.png');
            $url = $influencer->influencer_follower_platform()->where('platform_id', 1)->first()->url  ?? "";
            $influencer->snapchat_avatar = $url ? 'https://app.snapchat.com/web/deeplink/snapcode?username=' . $url . "&type=SVG&bitmoji=enable" : null;
            $influencer->ad_count = $influe['ad_count'];
            $influencerss[] = $influencer;
        }
        return $influencerss;
    }

    public function get_ad_type_chart()
    {
        if(!$this->get_current_company()) return [];
        $records = $this->getRecords()->groupBy('service.name_en');
        $result = [];
        foreach($records as $key => $record)
        {
            $result[] = ['name' => $key, 'y' => $record->count(),];
        }
        return $result;
    }

    public function get_promotion_type_chart()
    {
        if(!$this->get_current_company()) return [];
        $records = $this->getRecords()->groupBy('promotion_type.*.name_en');
        $result = [];
        $count = 0;
        foreach($records as $key => $record)
        {
            $count = $count + $record->count();
        }
        foreach($records as $key => $record)
        {
            $result[] = ['name' => $key, 'y' => $record->count(), 'xx' => round($record->count() / $count * 100),];
        }
        return $result;
    }

    public function get_ads_count_chart()
    {
        if(!$this->get_current_company()) return [];
        $dates = collect();
        $start = Carbon::now()->diffInDays($this->range_start_date());
        $end = Carbon::now()->diffInDays($this->range_end_date());
        if($this->range_start_date() < Carbon::now())
        {
            $start = -$start;
        }
        if($this->range_start_date() > Carbon::now())
        {
            $start = $start + 1;
        }
        if($this->range_end_date() > Carbon::now())
        {
            $end = $end + 1;
        }
        if($this->range_end_date() < Carbon::now())
        {
            $end = -$end;
        }
        foreach(range($start, $end) as $i)
        {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates->put($date, 0);
        }
        $records = AdRecord::whereBetween('date', [$dates->keys()->first(), $dates->keys()->last()])
            ->where('company_id', $this->get_current_company()->id)->groupBy('date')->orderBy('date')
            ->get([DB::raw('DATE( date ) as date'), DB::raw('COUNT( * ) as "count"')])->pluck('count', 'date');
        return $dates->merge($records);
    }

    public function getdatechartbycompany($request)
    {
        $datas = AdRecord::with(['company', 'category', 'influencer'])
            ->whereBetween('date', [$request->date . ' 00:00:00', $request->date . ' 23:59:59']);
        $datas = $datas->where('company_id', $request->company_id);
        $datas = $datas->orderBy('id', 'desc')->get();
        return $datas;
    }

    public function getdatechartbypromotedProducts($request)
    {
        $datas = AdRecord::with(['company', 'category', 'influencer'])
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $request->company_id)->whereNotNull('promoted_products')
            ->where('promoted_products', $request->promoted_products);
        $datas = $datas->orderBy('id', 'desc')->get();
        return $datas;
    }

    public function getdatechartbydiscount($request)
    {
        $datas = AdRecord::with(['company', 'category', 'influencer'])
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $request->company_id)->whereNotNull('promoted_offer')
            ->where('promoted_offer', $request->promoted_offer);
        $datas = $datas->orderBy('id', 'desc')->get();
        return $datas;
    }

    public function get_discount_cloud()
    {
        if(!$this->get_current_company()) return [];
        $offers = DB::table('ad_records')->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $this->get_current_company()->id)
            ->select('promoted_offer', DB::raw('count(*) as total'))->whereNotNull('promoted_offer')
            ->where('promoted_offer', '!=', '')->groupBy('promoted_offer')->get();
        $result = [];
        foreach($offers as $key => $offer)
        {
            $result[$key]['name'] = $offer->promoted_offer;
            $result[$key]['weight'] = $offer->total;
        }
        return $result;
    }

    public function get_promoted_products_cloud()
    {
        if(!$this->get_current_company()) return [];
        $promoted_products = DB::table('ad_records')
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $this->get_current_company()->id)
            ->select('promoted_products', DB::raw('count(*) as total'))->whereNotNull('promoted_products')
            ->where('promoted_products', '!=', '')->groupBy('promoted_products')->get();
        $result = [];
        foreach($promoted_products as $key => $product)
        {
            $result[$key]['name'] = $product->promoted_products;
            $result[$key]['weight'] = $product->total;
        }
        return $result;
    }

    public function get_influencer_size()
    {
        $data = [];
        foreach(Size::all() as $size)
        {
            $data[$size->name_en] = 0;
        }
        $records = $this->get_current_company()->ad_record()
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->select('influencer_id', 'platform_id')->get()->groupBy('platform_id');
        $datas = [];
        $influencer_follower_platform = [];
        foreach($records as $key => $record)
        {
            $influencer_follower_platform = InfluencerFollowerPlatform::with('size')
                ->whereIn('influencer_follower_platforms.influencer_id', $record->pluck('influencer_id'))
                ->where('influencer_follower_platforms.platform_id', $key)->get()->pluck('size.name_en')->toArray();
            $influencer_follower_platform = array_map(fn($value) => $value ?? '-', $influencer_follower_platform);

            $data['-']=0;

            if(isset($influencer_follower_platform->name_en))
            {
                $data[$influencer_follower_platform->name_en] = $data[$influencer_follower_platform->name_en] + 1;
            }else
            {
                $data['-'] = $data['-'] + 1;
            }
        }
        $datas = array_count_values($influencer_follower_platform) ?? [];
        return $datas;
    }

    public function get_influencer_gender(): array
    {
        $influencer = Influencer::whereHas('ad_record', function($query)
        {
            $query->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->where('company_id', $this->get_current_company()->id);
        })->pluck('gender')->toArray();
        return array_count_values($influencer);
    }

    public function get_content_category_chart(): array
    {
        $unique_influencers = Influencer::whereHas('ad_record', function($query)
        {
            $query->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->where('company_id', $this->get_current_company()->id);
        })->pluck('id')->toArray();
        $result = [];
        $categories = InfluencerCategory::with('category')->whereIn('influencer_id', $unique_influencers)->get()
            ->pluck('category.name_en')->toArray();
        $categories = array_count_values($categories);
        $result['keys'] = array_keys($categories);
        $result['values'] = array_values($categories);
        return $result;
    }

    public function search(Request $request)
    {
        /* if(user()->role->role->type == 1)
         {
             return Company::WhereHas('company_industry', function($query)
             {
                 $query->wherein('industry_id', Category::getCategoriesIdsByUserId());
             })->where('active',activeType()['as'])->where('name_en', 'LIKE', "%{$request->term}%")->orWhere('name_ar', 'LIKE', "%{$request->term}%")
                 ->with('industry')->get();
         }else
         {*/
        return Company::where('active', activeType()['as'])->where('name_en', 'LIKE', "%{$request->term}%")
            ->orWhere('name_ar', 'LIKE', "%{$request->term}%")->with('industry')->get();
        /* }*/
    }

    private function get_admin_categories()
    {
        return Category::all();
    }

    private function setRecords()
    {
        if($this->records == null)
        {
            $this->records = $this->get_current_company()->ad_record()
                ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->with(['promotion_type', 'service', 'influencer'])->get();
        }
    }

    private function getRecords(): object
    {
        $this->setRecords();
        return $this->records;
    }
}
