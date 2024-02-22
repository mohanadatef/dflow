<?php

namespace Modules\CoreData\Http\Resources\City;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\CoreData\Http\Resources\Country\CountryListResource;

class CityListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'name_fr' => $this->name_fr,
            'code' => $this->code,
            'country' => new CountryListResource($this->country)
        ];
    }
}
