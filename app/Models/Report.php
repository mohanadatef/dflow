<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status_date' => 'date',
        'report_date' => 'date'
    ];
}
