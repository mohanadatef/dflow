<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class InfluencerGender extends Model
{
    protected $fillable = [
        'influencer_id', 'gender', 'rate','id'
    ];
    protected $table = 'influencer_genders';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
