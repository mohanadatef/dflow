<?php

namespace Modules\CoreData\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Export\ExportEvent;
use Modules\CoreData\Http\Requests\Event\CreateRequest;
use Modules\CoreData\Http\Requests\Event\EditRequest;
use Modules\CoreData\Service\EventService;

class EventController extends BasicController
{
    protected $service;

    public function __construct(EventService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->middleware('permission:view_event')->only('index');
        $this->middleware('permission:create_event')->only(['create','store']);
        $this->middleware('permission:update_event')->only(['edit','update']);
        $this->middleware('permission:delete_event')->only('destroy');
        $this->middleware('permission:export_event')->only('export');
        $this->service = $Service;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if(isset($request->influencer))
        {
            $influencers_data = $this->service->influencerList(new request(['id' => $request->influencer_id]));
        }
        $dates = $this->service->findBy($request, true, $this->perPage(),withRelations:['influencer','category','country','tag']);
        $categories = $this->service->categoryList(new request());
        if($request->ajax())
        {
            return view(checkView('coredata::event.table'), get_defined_vars());
        }
        return view(checkView('coredata::event.index'), get_defined_vars());
    }

    public function create(Request $request)
    {
        $country = $this->service->countryList();
        $category = $this->service->categoryList(new Request());
        $tag = $this->service->tagList(new Request());
        return view(checkView('coredata::event.create'),get_defined_vars());
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('event.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('event.create'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $country = $this->service->countryList();
        $category = $this->service->categoryList(new Request());
        $tag = $this->service->tagList(new Request());
        $data = $this->service->show($id);
        return view(checkView('coredata::event.edit'), get_defined_vars());
    }

    public function update(EditRequest $request, $id)
    {
        if($this->service->update($request, $id))
        {
            return redirect(route('event.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('event.edit'))->with(getCustomTranslation('problem'));
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportEvent($request), "event.xlsx");
    }

}
