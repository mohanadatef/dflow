<?php

namespace Modules\Acl\Service;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerCity;
use Modules\Acl\Entities\InfluencerCountry;
use Modules\Acl\Entities\InfluencerFollowerPlatform;
use Modules\Acl\Http\Resources\Influencer\InfluencerListResource;
use Modules\Acl\Repositories\InfluencerRepository;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Entities\BrandActivityInfluencer;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\EventInfluencer;
use Modules\CoreData\Entities\InfluencerTravel;
use Modules\CoreData\Repositories\CalendarRepository;
use Modules\CoreData\Service\CategoryService;
use Modules\CoreData\Service\LinkTrackingService;
use Modules\CoreData\Service\LocationService;
use Modules\CoreData\Service\PlatformService;
use Modules\CoreData\Service\SizeService;
use Modules\Material\Entities\InfluencerTrend;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Entities\AdRecordDraft;
use Modules\Record\Entities\Campaign;

class InfluencerService extends BasicService
{
    protected $repo, $countryService, $categoryService, $platformService, $sizeService, $linkTrackingService,
        $calendarRepository;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(InfluencerRepository $repository, LocationService $countryService,
        CategoryService $categoryService, LinkTrackingService $linkTrackingService,
        PlatformService $platformService,
        SizeService $sizeService, CalendarRepository $calendarRepository)
    {
        $this->repo = $repository;
        $this->countryService = $countryService;
        $this->categoryService = $categoryService;
        $this->platformService = $platformService;
        $this->sizeService = $sizeService;
        $this->linkTrackingService = $linkTrackingService;
        $this->calendarRepository = $calendarRepository;
    }

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $get = '', $column = ['*'],
        $pagination = false, $perPage = 10, $recursiveRel = [], $withRelations = [], $orderBy = [], $pluck = [])
    {
        return $this->repo->findBy($request, $moreConditionForFirstLevel, $withRelations, $get, $column, $pagination,
            $perPage, $recursiveRel, null, $orderBy, pluck: $pluck);
    }

    public function store(Request $request)
    {
        $data = $this->repo->save($request);
        if($data)
        {
            return true;
        }
        return false;
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        if($data)
        {
            return $data;
        }
        return false;
    }

    public function countryList()
    {
        return $this->countryService->list(new Request(['active'=>activeType()['as']]));
    }

    public function countryListCreated()
    {
        $recursiveRel = [
            'influencer' => [
                'type' => 'whereHas',
            ]
        ];
        return $this->countryService->list(new Request(), false, 10, $recursiveRel);
    }

    public function categoryListCreated()
    {
        $recursiveRel = [
            'influencer' => [
                'type' => 'whereHas',
            ]
        ];
        return $this->categoryService->list(new Request(['active' => activeType()['as']]), recursiveRel: $recursiveRel);
    }

    public function categoryList(Request $request)
    {
        $request->merge(['active' => activeType()['as'], 'group' => groupType()['fg']]);
        return $this->categoryService->list($request);
    }

    public function industryList(Request $request)
    {
        $request->merge(['active' => activeType()['as'], 'group' => groupType()['igc']]);
        return $this->categoryService->list($request);
    }

    public function platformList()
    {
        return $this->platformService->list(new Request(['active' => activeType()['as']]));
    }

    public function list(Request $request)
    {
        return InfluencerListResource::collection($this->repo->findBy($request));
    }

    public function toggleActive(): bool
    {
        return $this->repo->toggleActive();
    }

    public function sizeList()
    {
        return $this->sizeService->list(new Request(['active' => activeType()['as']]));
    }

    public function adRecordInsight(Request $request, $data)
    {
        $adDetails = [];
        $date = [];
        if(isset($request->rang_data_analysis) && !empty($request->rang_data_analysis))
        {
            $rang_data_analysis = explode(' - ', $request->rang_data_analysis);
            $start_access = user()->start_access;
            $end_access = user()->end_access;
            if($start_access && $end_access)
            {
                if(Carbon::parse($rang_data_analysis[0])->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    $start = Carbon::parse($start_access);
                }else
                {
                    $start = Carbon::parse($rang_data_analysis[0]);
                }
                if(Carbon::parse($rang_data_analysis[1])->addDays(1)->isAfter($end_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    $end = Carbon::parse($end_access);
                }else
                {
                    $end = Carbon::parse($rang_data_analysis[1])->addDays(1);
                }
                $start = $start->startOfDay()->toDateTimeString();
                $end = $end->endOfDay()->toDateTimeString();
            }elseif($start_access)
            {
                if(Carbon::parse($rang_data_analysis[0])->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    $start = Carbon::parse($start_access);
                }else
                {
                    $start = Carbon::parse($rang_data_analysis[0]);
                }
                $end = Carbon::parse($rang_data_analysis[1])->addDays(1)->endOfDay()->toDateTimeString();
            }elseif($end_access)
            {
                $start = Carbon::parse($rang_data_analysis[0])->startOfDay()->toDateTimeString();
                if(Carbon::parse($rang_data_analysis[1])->addDays(1)->isAfter($end_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    $end = Carbon::parse($end_access);
                }else
                {
                    $end = Carbon::parse($rang_data_analysis[1])->addDays(1);
                }
            }else
            {
                $start = Carbon::parse($rang_data_analysis[0])->startOfDay()->toDateTimeString();
                $end = Carbon::parse($rang_data_analysis[1])->addDays(1)->endOfDay()->toDateTimeString();
            }
            $ad = $data->ad_record()->whereBetween('date', [$start, $end])->get();
            $ii = Carbon::parse($rang_data_analysis[0])->startOfDay()->diffInDays($end);
            $y = 0;
            for($i = 0; $i < $ii; $i++)
            {
                $y++;
                $date['date'][] = Carbon::parse($rang_data_analysis[0])->addDays($i)->startOfDay()->toDateString();
                $date['count'][] = $data->ad_record()->whereBetween('date',
                    [Carbon::parse($rang_data_analysis[0])->addDays($i)->startOfDay()
                        ->toDateTimeString(), Carbon::parse($rang_data_analysis[0])->addDays($i)->endOfDay()
                        ->toDateTimeString()])->count();
            }
        }else
        {
            $ad = $data->ad_record()->whereBetween('date',
                [Carbon::now()->subDays(30)->startOfDay()->toDateTimeString(), Carbon::today()->endOfDay()
                    ->toDateTimeString()])->get();
            $y = 0;
            for($i = 30; $i > 0; $i--)
            {
                $y++;
                $date['date'][] = Carbon::now()->subDays($i)->toDateString();
                $date['count'][] = $data->ad_record->whereBetween('date',
                    [Carbon::now()->subDays($i)->startOfDay()->toDateTimeString(), Carbon::now()->subDays($i)
                        ->endOfDay()->toDateTimeString()])->count();
            }
        }
        $data->date = $date;
        if($ad->count())
        {
            $data->ad = $ad->count();
            $company_ad = array_unique($ad->pluck('company_id')->toArray());
            if(count($company_ad))
            {
                foreach($company_ad as $company)
                {
                    $ads = $ad->where('company_id', $company);
                    $count = $ads->count();
                    $categories = $ads->first()->category->pluck('id')->toArray();
                    if($count > 1) $adDetails += [$ads->first()->company->name_en => [$count, $ads->first()->company->id, $categories]];
                }
                $data->adDetails = $adDetails;
            }
        }else
        {
            $data->ad = $ad->count();
            $data->adDetails = $adDetails;
        }
        $category_ad = [];
        $category_all = [];
        $category_parent = [];
        foreach($ad as $a)
        {
            if(count($a->category) && $a->category[0])
            {
                array_key_exists($a->category[0]->name_en,
                    $category_ad) ? $category_ad[$a->category[0]->name_en]++ : $category_ad[$a->category[0]->name_en] = 1;
                if(!in_array($a->category[0]->id, $category_all))
                {
                    array_push($category_all, $a->category[0]->id);
                }
                if($a->category[0]->parent_id == 0)
                {
                    if(!in_array($a->category[0]->id, $category_parent))
                    {
                        array_push($category_parent, $a->category[0]->id);
                    }
                }else
                {
                    if(!in_array($a->category[0]->parent_id, $category_parent))
                    {
                        array_push($category_parent, $a->category[0]->parent_id);
                    }
                }
            }
        }
        $categories = Category::wherein('id', $category_parent)->get();
        $data->category_all = $category_all;
        $data->category_ad = $category_ad;
        $data->categories = $categories;
        $data->ad_record = $data->ad_record()->paginate(5);
        $data->clientcategory = [];
        if(user()->role->type)
        {
            $data->clientcategory = Category::getCategoriesIdsByUserId();
        }
        return $data;
    }

    public function range_start_date()
    {
        $start_access = user()->start_access;
        if(request('ranges'))
        {
            if(strpos(request('ranges'), '-') )
            {
            $ranges = explode('-', request('ranges'));
            }
            if(strpos(request('ranges'), ',') )
            {
                $ranges = explode(',', request('ranges'));
            }
            if($start_access)
            {
                if(\Illuminate\Support\Carbon::parse(trim($ranges[0]))->isBefore($start_access))
                {
                    session(['message_false' => getCustomTranslation('this_dates_of_your_dates_range')]);
                    return Carbon::parse($start_access);
                }else
                {
                    return Carbon::createFromFormat('m/d/Y', trim($ranges[0]))->setTime(0, 0, 0);
                }
            }else
            {
                return Carbon::createFromFormat('m/d/Y', trim($ranges[0]))->setTime(0, 0, 0);
            }
        }
        if($start_access)
        {
            return Carbon::now()->subDays(30)->isBefore($start_access) ? Carbon::parse($start_access) : Carbon::now()
                ->subDays(30)->startOfDay();
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
            if(strpos(request('ranges'), '-') )
            {
                $ranges = explode('-', request('ranges'));
            }
            if(strpos(request('ranges'), ',') )
            {
                $ranges = explode(',', request('ranges'));
            }
            if($end_access)
            {
                if(Carbon::parse(trim($ranges[1]))->isAfter($end_access))
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

    public function search(Request $request, $pagination = false, $perPage = 10, $all = false)
    {
        if(!$request->search || !isset($request->search))
        {
            $request->merge(['search' => $request->term]);
        }
        $data = [];
        $query = Influencer::with('influencer_follower_platform.size', 'category', 'platform')
            ->where('active', activeType()['as']);
        if((isset($request->search) && !empty($request->search)) or $all)
        {
            if(user()->match_search)
            {
                $s = '%' . $request->search . '%';
                $operator = 'like';
            }else
            {
                $s = $request->search;
                $operator = '=';
            }
            $data = $query
                ->where(function($query) use ($request, $s, $operator)
                {
                    $query
                        ->where('name_en', $operator, $s)
                        ->orWhere('name_ar', $operator, $s)
                        ->orWhere('gender', $operator, $s)
                        ->orWhereHas('platform', function($q) use ($request, $s, $operator)
                        {
                            $q
                                ->where('name_en', $operator, $s)
                                ->orWhere('name_ar', $operator, $s);
                        })
                        ->orWhereHas('influencer_follower_platform', function($q) use ($request, $s, $operator)
                        {
                            $q->WhereHas('size', function($query) use ($request, $s, $operator)
                            {
                                $query
                                    ->where('name_en', $operator, $s)
                                    ->orWhere('name_ar', $operator, $s);
                            });
                        })
                        ->orWhereHas('category', function($q) use ($request, $s, $operator)
                        {
                            $q
                                ->where('name_en', $operator, $s)
                                ->orWhere('name_ar', $operator, $s);
                        });
                });
        }elseif(isset($request->id) && !empty($request->id))
        {
            if(is_array($request->id))
            {
                $data = $query->whereIn('id', $request->id);
            }elseif(strpos($request->id, ',') !== false)
            {
                $data = $query->whereIn('id', explode(',', $request->id));
            }else
            {
                $data = $query->where('id', $request->id);
            }
        }elseif(isset($request->company_id))
        {
            $range_start = $this->range_start_date();
            $range_end = $this->range_end_date();
            $data = $query->WhereHas('ad_record', function($q) use ($request, $range_end, $range_start)
            {
                if($range_end && $range_start)
                {
                    $q->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);
                }
                $q->WhereHas('company', function($query) use ($request)
                {
                    $query->where('id', $request->company_id);
                });
            });
        }
        if(!empty($data))
        {
            $data = $data->get();
        }
        return $data;
    }

    public function searchDiscover(Request $request)
    {
        if(empty($request->search))
        {
            unset($request['search']);
        }
        if(!empty($request->all()))
        {
            $data = Influencer::with('influencer_follower_platform.size', 'category', 'platform', 'country')
                ->where('active', activeType()['as']);
        }else
        {
            $data = [];
        }
        if((isset($request->search) && !empty($request->search)))
        {
            if(user()->match_search)
            {
                $s = '%' . $request->search . '%';
                $operator = 'like';
            }else
            {
                $s = $request->search;
                $operator = '=';
            }
            $data = $data
                ->where(function($query) use ($request, $s, $operator)
                {
                    $query
                        ->where('name_en', $operator, $s)
                        ->orWhere('name_ar', $operator, $s);
                });
        }elseif(isset($request->id) && !empty($request->id))
        {
            if(is_array($request->id))
            {
                $data = $data->whereIn('id', $request->id);
            }elseif(strpos($request->id, ',') !== false)
            {
                $data = $data->whereIn('id', explode(',', $request->id));
            }else
            {
                $data = $data->where('id', $request->id);
            }
        }
        if(isset($request->country) && !is_null($request->country))
        {
            $data = $data->WhereHas('country', function($q) use ($request)
            {
                $q->whereIn('country_id', $request->country);
            });
        }
        if(isset($request->gender) && !is_null($request->gender))
        {
            $data = $data->whereIn('gender', $request->gender);
        }
        if(isset($request->category) && !is_null($request->category))
        {
            $data = $data->WhereHas('category', function($q) use ($request)
            {
                $q->whereIn('category_id', $request->category);
            });
        }
        if(isset($request->platform) && !is_null($request->platform))
        {
            $data = $data->WhereHas('platform', function($q) use ($request)
            {
                $q->whereIn('platform_id', $request->platform);
            });
        }
        if(isset($request->size) && !is_null($request->size))
        {
            $data = $data->WhereHas('influencer_follower_platform', function($q) use ($request)
            {
                $q->whereIn('size_id', $request->size);
            });
        }
        $range_start = $this->range_start_date();
        $range_end = $this->range_end_date();
        if(isset($request->company_id) && !is_null($request->company_id))
        {
            $data = $data->WhereHas('ad_record', function($q) use ($request, $range_end, $range_start)
            {
                if($range_end && $range_start)
                {
                    $q->whereBetween('date', [$this->range_start_date(), $this->range_end_date()]);
                }
                $q->WhereHas('company', function($query) use ($request)
                {
                    $query->where('id', $request->company_id);
                });
            });
        }
        if(!empty($data))
        {
            $data = $data->get();
        }
        return $data;
    }

    public function linkTracker(Request $request): array
    {
        $data = [];
        foreach($request->influencer as $influencer_id)
        {
            $data[] = $this->linkTrackingService->store(
                new Request(
                    ['destination' => $request->url, 'title' => $request->url, 'influencer_id' => $influencer_id]
                )
            );
        }
        return $data;
    }

    public function campaignList()
    {
        return Campaign::all();
    }

    public function discoverCalander(Request $request)
    {
        return $this->calendarRepository->save($request, sync_influencers: true);
    }

    public function listHander(Request $request)
    {
        $platform_id = $this->platformService->findBy(new Request(['name' => "Snapchat"]))->first()->id;
        $start = Carbon::now()->startOfDay()->subDays(30);
        $end = Carbon::now()->endOfDay();
        $x= InfluencerFollowerPlatform::where('platform_id', $platform_id)->whereNotNull('url')
            ->where('url', '!=', '0')
            ->where('influencer_group_id','!=',0)
            ->whereHas('influencer', function($query) use ($start, $end)
            {
                $query->where('active', 1);
            })->addSelect('url',DB::raw("(SELECT COUNT(`ad_records`.`id`) FROM `ad_records` WHERE `ad_records`.`influencer_id` = `influencer_follower_platforms`.`influencer_id` AND `ad_records`.`created_at` BETWEEN '$start' AND '$end')  AS `total_ads`"))
            ->orderBy('total_ads', 'DESC')->get()->pluck('url');
        $y=InfluencerFollowerPlatform::where('platform_id', $platform_id)->whereNotNull('url')
            ->where('url', '!=', '0')
            ->where('influencer_group_id',0)
            ->whereHas('influencer', function($query) use ($start, $end)
            {
                $query->where('active', 1);
            })->addSelect('url',DB::raw("(SELECT COUNT(`ad_records`.`id`) FROM `ad_records` WHERE `ad_records`.`influencer_id` = `influencer_follower_platforms`.`influencer_id` AND `ad_records`.`created_at` BETWEEN '$start' AND '$end')  AS `total_ads`"))
            ->orderBy('total_ads', 'DESC')->get()->pluck('url');
        return array_values(array_diff(array_merge($x->toArray(),$y->toArray()), ['alfarraj_banan']));
    }

    public function getUniqueInfluencers(Request $request, $start_date, $end_date, $perPage)
    {
        $sorting = ($request->sorting) ? $request->sorting : "desc";
        $inflwancer = Influencer::leftJoin('ad_records', 'influencers.id', '=', 'ad_records.influencer_id')
            ->select('influencers.*', DB::raw('COUNT(ad_records.id) as count'))
            ->groupBy('influencers.id')
            ->orderBy('count', $sorting);
        $inflwancer = $inflwancer->whereHas('ad_record', function($query) use ($request, $start_date, $end_date)
        {
            $query->where('company_id', $request->company_id)
                ->whereBetween('date', [$start_date, $end_date]);
            if(user()->role->type)
            {
                $query->whereHas('category', function($que) use ($request)
                {
                    $que->whereIn('category_id', user()->category->pluck('id')->toArray());
                });
            }
        });
        if($request->search)
        {
            if(substr($request->search, 0, 1) === "i" || substr($request->search, 0, 1) === "I")
            {
                $inflwancer->where('influencers.id', substr($request->search, 1));
            }else
            {
                if(user()->match_search)
                {
                    $s = '%' . $request->search . '%';
                    $operator = 'like';
                }else
                {
                    $s = $request->search;
                    $operator = '=';
                }
                $inflwancer = $inflwancer->where(function($query) use ($request, $operator, $s)
                {
                    $query->where('name_en', $operator, $s)
                        ->orWhere('name_ar', $operator, $s);
                });
            }
        }
        return $inflwancer->paginate($perPage);
    }

    public function getInfluencersByids(Request $request, $perPage = 12, $page = 1)
    {
        $category = $this->categoryService->findBy(new Request(['id' => $request->category]), get: "first");
        if($category)
        {
            $ad = $category->ad_record()->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->get();
            $ad = $ad->groupBy('influencer_id')->map(function($values)
            {
                return $values->count() ?? 0;
            })->toArray();
            if($request->sorting == "asc")
            {
                asort($ad);
            }else
            {
                arsort($ad);
            }
            $influencer = new Collection();
            foreach($ad as $key => $value)
            {
                $inf = $this->repo->findOne($key);
                if($inf)
                {
                    $inf->count = $value;
                    $influencer->push($inf);
                }
            }
            return new LengthAwarePaginator($influencer->forPage($page, $perPage), $influencer->count(), $perPage,
                $page, ['path' => route('influencer.InfluencersByids')]);
        }
    }

    public function searchMerge($request)
    {
        $moreConditionForFirstLevel = [];
        if(!empty($request->term))
        {
            $moreConditionForFirstLevel = [
                'where' => [
                    'id' => ['!=', $request->influencer_id]
                ],
                'whereCustom' => [
                    'orWhere' => [
                        ['name_en' => $request->term], ['name_ar' => $request->term]
                    ]],
            ];
        }
        return $this->findBy($request, column: ['name_en', 'name_ar', 'id'],
            moreConditionForFirstLevel: $moreConditionForFirstLevel);
    }

    public function merge(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        AdRecord::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        AdRecordDraft::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        InfluencerTravel::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        InfluencerCountry::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        InfluencerCity::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        EventInfluencer::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        BrandActivityInfluencer::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        InfluencerTrend::where('influencer_id', $request->influencer_id)->update(['influencer_id' => $data->id]);
        $this->repo->findOne($request->influencer_id)->delete();
        return true;
    }

    public function uploadImage(Request $request)
    {
        foreach($request->images as $image)
        {
            $id = $image->getClientOriginalname();
            $data = $this->repo->findOne($id);
            if($data)
            {
                $this->repo->checkMediaDelete($data, new Request(['image'=>$image]), mediaType()['mm']);
            $this->repo->media_upload($data, new Request(['image'=>$image]), createFileNameServer($this->repo->model(), $data->id), pathType()['ip'],
                mediaType()['mm']);
            }
        }
        return true;
    }

    public function uploadManyImage()
    {
        $images=\File::allFiles(public_path('All'));
        foreach($images as $image)
        {
            $id = $image->getRelativePathname();
            $data = $this->repo->findOne($id);
            if($data)
            {
                $this->repo->checkMediaDelete($data, new Request(['image'=>$image]), mediaType()['mm']);
                $fileName = time() . $image->getRelativePathname();
                $file = $data->media()->create(['file' => $fileName, 'type' => mediaType()['mm']]);
                \File::makeDirectory(public_path('images/influencer' . '/' . $data->id), 0777, true, true);
                if (!\File::isDirectory(public_path(pathType()['ip'] . '/' . $fileName))) {
                    \File::makeDirectory(public_path(pathType()['ip'] . '/' . $fileName), 0777, true, true);
                }
                \File::move(public_path('All').'/'.$image->getRelativePathname(),
                    public_path('images/influencer' . '/' . $data->id) . '/' . $fileName);
            }
        }
    }
}
