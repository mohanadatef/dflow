<?php

namespace Modules\Basic\Repositories;

use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Modules\Basic\Traits\MediaTrait;

abstract class BasicRepository
{
    use MediaTrait;


    protected  $model;

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();


    protected  $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }


    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if(!$model instanceof Model)
        {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }


    abstract public function getFieldsSearchable(): array;

    abstract public function getFieldsRelationShipSearchable();

    /**
     * Display a listing of the resource.
     * column is array with we select it from table
     */
    public function all(
        $search = [], $column = ['*'], $withRelations = [], $recursiveRel = [], $moreConditionForFirstLevel = [],
        $pluck = [],
        $orderBy = [], $get = '', $skip = null, $limit = null, $pagination = false,
        $perPage = 10, $latest = '', $distinct = null, $groupBy = null
    )
    {

        $query = $this->allQuery($search, $skip, $limit, $latest, $distinct, $groupBy);
        if($recursiveRel != [])
        {
            $query = $this->addRecursiveRelationsToQuery($query, $recursiveRel);
        }
        if($moreConditionForFirstLevel)
        {
            if(count($moreConditionForFirstLevel) == 1)
            {
                $query = self::proccessQuery($query, $moreConditionForFirstLevel);
            }else
            {
                foreach($moreConditionForFirstLevel as $key => $value)
                {
                    $query = self::proccessQuery($query, [$key => $value]);
                }
            }
        }
        if(!empty($orderBy))
        {
            $query = $query->orderBy($orderBy['column'], $orderBy['order']);
        }
        if(!empty($withRelations))
        {
            $query = $this->with($query, $withRelations);
        }
        if(!empty($column) && $column != ['*'])
        {
            $query = $query->select($column);
        }
        if(!empty($pluck))
        {
            return $query->pluck($pluck[0], $pluck[1]);
        }elseif($get == 'toArray')
        {
            return $query->toArray();
        }elseif($get == 'count')
        {
            return $query->count();
        }elseif($get == 'first')
        {
            return $query->first();
        }elseif($pagination && $perPage != 0)
        {
            return $query->paginate($perPage);
        }
        else
        {
            return $query->get();
        }
    }

    public function find($id, $column = ['*'], $withRelations = [])
    {
        $query = $this->model->newQuery();
        if(!empty($withRelations))
        {
            $query = $this->with($query, $withRelations);
        }
        return $query->find($id, $column);
    }

    public function with($query, $withRelations)
    {
        return $query->with($withRelations);
    }

    public function create(array $request)
    {
        return $this->model->create($request);
    }

    public function update($request, $id = null)
    {
        $data = $this->find($id);
        $data->update($request);
        return $this->find($id);
    }

    public function allQuery($search = [], $skip = null, $limit = null, $latest = '', $distinct = null,
        $groupBy = null)
    {
        $query = $this->model->newQuery();
        if(count($search) > 0)
        {
            foreach($search as $key => $value)
            {
                if(!empty($value) || $value === 0 || $value === "0")
                {
                    if(in_array($key, $this->getFieldsSearchable()))
                    {
                        if(isset($this->model->searchConfig) && !is_array($value) && array_key_exists($key,
                                $this->model->searchConfig) && !empty
                            ($this->model->searchConfig[$key]))
                        {
                            if(($this->model->searchConfig[$key] == 'like' || $this->model->searchConfig[$key] == 'LIKE') && user()->match_search)
                            {
                                $condition = $this->model->searchConfig[$key] == 'like' || $this->model->searchConfig[$key] == 'LIKE';
                                $query->where($key, $this->model->searchConfig[$key],
                                    $condition ? '%' . $value . '%' : $value);
                            }else
                            {
                                $query->where($key, $value);
                            }
                        }else
                        {
                            if(is_array($value))
                            {
                                $query->whereIn($key, $value);
                            }elseif(str_contains($value, ','))
                            {
                                $query->whereIn($key, explode(',', $value));
                            }else
                            {
                                $query->where($key, $value);
                            }
                        }
                    }
                    if(!empty($this->getFieldsRelationShipSearchable()) && array_key_exists($key,
                            $this->getFieldsRelationShipSearchable()))
                    {
                        $relation = explode("->", $this->model->searchRelationShip[$key]);
                        $query->whereHas($relation[0], function($query) use ($value, $relation)
                        {
                            if(is_array($value))
                            {
                                $query->whereIn($relation[1], $value);
                            }elseif(strpos($value, ',') !== false)
                            {
                                $query->whereIn($relation[1], explode(',', $value));
                            }else
                            {
                                $query->where($relation[1], $value);
                            }
                        });
                    }
                }
            }
        }
        if(!is_null($skip))
        {
            $query->skip($skip);
        }
        if(!is_null($limit))
        {
            $query->limit($limit);
        }
        if($latest == 'latest')
        {
            $query->latest();
        }
        if(!is_null($distinct))
        {
            $query->distinct($distinct);
        }
        if(!is_null($groupBy))
        {
            $query->groupBy($groupBy);
        }
        return $query;
    }

    public function addRecursiveRelationsToQuery($query, $withRecursive)
    {
        foreach($withRecursive as $key => $value)
        {
            if(!isset($value['type']) || $value['type'] == 'normal')
            {
                $query = $query->with([$key => function($q) use ($key, $value)
                {
                    $q = self::proccessQuery($q, $value);
                    if(isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                }]);
            }elseif($value['type'] == 'whereHas')
            {// use relation whereHas
                $query = $query->whereHas($key, function($q) use ($key, $value)
                {
                    $q = self::proccessQuery($q, $value);
                    if(isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            }elseif(in_array($value['type'], ['whereDoesntHave', 'orWhereDoesntHave']))
            {// use relation doesntHave
                $query = $query->{$value['type']}($key, function($q) use ($key, $value)
                {
                    $q = self::proccessQuery($q, $value);
                    if(isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            }elseif($value['type'] == 'orWhereHas')
            {// use relation whereHas
                $query = $query->orWhereHas($key, function($q) use ($key, $value)
                {
                    $q = self::proccessQuery($q, $value);
                    if(isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            }elseif(in_array($value['type'], ['whereHasMorph', 'orWhereHasMorph']))
            {
                $query = $query->{$value['type']}($key, '*', function($q, $type) use ($key, $value)
                {
                    $q = self::proccessQuery($q, $value);
                    if(isset($value['recursive']) && count($value['recursive']) > 0)
                        $this->addRecursiveRelationsToQuery($q, $value['recursive']);
                });
            }
        }
        return $query;
    }

    public function proccessQuery($q, $values)
    {
        if(isset($values['where']) && count($values['where']) > 0)
        {
            foreach($values['where'] as $key => $value)
            {
                if(isset($this->model->searchConfig) && array_key_exists($key,
                        $this->model->searchConfig) && !empty($this->model->searchConfig[$key]))
                {
                    if( $this->model->searchConfig[$key] == 'like')
                    {
                        if(user()->match_search)
                        {
                            $q->where($key, $this->model->searchConfig[$key], '%' . $value . '%');
                        }else{
                            $q->where($key, $value );
                        }
                    }else{
                        $q->where($key, $this->model->searchConfig[$key], '%' . $value . '%');
                    }
                }else
                {
                    $q = $this->proccessWhere($q, $key, $value);
                }
            }
        }
        if(isset($values['whereBetween']) && count($values['whereBetween']) > 0)
        {
            foreach($values['whereBetween'] as $key => $value)
            {
                $q->whereBetween($key, [$value[0], $value[1]]);
            }
        }
        if(isset($values['orWhereBetween']) && count($values['orWhereBetween']) > 0)
        {
            foreach($values['orWhereBetween'] as $key => $value)
            {
                $q->orwhereBetween($key, [$value[0], $value[1]]);
            }
        }
        if(isset($values['whereQuery']) && count($values['whereQuery']) > 0)
        {
            foreach($values['whereQuery'] as $value)
            {
                $num = 0;
                $q->where(function($query) use ($num, $value)
                {
                    foreach($value as $k => $val)
                    {
                        if($num == 0)
                        {
                            $query = $this->proccessWhere($query, $k, $val);
                        }else
                        {
                            $query = $this->proccessOrWhere($query, $k, $val);
                        }
                        $num++;
                    }
                });
            }
        }
        if(isset($values['whereCustom']) && count($values['whereCustom']) > 0)
        {
            $num = 0;
            $q->where(function($query) use ($num, $values)
            {
                foreach($values['whereCustom'] as $ke => $value)
                {
                    foreach($value as $valC)
                    {
                        if(in_array($ke,
                            ['whereDoesntHave', 'whereHasMorph', 'orWhereHasMorph', 'whereHas', 'orWhereHas']))
                        {
                            $query = self::addRecursiveRelationsToQuery($query, $valC);
                        }else
                        {
                            foreach($valC as $k => $val)
                            {
                                if($ke == 'where')
                                {
                                    if($num == 0)
                                        $query = $this->proccessWhere($query, $k, $val);
                                    else
                                        $query = $this->proccessOrWhere($query, $k, $val);
                                }elseif($ke == 'orWhereNull')
                                {
                                    $query = $this->proccessOrWhereNull($query, $val);
                                }elseif($ke == 'orWhere')
                                {
                                    $query = $this->proccessOrWhere($query, $k, $val);
                                }elseif($ke == 'orWhereIn')
                                {
                                    $query = $this->proccessOrWhereIn($query, $k,$val);
                                }
                                elseif($ke == 'whereIn')
                                {
                                    $query = $this->proccessWhereIn($query, $k,$val);
                                }
                                $num++;
                            }
                        }
                    }
                }
            });
        }
        if(isset($values['orWhereNotNull']) && count($values['orWhereNotNull']) > 0)
        {
            $q = $this->whereNotNull($q, $values['orWhereNotNull']);
        }
        if(isset($values['whereNotNull']) && count($values['whereNotNull']) > 0)
        {
            $q = $this->whereNotNull($q, $values['whereNotNull']);
        }
        if(isset($values['whereNull']) && count($values['whereNull']) > 0)
        {
            $q = $this->whereNull($q, $values['whereNull']);
        }
        if(isset($values['orWhereNull']) && count($values['orWhereNull']) > 0)
        {
            $num = 0;
            foreach($values['orWhereNull'] as $column)
            {
                if($num == 0)
                    $q->whereNull($column);
                else
                    $q->orWhereNull($column);
                $num++;
            }
        }
        if(isset($values['orWherePivot']) && count($values['orWherePivot']) > 0)
        {
            foreach($values['orWherePivot'] as $where => $value)
            {
                $q->orWhere($where, $value);
            }
        }
        if(isset($values['whereIn']) && count($values['whereIn']) > 0)
        {
            foreach($values['whereIn'] as $where => $value)
            {
                $q->whereIn($where, $value);
            }
        }
        if(isset($values['whereNotIn']) && count($values['whereNotIn']) > 0)
        {
            foreach($values['whereNotIn'] as $where => $value)
            {
                $q->whereNotIn($where, $value);
            }
        }
        if(isset($values['orWhere']) && count($values['orWhere']) > 0)
        {
            foreach($values['orWhere'] as $where => $value)
            {
                $q = $this->proccessOrWhere($q, $where, $value);
            }
        }
        if(isset($values['doesntHave']) && count($values['doesntHave']) > 0)
        {
            foreach($values['doesntHave'] as $val)
            {
                $q->doesntHave($val);
            }
        }
        return $q;
    }

    public function proccessOrWhereNull($query, $val)
    {
        return $query->orWhereNull($val);
    }

    public function proccessOrWhere($q, $key, $value)
    {
        if(isset($this->model->searchConfig) && array_key_exists($key,
                $this->model->searchConfig) && !empty($this->model->searchConfig[$key]))
        {
            if(is_array($value) && count($value) == 2)
            {
                if($this->model->searchConfig[$key] == 'like')
                {
                        if(user()->match_search)
                        {
                            $q->orWhere($key, $this->model->searchConfig[$key],  '%' . $value[1] . '%');
                        }else
                        {
                            $q->orWhere($key, $value[1]);
                        }

                }else{
                    $q->orWhere($key, $this->model->searchConfig[$key], '%' . $value[1] . '%');
                }
            }else
            {
                if($this->model->searchConfig[$key] == 'like')
                {
                    if(user()->match_search)
                    {
                        $q->orWhere($key, $this->model->searchConfig[$key],  '%' . $value . '%');
                    }else
                    {
                        $q->orWhere($key, $value);
                    }

                }else{
                    $q->orWhere($key, $this->model->searchConfig[$key], '%' . $value . '%');
                }
            }
        }else
        {
            if(is_array($value) && count($value) == 2)
            {
                if($value[0] == 'like')
                {
                    if(user()->match_search)
                    {
                        $q->orWhere($key, $value[0],  '%' . $value[1] . '%');
                    }else
                    {
                        $q->orWhere($key, $value[1]);
                    }

                }else{
                    $q->orWhere($key,$value[0], $value[1]);
                }
            }
            else
            {
                $q->orWhere($key, $value);
            }
        }
        return $q;
    }

    public function whereNotNull($q, $values)
    {
        $num = 0;
        foreach($values as $column)
        {
            if($num == 0)
                $q->whereNotNull($column);
            else
                $q->orWhereNotNull($column);
            $num++;
        }
        return $q;
    }
    public function proccessOrWhereIn($q,$key, $values)
    {
        return $q->orWhereIn($key,$values);
    }
    public function proccessWhereIn($q,$key, $values)
    {
        return $q->whereIn($key,$values);
    }

    public function whereNull($q, $values)
    {
        $num = 0;
        foreach($values as $column)
        {
            if($num == 0)
                $q->whereNull($column);
            else
                $q->orWhereNull($column);
            $num++;
        }
        return $q;
    }

    public function proccessWhere($q, $key, $value)
    {
        if(is_array($value) && count($value) == 2)
        {
            if($value[0] == 'like')
            {
                if(user()->match_search)
                {
                    $q->where($key, $value[0], $value[1]);
                }else
                {
                    $q->where($key, $value[1]);
                }
            }else
            {
                $q->where($key, $value[0], $value[1]);
            }
        }else
        {
            $q->where($key, $value);
        }
        return $q;
    }

    public function updateValue($id, $key)
    {
        return $this->change($this->find($id), $key);
    }

    public function delete($id)
    {
        $data = $this->find($id);
        return $data ? $data->delete() : false;
    }

    public function deleteByName($category_id, $name)
    {
        $data = $this->model
            ::where('category_type', 'Modules\Record\Entities\AdRecord')
            ->where('category_id', $category_id)
            ->where('file', $name)
            ->first();
        $file = public_path('images') . "/adrecord/" . $category_id . "/$name";
        File::delete($file);
        if($data)
        {
            return $data->delete();
        }
        return false;
    }

    public function toggleActive()
    {
        $record = $this->findOne(request('id'));
        $record->update([
            'active' => !$record->active
        ]);
        return $record->active;
    }
}
