<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class CampaignCompany extends Model
{
    protected $fillable = [
        'company_id', 'campaign_id'
    ];
    protected $table = 'campaign_companies';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
