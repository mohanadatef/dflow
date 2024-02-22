<?php

namespace Modules\CoreData\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\CoreData\Entities\Calendar;
use Modules\Basic\Repositories\BasicRepository;

class CalendarRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'description', 'date', 'user_id', 'influencer_id', 'campaign'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Calendar::class;
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
        if (!empty($this->model->searchRelationShip)) {
            return $this->model->searchRelationShip;
        }
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = []): Model|Collection|LengthAwarePaginator|Builder|\Illuminate\Support\Collection|array|null
    {
        return $this->all($request->all(), ['*'], $withRelations, $recursiveRel, $moreConditionForFirstLevel, $pluck, [], $get, null, null, $pagination, $perPage);
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }

    public function save(Request $request, int $id = 0, bool $sync_influencers=false)
    {
        return DB::transaction(function () use ($request, $id,$sync_influencers) {
            if ($id) {
                $data = $this->update($request->all(), $id);
            } else {
                $create =  array_merge(
                    $request->all(),
                    ['user_id' => auth()->id()]
                );
                $role =  user()->role;
                if ($role->share_calender) {
                    $create['shared']= 1;
                }
                $data = $this->create($create);
            }
            if ($sync_influencers){
                $data->influencers()->sync($request->influencer);
            }
            return $data;
        });
    }

    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false, $perPage = 10): Model|Collection|LengthAwarePaginator|Builder|\Illuminate\Support\Collection|array|null
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, [], ['column' => 'name_en', 'order' => 'asc'], '', null, null, $pagination, $perPage);
    }
}
