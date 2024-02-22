<?php

namespace Modules\Acl\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanySearchResource extends JsonResource
{
    public function toArray($request)
    {
        $link = '';
        foreach($this->company_website as $site)
        {
            $link .= '<a href="' . $site['url'] . '" target= "_blank" class="menu-link px-3">';
            $link .= $site->website["name_" . user()->lang] . '</a>';
        }
        if($this->iconUrl)
        {
            $icon = ' <div class="symbol symbol-10 me-4" style="width: 50%;height: 50%">
                     
                    <img src="' . $this->iconUrl . '" >
                </div>';
        }else
        {
            $icon = '  <div class="symbol symbol-10 me-4" style="width: 50%;height: 50%">
                      <img src="' . asset('dashboard') . '/assets/media/svg/avatars/blank.svg" >
                </div>';
        }
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'html' => '<div class="row"><div class="col-md-6"><div>' . $this->name_en . '/' . $this->name_ar . '</div>
                <div><small style="color: blue">' . implode(',',
                    $this->industry->pluck('name_' . user()->lang)
                        ->toArray()) . '</small></div></div><div class="col-md-6" style="text-align: right">' . $icon . '</div></div>',
            'link' => $link,
        ];
    }
}
