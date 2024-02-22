<?php

namespace Modules\Record\Service;

use Illuminate\Http\Request;
use Modules\Acl\Service\UserService;
use Modules\Acl\Service\CompanyService;
use Modules\Basic\Service\BasicService;
use Modules\Acl\Service\InfluencerService;
use Modules\CoreData\Service\LocationService;
use Modules\CoreData\Service\CategoryService;
use Modules\CoreData\Service\PlatformService;
use Modules\CoreData\Service\PromotionTypeService;
use Modules\CoreData\Service\WebsiteService;
use Modules\Record\Repositories\AdRecordDraftRepository;
use Modules\Record\Repositories\AdRecordRepository;

class AdRecordDraftService extends BasicService
{
    protected $repo, $companyService, $promotionTypeService, $influencerService, $websiteService,
        $countryService, $userService, $categoryService, $platformService, $adRecordRepository;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(AdRecordDraftRepository $repository, CompanyService $companyService,
        PromotionTypeService $promotionTypeService, WebsiteService $websiteService,
        InfluencerService $influencerService, LocationService $countryService, PlatformService $platformService,
        UserService $userService, CategoryService $categoryService, AdRecordRepository $adRecordRepository)
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
        $this->adRecordRepository = $adRecordRepository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [], $column = ['*'], $orderBy = [],
        $latest = '')
    {
        if($request->company_ids)
        {
            $request->merge(['company_id' => $request->company_ids]);
        }
        $moreConditionForFirstLevel = [];
        if(isset($request->start) && !empty($request->start) && isset($request->end) && !empty($request->end))
        {
            $moreConditionForFirstLevel += ['whereBetween' => ['date' => [$request->start, $request->end]]];
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
                    'orWhere' => [['date' => $request->search]],
                ],
            ];
        }
        if(!in_array(user()->role_id, [1, 10]))
        {
            $request->merge(['user_id' => [user()->id]]);
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
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return $data;
    }

    public function companyList(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->companyService->list($request);
    }

    public function categoryList()
    {
        return $this->categoryService->list(new Request(['active' => activeType()['as']]));
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

    public function convertLogs($draft, $adRecord)
    {
        if($draft->ad_record_draft_log && $draft->ad_record_draft_log->count())
        {
            $logs = $draft->ad_record_draft_log->toArray();
            $adLogs = [];
            foreach($logs as $log)
            {
                $adLogs[] = [
                    'ad_record_id' => $adRecord['id'],
                    "user_id" => $log['user_id'],
                    "type" => $log['type'],
                    "created_at" => $log['created_at'],
                ];
            }
            $adRecord->ad_record_log()->insert($adLogs);
        }
    }

    public function convertToAdRecord($request)
    {
        $draft_id = $request->id;
        $request->request->remove('id');
        $request->merge(['is_draft' => 1]);
        $adRecord = $this->adRecordRepository->save($request);
        $draft = $this->show($draft_id);
        $this->convertLogs($draft, $adRecord);
        if(\File::isDirectory(public_path(pathType()['ip'] . '/' . createFileNameServer($this->repo->model(),
                $draft_id))))
        {
            \File::makeDirectory(public_path('images/adrecord' . '/' . $adRecord['id']), 0777, true, true);
            foreach($draft->medias as $imageName)
            {
                \File::move(public_path(pathType()['ip'] . '/' . createFileNameServer($this->repo->model(),
                            $draft_id)) . '/' . $imageName->file,
                    public_path('images/adrecord' . '/' . $adRecord['id']) . '/' . $imageName->file);
            }
        }
        $draft->delete();
        return ['ad_id' => $adRecord['id'], 'success' => 1];
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
        $data = $this->adRecordRepository->findBy(new Request(
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
            $row->update_url = route('ad_record.update', ['id' => $row->id, 'duplicate_draft' => 1]);
        }
        return $data;
    }
}
