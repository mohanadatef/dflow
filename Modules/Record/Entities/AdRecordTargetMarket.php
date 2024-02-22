<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class AdRecordTargetMarket extends Model
{
    protected $fillable = [
        'country_id', 'ad_record_id','id'
    ];
    protected $table = 'ad_record_target_markets';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
