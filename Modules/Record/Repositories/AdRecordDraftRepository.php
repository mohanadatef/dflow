<?php

namespace Modules\Record\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Record\Entities\AdRecordDraft;
use Modules\Basic\Repositories\BasicRepository;

class AdRecordDraftRepository extends BasicRepository
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
        return AdRecordDraft::class;
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
                $data->ad_record_draft_log()->create(['type' => 6,'user_id' => user()->id]);
            }else
            {
                $create = 1;
                $request->merge(['user_id' => user()->id]);
                $data = $this->create($request->all());
                $data->ad_record_draft_log()->create(['type' => 5, 'user_id' => user()->id]);
            }
            if($request->category)
            {
                $data->category()->sync((array)$request->category);
            }
            if($request->service_id)
            {
                $data->service()->sync((array)$request->service_id);
                $data = $this->find($data->id);
                $this->calculateAdPrice($data, $create);
            }
            if($request->promotion_type)
            {
                $data->promotion_type()->sync((array)$request->promotion_type);
            }
            if($request->target_market)
            {
                $data->target_market()->sync((array)$request->target_market);
            }
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
            return $this->find($data->id);
        });
    }


    public function calculateAdPrice($ad ,$create = 0){
        $price = 0;
        $services = [];
        if ($create) {
            $services = $ad->ad_record_draft_services;
        } else {
            $services =  $ad->ad_record_draft_services->where('price', 0) ?? [];
        }
        if(!empty($services)){
            foreach ($services as $service)
            {
                $service->update(['price' => $service->service->influencer_service_platform()->where('influencer_id', $ad->influencer_id)
                    ->where('platform_id', $ad->platform_id)->first()->price ?? 0]);
            }
        }
        if(!empty($ad->ad_record_draft_services)){
            foreach ($ad->ad_record_draft_services as $service) {
                $price += $service->price;
            }
            $ad->update(['price' => $price]);
        }
        return 1;
    }
}
