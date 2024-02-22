<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Acl\Entities\Influencer;
use Modules\Basic\Repositories\BasicRepository;

class InfluencerRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'name_en', 'name_ar', 'gender', 'nationality_id', 'birthdate', 'active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Influencer::class;
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

    public function findBy(Request $request, $moreConditionForFirstLevel = [], $withRelations = [], $get = '',
        $column = ['*'], $pagination = false, $perPage = 10, $recursiveRel = [], $limit = null, $orderBy = [],
        $pluck = [])
    {
        return $this->all($request->all(), $column, $withRelations, $recursiveRel, $moreConditionForFirstLevel,
            $pluck, $orderBy, $get, null, $limit, $pagination, $perPage);
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if(!isset($request->mawthooq))
            {
                $request->merge(['mawthooq' => 0]);
            }
            if($id)
            {
                $data = $this->update($request->all(), $id);
            }else
            {
                $data = $this->create($request->all());
            }
            $data->category()->sync((array)$request->category);

            $data->country()->sync((array)$request->country_id);
            if(isset($request->city_id) && !empty($request->city_id))
            {
                $data->city()->sync((array)$request->city_id);
            }
            $data->platform()->sync((array)$request->platform);
            if(isset($request->service))
            {
                $data->influencer_service_platform()->delete();
                foreach($request->service as $platform)
                {
                    foreach($platform as $service)
                    {
                        $data->influencer_service_platform()->create($service);
                    }
                }
            }
            if(isset($request->follower))
            {
                $data->influencer_follower_platform()->delete();
                foreach($request->follower as $follower)
                {
                    $data->influencer_follower_platform()->create($follower);
                }
            }
            if(isset($request->genderPercentage))
            {
                $data->influencer_gender()->delete();
                foreach($request->genderPercentage as $genderPercentage)
                {
                    $data->influencer_gender()->create($genderPercentage);
                }
            }
            if(isset($request->audienceCountry))
            {
                $data->influencer_country_audience()->delete();
                foreach($request->audienceCountry as $country)
                {
                    $data->influencer_country_audience()->create($country);
                }
            }
            if(isset($request->audienceCategory))
            {
                $data->influencer_category_audience()->delete();
                foreach($request->audienceCategory as $category)
                {
                    $data->influencer_category_audience()->create($category);
                }
            }
            $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'],
                mediaType()['mm']);
            if(isset($request->mawthooq_license) && !empty($request->mawthooq_license))
            {
                $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'],
                    mediaType()['mml']);
            }
            return isset($id) ? $this->findOne($id) : $data;
        });
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
