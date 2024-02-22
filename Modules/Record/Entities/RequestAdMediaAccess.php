<?php

namespace Modules\Record\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class RequestAdMediaAccess extends Model
{
    protected $fillable = [
        'user_id', 'ad_record_id','client_id','status','is_balance'
    ];
    protected $table = 'request_ad_media_access';
    public $timestamps = true;

    public function ad_record()
    {
        return $this->belongsTo(AdRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class,'client_id');
    }

    public function request_ad_media_access_log()
    {
        return $this->hasMany(RequestAdMediaAccessLog::class);
    }

    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->request_ad_media_access_log()->delete();
        });
    }
}
