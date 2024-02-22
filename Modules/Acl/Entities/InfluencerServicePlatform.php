<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\Service;

class InfluencerServicePlatform extends Model
{
    protected $fillable = [
        'influencer_id', 'platform_id', 'service_id', 'price','id'
    ];
    protected $table = 'influencer_service_platforms';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
