<?php

namespace Modules\Report\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalDashboardClient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'external_dashboard_id',
        'start_date',
        'end_date',
    ];
    protected static $rules = [
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'user_id' => 'exists:users,id',
        'external_dashboard_id' => 'exists:external_dashboards,id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function external_dashboard()
    {
        return $this->belongsTo(ExternalDashboard::class,'external_dashboard_id');
    }
}
