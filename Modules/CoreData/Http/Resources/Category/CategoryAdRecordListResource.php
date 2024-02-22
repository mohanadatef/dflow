<?php

namespace Modules\CoreData\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAdRecordListResource extends JsonResource
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
