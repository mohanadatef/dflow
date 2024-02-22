<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;

class BrandActivitySponsorship extends Model
{
    protected $fillable = [
        'sponsorship_id', 'brand_activity_id','id'
    ];
    protected $table = 'brand_activity_sponsorships';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
