<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class CampaignDate extends Model
{
    protected $fillable = [
        'date', 'campaign_id'
    ];
    protected $table = 'campaign_dates';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
