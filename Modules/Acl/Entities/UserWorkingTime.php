<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkingTime extends Model
{
    use HasFactory;

    protected $table = 'users_working_time';
    protected $fillable = ['user_id','working_hours','date','last_seen_at','first_login','id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
