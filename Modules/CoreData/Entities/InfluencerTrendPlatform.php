<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;

class InfluencerTrendPlatform extends Model
{
    protected $fillable = [
        'platform_id', 'influencer_trend_id','id'
    ];
    protected $table = 'influencer_trend_platforms';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
