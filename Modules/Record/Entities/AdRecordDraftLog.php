<?php

namespace Modules\Record\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdRecordDraftLog extends Model
{
    protected $fillable = [
        'ad_record_draft_id','type','user_id'
    ];
    protected $table = 'ad_record_draft_logs';
    public $timestamps = true;

    public function ad_record_draft()
    {
        return $this->belongsTo(AdRecordDraft::class,'ad_record_draft_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
