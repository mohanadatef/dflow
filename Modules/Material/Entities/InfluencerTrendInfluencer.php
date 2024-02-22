<?php

namespace Modules\Material\Entities;

use Illuminate\Database\Eloquent\Model;

class InfluencerTrendInfluencer extends Model
{
    protected $fillable = [
        'influencer_id', 'influencer_trend_id','id'
    ];
    protected $table = 'influencer_trend_influencers';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
