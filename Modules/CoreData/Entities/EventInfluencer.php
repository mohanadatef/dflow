<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;

class EventInfluencer extends Model
{
    protected $fillable = [
        'influencer_id', 'event_id','id'
    ];
    protected $table = 'event_influencers';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
