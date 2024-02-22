<?php

namespace Modules\CoreData\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Acl\Entities\Influencer;
use Modules\Basic\Repositories\BasicRepository;
use Modules\CoreData\Entities\Country;

class CountryRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'name_en', 'name_fr', 'name_ar', 'code','active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Country::class;
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

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = [])
    {
        return $this->all($request->all(), ['*'], $withRelations, $recursiveRel, $moreConditionForFirstLevel, $pluck, [], $get, null, null, $pagination, $perPage);
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
            return $data;
        });
    }

    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false, $perPage = 10)
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, [], ['column' => 'name_en', 'order' => 'asc'], '', null, null, $pagination, $perPage);
    }

    public function listSpecific(Request $request)
    {

        if(empty($request->selector)){
            $ids = Influencer::pluck('country_id')->toArray();
            return Country::whereIn('id', array_unique($ids))->get();
        }
        if($request->selector == "GCC"){
            return Country::whereIn('id',[2, 178, 21 ,159, 173, 112])->get();
        }
        return Country::whereNotIn('id',[2, 178, 21 ,159, 173, 112])->get();
    }
}
