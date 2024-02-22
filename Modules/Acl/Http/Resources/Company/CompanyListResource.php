<?php

namespace Modules\Acl\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'icon' => $this->icon ? getFile($this->icon->file ?? null, pathType()['ip'], getFileNameServer($this->icon)) : '',
        ];
    }
}
