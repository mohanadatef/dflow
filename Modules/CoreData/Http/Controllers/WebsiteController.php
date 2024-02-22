<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Website\CreateRequest;
use Modules\CoreData\Http\Requests\Website\EditRequest;
use Modules\CoreData\Service\WebsiteService;

class WebsiteController extends BasicController
{
    protected $service;

    public function __construct(WebsiteService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_websites')->only('index');
        $this->middleware('permission:create_websites')->only('create');
        $this->middleware('permission:create_websites')->only('store');
        $this->middleware('permission:update_websites')->only('edit');
        $this->middleware('permission:update_websites')->only('update');
        $this->middleware('permission:delete_websites')->only('destroy');
        $this->service = $Service;
    }

    public function index(Request $request)
    {

        $websites = $this->service->findBy($request, true, $this->perPage(), [], '', [], []);
        if($request->ajax())
        {
            return view(checkView('coredata::website.table'), get_defined_vars());
        }
        return view(checkView('coredata::website.index'), get_defined_vars());
    }

    public function create(Request $request)
    {
        return view(checkView('coredata::website.create'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if ($data) {
            return redirect(route('website.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('website.create'))->with(getCustomTranslation('problem'));
    }

    public function edit($id)
    {
        $data = $this->service->show($id);
        return view(checkView('coredata::website.edit'), compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if ($data) {
            return redirect(route('website.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('website.edit'))->with(getCustomTranslation('problem'));
    }



}
