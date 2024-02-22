<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Platform;

class InfluencerPlatform extends Model
{
    protected $fillable = [
        'influencer_id', 'platform_id','id'
    ];
    protected $table = 'influencer_platforms';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }
}
