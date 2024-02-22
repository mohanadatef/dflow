<?php

namespace Modules\Acl\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Acl\Service\AdminDashboardService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\Record\Entities\AdRecord;

/**
 * @extends BasicController
 * controller user about web function
 */
class AdminDashboardController extends BasicController
{
    protected $service;

    /**
     * @extends BasicController
     * controller user about web function
     * @required user login
     */
    public function __construct(AdminDashboardService $service)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->service = $service;
    }

    public function adminDashboard(Request $request)
    {
        if(Carbon::now()->format('H') == '00')
        {
            $range_start = Carbon::parse("yesterday 9am");
            $range_end = Carbon::parse("today 9am");
        }else
        {
            $range_start = Carbon::parse("today 9am");
            $range_end = Carbon::parse("tomorrow 9am");
        }
        $date = ['start' => $range_start, 'end' => $range_end];
        $is_online = $request->is_online ?? 0;
        $data = $this->service->getAdminDashboard($request, perPage: $this->perPage(), page: $request->page ?? 1,
            date: $date);
        if($request->ajax())
        {
            return view('acl::users.adminDashboard.table', compact('data', 'range_end', 'range_start'));
        }
        $roles = $this->service->roleList();
        return view('acl::users.adminDashboard.index',
            compact('data', 'roles', 'is_online', 'range_end', 'range_start'));
    }

    public function logAdminDashboard(Request $request)
    {
        if($request->date)
        {
            $range_start =Carbon::parse(request('date'))->subDay(1)->setTime(9, 0, 0);
            $range_end = Carbon::parse(request('date'))->setTime(9, 0, 0);
        }else
        {
            if(Carbon::now()->format('H') == '00')
            {
                $range_start = Carbon::yesterday()->subDays(1)->setTime(9,0,0);
                $range_end = Carbon::today()->subDays(1)->setTime(9,0,0);
            }else
            {
                $range_start = Carbon::yesterday()->setTime(9,0,0);
                $range_end = Carbon::today()->setTime(9,0,0);
            }
        }
        $date = ['start' => $range_start, 'end' => $range_end];
        $data = $this->service->getAdminDashboardLogs($request, perPage: 35, page: $request->page ?? 1,date:$date);
        $roles = $this->service->roleList();
        if($request->ajax())
        {
            return view('acl::users.logAdminDashboard.table', compact('data','range_start','range_end'));
        }
        return view('acl::users.logAdminDashboard.index', compact('data', 'roles', 'range_end', 'range_start'));
    }
}
