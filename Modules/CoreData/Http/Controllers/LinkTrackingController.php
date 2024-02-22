<?php

namespace Modules\CoreData\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CoreData\Entities\Location;
use Modules\CoreData\Service\LinkTrackingClicksService;
use Yajra\DataTables\Facades\DataTables;
use Modules\CoreData\Service\LinkTrackingService;
use Modules\Basic\Http\Controllers\BasicController;
use Modules\CoreData\Entities\LinkTracking;
use Modules\CoreData\Entities\LinkTrackingClick;
use Modules\CoreData\Http\Requests\Linktracking\EditRequest;
use Modules\CoreData\Http\Requests\Linktracking\CreateRequest;

class LinkTrackingController extends BasicController
{
    protected $service;
    protected $clicks_service;

    public function __construct(LinkTrackingService $Service, LinkTrackingClicksService $clicks_service)
    {
        $this->middleware('auth')->except("visit");
        $this->service = $Service;
        $this->clicks_service = $clicks_service;
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            return DataTables::of($this->service->findBy($request))->make(true);
        }
        return view(checkView('coredata::linktracking.index'));
    }

    public function create(Request $request)
    {
        $linktracking = $this->service->list($request);
        $countries = $this->service->listCountries($request);
        return view(checkView('coredata::linktracking.create'), compact('linktracking', 'countries'));
    }

    public function store(CreateRequest $request)
    {
        $data = $this->service->store($request);
        if($data)
        {
            return redirect(route('linktracking.index'))->with(
                ['link_id' => $data->link_id]
            );
        }
        return redirect(route('linktracking.create'))->with(getCustomTranslation('problem'));
    }

    public function edit(Request $request, $id)
    {
        $linktracking = $this->service->show($id);
        $countries = $this->service->listCountries();
        $tracking_countries = [];
        if($linktracking)
        {
            $tracking_countries = !unserialize($linktracking->countries) ? [] : unserialize($linktracking->countries);
        }
        return view(checkView('coredata::linktracking.edit'),
            compact('linktracking', 'countries', 'tracking_countries'));
    }

    public function update(EditRequest $request, $id)
    {
        $data = $this->service->update($request, $id);
        if($data)
        {
            return redirect(route('linktracking.index'))->with(getCustomTranslation('done'));
        }
        return redirect(route('linktracking.edit'))->with(getCustomTranslation('problem'));
    }

    function getClientIPAddress()
    {
        //whether ip is from the share internet
        if(!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from the proxy
        elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from the remote address
        else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function visit(Request $request, $linkId)
    {
        $platform = "";
        $destination_url = null;
        $ip = $this->getClientIPAddress();
        $link_tracking = LinkTracking::where('link_id', $linkId)->first();
        if(!$link_tracking)
        {
            abort(404);
        }
        $request_server = $request->server->all();
        //"156.223.184.141"
        $ipData = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        $data = [
            'request_server' => $request->server->all(),
            'ip_info' => $ipData
        ];
        $tracking_countries = $link_tracking->countries ? (!unserialize($link_tracking->countries) ? [] : unserialize($link_tracking->countries)) : [];
        foreach($tracking_countries as $item)
        {
            $country = Location::find($item['country_id']);
            if(strtolower($country->code) == strtolower($ipData->geoplugin_countryCode))
            {
                $destination_url = $item['destination'];
                break;
            }
        }
        if(isset($request_server['HTTP_USER_AGENT']))
        {
            $HTTP_USER_AGENT = strtolower($data['request_server']['HTTP_USER_AGENT']);
            if(str_contains($HTTP_USER_AGENT, 'surface'))
            {
                $device = 'PC';
            }elseif(str_contains($HTTP_USER_AGENT, 'ipad'))
            {
                $device = 'iPad';
            }elseif(!str_contains($HTTP_USER_AGENT, 'mobile') && str_contains($HTTP_USER_AGENT, 'android'))
            {
                $device = 'Tablet';
            }elseif(str_contains($HTTP_USER_AGENT, 'mobile'))
            {
                $device = 'mobile';
            }else
            {
                $device = 'PC';
            }
        }
        if(isset($request_server['HTTP_SEC_CH_UA_PLATFORM']))
        {
            $operating_system = str_replace('"', ' ', $request_server['HTTP_SEC_CH_UA_PLATFORM']);
        }else
        {
            if(isset($request_server['HTTP_USER_AGENT']))
            {
                $operating_system = strtolower(str_replace('"', ' ', $request_server['HTTP_USER_AGENT']));
                if(str_contains($operating_system, 'ubuntu'))
                {
                    $operating_system = 'Ubuntu';
                }elseif(str_contains($operating_system, 'android'))
                {
                    $operating_system = 'Android';
                }elseif(str_contains($operating_system, 'mac'))
                {
                    $operating_system = 'macOS';
                }else
                {
                    $operating_system = 'Other';
                }
            }else
            {
                $operating_system = 'Other';
            }
        }
        // Store Click
        LinkTrackingClick::create([
            'link_tracking_id' => $link_tracking->id,
            'ip' => $ipData->geoplugin_request,
            'operating_system' => $operating_system,
            'country' => $ipData->geoplugin_countryName,
            'city' => $ipData->geoplugin_city,
            'region' => $ipData->geoplugin_region,
            'country_code' => $ipData->geoplugin_countryCode,
            'continent_name' => $ipData->geoplugin_continentName,
            'latitude' => $ipData->geoplugin_latitude,
            'longitude' => $ipData->geoplugin_longitude,
            'timezone' => $ipData->geoplugin_timezone,
            'currency_code' => $ipData->geoplugin_currencyCode,
            'currency_symbol' => $ipData->geoplugin_currencySymbol,
            'device' => $device ?? null,
            'data' => serialize($data)
        ]);
        // go to the device destination URL
        $devices_array = array(
            'ios', 'android', 'windows', 'linux'
        );
        if(!isset($request_server['HTTP_SEC_CH_UA_PLATFORM']))
        {
            if(isset($data['request_server']['HTTP_USER_AGENT']))
            {
            $HTTP_USER_AGENT = $data['request_server']['HTTP_USER_AGENT'];
            foreach($devices_array as $item)
            {
                if(str_contains(strtolower($HTTP_USER_AGENT), $item))
                {
                    $platform = $item;
                    break;
                }
            }
            }
        }
        if($platform)
        {
            $platform = str_replace('"', '', strtolower($platform));
            if(in_array($platform, $devices_array))
            {
                $key = $platform . "_url";
                if($link_tracking->$key)
                {
                    return redirect($link_tracking->$key);
                }
            }
        }
        // go to the location destination URL
        if($destination_url)
        {
            return redirect($destination_url);
        }
        return redirect($link_tracking->destination);
    }

    public function show($id)
    {
        $tracker = $this->service->show($id);
        $total_clicks_count = $this->clicks_service->count($id);
        $countries_clicks_count = $this->clicks_service->get('country', $id, 5, more_columns: ['country_code']);
        $total_countries_clicks_count = $this->clicks_service->countriesCount($id);
        if($total_countries_clicks_count > 5)
        {
            $other_countries_clicks_count = $this->clicks_service->otherCountriesCount($id, $countries_clicks_count);
            $otherCountries = new \stdClass();
            $otherCountries->category = 'Others';
            $otherCountries->value = $other_countries_clicks_count;
            $countries_clicks_count->push($otherCountries);
        }
        $platform_clicks_count = $this->clicks_service->get('operating_system', $id);
        $device_clicks_count = $this->clicks_service->get('device', $id);
        return view(
            checkView('coredata::link_tracking.show'),
            compact(
                "tracker", "total_clicks_count", 'countries_clicks_count', 'platform_clicks_count',
                'device_clicks_count'
            )
        );
    }
}
