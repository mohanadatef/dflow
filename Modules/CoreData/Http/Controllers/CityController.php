<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Entities\City;
use Modules\CoreData\Entities\Country;
use Modules\CoreData\Service\CityService;
use Yajra\DataTables\Facades\DataTables;
use Modules\CoreData\Http\Requests\City\CreateRequest;
use Modules\CoreData\Http\Requests\City\EditRequest;

class CityController extends BasicController
{
    protected $service;

    public function __construct(CityService $service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $builder = $this->service->findBy($request, $pagination = false, $perPage = 10, $pluck = [], $get = '', $moreConditionForFirstLevel = [], $recursiveRel = [], 'country');
            return DataTables::of($builder)->make(true);
        }

        return view(checkView('coredata::cities.index'), [
            'countries' => $this->service->countriesList($request),
        ]);
    }

    public function store(CreateRequest $request)
    {
        $this->service->store($request);
        return response()->json(['Message' => getCustomTranslation('created_successfully')], 200);
    }

    public function show($id)
    {
        return view('coredata::show');
    }

    public function edit(Request $request, $id)
    {
        $city = City::findOrFail($id);
        return view(checkView('coredata::cities.edit_inputs'), [
            'countries' => Country::all(),
            'city' => $city
        ]);
    }

    public function update(EditRequest $request, $id)
    {
        $this->service->update($request, $id);
        return response()->json(['Message' => getCustomTranslation('updated_successfully')], 200);
    }
}
