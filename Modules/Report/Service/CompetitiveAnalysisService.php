<?php

namespace Modules\Report\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerCategory;
use Modules\Acl\Entities\InfluencerFollowerPlatform;
use Modules\Acl\Service\CompanyService;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\Size;
use Modules\Record\Entities\AdRecord;

class CompetitiveAnalysisService extends BasicService
{
    public $companies_records = null;
    public $company = null;
    public $records = null;
    protected $companyService ;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }
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
        })->select('name_'.user()->lang, 'id')->get();
    }

    public function get_companies_direct()
    {
        return Company::WhereHas('company_industry', function($query)
        {
            $query->whereIn('industry_id', Category::getCategoriesIdsByUserId());
        })->select('name_'.user()->lang, 'id')->get();
    }

    public function get_current_company()
    {
        if(request('company'))
        {
            return Company::find(request('company'));
        }
        if(request('company_name'))
        {
            return Company::where("name_en", request('company_name'))
                ->orWhere("name_ar", request('company_name'))->first();
        }
        if(!$this->companies_records)
        {
            if(user()->role->type == 1)
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
        $start_access = user()->start_access;
        if(request('ranges'))
        {
            $ranges = explode('-', request('ranges'));
            if($start_access)
            {
                if(Carbon::parse(trim($ranges[0]))->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return  Carbon::parse($start_access)->startOfDay();
                }else
                {
                    return Carbon::parse(trim($ranges[0]))->startOfDay();
                }
            }else
            {
                return Carbon::parse(trim($ranges[0]))->startOfDay();
            }
        }
        if(Cache::get('competitive_start_' . user()->id) != null)
        {
            return Carbon::parse(Cache::get('competitive_start_' . user()->id))->startOfDay();
        }
        elseif($start_access)
        {
            return Carbon::now()->subDays(30)->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::now()->subDays(30)->startOfDay();
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
            $ranges = explode('-', request('ranges'));
            if($end_access)
            {
                if(Carbon::parse(trim($ranges[1]))->isAfter($end_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return  Carbon::parse($end_access)->endOfDay();
                }else
                {
                    return Carbon::parse(trim($ranges[1]))->endOfDay();
                }
            }else
            {
                return Carbon::parse(trim($ranges[1]))->endOfDay();
            }
        }
        if(Cache::get('competitive_end_' . user()->id) != null)
        {
            return Carbon::parse(Cache::get('competitive_end_' . user()->id))->startOfDay();
        }
        elseif($end_access)
        {
            return Carbon::now()->isAfter($end_access) ? Carbon::parse($end_access) : Carbon::now()->endOfDay();
        }else
        {
            return Carbon::now()->endOfDay();
        }

    }

    public function get_top_companies_direct()
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
        $data = AdRecord::where('company_id', $this->get_current_company()->id)
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);
        if(user()->role->type == 1)
        {
            $data = $data->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
        return $data->sum('price');
    }

    public function get_total_ads()
    {
        $data = AdRecord::where('company_id', $this->get_current_company()->id)
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);
        if(user()->role->type == 1)
        {
            $data = $data->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
        return $data->count();
    }

    public function get_unique_influencers()
    {
        $data = AdRecord::where('company_id', $this->get_current_company()->id)
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);
        if(user()->role->type)
        {
            $data = $data->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
       $data->pluck('influencer_id');

        return count(array_unique($data->pluck('influencer_id')->toArray()));
    }

    public function get_influencers($company)
    {
        $influencerss = [];
        $influencers = AdRecord::where('company_id', $company->id)
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);
        if(user()->role->type == 1)
        {
            $influencers = $influencers->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
        $influencers = $influencers->groupBy('influencer_id')
            ->select('influencer_id', DB::raw('COUNT(*) as ad_count'))->orderByDesc('ad_count')->take(3)->get();
        foreach($influencers->toArray() as $influe)
        {
            $influencer = Influencer::with('country', 'category')->find($influe['influencer_id']);
            $influencer->images = in_array($influencer->gender,
                ['Male', 'male']) ? asset('dashboard/assets/media/avatars/blank.png') : asset('dashboard/assets/media/avatars/blank-girl.png');
            $url = $influencer->influencer_follower_platform()->where('platform_id', 1)->first()->url ?? "";
            $influencer->snapchat_avatar = $url ? 'https://app.snapchat.com/web/deeplink/snapcode?username=' . $url . "&type=SVG&bitmoji=enable" : null;
            $influencer->ad_count = $influe['ad_count'];
            $influencerss[] = $influencer;
        }
        return $influencerss;
    }

    public function get_ad_type_chart()
    {
        if(!$this->get_current_company()) return [];
        $records = $this->getRecords()->pluck('service.*.name_en')->toArray();
        $result = [];
        foreach(array_count_values(array_merge(...array_values($records))) as $key => $record)
        {
            $result[] = ['name' => $key, 'y' => $record];
        }
        return $result;
    }

    public function get_promotion_type_chart()
    {
        if(!$this->get_current_company()) return [];
        $records = $this->getRecords()->groupBy('promotion_type.*.name_'.user()->lang);
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
            ->where('company_id', $this->get_current_company()->id)->groupBy('date')->orderBy('date');
              if(user()->role->type == 1)
              {
                  $records = $records->whereHas('category', function($query)
                  {
                      $query->whereIn('category_id', user()->category->pluck('id')->toArray());
                  });
              }
        $records=$records->get([DB::raw('DATE( date ) as date'), DB::raw('COUNT( * ) as "count"')])->pluck('count', 'date');
        return $dates->merge($records);
    }

    public function getdatechartbycompany($request)
    {
        $datas = AdRecord::with(['company', 'category', 'influencer'])
            ->whereBetween('date', [$request->date . ' 00:00:00', $request->date . ' 23:59:59'])
            ->where('company_id', $request->company_id);
        if(user()->role->type == 1)
        {
            $datas = $datas->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
        $datas = $datas->orderBy('id', 'desc')->get();
        return $datas;
    }

    public function getdatechartbypromotedProducts($request)
    {
        $datas = AdRecord::with(['company', 'category', 'influencer'])
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);
            if(user()->role->type == 1)
            {
                $datas = $datas->whereHas('category', function($query)
                {
                    $query->whereIn('category_id', user()->category->pluck('id')->toArray());
                });
            }
        $datas=$datas->where('company_id', $request->company_id)->whereNotNull('promoted_products')
            ->where('promoted_products', $request->promoted_products);
        $datas = $datas->orderBy('id', 'desc')->get();
        return $datas;
    }

    public function getdatechartbydiscount($request)
    {
        $datas = AdRecord::with(['company', 'category', 'influencer'])
            ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $request->company_id);
        if(user()->role->type == 1)
        {
            $datas = $datas->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
        $datas=$datas->whereNotNull('promoted_offer')
            ->where('promoted_offer', $request->promoted_offer);
        $datas = $datas->orderBy('id', 'desc')->get();
        return $datas;
    }

    public function get_discount_cloud()
    {
        if(!$this->get_current_company()) return [];
        $offers = AdRecord::whereBetween('date',[$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $this->get_current_company()->id);
        if(user()->role->type == 1)
        {
            $offers = $offers->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
        $offers=$offers->select('promoted_offer', DB::raw('count(*) as total'))->whereNotNull('promoted_offer')
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
        $promoted_products = AdRecord::whereBetween('date',[$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $this->get_current_company()->id);
               if(user()->role->type == 1)
               {
                   $promoted_products = $promoted_products->whereHas('category', function($query)
                   {
                       $query->whereIn('category_id', user()->category->pluck('id')->toArray());
                   });
               }
            $promoted_products=$promoted_products->select('promoted_products', DB::raw('count(*) as total'))->whereNotNull('promoted_products')
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
            $data[$size->{'name_'.user()->lang}] = 0;
        }
        $records = AdRecord::whereBetween('date',[$this->range_start_date(), $this->range_end_date()])
            ->where('company_id', $this->get_current_company()->id);
        if(user()->role->type == 1)
        {
            $records = $records->whereHas('category', function($query)
            {
                $query->whereIn('category_id', user()->category->pluck('id')->toArray());
            });
        }
        $records=$records->select('influencer_id', 'platform_id')->get()->groupBy('platform_id');
        $data['-'] = 0;
        foreach($records as $key => $record)
        {
            $influencer_follower_platform = InfluencerFollowerPlatform::with('size')
                ->whereIn('influencer_follower_platforms.influencer_id', $record->pluck('influencer_id'))
                ->where('influencer_follower_platforms.platform_id', $key)->get()->pluck('size.name_'.user()->lang)->toArray();
            $influencer_follower_platform = array_map(fn($value) => $value ?? '-', $influencer_follower_platform);

            foreach($influencer_follower_platform as  $power)
            {
                $data[$power] = $data[$power] + 1;
            }
        }
        return $data;
    }

    public function get_influencer_gender(): array
    {
        $influencer = Influencer::whereHas('ad_record', function($query)
        {
            $query->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->where('company_id', $this->get_current_company()->id);
            if(user()->role->type == 1)
            {
               $query->whereHas('category', function($q)
                {
                    $q->whereIn('category_id', user()->category->pluck('id')->toArray());
                });
            }
        })->pluck('gender')->toArray();
        return array_count_values($influencer);
    }

    public function get_content_category_chart(): array
    {
        $unique_influencers = Influencer::whereHas('ad_record', function($query)
        {
            $query->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->where('company_id', $this->get_current_company()->id);
            if(user()->role->type == 1)
            {
                $query->whereHas('category', function($q)
                {
                    $q->whereIn('category_id', user()->category->pluck('id')->toArray());
                });
            }
        })->pluck('id')->toArray();
        $result = [];
        $categories = InfluencerCategory::with('category')->whereIn('influencer_id', $unique_influencers)->get()
            ->pluck('category.name_'.user()->lang)->toArray();
        $categories = array_count_values($categories);
        $result['keys'] = array_keys($categories);
        $result['values'] = array_values($categories);
        return $result;
    }

    public function search(Request $request)
    {
        return  $this->companyService->findBy(new Request(['active'=>activeType()['as'],'name'=>$request->term]),with:['industry', 'company_website']);
    }

    private function get_admin_categories()
    {
        return Category::all();
    }

    private function setRecords()
    {
        if($this->records == null)
        {
            $datas = AdRecord::whereBetween('date',[$this->range_start_date(), $this->range_end_date()])
                ->where('company_id', $this->get_current_company()->id);
            if(user()->role->type == 1)
            {
                $datas = $datas->whereHas('category', function($query)
                {
                    $query->whereIn('category_id', user()->category->pluck('id')->toArray());
                });
            }
            $this->records = $datas->with(['promotion_type', 'service', 'influencer'])->get();
        }
    }

    private function getRecords()
    {
        $this->setRecords();
        return $this->records;
    }
}
