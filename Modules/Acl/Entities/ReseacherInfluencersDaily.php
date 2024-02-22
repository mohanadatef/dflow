<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReseacherInfluencersDaily extends Model
{
    use HasFactory;

    protected $table = 'reseacher_influencers_daily';
    protected $fillable = [
        'influencer_follower_platform_id', 'date', 'is_complete', 'owner_researcher_id', 'researcher_id','shift'
    ];
    public static $rules = [
        'researcher_id' => 'required',
        'id' => 'required'
    ];

    public static function getValidationRules(): array
    {
        return self::$rules;
    }

    public function researcher()
    {
        return $this->belongsTo(User::class, 'researcher_id');
    }

    public function ownerResearcher()
    {
        return $this->belongsTo(User::class, 'owner_researcher_id');
    }

    public function influencer_follower_platform()
    {
        return $this->belongsTo(InfluencerFollowerPlatform::class, 'influencer_follower_platform_id');
    }
}
