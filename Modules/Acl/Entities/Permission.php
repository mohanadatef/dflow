<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static get()
 */
class Permission extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

}
