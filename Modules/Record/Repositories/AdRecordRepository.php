<?php

namespace Modules\Record\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Record\Entities\AdRecord;
use Modules\Basic\Repositories\BasicRepository;

class AdRecordRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'influencer_id', 'company_id', 'user_id', 'mention_ad', 'date', 'platform_id', 'service_id','red_flag'
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return AdRecord::class;
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

    public function findOne($id,$withRelations=[])
    {
        return $this->find($id, withRelations:$withRelations);
    }

    public function save(Request $request, $id = null)
    {
        $request->date = $request->myDate;
        return DB::transaction(function() use ($request, $id)
        {
            if($id)
            {
                $create = 0;
                if(!isset($request->mention_ad))
                {
                    $request->merge(['mention_ad' => 0]);
                }
                if(!isset($request->gov_ad))
                {
                    $request->merge(['gov_ad' => 0]);
                }
                if(!isset($request->red_flag))
                {
                    $request->merge(['red_flag' => 0]);
                }
                $data = $this->update($request->all(), $id);
                if(!isset($request->solve))
                {
                    if(isset($request->duplicate_draft_id) && $request->duplicate_draft_id != 0)
                    {
                        $data->ad_record_log()->create(['type' => 9, 'user_id' => user()->id]);
                    }else{

                        $data->ad_record_log()->create(['user_id' => user()->id]);
                    }
                }
            } else {
                $create = 1;
                $request->merge(['user_id' => user()->id]);
                $data = $this->create($request->all());
                if($request->is_draft == 0){
                    $data->ad_record_log()->create(['type' => 0, 'user_id' => user()->id]);
                }
            }
            $data->category()->sync((array)$request->category);
            $data->service()->sync((array)$request->service_id);
            $data->promotion_type()->sync((array)$request->promotion_type);
            $data->target_market()->sync((array)$request->target_market);
            $data = $this->find($data->id);
            $this->calculateAdPrice($data, $create);
            if(isset($request->images) && !empty($request->images))
            {
                foreach($data->medias as $media)
                {
                    $media->delete();
                }
                $this->media_upload_by_name($data, $request, createFileNameServer($this->model(), $data->id),
                    pathType()['ip'], mediaType()['dm']);
            }
            if(isset($request->file) && !empty($request->file))
            {
                foreach($data->mediasS3 as $media)
                {
                    $media->delete();
                }
                if($request->file)
                {
                    $this->media_save_s3($request->file, $data, mediaType()['s3']);
                }
            }
            return $data;
        });
    }

    public function calculateAdPrice($ad ,$create = 0){
        $price = 0;
        $services = [];
        if ($create) {
            $services = $ad->ad_record_services;
        } else {
            $services = $ad->ad_record_services->where('price', 0) ?? [];
        }
        foreach ($services as $service)
        {
            $service->update(['price' => $service->service->influencer_service_platform()->where('influencer_id', $ad->influencer_id)
                ->where('platform_id', $ad->platform_id)->first()->price ?? 0]);
        }
        foreach ($ad->ad_record_services as $service) {
            $price += $service->price ?? 0;
        }
        $ad->update(['price' => $price]);
        return 1;
    }

}
