<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;

class BrandActivityInfluencer extends Model
{
    protected $fillable = [
        'influencer_id', 'brand_activity_id','id'
    ];
    protected $table = 'brand_activity_influencers';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
