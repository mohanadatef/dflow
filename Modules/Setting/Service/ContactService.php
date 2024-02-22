<?php

namespace Modules\Setting\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Setting\Http\Resources\Fq\FqListResource;
use Modules\Setting\Http\Resources\Fq\FqResource;
use Modules\Setting\Repositories\ContactRepository;
use Modules\Setting\Repositories\FqRepository;

class ContactService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(ContactRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request)
    {
        return $this->repo->findBy($request);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function update(Request $request, $id)
    {
        $data = $this->repo->save($request, $id);
        return new FqResource($data);
    }

    public function list(Request $request)
    {
        return FqListResource::collection($this->repo->list($request));
    }
}
