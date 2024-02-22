<?php

namespace Modules\Basic\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Service\MediaService;

class MediaController extends BasicController
{
    private $service;

    public function __construct(MediaService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $Service;
    }

    public function remove(Request $request): bool
    {
        $data = $this->service->remove($request);
        if ($data) {
            return true;
        }
        return false;
    }

    public function removeByName(Request $request): bool
    {
        $data = $this->service->removeByName($request);
        if ($data) {
            return true;
        }
        return false;
    }
}
