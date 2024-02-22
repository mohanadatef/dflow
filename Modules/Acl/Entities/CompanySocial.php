<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Platform;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanySocial extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'platform_id', 'user_id', 'content'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
