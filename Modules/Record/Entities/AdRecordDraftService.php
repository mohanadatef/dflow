<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Service;

class AdRecordDraftService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'ad_record_draft_id','price'
    ];
    protected $table = 'ad_record_drafts_services';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
    public function ad_record_draft(){
        return $this->belongsTo(AdRecordDraft::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
