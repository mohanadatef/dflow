<?php

namespace Modules\CoreData\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Basic\Repositories\BasicRepository;
use Modules\CoreData\Entities\LinkTracking;
use Illuminate\Support\Str;
use Modules\CoreData\Entities\LinkTrackingClick;

class LinkTrackingClicksRepository extends BasicRepository
{
    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return LinkTrackingClick::class;
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
        if (!empty($this->model->searchRelationShip)) {
            return $this->model->searchRelationShip;
        }
        return null;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|Collection|array|null
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, $pluck, [], $get, null, null, $pagination, $perPage);
    }

    public function findByLinkId($linkId)
    {
        return LinkTracking::where('link_id', $linkId)->first();
    }

    public function findOne($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null
    {
        return $this->find($id, ['*']);
    }

    public function list(Request $request, $moreConditionForFirstLevel = [], $recursiveRel = [], $pagination = false, $perPage = 10): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|Collection|array|null
    {
        return $this->all($request->all(), ['*'], [], $recursiveRel, $moreConditionForFirstLevel, [], ['column' => 'id', 'order' => 'desc'], '', null, null, $pagination, $perPage);
    }

    public function get(string $name,int $id,int $limit=0,array $more_columns=[]): Collection
    {
        $columns = [
            $name ." as category",
            DB::raw('count(*) as value')
        ];
        $columns = array_merge($columns,$more_columns);
        $data = DB::table('link_tracking_clicks')
            ->select($columns)
            ->where('link_tracking_id',$id)
            ->groupBy($name)
            ->orderBy("value","desc")
        ;
        if ($limit) $data->limit($limit);
        return $data->get();
    }

    public function countriesCount(int $id): int
    {
        return DB::table('link_tracking_clicks')
            ->select( DB::raw('count(*) as count'))
            ->where('link_tracking_id',$id)
            ->groupBy('country')
            ->get()->count()
        ;
    }

    public function otherCountriesCount(int $id,array $top_counties)
    {
        return DB::table('link_tracking_clicks')
            ->select( DB::raw('count(*) as `value`'),'country as category')
            ->where('link_tracking_id',$id)
            ->whereNotIn('country',$top_counties)
            ->groupBy('country')
            ->get()->sum('value')
        ;
    }

    public function count(int $id)
    {
        return LinkTrackingClick::where('link_tracking_id', $id)->count();
    }
}
