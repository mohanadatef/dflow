<?php

namespace Modules\Acl\Http\Resources\InfluencerGroup;

use Illuminate\Http\Resources\Json\JsonResource;

class InfluencerGroupListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
        ];
    }
}
