<?php

namespace Modules\Material\Entities;

use Illuminate\Database\Eloquent\Model;

class InfluencerTrendTag extends Model
{
    protected $fillable = [
        'tag_id', 'influencer_trend_id','id'
    ];
    protected $table = 'influencer_trend_tags';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
