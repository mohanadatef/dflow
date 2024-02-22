<?php

namespace Modules\CoreData\Http\Resources\LinkTracking;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkTrackingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'link_id' => $this->link_id,
            'destination' => $this->destination,
            'title' => $this->title,
            'options' => $this->options,
            'data' => $this->data,
            'user_id' => $this->user_id,
        ];
    }
}
