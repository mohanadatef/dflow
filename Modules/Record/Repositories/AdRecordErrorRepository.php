<?php

namespace Modules\Record\Repositories;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Record\Entities\AdRecordError;

class AdRecordErrorRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'created_by_id', 'action_at', 'ad_record_id', 'action', 'created_at','action_by_id '
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return AdRecordError::class;
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
        $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [], $column = ['*'], $orderBy = [],
        $latest = '')
    {
        return $this->all($request->all(), $column, $relation, $recursiveRel, $moreConditionForFirstLevel, $pluck,
            $orderBy, $get, null, null, $pagination, $perPage, $latest);
    }

    public function findOne($id)
    {
        return $this->find($id);
    }

    public function save(Request $request, $id = null){
        return DB::transaction(function() use ($request, $id)
        {
            if($id){
                $data = $this->update($request->all(), $id);
                $data->ad_record_log()->create(['type' => 4, 'user_id' => user()->id]);
            }
            else{
                $data = $this->create($request->all());
                $data->ad_record_log()->create(['type' => 3, 'user_id' => user()->id]);
            }
            return $this->find($data->id);
        });

    }

    public function cancel($id){
        $data = $this->update(
            [
                'action' => 2,
                'action_by_id' => user()->id,
                'action_at' => Carbon::now()
            ], $id);

        $data->ad_record_log()->create(['type' => 8, 'user_id' => user()->id]);
        return $data;
    }
}
