<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Location;

class InfluencerCountry extends Model
{
    protected $fillable = [
        'influencer_id', 'country_id','id'
    ];
    protected $table = 'influencer_countries';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public function country()
    {
        return $this->belongsTo(Location::class,'country_id');
    }
}
