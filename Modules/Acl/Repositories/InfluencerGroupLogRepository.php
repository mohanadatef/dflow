<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\InfluencerGroupLog;
use Modules\Basic\Repositories\BasicRepository;

class InfluencerGroupLogRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'user_id', 'influencer_follower_platform_id', 'influencer_group_id','type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return InfluencerGroupLog::class;
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

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $withRelations = [], $get = '',
        $column = ['*'], $pagination = false, $perPage = 10, $recursiveRel = [], $limit = null, $orderBy = [])
    {
        return $this->all($request->all(), $column, $withRelations, $recursiveRel, $moreConditionForFirstLevel,
            [], $orderBy, $get, null, $limit, $pagination, $perPage);
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if($id)
            {
                $data = $this->update($request->all(), $id);
            }else
            {
                $data = $this->create($request->all());
            }
            return isset($id) ? $this->findOne($id) : $data;
        });
    }
}
