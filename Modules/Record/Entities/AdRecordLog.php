<?php

namespace Modules\Record\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdRecordLog extends Model
{
    protected $fillable = [
        'ad_record_id','type','user_id','id'
    ];
    protected $table = 'ad_record_logs';
    public $timestamps = true;

    public function ad_record()
    {
        return $this->belongsTo(AdRecord::class,'ad_record_id');
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
