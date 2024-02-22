<?php

namespace Modules\Record\Http\Resources\ContentRecord;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\Company\CompanyListResource;
use Modules\Acl\Http\Resources\Influencer\InfluencerListResource;
use Modules\CoreData\Http\Resources\Platform\PlatformListResource;

class ContentRecordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'influencer' => new InfluencerListResource($this->influencer),
            'company' => new CompanyListResource($this->company),
            'platform' => new PlatformListResource($this->researcher),
            'date' => $this->date,
        ];
    }


}
