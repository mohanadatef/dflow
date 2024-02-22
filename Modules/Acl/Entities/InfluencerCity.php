<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Location;

class InfluencerCity extends Model
{
    protected $fillable = [
        'influencer_id', 'city_id','id'
    ];
    protected $table = 'influencer_cities';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public function city()
    {
        return $this->belongsTo(Location::class,'city_id');
    }
}
