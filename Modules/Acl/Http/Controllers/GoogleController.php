<?php

namespace Modules\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Acl\Service\GoogleService;
use Modules\Basic\Http\Controllers\BasicController;

class GoogleController extends BasicController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GoogleService $service)
    {
        $this->GOOGLE_REDIRECT = \Route('callback');
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $account = $this->service->getAccount();
        if ($account) {
            $this->service->getSheetDrive($account, User()->id);
            $account->spread_sheet = $account->sheets->pluck('sheet_name', 'sheet_id');
        }
    }

    public function create()
    {
        $account = $this->service->getAccount();
        return view('acl::google.create',compact('account'));
    }

    public function redirectToGoogleProvider()
    {
        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/userinfo.email&redirect_uri=' . $this->GOOGLE_REDIRECT . '&response_type=code&client_id=' . env('GOOGLE_CLIENT_ID') . '&access_type=offline&prompt=consent select_account');
    }

    public function handleProviderGoogleCallback(Request $request)
    {
        $result = $this->service->handleProviderGoogleCallback($request);
        return redirect()->to($result);
    }

    public function uploadSheet(Request $request)
    {
        $result = $this->service->uploadSheet($request);
        return redirect()->to($result);
    }

    public function logoutGoogle()
    {
        return $this->service->logoutGoogle();
    }

    public function getSheet($spreadsheetId)
    {
        $title = $this->service->getSheet($spreadsheetId);
        return $this->sendResponse($title, 'sheet  successfully');
    }
}
