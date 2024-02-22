<?php

namespace Modules\CoreData\Http\Resources\Tag;

use Illuminate\Http\Resources\Json\JsonResource;

class TagListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
