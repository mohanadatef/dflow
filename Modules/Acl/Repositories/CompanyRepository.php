<?php

namespace Modules\Acl\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Acl\Entities\Company;

class CompanyRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected  $fieldSearchable = [
        'id', 'name_ar', 'name_en','active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Company::class;
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
        $moreConditionForFirstLevel = [], $with = [], $recursiveRel = [],$column=['*'])
    {
        return $this->all(
            $request->all(), $column, $with, $recursiveRel, $moreConditionForFirstLevel,
            $pluck, [], $get, null, null, $pagination, $perPage
        );
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if($id)
            {
                $data = $this->update($request->all(), $id);
                if($request->icon_remove == 1)
                {
                    $data->media()->delete();
                }
                $this->checkMediaDelete($data, $request, mediaType()['lm']);
            }else
            {
                $data = $this->create($request->all());
            }
            $data->industry()->sync((array)$request->industry);
            $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'],
                mediaType()['im']);
            if(!empty($request->link)){
                $data->company_website()->delete();
                foreach ($request->link as $key => $value){
                    $data->company_website()->create(['website_id' => $key, 'url' => strtolower($value)]);
                }
            }
            return $this->find($data->id);
        });
    }

    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false,
        $perPage = 10, $withRelations = [])
    {
        return $this->all($request->all(), ['*'], $withRelations, $recursiveRel, $moreConditionForFirstLevel, [],
            ['column' => 'name_en', 'order' => 'asc'], '', null, null, $pagination, $perPage);
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
