<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class AdRecordDraftCategory extends Model
{
    protected $fillable = [
        'category_id', 'ad_record_draft_id'
    ];
    protected $table = 'ad_record_draft_categories';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
