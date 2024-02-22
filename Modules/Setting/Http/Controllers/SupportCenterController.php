<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Fq;

class SupportCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function faq()
    {
        $data = Fq::all();
        return view('setting::support_center.faq', compact('data'));
    }
}
