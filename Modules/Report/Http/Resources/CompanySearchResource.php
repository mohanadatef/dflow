<?php

namespace Modules\Report\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanySearchResource extends JsonResource
{
    public function toArray($request)
    {
        $link = getCustomTranslation("no_link");
        if(count($this->company_website) > 0){
            $link = '';
            foreach ($this->company_website as $site){
                $link .= '<a href="' . $site['url'] .'" target= "_blank" class="menu-link px-3">';
                $link.= $site->website["name_".user()->lang] . '</a>';
            }
        }

        return [
            'id' => $this->id,
            'name_en' => $this->name_en ,
            'name_ar' => $this->name_ar ,
            'html' => '
                <div >'. $this->{"name_".user()->lang} .'</div>
                <div>
                    <small style="color: blue">' . implode(',',$this->industry->pluck('name_'.user()->lang)) . '</small>
                </div>',
            'link'=>$link
        ];
    }
}
