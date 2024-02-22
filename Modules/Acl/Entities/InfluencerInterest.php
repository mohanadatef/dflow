<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Interest;

class InfluencerInterest extends Model
{
    protected $fillable = [
        'influencer_id', 'interest_id', 'rate'
    ];
    protected $table = 'influencer_interests';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public function interest()
    {
        return $this->belongsTo(Interest::class);
    }
}
