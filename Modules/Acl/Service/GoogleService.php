<?php

namespace Modules\Acl\Service;

use Illuminate\Http\Request;
use Modules\Acl\Entities\IntgrationAccount;
use Modules\Acl\Entities\SheetsUser;
use Modules\Basic\Service\BasicService;
use Google_Service_Drive;
use Google_Service_Sheets;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class GoogleService extends BasicService
{
    public function __construct()
    {
        $this->GOOGLE_REDIRECT = \Route('callback');
    }

    public function logoutGoogle()
    {
        IntgrationAccount::where('user_id', Auth::id())->where('login', 1)->update(['login' => 0]);
        return redirect(Route('google.create'));
    }

    public function getDataSheet($spreadsheetId, $sheet_name)
    {
        $client_sheet = $this->getClient();
        $service = new Google_Service_Sheets($client_sheet);
        $range = $sheet_name . '!A:Z';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        return $values;
    }

    public function getClientInfo($id_token)
    {
        $client_user_info = new Client();
        $url = 'https://oauth2.googleapis.com/tokeninfo';
        $response_user_info = $client_user_info->request('POST', $url,
            ['form_params' => ['id_token' => $id_token,
                'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email']]);
        return json_decode($response_user_info->getBody()->getContents(), true);
    }

    public function getClient($refresh_token = null)
    {
        if (!$refresh_token) {
            $refresh_token = $this->getAccount()->refresh_token;
        }
        $client_sheet = new \Google_Client();
        $client_sheet->setClientId(env('GOOGLE_CLIENT_ID'));
        $client_sheet->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client_sheet->refreshToken($refresh_token);
        return $client_sheet;
    }

    public function getSheetDrive($account, $user_id)
    {
        $client_sheet = $this->getClient($account->refresh_token);
        $client_sheet->setScopes('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email');
        $service_sheet = new Google_Service_Drive($client_sheet);
        $query = "mimeType='application/vnd.google-apps.spreadsheet' and  trashed=false";
        $optParams = ['fields' => 'files(id, name)', 'q' => $query];
        try {
            $sheet_data = $service_sheet->files->listFiles($optParams);
        } catch (\Exception $e) {
            session()->flash('warning', 'must choose access google drive.');
            $this->logoutGoogle();
        }
        $sheet_data_old = SheetsUser::where('intgration_account_id', $account->id)
            ->where('user_id', $user_id)->pluck('sheet_id', 'id')->toarray();
        $check_sheet = [];
        if (isset($sheet_data) && count($sheet_data->files) > 0) {
            foreach ($sheet_data->files as $sheet) {
                if (in_array($sheet->id, $sheet_data_old)) {
                    $check_sheet[] = $sheet->id;
                    continue;
                } else {
                    $check_sheet[] = $sheet->id;
                    $sheets_user = new SheetsUser();
                    $sheets_user->create(['sheet_id' => $sheet->id, 'sheet_name' => $sheet->name, 'intgration_account_id' => $account->id,
                        'user_id' => $user_id]);
                }
            }
            foreach ($sheet_data_old as $key => $value) {
                if (!in_array($value, $check_sheet)) {
                    SheetsUser::find($key)->delete();
                }
            }
        } else {
            foreach ($sheet_data_old as $key => $value) {
                SheetsUser::find($key)->delete();
            }
        }
    }

    public function uploadSheet(Request $request)
    {
        $sheet_data = $this->getDataSheet($request->spread_sheet, $request->sheet_name);

        return redirect(Route('google.create'));

    }

    public function handleProviderGoogleCallback(Request $request)
    {
        if (isset($request->code) && !empty($request->code)) {
            $code = $request->code;
            $client = new Client();
            $url = 'https://www.googleapis.com/oauth2/v4/token';
            $response_token = $client->request('POST', $url, ['form_params' => ['client_id' => env('GOOGLE_CLIENT_ID'), 'redirect_uri' => $this->GOOGLE_REDIRECT, 'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'code' => $code, 'grant_type' => 'authorization_code', 'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email']]);
            $statusCode = $response_token->getstatusCode();
            if ($statusCode == 200) {
                $response_token = json_decode($response_token->getBody()->getContents(), true);
                $id_token = $response_token['id_token'];
                if (isset($response_token['refresh_token']) and !empty($response_token['refresh_token'])) {
                    $refresh_token = $response_token['refresh_token'];
                    $client = new Client();
                    $url = 'https://www.googleapis.com/oauth2/v4/token';
                    $response_access = $client->request('POST', $url, ['form_params' => ['client_id' => env('GOOGLE_CLIENT_ID'),
                        'client_secret' => env('GOOGLE_CLIENT_SECRET'), 'grant_type' => 'refresh_token', 'refresh_token' => $refresh_token, 'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email']]);
                    $statusCode = $response_access->getstatusCode();
                    if ($statusCode == 200) {
                        $response_access = json_decode($response_access->getBody()->getContents(), true);
                        $user_info = $this->getClientInfo($id_token);
                        $data['token'] = array_merge($response_token, $response_access);
                        $user_id = Auth::id();
                        $account = IntgrationAccount::where('email', $user_info['email'])->where('user_id', $user_id)->first();
                        if ($account) {
                            $account->update(['code' => $code, 'refresh_token' => $data['token']['refresh_token'], 'access_token' => $data['token']['access_token'], 'login' => 1]);
                        } else {
                            $account = new IntgrationAccount();
                            $account->create(['email' => $user_info['email'], 'name' => $user_info['name'], 'code' => $code, 'refresh_token' => $data['token']['refresh_token'], 'access_token' => $data['token']['access_token'], 'avater' => $user_info['picture'], 'account_id' => $user_info['sub'], 'user_id' => $user_id, 'login' => 1]);
                        }
                        return redirect(Route('google.create'));
                    } else {
                        session()->flash('try again later');
                        return redirect(Route('google.create'));
                    }
                } else {
                    session()->flash('You Cant Access Page Without Refresh Access Token For User');
                    return redirect(Route('google.create'));
                }
            }
        }
        session()->flash('try again later');
        return redirect(Route('google.create'));
    }

    public function getAccount()
    {
        return IntgrationAccount::where('user_id', user()->id)->where('login', 1)->first();
    }


    public function getSheet($spreadsheetId)
    {
        $refresh_token = $this->getAccount()->refresh_token;
        $client_sheet = $this->getClient($refresh_token);
        $service = new \Google_Service_Sheets($client_sheet);
        $response = $service->spreadsheets->get($spreadsheetId);
        $title = [];
        foreach ($response->sheets as $s) {
            $title[] = ['id' => $s['properties']->title, 'name' => $s['properties']->title];
        }
        return $title;
    }
}
