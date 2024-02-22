<?php

namespace Modules\Record\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Record\Entities\Campaign;

class CampaignRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'name_ar', 'name_en', 'link'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Campaign::class;
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

    public function findBy(Request $request, $pagination = false, $perPage = 10, $withRelations = [])
    {
        return $this->all($request->all(), ['*'], $withRelations, [], [], [], [], '', null, null, $pagination, $perPage);
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

            $data->company()->sync((array)$request->company);
            $data->influencer()->sync((array)$request->influencer);
            // $this->media_upload($data,$request,createFileNameServer($this->model(),$data->id),pathType()['ip'], mediaType()['lm']);

            return $data;
        });
    }
}
