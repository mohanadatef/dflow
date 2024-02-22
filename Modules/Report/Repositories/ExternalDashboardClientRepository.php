<?php

namespace Modules\Report\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Report\Entities\ExternalDashboardClient;

class ExternalDashboardClientRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'user_id', 'external_dashboard_id', 'start_date', 'end_date'
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return ExternalDashboardClient::class;
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
        return $this->find($id, ['*']);
    }

    public function save($request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if($id)
            {
                $data = $this->update($request->all(), $id);
                $data->external_dashboard->external_dashboard_log()
                    ->create(['user_id' => user()->id, 'type' => 4]);
            }else
            {
                $data = $this->create($request->all());
                $data->external_dashboard->external_dashboard_log()
                    ->create(['user_id' => user()->id, 'type' => 3]);
            }
            return $data;
        });
    }

    public function delete($id)
    {
        $data = $this->find($id);
        $data->external_dashboard->external_dashboard_log()
            ->create(['user_id' => user()->id, 'type' => 5]);
        return $data ? $data->delete() : false;
    }
}
