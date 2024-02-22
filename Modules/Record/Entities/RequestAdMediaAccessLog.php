<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class RequestAdMediaAccessLog extends Model
{
    protected $fillable = [
        'request_ad_media_access_id', 'status'
    ];
    protected $table = 'request_ad_media_access_logs';
    public $timestamps = true;
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
        'ad_record_id'=>'request_ad_media_access->ad_record_id',
        'client_id'=>'request_ad_media_access->client_id',
    ];

    public function request_ad_media_access()
    {
        return $this->belongsTo(RequestAdMediaAccess::class, 'request_ad_media_access_id');
    }
}
