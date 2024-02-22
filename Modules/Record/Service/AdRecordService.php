<?php

namespace Modules\Record\Service;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Acl\Service\UserService;
use Modules\Acl\Service\CompanyService;
use Modules\Basic\Service\BasicService;
use Modules\Acl\Service\InfluencerService;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Service\LocationService;
use Modules\CoreData\Service\CategoryService;
use Modules\CoreData\Service\PlatformService;
use Modules\CoreData\Service\PromotionTypeService;
use Modules\CoreData\Service\WebsiteService;
use Modules\Record\Repositories\AdRecordRepository;
use Modules\Record\Http\Resources\AdRecord\AdRecordResource;
use Modules\Record\Http\Resources\AdRecord\AdRecordListResource;

class AdRecordService extends BasicService
{
    protected $repo, $companyService, $promotionTypeService, $influencerService, $websiteService, $adRecordErrorService,
        $countryService, $userService, $categoryService, $platformService, $adRecordDraftService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(AdRecordRepository $repository, CompanyService $companyService,
        PromotionTypeService $promotionTypeService, WebsiteService $websiteService,
        AdRecordErrorService $adRecordErrorService,
        InfluencerService $influencerService, LocationService $countryService, PlatformService $platformService,
        UserService $userService, CategoryService $categoryService, AdRecordDraftService $adRecordDraftService)
    {
        $this->repo = $repository;
        $this->companyService = $companyService;
        $this->promotionTypeService = $promotionTypeService;
        $this->influencerService = $influencerService;
        $this->countryService = $countryService;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->platformService = $platformService;
        $this->websiteService = $websiteService;
        $this->adRecordDraftService = $adRecordDraftService;
        $this->adRecordErrorService = $adRecordErrorService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [], $column = ['*'], $orderBy = [],
        $latest = '')
    {
        if($request->company_ids)
        {
            $request->merge(['company_id' => $request->company_ids]);
        }
        if(isset($request->clientauth) && $request->clientauth)
        {
            $request->merge(['category' => array_merge($request->category, Category::getCategoriesIdsByUserId())]);
        }
        if(user()->role->type && !isset($request->category))
        {
            $request->merge(['category' => Category::getCategoriesIdsByUserId()]);
        }
        $moreConditionForFirstLevel = [];
        if(isset($request->start) && !empty($request->start) && isset($request->end) && !empty($request->end))
        {
            $moreConditionForFirstLevel += ['whereBetween' => ['date' => [$request->start, $request->end]]];
        }else
        {
            $start = user()->start_access;
            $end = user()->end_access;
            if($start && $end)
            {
                $moreConditionForFirstLevel += ['whereBetween' => ['date' => [$start, $end]]];
            }elseif($start)
            {
                $moreConditionForFirstLevel += ['where' => ['date' => ['>=', $start]]];
            }elseif($end)
            {
                $moreConditionForFirstLevel += ['where' => ['date' => ['<=', $end]]];
            }
        }
        if(isset($request->creation_start) && !empty($request->creation_start) && isset($request->creation_end) && !empty($request->creation_end))
        {
            $moreConditionForFirstLevel += ['whereBetween' => ['created_at' => [$request->creation_start, $request->creation_end]]];
        }
        if(isset($request->search) && !empty($request->search))
        {
            $s = $request->search;
            $influencerWhereCustom = [];
            if(substr($s, 0, 1) === "i" || substr($s, 0, 1) === "I")
            {
                $request->request->add(['influencer_id' => substr($s, 1)]);
            }else
            {
                $influencerWhereCustom = ['whereHas' => ['influencer' =>
                    [
                        'type' => 'whereHas',
                        'where' => ['name_en' => $request->search],
                        'orWhere' => ['name_ar' => $request->search],
                    ]]];
            }
            if(substr($s, 0, 2) === "ad" || substr($s, 0, 2) === "Ad")
            {
                $request->request->add(['id' => substr($s, 2)]);
            }
            $moreConditionForFirstLevel += [
                'whereCustom' => [
                    $influencerWhereCustom,
                    'orWhereHas' => [['company' =>
                        [
                            'type' => 'orWhereHas',
                            'where' => ['name_en' => $request->search],
                            'orWhere' => ['name_ar' => $request->search],
                        ]]],
                ],
            ];
        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel,
            $recursiveRel, $relation, $column, $orderBy, $latest);
    }

    public function show($id, $withRelations = [])
    {
        return $this->repo->findOne($id, $withRelations);
    }

    public function store(Request $request)
    {
        $request->merge(['is_draft' => 0]);
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        if(isset($request->solve) && $request->solve == 1)
        {
            foreach($data->ad_record_errors->where('action', 0) as $solve)
            {
                $this->adRecordErrorService->update(new Request(['error_id' => $solve->id]));
            }
        }
        if(isset($request->duplicate_draft_id))
        {
            $this->adRecordDraftService->delete($id);
        }
        return new AdRecordResource($data);
    }

    public function list(Request $request)
    {
        return AdRecordListResource::collection($this->repo->findBy($request));
    }

    public function companyList(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->companyService->list($request);
    }

    public function categoryList()
    {
        return $this->categoryService->AdRecordCategorylist(new Request(['active' => activeType()['as'], 'group' => [groupType()['igc'], groupType()['igp']]]));
    }

    public function getCategoriesnamesByUserId()
    {
        return $this->categoryService->getCategoriesnamesByUserId();
    }

    public function platformList()
    {
        return $this->platformService->list(new Request(['active' => activeType()['as']]));
    }

    public function promotionTypeList()
    {
        return $this->promotionTypeService->list(new Request(['active' => activeType()['as']]));
    }

    public function influencerList(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->influencerService->list($request);
    }

    public function countryList()
    {
        $request = new Request(['selector' => "-1"]);
        return $this->countryService->listSpecific($request);
    }

    public function countryListGcc()
    {
        $request = new Request(['selector' => "GCC"]);
        return $this->countryService->listSpecific($request);
    }

    public function researcherList()
    {
        return $this->userService->list(new Request(['role_id' => 3]));
    }

    public function usersList()
    {
        $ids = $this->findBy(new Request(), $pagination = false, $perPage = 10, $pluck = ['user_id', 'user_id']);
        $ids = array_unique(array_values($ids->toArray()));
        return $this->userService->list(new Request(['id' => $ids]));
    }

    public function listCompanyIndustry()
    {
        return $this->companyService->listIndustry();
    }

    public function getPlatform()
    {
        return $this->platformService->findBy(new Request(['name' => "Snapchat"]))->first()->id;
    }

    public function websiteList()
    {
        return $this->websiteService->findBy(new Request(['active' => activeType()['as']]));
    }

    public function getInfluencer($id)
    {
        return $this->influencerService->show($id);
    }

    public function accsseAdReqcord($data)
    {
        $date = $data->date;
        $start = user()->start_access;
        $end = user()->end_access;
        $categoryAdRecord = $data->category->pluck('id')->toArray();
        $categoryUser = user()->category->pluck('id')->toArray();
        $array_intersect = array_intersect($categoryUser, $categoryAdRecord);
        if(count($array_intersect) == 0)
        {
            session(['message_false' => getCustomTranslation("this_ad_record_out_of_your_category")]);
            return false;
        }
        if($start && $end)
        {
            $check = Carbon::parse($date)->between($start, $end);
            if($check == false)
            {
                session(['message_false' => getCustomTranslation("this_ad_record_out_of_your_dates_range")]);
                return false;
            }
        }elseif($start)
        {
            $check = Carbon::parse($date)->isAfter($start);
            if($check == false)
            {
                session(['message_false' => getCustomTranslation("this_ad_record_out_of_your_dates_range")]);
                return false;
            }
        }elseif($end)
        {
            $check = Carbon::parse($date)->isBefore($end);
            if($check == false)
            {
                session(['message_false' => getCustomTranslation("this_ad_record_out_of_your_dates_range")]);
                return false;
            }
        }
        return true;
    }

    public function checkDuplicates($request)
    {
        if(!isset($request->company_id))
        {
            if(empty($request->name_en) || empty($request->name_ar) || empty($request->industry))
            {
                return [];
            }
            $companies = $this->companyService->findBy(new Request(['active' => 1,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar, 'industry' => $request->industry]), pluck: ['id', 'id']);
            if(count($companies) == 0)
            {
                return [];
            }
        }
        $data = $this->repo->findBy(new Request(
            [
                'company_id' => $request->company_id ?? $companies->toArray(),
                'influencer_id' => $request->influencer_id,
                'date' => $request->date,
                'platform_id' => $request->platform_id
            ]), latest: 'latest');
        $data->count = count($data);
        $data->date = $request->date;
        foreach($data as $row)
        {
            $row->show_url = route('ad_record.show', ['id' => $row->id]);
            $row->update_url = route('ad_record.update', ['id' => $row->id, 'duplicate' => 1]);
        }
        return $data;
    }

    public function getLastDraft()
    {
        return $this->adRecordDraftService->findBy(new Request(['user_id' => user()->id]), get: 'first',
            latest: 'latest');
    }

    public function readFiles(Request $request)
    {
        $request->merge(['module' => createFileNameServer($this->repo->model(), $request->id)]);
        return $this->repo->readFiles($request);
    }

    public function fixCategory(Request $request)
    {
        $company = $this->companyService->findBy(new Request(['industry' => $request->target_company_category,'active'=>activeType()['as']]),
            pluck: ['id', 'id'])->toArray();
        $adRecord = $this->repo->findBy(new Request(['company_id'=>$company]),relation:['category']);
        foreach($adRecord as $ad)
        {
            $category = $ad->category->pluck('id','id')->toArray();
            $category = array_merge($category,[$request->correct_category]);
            if(isset($request->misclassified_category) && !empty($request->misclassified_category))
            {
            $category = array_diff($category,$request->misclassified_category);
            }
            if(count($category))
            {
                $this->repo->save(new Request(['category'=>$category]),$ad->id);
            }
        }
    }
}
