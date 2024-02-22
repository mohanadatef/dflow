<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Modules\Acl\Entities\UserWorkingTime;
use Modules\Basic\Repositories\BasicRepository;

class UserWorkingTimeRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'created_at','user_id',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserWorkingTime::class;
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

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $withRelations = [], $get = '', $column = ['*'], $pagination = false, $perPage = 10, $recursiveRel = [], $limit = null, $orderBy = [])
    {
        return $this->all($request->all(), $column, $withRelations, $recursiveRel, $moreConditionForFirstLevel,
            [], $orderBy, $get, null, $limit, $pagination, $perPage);
    }



    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }


}
