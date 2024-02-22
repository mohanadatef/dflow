<?php

namespace Modules\Acl\Http\Resources\InfluencerGroup;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerSearchResource extends JsonResource
{
    public function toArray($request)
    {
        $influencer= $this->influencer;
        $platform= $this->platform;
        $influencer_name=$influencer->{'name_'.user()->lang};
        $platform_name=$platform->{'name_'.user()->lang};
        $count = $influencer->ad_record
                ->whereBetween('date',
                    [Carbon::yesterday()->subDays(30)->startOfDay(), Carbon::yesterday()->endOfDay()])
                ->where('platform_id', $this->platform_id)->count() / 30;
        $group = $this->influencer_group ?? null;
        $name_group = $group->{'name_'.user()->lang} ?? null;
        $group_name = !is_null($name_group) ? '<small style="color: red">' . $name_group . '</small>' : "";
        $line = !is_null($name_group) ? 'style="color: red"' : "";
        $id = $this->id ;
        return [
            'id' => $this->id,
            'influencer' => $influencer_name,
            'name_group' => $name_group,
            'count' => ceil($count),
            'check_group' => $name_group ? 1 : 0,
            'html' => '<div >' . $influencer_name . '</div><div><small style="color: blue">' . $platform_name . '</small>     ' . $group_name . '</div>',
            'div' => '<div ' . $line . ' class="count" id="' . $this->id . '" data-count-' . $this->id . '="' . $count . '" data-platfrom="' . $this->platform_id . '">' . $influencer_name . '     ' . $platform_name . '     ' . ceil($count). '
<a type="button" onclick="rowDelete(' . $this->id . ')"
                                       class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <span class="svg-icon svg-icon-5 m-0">
                                        <i class="fa fa-x"></i>
                                    </span>
                                    </a>
                                    <input type="text" name="influencer_Platform[]" class="id-data" hidden id="' . $this->id . '"
                                                   value="' . $id. '"
                                                  /></div>'
        ];
    }
}
