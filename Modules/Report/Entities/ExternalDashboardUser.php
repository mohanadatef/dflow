<?php

namespace Modules\Report\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalDashboardUser extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'external_dashboard_users';
    protected $fillable = [
      'user_id',
      'external_dashboard_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
