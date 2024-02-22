<?php

namespace Modules\Record\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Record\Entities\ContentRecord;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Record\Service\ShortLinkService;

class ContentRecordRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'influencer_id', 'company_id', 'platform_id', 'date'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ContentRecord::class;
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

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [])
    {
        return $this->all($request->all(), ['*'], $relation, $recursiveRel, $moreConditionForFirstLevel, $pluck, [], $get, null, null, $pagination, $perPage);
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

            if ($request->has('video')) {
                $this->deleteMedia($data);
            }
            $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'], mediaType()['vm']);

            $shortLink = app()->make(ShortLinkService::class)->findBy(new request(['record_id' => $data->id]), get: 'first');
            if ($shortLink) {
                app()->make(ShortLinkService::class)->update($data);
            } else {
                app()->make(ShortLinkService::class)->store($data);
            }
            
            return $data;
        });
    }
}
