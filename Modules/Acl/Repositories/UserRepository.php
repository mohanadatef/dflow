<?php

namespace Modules\Acl\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Basic\Repositories\BasicRepository;

class UserRepository extends BasicRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id', 'name', 'website', 'conatact_person_email', 'email', 'conatact_person_name', 'company_size', 'role_id', 'active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
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
            if(isset($request->password))
            {
                $request->merge(['password' => Hash::make($request->password)]);
            }
            if($id)
            {
                $data = $this->find($id);
                if(in_array(user()->role_id, [1, 10]))
                {
                    if(!isset($request->unlimit_balance))
                    {
                        $request->merge(['unlimit_balance' => 0]);
                    }
                    if(!isset($request->change_language))
                    {
                        $request->merge(['change_language' => 0]);
                    }
                    if(!isset($request->competitive_analysis_pdf))
                    {
                        $request->merge(['competitive_analysis_pdf' => 0]);
                    }
                    if(!isset($request->access_media_ad))
                    {
                        $request->merge(['access_media_ad' => 0]);
                    }
                }
                $data = $this->update($request->all(), $id);
                $this->checkMediaDelete($data, $request, mediaType()['am']);
            }else
            {
                $data = $this->create($request->all());
            }
            $this->media_upload($data, $request, createFileNameServer($this->model(), $data->id), pathType()['ip'],
                mediaType()['am']);
            if(isset($request->category) && !empty($request->category))
            {
                $data->category()->sync($request->category);
            }
            return isset($id) ? $this->findOne($id) : $data;
        });
    }

    public function destroy($id)
    {
        return $this->find($id)->delete();
    }

    public function toggleSearch()
    {
        $record = $this->findOne(request('id'));
        $record->update([
            'match_search' => !$record->match_search
        ]);
        return $record->match_search;
    }
}
