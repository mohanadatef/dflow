<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Entities\Location;
use Modules\CoreData\Export\ExportLocation;
use Modules\CoreData\Http\Requests\Location\CreateRequest;
use Modules\CoreData\Http\Requests\Location\EditRequest;
use Modules\CoreData\Http\Resources\Country\CountryListResource;
use Modules\CoreData\Repositories\LocationRepository;
use Modules\CoreData\Service\LocationService;

class LocationController extends BasicController
{
    protected $service;

    public function __construct(LocationService $service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->findBy($request, true, $this->perPage(), [], '', [], [], ['parents']);
        $country = $this->service->list(new Request());
        if($request->ajax())
        {
            return view(checkView('coredata::location.table'), get_defined_vars());
        }
        return view(checkView('coredata::location.index'), get_defined_vars());
    }

    public function listSpecific(Request $request)
    {
        $repo = new LocationRepository(app());
        return CountryListResource::collection($repo->listSpecific($request));
    }

    public function create(Request $request)
    {
        $request->merge(['active' => activeType()['as']]);
        $country = $this->service->findBy(new Request(),
            moreConditionForFirstLevel: ['where' => ['parent_id' => null], 'orWhere' => ['parent_id' => 0]]);
        return view(checkView('coredata::location.create'), compact('country'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('location.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('location.create'))->with(getCustomTranslation('problem'));
    }

    public function show($id)
    {
        return view('coredata::show');
    }

    public function edit($id)
    {
        $data = Location::findOrFail($id);
        $country = $this->service->findBy(new Request(),
            moreConditionForFirstLevel: ['where' => ['parent_id' => null], 'orWhere' => ['parent_id' => 0]]);
        return view(checkView('coredata::location.edit'), ['data' => $data,'country'=>$country]);
    }

    public function update(EditRequest $request, $id)
    {
        if($this->service->update($request, $id))
        {
            return redirect(route('location.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('location.edit'))->with(getCustomTranslation('problem'));
    }

    public function cityList(Request $request)
    {
        return $this->service->cityList($request, $this->pagination(), $this->perPage());
    }

    public function export(Request $request)
    {
        executionTime();
        return Excel::download(new ExportLocation($request), "location.xlsx");
    }
}
