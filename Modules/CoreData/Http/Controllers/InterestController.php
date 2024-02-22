<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Modules\CoreData\Service\InterestService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Interest\EditRequest;
use Modules\CoreData\Http\Requests\Interest\CreateRequest;

class InterestController extends BasicController
{
    protected $service;

    public function __construct(InterestService $Service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_interests')->only('index');
        $this->middleware('permission:create_interests')->only('create');
        $this->middleware('permission:create_interests')->only('store');
        $this->middleware('permission:update_interests')->only('edit');
        $this->middleware('permission:update_interests')->only('update');
        $this->middleware('permission:delete_interests')->only('destroy');
        $this->service = $Service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(checkView('coredata::interest.index'));
    }

    public function create(Request $request)
    {
        $interest = $this->service->list($request);
        return view(checkView('coredata::interest.create'), compact('interest'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('interest.index'))->with('Done');
        }
        return redirect(route('interest.create'))->with('problem');
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        $interest = $this->service->list(new Request());
        return view(checkView('coredata::interest.edit'), compact('data', 'interest'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('interest.index'))->with('Done');
        }
        return redirect(route('interest.edit'))->with('problem');
    }

}
