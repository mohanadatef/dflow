<?php

namespace Modules\CoreData\Http\Resources\Country;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'name_fr' => $this->name_fr,
            'code' => $this->code,
        ];
    }
}
