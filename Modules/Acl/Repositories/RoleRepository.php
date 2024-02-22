<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Acl\Entities\Role;
use Modules\Basic\Repositories\BasicRepository;

class RoleRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'name', 'label','type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
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

    public function findBy(Request $request)
    {
        return $this->all($request->all());
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
            $data->permissions()->sync((array)$request->permissions);
            return $data;
        });
    }

    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false, $perPage = 10)
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, [], ['column' => 'id', 'order' => 'asc'], '', null, null, $pagination, $perPage);
    }

    public function delete($id)
    {
        $data = $this->find($id, ['*'], [], true);
        return $data ? $data->delete() : false;
    }

    public function toggleActive(): bool
    {
        $record = $this->findOne(request('id'));

        $record->update([
            'active' => !$record->active
        ]);

        return $record->active;
    }
}
