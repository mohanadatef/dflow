<?php

namespace Modules\Record\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Record\Repositories\ShortLinkRepository;
use Illuminate\Support\Str;

class ShortLinkService extends BasicService
{
    protected
        $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(ShortLinkRepository $repository)
    {
        $this->repo = $repository;
    }


    public function findBy(Request $request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], $relation = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $pluck, $get, $moreConditionForFirstLevel, $recursiveRel, $relation);
    }


    public function store($contentRecord)
    {
        $request = request();
        $request->merge([
            'link' => getFile($contentRecord->video->file ?? null, pathType()['ip'], getFileNameServer($contentRecord->video)),
            'code' => Str::random(6),
            'record_id' => $contentRecord['id'],
        ]);
        return $this->repo->save($request, $id = null);
    }


    public function update($contentRecord)
    {
        $request = request();
        $request->merge([
            'link' => getFile($contentRecord->video->file ?? null, pathType()['ip'], getFileNameServer($contentRecord->video)),
            'code' => Str::random(6),
            'record_id' => $contentRecord['id'],
        ]);
        $shortLink = $this->findBy(new request(['record_id' => $contentRecord->id]), get: 'first');
        if ($shortLink) {
            return $this->repo->save($request, $shortLink->id);
        }
        return $this->repo->save($request, $id = null);
    }
}
