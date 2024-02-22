<?php

namespace Modules\Record\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Record\Entities\RequestAdMediaAccess;

class RequestAdMediaAccessRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'user_id', 'client_id', 'ad_record_id', 'status'
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return RequestAdMediaAccess::class;
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

    public function findOne($id, $withRelations = [])
    {
        return $this->find($id, withRelations: $withRelations);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if($id)
            {
                $re = $this->findOne($id);
                if($re->status == 1)
                {
                    if($request->status == 2 && ($re->client->unlimit_balance || $re->client->balance > $re->client->request_ad_media_access_approve_balance()))
                    {
                        $request->merge(['user_id' => user()->id]);
                        $data = $this->update($request->all(), $id);
                        if($re->client->unlimit_balance == 1)
                        {
                            $newRequest = new Request(['is_balance'=>0]);
                            $this->update($newRequest->all(), $id);
                        }
                    }elseif(in_array($request->status ,[ 3,5]))
                    {
                        $request->merge(['user_id' => user()->id]);
                        $data = $this->update($request->all(), $id);
                    }else
                    {
                        return ['status' => 0];
                    }
                }else
                {
                    return null;
                }
            }else
            {
                $data = $this->findBy(new Request(['ad_record_id' => $request->ad_record_id]), get: 'first',
                    latest: 'latest');
                if(!is_null($data) && $data->status == 1)
                {
                    $request->merge(['user_id' => user()->id]);
                    $data = $this->update($request->all(), $data->id);
                }elseif(!is_null($data) && in_array($data->status ,[ 2,3]))
                {
                    return null;
                }elseif(!is_null($data) && $data->status == 5)
                {
                    $request->merge(['status' => 1, 'client_id' => user()->id]);
                    $data = $this->create($request->all());
                }else
                {
                    $request->merge(['client_id' => user()->id]);
                    $data = $this->create($request->all());
                }
            }
            $data = $this->findOne($data->id, ['user']);
            $data->request_ad_media_access_log()->create(['status' => $data->status]);
            return $data;
        });
    }
}
