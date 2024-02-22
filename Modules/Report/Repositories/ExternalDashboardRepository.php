<?php

namespace Modules\Report\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Report\Entities\ExternalDashboard;

class ExternalDashboardRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name', 'start_date', 'end_date', 'active'
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return ExternalDashboard::class;
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

    public function findOne(int $id, $withRelations = [])
    {
        return $this->find($id, withRelations: $withRelations);
    }

    public function save($request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if($id)
            {
                $data = $this->update($request->all(), $id);
                if(isset($request->change_version) && $request->change_version)
                {
                    $data->external_dashboard_log()
                        ->create(['user_id' => user()->id, 'type' => 2]);
                }else
                {
                    $data->external_dashboard_log()
                        ->create(['user_id' => user()->id, 'type' => 1]);
                }
                $typeExternalDashboardVersion = 1;
            }else
            {
                $data = $this->create($request->all());
                $data->external_dashboard_log()
                    ->create(['user_id' => user()->id, 'type' => 0]);
                $typeExternalDashboardVersion = 0;
            }
            $this->externalDashboardVersion($typeExternalDashboardVersion, $data, $request);
            if(isset($request->change_version) && $request->change_version)
            {
                $data->category()->sync((array)$request->category_id ?? []);
                $data->assignedUser()->sync((array)$request->users ?? []);
                $data->company()->sync((array)$request->company_id ?? []);
            }else
            {
                if(isset($request->category_id) && !empty($request->category_id))
                {
                    $data->category()->sync((array)$request->category_id);
                }
                if(isset($request->users) && !empty($request->users))
                {
                    $data->assignedUser()->sync((array)$request->users);
                }
                if(isset($request->company_id) && !empty($request->company_id))
                {
                    $data->company()->sync((array)$request->company_id);
                }
            }
            return $data;
        });
    }

    public function list(Request $request)
    {
        return $this->all($request->all());
    }

    public function toggleActive(): bool
    {
        $record = $this->findOne(request('id'));
        $record->update([
            'active' => !$record->active
        ]);
        return $record->active;
    }

    public function prepareJson($request)
    {
        $arr = [
            'category_id' => $request['category_id'],
            'company_id' => $request['company_id'],
            'users' => $request['users'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'name' => $request['name'],
        ];
        return json_encode($arr);
    }

    public function externalDashboardVersion($type = 1, $data, Request $request)
    {
        if(isset($request->change_version) && $request->change_version)
        {
            $request = $request->except(['change_version']);
        }
        $json = $this->prepareJson($request);
        if($type)
        {
            $data->external_dashboard_version()->update(['default' => 0]);
            $count = $data->external_dashboard_version->where('major', $request['major'])
                ->where('minor', $request['minor'])->where('batch', $request['batch'])->count();
            if($count == 0)
            {
                $data->external_dashboard_version()
                    ->create(['major' => $request['major'], 'minor' => $request['minor'], 'batch' => $request['batch'],
                        'dashboard_data' => $json, 'default' => 1]);
            }else
            {
                $data->external_dashboard_version->where('major', $request['major'])
                    ->where('minor', $request['minor'])->where('batch', $request['batch'])->first()
                    ->update(['dashboard_data' => $json, 'default' => 1]);
            }
        }else
        {
            $request->merge(['user_id' => user()->id, 'major' => 1, 'minor' => 0, 'batch' => 0]);
            $data->external_dashboard_version()
                ->create(['major' => $request['major'], 'minor' => $request['minor'], 'batch' => $request['batch'],
                    'dashboard_data' => $json]);
        }
    }
}
