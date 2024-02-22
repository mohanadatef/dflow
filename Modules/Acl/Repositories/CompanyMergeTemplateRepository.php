<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Acl\Entities\CompanyMergeSheetTemplate;

class CompanyMergeTemplateRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'name_ar', 'name_en','company_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompanyMergeSheetTemplate::class;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getFieldsRelationShipSearchable()
    {
        return $this->model->searchRelationShip;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $with = [], $recursiveRel = [],$column=['*'])
    {

        return $this->all(
            $request->all(), $column, $with, $recursiveRel, $moreConditionForFirstLevel,
            $pluck, [], $get, null, null, $pagination, $perPage
        );
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }


    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false,
        $perPage = 10)
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, [],
            ['column' => 'name_en', 'order' => 'asc'], '', null, null, $pagination, $perPage);
    }

}
