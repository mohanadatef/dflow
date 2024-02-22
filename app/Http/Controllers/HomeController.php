<?php

namespace App\Http\Controllers;

use Modules\Basic\Http\Controllers\BasicController;
use Modules\Report\Service\HomeService;

class HomeController extends BasicController
{
    protected  $service;

    /**
     * @required must user be login
     *
     * @return void
     */
    public function __construct(HomeService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->middleware('admin');
    }


    public function home()
    {
        if(permissionShow('admin_dashboard_users'))
        {
            return redirect(route('admin.dashboard'));
        }
        if(permissionShow('show_researcher_dashboard_users'))
        {
            return redirect(route('researcher_dashboard.researcherDashboard'));
        }
        return view('dashboard.home');
    }
}
