<?php

namespace Modules\CoreData\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportTag;
use Modules\CoreData\Http\Requests\Tag\CreateRequest;
use Modules\CoreData\Http\Requests\Tag\EditRequest;
use Modules\CoreData\Service\TagService;

class TagController extends BasicController
{
    protected $service;
    public function __construct(TagService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_tag')->only('index');
        $this->middleware('permission:create_tag')->only(['create','store']);
        $this->middleware('permission:update_tag')->only(['edit','update']);
        $this->middleware('permission:delete_tag')->only('destroy');
        $this->middleware('permission:export_tag')->only('export');
        $this->service = $Service;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        $tags = $this->service->findBy($request, true, $this->perPage());
        if($request->ajax())
        {
            return view(checkView('coredata::tag.table'), get_defined_vars());
        }
        return view(checkView('coredata::tag.index'), get_defined_vars());
    }

    public function create(Request $request)
    {
        return view(checkView('coredata::tag.create'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('tag.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('tag.create'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $data = $this->service->show($id);
        return view(checkView('coredata::tag.edit'), compact('data'));
    }

    public function update(EditRequest $request, $id)
    {
        if($this->service->update($request, $id))
        {
            return redirect(route('tag.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('tag.edit'))->with(getCustomTranslation('problem'));
    }

    public function toggleActive()
    {
        return response()->json(['status' => $this->service->toggleActive() ? 'true' : 'false']);
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportTag($request), "tag.xlsx");
    }
    public function checkTag(CreateRequest $request) {
        return 1;
    }
}
