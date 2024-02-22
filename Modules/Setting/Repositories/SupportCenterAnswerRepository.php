<?php

namespace Modules\Setting\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\Setting\Entities\SupportCenterAnswer;

class SupportCenterAnswerRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'support_center_question_id', 'answer', 'user_id',
    ];

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return SupportCenterAnswer::class;
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
        return $this->find($id, withRelations:$withRelations);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function() use ($request, $id)
        {
            if($id) {
                $data = $this->update($request->all(), $id);
            } else {
                $request->merge([
                    'user_id' => user()->id,
                ]);
                $data = $this->create($request->all());
            }
            if(isset($request->image) && !empty($request->image))
            {
                foreach($data->medias as $media)
                {
                    $media->delete();
                }
                $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'],
                    mediaType()['mm']);
            }

            return $data;
        });
    }

    public function list(Request $request)
    {
        return $this->all($request->all());
    }

}
