<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class InfluencerGeo extends Model
{
    protected $fillable = [
        'influencer_id','country_id','city_id','rate'
    ];
    protected $table = 'influencer_geos';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip  = [];
}
