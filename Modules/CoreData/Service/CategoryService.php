<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Http\Resources\Category\CategoryAdRecordListResource;
use Modules\CoreData\Repositories\CategoryRepository;
use Modules\CoreData\Http\Resources\Category\CategoryResource;
use Modules\CoreData\Http\Resources\Category\CategoryListResource;

class CategoryService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = [],$column=['*'])
    {
        if(isset($request->group) && $request->group == 'all')
        {
            unset($request['group']);
        }
        if(isset($request->search) && $request->search != null)
        {
            $moreConditionForFirstLevel = [
                'whereCustom' => [
                    'orWhere' => [
                        ['name_en' => $request->search], ['name_ar' => $request->search]
                    ]],
            ];
        }
        return $this->repo->findBy(
            $request,
            $pagination,
            $perPage,
            $pluck,
            $get,
            $moreConditionForFirstLevel,
            $recursiveRel,
            $withRelations,
            $column
        );
    }

    public function store(Request $request)
    {
        $request['parent_id'] = $request->group == "industry_child" ? $request->parent_id : null;
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $request['parent_id'] = $request->group == "industry_child" ? $request->parent_id : null;
        $data = $this->repo->save($request, $id);
        return new CategoryResource($data);
    }

    public function list(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return CategoryListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage, ['parents']));
    }
    public function AdRecordCategorylist(Request $request, $pagination = false, $perPage = 10, $recursiveRel = [])
    {
        return CategoryAdRecordListResource::collection($this->repo->list($request, [], $recursiveRel, $pagination, $perPage, ['parents']));
    }
    public function parent(Request $request)
    {
        $data = $this->repo->findOne($request->id);
        $childs = $data->childs()->pluck('id')->toArray();
        $moreConditionForFirstLevel = ['whereNotIn' => ['id' => array_merge($childs, [$request->id])]];
        return CategoryListResource::collection($this->repo->list(new Request(), $moreConditionForFirstLevel));
    }

    public function delete($id): bool
    {
        $this->repo->delete($id);
        return true;
    }

    public function listParentChild($id)
    {
        $data = $this->repo->findOne($id);
        $children = $data->childs()->pluck('id')->toArray();
        $moreConditionForFirstLevel = ['whereNotIn' => ['id' => array_merge($children, [$id])]];
        return CategoryListResource::collection($this->repo->list(new Request(), $moreConditionForFirstLevel));
    }

    public function toggleActive()
    {
        return $this->repo->toggleActive();
    }

    public function getCategoriesnamesByUserId()
    {
        return $this->repo->getCategoriesnamesByUserId();
    }
}
