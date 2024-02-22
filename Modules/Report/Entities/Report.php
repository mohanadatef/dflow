<?php

namespace Modules\Report\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status_date' => 'date',
        'report_date' => 'date'
    ];
}
