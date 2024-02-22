<?php

namespace Modules\CoreData\Http\Resources\Calendar;

use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'from' => $this->from,
            'to' => $this->to,
            'user_id' => $this->group,
            'influencer_id' => $this->influencer_id,
        ];
    }
}
