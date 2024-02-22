<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Entities\Country;
use Modules\CoreData\Http\Requests\Country\CreateRequest;
use Modules\CoreData\Http\Requests\Country\EditRequest;
use Modules\CoreData\Http\Resources\Country\CountryListResource;
use Modules\CoreData\Repositories\CountryRepository;
use Modules\CoreData\Service\CountryService;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends BasicController
{
    protected $service;

    public function __construct(CountryService $service)
    {
         $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $builder = $this->service->findBy($request);
            return DataTables::of($builder)->make(true);
        }
        return view(checkView('coredata::countries.index'));
    }

    public function listSpecific(Request $request)
    {
        $repo = new CountryRepository(app());
        return CountryListResource::collection($repo->listSpecific($request));
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

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view(checkView('coredata::countries.edit_inputs'), ['country' => $country]);
    }

    public function update(EditRequest $request, $id)
    {
        $this->service->update($request, $id);
        return response()->json(['Message' =>  getCustomTranslation('updated_successfully')], 200);
    }
}
