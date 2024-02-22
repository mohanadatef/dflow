<?php

namespace Modules\Basic\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\Basic\Repositories\MediaRepository;

class MediaService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */

    public function __construct(MediaRepository $repository)
    {
        $this->repo = $repository;
    }

    public function remove(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            return $this->repo->delete($request->id);
        }
        return false;
    }

    public function removeByName(Request $request): bool
    {
        if (isset($request->name) && !empty($request->name)) {
            if (isset($request->id) && !empty($request->id)) {
                $this->repo->deleteByName($request->id,$request->name);
            }
            $session_id = user()->id;
            $file = public_path('images') ."/".$session_id."/".$request->name;
            File::delete($file);
            return true;
        }
        return false;
    }
}
