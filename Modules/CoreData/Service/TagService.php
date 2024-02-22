<?php

namespace Modules\CoreData\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\CoreData\Repositories\TagRepository;
use Modules\CoreData\Http\Resources\Tag\TagResource;
use Modules\CoreData\Http\Resources\Tag\TagListResource;

class TagService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(TagRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '',
        $moreConditionForFirstLevel = [], $recursiveRel = [], $withRelations = [], $column = ['*'])
    {
        if(isset($request->search) && $request->search != null)
        {
            $moreConditionForFirstLevel = [
                    'where' => [
                        ['name' => $request->search]
                    ]
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
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new TagResource($data);
    }

    public function list(Request $request)
    {
        return TagListResource::collection($this->repo->list($request));
    }

    public function delete($id): bool
    {
        $this->repo->delete($id);
        return true;
    }

    public function toggleActive()
    {
        return $this->repo->toggleActive();
    }
}
