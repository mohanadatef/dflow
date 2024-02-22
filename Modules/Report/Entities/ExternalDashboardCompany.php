<?php

namespace Modules\Report\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalDashboardCompany extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'company_id',
      'external_dashboard_id',
      'id'
    ];

    protected $table = 'external_dashboard_companies';
}
