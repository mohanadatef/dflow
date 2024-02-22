<?php

namespace Modules\CoreData\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\CoreData\Entities\LinkTracking;
use Illuminate\Support\Str;

class LinkTrackingRepository extends BasicRepository
{
    /**
     * Search using any columns
     * @var array
     */
    protected array $fieldSearchable = [
        'id', 'destination', 'title', 'options', 'data', 'user_id','influencer_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return LinkTracking::class;
    }

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable() : array
    {
        return $this->fieldSearchable;
    }

    public function getFieldsRelationShipSearchable()
    {
        return $this->model->searchRelationShip;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [])
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, $pluck, [], $get, null, null, $pagination, $perPage);
    }

    public function findByLinkId($linkId)
    {
        return LinkTracking::where('link_id', $linkId)->first();
    }

    public function findOne($id)
    {
        return $this->find($id, ['*']);
    }

    public function save(Request $request, $id = null)
    {
        return DB::transaction(function () use ($request, $id) {
            $requestData = [
                'destination' => $request->destination,
                'title' => $request->title,
                'countries' => serialize($request->countries),
                'ios_url' => $request->ios_url,
                'android_url' => $request->android_url,
                'windows_url' => $request->windows_url,
                'linux_url' => $request->linux_url,
                'mac_url' => $request->mac_url,
                'note' => $request->note,
                'user_id' => user()->id,
                'influencer_id' => $request->influencer_id,
            ];
            if ($id) {
                $data = $this->update($requestData, $id);
            } else {
                for ($x = 0; $x < 100; $x++) {
                    $random = Str::random(10);
                    $links = $this->findByLinkId($random);
                    if (!$links) {
                        break;
                    }
                }
                $requestData['link_id'] = $random;
                $data = $this->create($requestData);
            }
            return $data;
        });
    }

    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false, $perPage = 10): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\Illuminate\Support\Collection|array|null
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, [], ['column' => 'id', 'order' => 'desc'], '', null, null, $pagination, $perPage);
    }
}
