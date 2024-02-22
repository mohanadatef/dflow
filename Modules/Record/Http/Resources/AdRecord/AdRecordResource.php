<?php

namespace Modules\Record\Http\Resources\AdRecord;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Acl\Http\Resources\User\UserListResource;
use Modules\Acl\Http\Resources\Company\CompanyListResource;
use Modules\Acl\Http\Resources\Influencer\InfluencerListResource;
use Modules\CoreData\Http\Resources\Category\CategoryListResource;

class AdRecordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'influencer' => new InfluencerListResource($this->influencer),
            'company' => new CompanyListResource($this->company),
            'category' => new CategoryListResource($this->category),
            'researcher' => new UserListResource($this->researcher),
            'data' => $this->data,
        ];
    }


}
