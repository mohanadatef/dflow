<?php

namespace Modules\Record\Repositories;

use Illuminate\Http\Request;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Record\Entities\AdRecordDraftLog;

class AdRecordDraftLogRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'user_id','ad_record_draft_id','type'
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return AdRecordDraftLog::class;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable() : array
    {
        return $this->fieldSearchable;
    }

    public function getFieldsRelationShipSearchable()
    {
        return $this->model->searchRelationShip;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [], $column = ['*'],$orderBy=[],$latest='')
    {
        return $this->all($request->all(), $column, $relation, $recursiveRel, $moreConditionForFirstLevel, $pluck, $orderBy, $get, null, null, $pagination, $perPage,$latest);
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }


}
