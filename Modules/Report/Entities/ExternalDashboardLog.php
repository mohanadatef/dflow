<?php

namespace Modules\Report\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalDashboardLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'external_dashboard_id','type','user_id','id'
    ];
    protected $table = 'external_dashboard_logs';
    public $timestamps = true;

    public function external_dashboard()
    {
        return $this->belongsTo(ExternalDashboard::class,'external_dashboard_id');
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
