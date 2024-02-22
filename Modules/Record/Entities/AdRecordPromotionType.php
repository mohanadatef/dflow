<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class AdRecordPromotionType extends Model
{
    protected $fillable = [
        'promotion_type_id', 'ad_record_id','id'
    ];
    protected $table = 'ad_record_promotion_types';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
