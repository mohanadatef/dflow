<?php

namespace Modules\Acl\Repositories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\InfluencerGroupSchedule;
use Modules\Basic\Repositories\BasicRepository;

class InfluencerGroupScheduleRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'day', 'researcher_id', 'influencer_group_id','shift'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return InfluencerGroupSchedule::class;
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

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $withRelations = [], $get = '', $column = ['*'], $pagination = false, $perPage = 10, $recursiveRel = [], $limit = null, $orderBy = [],$pluck=[])
    {
        return $this->all($request->all(), $column, $withRelations, $recursiveRel, $moreConditionForFirstLevel,
            $pluck, $orderBy, $get, null, $limit, $pagination, $perPage);
    }



    public function findOne($id)
    {
        return $this->find($id);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function () use ($request, $id) {
            return $this->create($request->all());
        });
    }

    public function destroy($id)
    {
        return $this->find($id)->delete();
    }

}
