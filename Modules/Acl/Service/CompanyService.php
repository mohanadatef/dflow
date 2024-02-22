<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Entities\Company;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Entities\BrandActivitySponsorship;
use Modules\CoreData\Service\CategoryService;
use Modules\Acl\Repositories\CompanyRepository;
use Modules\Acl\Http\Resources\Company\CompanyListResource;
use Modules\CoreData\Service\WebsiteService;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Entities\AdRecordDraft;
use Modules\Record\Entities\CampaignCompany;

class CompanyService extends BasicService
{
    protected $repo, $categoryService, $websiteService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(CompanyRepository $repository, CategoryService $categoryService,
        WebsiteService $websiteService)
    {
        $this->repo = $repository;
        $this->categoryService = $categoryService;
        $this->websiteService = $websiteService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $with = [], $recursiveRel = [], $column = ['*'])
    {
        if(isset($request->company_id))
        {
            if(count(array_filter($request->company_id)))
            {
                $moreConditionForFirstLevel += [
                    'whereNotIn' => [
                        'id' => $request->company_id
                    ],
                ];
            }
        }
        if(isset($request->name) && !empty($request->name))
        {
            $moreConditionForFirstLevel += [
                'whereCustom' => [
                    'orWhere' => [
                        ['name_en' => $request->name], ['name_ar' => $request->name]
                    ]],
            ];
        }
        if(isset($request->link) && !empty($request->link))
        {
            if(user()->match_search)
            {
                $s = '%' . $request->link . '%';
                $operator = 'like';
            }else
            {
                $s = $request->link;
                $operator = '=';
            }
            $recursiveRel += ['company_website' => [
                'type' => 'whereHas',
                'where' => ['url' => [$operator, $s]],
            ]
            ];
        }
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $with,
            $recursiveRel, $column);
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

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        $request->merge(['active'=>activeType()['as']]);
        return CompanyListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage));
    }

    public function listIndustry()
    {
        return $this->categoryService->list(new Request(['group' => [groupType()['igc'], groupType()['igp']], 'active' => activeType()['as']]));
    }

    public function toggleActive(): bool
    {
        return $this->repo->toggleActive();
    }

    public function filter(int $perPage)
    {
        $request = new Request(['name' => request('name_en'), 'industry' => request('industry_id')]);
        return $this->findBy($request, true, $perPage);
    }

    public function getBrands(Request $request)
    {
        if($request->direct)
        {
            $key = 'whereIn';
        }else{
            $key = 'whereNotIn';
        }
        $recursiveRel =
            ['ad_record' => [
                'type' => 'whereHas',
                'where' => ['company_id' => ['!=', $request->company]],
                'recursive' => [
                    'category' => [
                        'type' => 'whereHas',
                        'whereIn' => ['category_id' => $this->get_categories()]
                    ], 'company' => [
                        'type' => 'whereHas',
                        'recursive' => [
                            'industry' => [
                                'type' => 'whereHas',
                                $key => ['industry_id' => $this->get_categories()]
                            ]
                        ]
                    ]
                ],
            ]
            ];

        return $this->findBy($request, true, 9, with: ['icon'], recursiveRel: $recursiveRel);
    }

    public function get_categories()
    {
        $categories = AdRecord::join('ad_record_categories', 'ad_record_categories.ad_record_id', '=', 'ad_records.id')
            ->where('ad_records.company_id', request('company'))->select('ad_record_categories.category_id')
            ->groupBy('ad_record_categories.category_id')->orderBy("ad_record_categories.category_id")
            ->pluck('ad_record_categories.category_id');
        return $categories;
    }

    public function company_in_categories($request)
    {
        if(empty($request->category_id))
        {
            return [];
        }
        $newRequest = new Request(['industry' => $request->category_id]);
        return $this->findBy($newRequest, false);
    }

    public function companyByid($request)
    {
        if(empty($request->category))
        {
            return [];
        }
        $category = $this->categoryService->findBy(new Request(['id'=>$request->category]),get:'first');
            $ad = $category->ad_record()->whereBetween('date', [$this->range_start_date(), $this->range_end_date()])
                ->get();
            $ad = $ad->groupBy('company_id')->map(function($values)
            {
                return $values->count();
            })->sort()->reverse();
            $companyids = array_keys(array_filter($ad->toArray(), null));
        $newRequest = new Request(['id' => $companyids]);
        return $this->findBy($newRequest, true, 9, with: ['industry']);
    }

    public function search(Request $request)
    {
        $request->merge(['name' => $request->term]);
        return $this->findBy($request, column: ['name_en', 'name_ar', 'id']);
    }

    public function merge(Request $request)
    {
        $data = $this->repo->save($request, $request->company_id);
		print_r($request->companies); die();
        if (is_array(json_decode($request->companies[0]))) {
            $company_merge = array_unique(json_decode($request->companies[0]));
        } else {
            $company_merge = $request->companies;
        }
        $remove = array_search($request->company_id, $company_merge);
        if(isset($remove))
        {
            unset($company_merge[$remove]);
        }
        if(!empty($company_merge)) {
            AdRecord::whereIn('company_id', $company_merge)->update(['company_id' => $data->id]);
            CampaignCompany::whereIn('company_id',$company_merge)->update(['company_id' => $data->id]);
            AdRecordDraft::whereIn('company_id', $company_merge)->update(['company_id' => $data->id]);
            BrandActivitySponsorship::whereIn('company_id', $company_merge)->update(['company_id' => $data->id]);
            $company = $this->repo->findBy(new Request(['id' => $company_merge]));
            foreach($company as $c)
            {
                Company::where('id',$c->id)->update(['merge_company_id' => $data->id]);
                $c->delete();
            }
        }
            return true;
    }

    public function getWebsites(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        return $this->websiteService->list($request);
    }public function companyList(Request $request)
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
}
