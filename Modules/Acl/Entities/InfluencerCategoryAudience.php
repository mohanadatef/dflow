<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class InfluencerCategoryAudience extends Model
{
    protected $fillable = [
        'influencer_id', 'category_id', 'rate'
    ];
    protected $table = 'influencer_category_audiences';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
