<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Repositories\CompanyMergeTemplateRepository;
use Modules\Basic\Entities\Media;
use Modules\Basic\Service\BasicService;

class CompanyMergeTemplateService extends BasicService
{
    protected $repo, $companyService;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(CompanyMergeTemplateRepository $repository, CompanyService $companyService)
    {
        $this->repo = $repository;
        $this->companyService = $companyService;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $with = [], $recursiveRel = [], $column = ['*'])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $with,
            $recursiveRel, $column);
    }

    public function checkDuplicates()
    {
        $c = user()->match_search;
        if($c)
        {
            user()->update(['match_search' => 0]);
        }
        $companyTemps = $this->findBy(new Request());
        $de = [];
        foreach($companyTemps as $temp)
        {
            $com = $this->companyService->findBy(new Request(['id'=>$temp->company_id]),get:'count');
            if($com == 0)
            {
                $de = array_merge([$temp->id], $de);
                $this->delete($temp->id);
            }
            if(in_array($temp->id, $de))
            {
                continue;
            }
            executionTime();
            $ids = [];
            $duplicates = $this->findBy(new Request(['name_en' => $temp->name_en, 'name_ar' => $temp->name_ar]),
                moreConditionForFirstLevel: ['where' => ['company_id' => ['!=', $temp->company_id]]]);
            if($duplicates->count())
            {
                $temp->update([
                    'merge_id_sheet' => implode(',', $duplicates->pluck('company_id')->toArray()),
                ]);
                $ids = array_merge($duplicates->pluck('company_id')->toArray(), [$temp->company_id]);
                $de = array_merge($duplicates->pluck('id')->toArray(), $de);
                $this->delete($duplicates->pluck('id')->toArray());
            }
            $companyTableDuplicates = $this->companyService->findBy(new Request(['name_en' => $temp->name_en, 'name_ar' => $temp->name_ar]),
                moreConditionForFirstLevel: ['whereNotIn' => ['id' => $ids]]);
            if($companyTableDuplicates->count())
            {
                $temp->update([
                    'merge_id_system' => implode(',', $companyTableDuplicates->pluck('id')->toArray()),
                ]);
            }
        }
        if($c)
        {
            user()->update(['match_search' => 1]);
        }
        return true;
    }

    public function DeleteAll()
    {
        $companyTemps = $this->findBy(new Request());
        $this->delete($companyTemps->pluck('id')->toArray());
        return true;
    }

    public function merge($id)
    {
        $s = $this->repo->findOne($id);
        $ids = [];
        if($s){
            $ids = array_merge([$s->company_id], array_map('intval', explode(',', $s->merge_id_sheet))
            , array_map('intval', explode(',', $s->merge_id_system)));
            $ids = array_filter($ids);
        }
        $mergeReturn = false;
        if(count($ids)) {
            $companies = $this->companyService->findBy(new Request(['id' => $ids]),
                with: ['industry', 'company_website', 'icon']);
            if(count($companies)) {
                $industry = [];
                $link = [];
                $icon = [];
                foreach($companies as $c) {
                    $industry = array_merge($industry, $c->industry->pluck('id')->toArray());
                    foreach($c->company_website->pluck('url', 'website_id') as $key => $w) {
                        $link [$key] = $w;
                    }
                    $icon = array_merge($icon, [$c->icon->id ?? null]);
                }
                $ids = $companies->pluck('id')->toArray();
                $icon=array_filter($icon);
                if($icon) {
                    $index = array_key_first($icon);
                    $icon = $icon[$index];
                    Media::find($icon)->update(['category_id' => $s->company_id]);
                }
                if(in_array($s->company_id,$ids)) {
                    $mergeReturn = $this->companyService->merge(new Request(['company_id' => $s->company_id, 'companies' => $ids,
                        'name_en' => $s->name_en, 'name_ar' => $s->name_ar, 'industry' => $industry, 'link' => $link]));
                }
            }
        }
        if($mergeReturn) {
            $s->delete();
        }
        return $mergeReturn;
    }
    public function mergeAll()
    {
      $all =  $this->repo->findBy(new Request());
      foreach($all as $one)
      {
          $this->merge($one->id);
      }
    }
}
