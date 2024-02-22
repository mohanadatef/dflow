<?php

namespace Modules\Record\Http\Resources\AdRecord;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Company\CompanyListResource;
use Modules\Acl\Http\Resources\Influencer\InfluencerListResource;

class AdRecordListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'influencer' => new InfluencerListResource($this->influencer),
            'company' => new CompanyListResource($this->company),
            'researcher' => new UserRListResource($this->researcher),
            'data' => $this->data,
        ];
    }
}
