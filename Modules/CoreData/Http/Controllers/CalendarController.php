<?php

namespace Modules\CoreData\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\CoreData\Entities\Calendar;
use Yajra\DataTables\Facades\DataTables;
use Modules\CoreData\Service\CalendarService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Http\Requests\Calendar\EditRequest;
use Modules\CoreData\Http\Requests\Calendar\CreateRequest;

class CalendarController extends BasicController
{
    protected $service;

    public function __construct(CalendarService $Service)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->service = $Service;
    }

    public function index(Request $request)
    {
        $charts_disabled = true;
        if ($request->ajax()) {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(
            checkView('coredata::calendar.index'), compact('charts_disabled')
        );
    }

    public function events(Request $request)
    {
        $columns = [
            'id AS id',
            'from AS start',
            'to AS end',
            'description AS description',
            'color',
            'campaign',
            'title',
            'user_id'
        ];

        $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
        $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
        $role = user()->role;

        if ($role->share_calender) {
            //one calendar for all users
            $events = Calendar::with('influencers:id,name_en')
                ->where(function($query) use ($start,$end){
                    $query
                        ->whereRaw(DB::raw("YEAR('$start') between YEAR(`from`) and YEAR(`to`)"))
                        ->orWhereRaw(DB::raw("YEAR('$end') between YEAR(`from`) and YEAR(`to`)"))
                    ;
                })
                ->where('shared', true)
                ->get($columns)
            ;
        }
        else{
            $events = Calendar
                ::with('influencers:id,name_en')
                ->where('user_id', '=', user()->id)
                ->where(function($query) use ($start,$end){
                    $query
                        ->whereRaw(DB::raw("YEAR('$start') between YEAR(`from`) and YEAR(`to`)"))
                        ->orWhereRaw(DB::raw("YEAR('$end') between YEAR(`from`) and YEAR(`to`)"))
                    ;
                })
                ->where('shared', false)
                ->get($columns)
            ;
        }

        foreach ($events as $event){
            $event->to = $event->end;
            $to_date = Carbon::parse($event->end)->addDay()->toDateString();
            $event->end = $to_date;
            $event->delete_url = route('calendar.delete',$event->id);
        }


        return json_encode($events);
    }

    public function create()
    {
        $charts_disabled = true;
        return view(checkView('coredata::calendar.create'), compact('charts_disabled'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store(request:$request,sync_influencers:true);
        $events = Calendar::whereDate('from', '=', $request->from)->orWhereDate('to', '=', $request->to)->get('id');
        foreach ($events as $event){
            $update_request = new Request();
            $update_request->replace(['color' => rand_color()]);
            $this->service->update($update_request, $event->id);
        }

        if ($data) {
            return response()->json($data);
        }
        return response()->json([getCustomTranslation('some_thing_went_wrong')]);
    }

    public function edit(int $id)
    {
        $data = $this->service->show($id);

        return view(checkView('coredata::calendar.edit'), compact('data'));
    }

    public function update(EditRequest $request, int $id)
    {
        if ($this->service->update(request:$request, id:$id,sync_influencers:true)) {
            return redirect(route('calendar.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('calendar.edit'))->with(getCustomTranslation('problem'));
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect(route('calendar.index'))->with(getCustomTranslation('done'));
    }
}
