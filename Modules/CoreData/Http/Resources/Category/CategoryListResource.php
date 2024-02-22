<?php

namespace Modules\CoreData\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'group' => $this->group,
            'parent' => new CategoryListResource($this->parents),
        ];
    }
}
