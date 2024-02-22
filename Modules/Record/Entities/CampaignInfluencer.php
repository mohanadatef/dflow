<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class CampaignInfluencer extends Model
{
    protected $fillable = [
        'company_id', 'influencer_id'
    ];
    protected $table = 'campaign_influencers';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
