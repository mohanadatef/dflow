<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Setting\Http\Requests\Fq\CreateRequest;
use Modules\Setting\Http\Requests\Fq\EditRequest;
use Modules\Setting\Service\FqService;
use Yajra\DataTables\Facades\DataTables;

class FqController extends BasicController
{
    protected $service;

    public function __construct(FqService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(checkView('setting::fq.index'));
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function create(Request $request)
    {
        return view(checkView('setting::fq.create'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('fq.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('fq.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        return view(checkView('setting::fq.edit'), compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('fq.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('fq.edit'))->with(getCustomTranslation('problem'));
    }

    public function show_user(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(checkView('setting::fq.show_user'));
    }
}
