<?php

namespace Modules\CoreData\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\CoreData\Entities\InfluencerTrend;

class InfluencerTrendRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id','date_from', 'date_to', 'influencer_id', 'country_id', 'tag_id', 'subject', 'brief','audience_impression'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return InfluencerTrend::class;
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

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = [],$column=['*'])
    {
        return $this->all($request->all(), $column, $withRelations, $recursiveRel, $moreConditionForFirstLevel, $pluck, [], $get, null, null, $pagination, $perPage);
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function () use ($request, $id) {
            if ($id) {
                $data = $this->update($request->all(), $id);
            } else {
                $data = $this->create($request->all());
            }
            $data->platform()->sync((array)$request->platform);
            return $data;
        });
    }
}
