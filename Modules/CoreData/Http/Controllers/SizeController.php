<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Size\CreateRequest;
use Modules\CoreData\Http\Requests\Size\EditRequest;
use Modules\CoreData\Service\SizeService;
use Yajra\DataTables\Facades\DataTables;

class SizeController extends BasicController
{
    protected $service;

    public function __construct(SizeService $Service)
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
        return view(checkView('coredata::size.index'));
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function create(Request $request)
    {
        return view(checkView('coredata::size.create'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('size.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('size.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        return view(checkView('coredata::size.edit'), compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('size.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('size.edit'))->with(getCustomTranslation('problem'));
    }
}
