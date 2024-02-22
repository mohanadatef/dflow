<?php

namespace Modules\CoreData\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\CoreData\Entities\Category;

class CategoryRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'name_ar', 'name_en', 'parent_id', 'group','active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
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
            return $data;
        });
    }

    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false, $perPage = 10, $withRelations = [])
    {
        return $this->all($request->all(), ['*'], $withRelations, $recursiveRel, $moreConditionForFirstLevel, [], ['column' => 'name_en', 'order' => 'asc'], '', null, null, $pagination, $perPage);
    }

    public function toggleActive()
    {
        $record = $this->findOne(request('id'));
        if ($record->parents) {
            if ($record->parents->active === 0) {
                return false;
            }
        }

        $record->update([
            'active' => !$record->active
        ]);
        $record->updateChildCategories($record, !$record->active);
        return true;
    }

    public function getCategoriesnamesByUserId()
    {
        return Category::getCategoriesnamesByUserId();
    }
}
