<?php

namespace Modules\Acl\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CoreData\Http\Resources\Category\CategoryListResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        $link = '';
            foreach ($this->company_website as $site){
                $link .= '<a href="' . $site['url'] .'" target= "_blank" class="menu-link px-3">';
                $link.= $site->website["name_".user()->lang] . '</a>';
            }
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'link' => $link,
            'contact_info' => $this->contact_info,
            'icon' => $this->icon ? getFile($this->icon->file ?? null, pathType()['ip'],
                getFileNameServer($this->icon)) : '',
            'industry' => CategoryListResource::collection($this->industry),
            'industry_id' => $this->industry->pluck('id')
        ];
    }
}
