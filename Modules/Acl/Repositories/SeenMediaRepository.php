<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\InfluencerGroupLog;
use Modules\Acl\Entities\SeenMedia;
use Modules\Basic\Repositories\BasicRepository;

class SeenMediaRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SeenMedia::class;
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
        $column = ['*'], $pagination = false, $perPage = 10, $recursiveRel = [], $limit = null, $orderBy = [],$pluck=[])
    {
        return $this->all($request->all(), $column, $withRelations, $recursiveRel, $moreConditionForFirstLevel,
            $pluck, $orderBy, $get, null, $limit, $pagination, $perPage);
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
                $data = $this->findBy(new Request(['name' => $request->name]),get:'first');
                if(is_null($data))
                {
                    $data = $this->create($request->all());
                }
            }
            return isset($id) ? $this->findOne($id) : $data;
        });
    }
}
