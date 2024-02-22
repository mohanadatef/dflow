<?php

namespace Modules\CoreData\Http\Resources\Platform;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CoreData\Http\Resources\Service\ServiceListResource;

class PlatformListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'active' => $this->active,
            'icon' => $this->icon ? getFile($this->icon->file ?? null, pathType()['ip'], getFileNameServer($this->icon)) : '',
            'service' => ServiceListResource::collection($this->service)
        ];
    }
}
