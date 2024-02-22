<?php

namespace Modules\Basic\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Basic\Traits\ApiResponseTrait;
use Modules\Basic\Traits\MediaTrait;

class BasicController extends Controller
{
    use ApiResponseTrait,MediaTrait;
    public function perPage()
    {
        return (!isset(Request()->perPage) || Request()->perPage == 'undefined') ? 10 : Request()->perPage;
    }

    public function pagination()
    {
        return !isset(Request()->pagination) ? false : Request()->pagination;
    }

    public function destroy($id)
    {
        return response()->json($this->service->delete($id));
    }

    public function list(Request $request)
    {
        return $this->service->list($request, $this->pagination(), $this->perPage());
    }

    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }
}
