<?php

namespace Modules\Report\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalDashboardVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_dashboard_id',
        'major',
        'minor',
        'batch',
        'default',
        'dashboard_data',
    ];

    protected $table = 'external_dashboard_versions';

    public function external_dashboard()
    {
        return $this->belongsTo(ExternalDashboard::class,'external_dashboard_id');
    }
}
