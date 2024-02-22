<?php

namespace Modules\Report\Service;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Service\UserService;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Entities\Category;
use Modules\Record\Entities\AdRecord;

class HomeService extends BasicService
{
    public  $category = null;
    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function get_categories()
    {
        if(user() && !user()->role)
        {
            Auth::logout();
            return redirect('/login');
        }
        if(user()->role->type)
        {
            return $this->get_client_categories();
        }else
        {
            return $this->get_admin_categories();
        }
        return [];
    }

    public function number_of_brands()
    {
        $category = $this->get_current_category();
        if($category)
        {
            $ad = $category->ad_record()->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->get();
            return $ad->groupBy('company_id')->count();
        }
        return 0;
    }

    public function number_of_ads()
    {
        $category = $this->get_current_category();
        if($category)
        {
            return $category->ad_record()
                ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->count();
        }
        return 0;
    }

    public function number_of_influencers()
    {
        $category = $this->get_current_category();
        if($category)
        {
            $ad = $category->ad_record()
                ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->get();
            $ad = $ad->groupBy('influencer_id')->count();
            return $ad;
        }
        return 0;
    }

    public function estimated_spent()
    {
        $category = $this->get_current_category();
        if($category)
        {
            return $category->ad_record()
                ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->sum('price');
        }
        return 0;
    }

    public function get_chart_data()
    {
        $category = $this->get_current_category();
        if($category)
        {
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
            $records = $category->ad_record()->whereBetween('date', [$dates->keys()->first(),$dates->keys()->last()])
                ->groupBy(DB::raw("DATE_FORMAT(date, '%Y-%m-%d')"))
                ->orderBy('date')
                ->get([
                    DB::raw("(DATE_FORMAT(date, '%Y-%m-%d')) as date"),
                    DB::raw('COUNT( * ) as "count"')
                ])
                ->pluck('count', 'date');

            return $dates->merge($records);
        }
    }

    public function get_chart_data_by_price()
    {
        $category = $this->get_current_category();
        if($category)
        {
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
            $records = AdRecord::select(
                "id",
                DB::raw("(sum(price)) as subtotal"),
                DB::raw("(DATE_FORMAT(date, '%Y-%m-%d')) as my_date")
            )->whereHas('ad_record_category', function($query) use ($category)
            {
                return $query->where('category_id', $category->id);
            })
                ->whereBetween('date', [$dates->keys()->first(),$dates->keys()->last()])
                ->orderBy('date')
                ->groupBy(DB::raw("DATE_FORMAT(date, '%Y-%m-%d')"))
                ->get()->pluck('subtotal', 'my_date');
            $recordsint = [];
            foreach($records as $key => $value)
            {
                $recordsint[$key] = (double)$value;
            }
            return $dates->merge($recordsint);
        }
    }

    public function getdatechart($request)
    {
        $datas = AdRecord::with(['company', 'category', 'influencer'])
            ->whereBetween('date', [Carbon::parse($request->date)->startOfDay(), Carbon::parse($request->date)->endOfDay()]);
        if(isset($request->type))
        {
            $datas=$datas->where('price', '!=',0);
        }
        $datas = $datas->WhereHas('ad_record_category', function($query) use ($request)
        {
            $query->where('category_id', $request->category_id);
        });
        $datas = $datas->orderBy('id', 'desc')->get();
        return $datas;
    }

    public function get_top_brands()
    {
        $category = $this->get_current_category();
        if($category)
        {
            $ad = $category->ad_record()->with('company.icon','company.company_website.website')
                ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->select('company_id', DB::raw('count(*) as total'))
                ->groupBy('company_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get();
            return $ad;
        }
    }

    public function get_top_influencers()
    {
        $category = $this->get_current_category();
        if($category)
        {
            $ad = $category->ad_record()->with('influencer.influencer_follower_platform.size','influencer')
                ->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->select('influencer_id', DB::raw('count(*) as ad_record_count'))
                ->groupBy('influencer_id')
                ->orderBy('ad_record_count', 'desc')
                ->limit(5)
                ->get();
            return $ad;
        }
    }

    private function get_admin_categories()
    {
        return Category::where('active', activeType()['as'])->where('group', '!=', groupType()['fg'])
            ->orderBy('name_en')->get();
    }

    private function get_client_categories()
    {
        $categories = Category::WhereHas('user_category', function($query)
        {
            $query->where('user_id', user()->id);
        })->with('parents')->get();
        $cat = [];
        $parent_array = [];
        $i = 0;
        foreach($categories as $row)
        {
            if($row->parent_id)
            {
                if(!in_array($row->parent_id, $parent_array))
                {
                    $cat[$i] = $row->parents;
                    array_push($parent_array, $row->parent_id);
                    $i++;
                }
            }elseif($row->parent_id == 0)
            {
                if(!in_array($row->id, $parent_array))
                {
                    array_push($parent_array, $row->id);
                    $cat[$i] = $row;
                    $i++;
                }
            }
        }
        $data['parent'] = $cat;
        $data['all'] = $categories;
        return $data;
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
        if(Cache::get('market_start_' . user()->id) != null)
        {
            return Carbon::parse(Cache::get('market_start_' . user()->id))->startOfDay();
        }
        elseif($start_access)
        {
            return Carbon::now()->subDays(14)->isBefore($start_access) ? Carbon::parse($start_access)->startOfDay() : Carbon::now()->subDays(14)->startOfDay();
        }else
        {
            return Carbon::now()->subDays(14)->startOfDay();
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
        if(Cache::get('market_end_' . user()->id) != null)
        {
            return Carbon::parse(Cache::get('market_end_' . user()->id))->endOfDay();
        }
        elseif($end_access)
        {
            return Carbon::now()->isAfter($end_access) ? Carbon::parse($end_access)->endOfDay() : Carbon::now()->endOfDay();
        }else
        {
            return Carbon::now()->endOfDay();
        }
    }

    public function get_current_category()
    {
        if(request('category'))
        {
            $this->category = Category::findOrFail(request('category'));
        }
        if(!$this->category)
        {
            $categories = $this->get_categories();
            if($categories)
            {
                $first = [];
                if(user()->role->type)
                {
                    foreach($categories['parent'] as $category)
                    {
                        $onlyparent = 1;
                        foreach($categories['all'] as $row)
                        {
                            if($category->id == $row->parent_id)
                            {
                                $onlyparent = 0;
                                $first = $row;
                                break;
                            }
                        }
                        if($onlyparent)
                        {
                            $first = $category;
                            break;
                        }else
                        {
                            break;
                        }
                    }
                    $this->category = $first;
                }else
                {
                    $this->category = $categories->first();
                }
            }
        }
        return $this->category;
    }
}
