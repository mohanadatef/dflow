<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Platform;

class InfluencerGroupLog extends Model
{
    protected $fillable = [
        'user_id', 'influencer_group_id', 'influencer_follower_platform_id','type','new_influencer_group_id'
    ];
    protected $table = 'influencer_group_logs';
    public $timestamps = true;
    public static $rules = [];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function influencer_follower_platform()
    {
        return $this->belongsTo(InfluencerFollowerPlatform::class,'influencer_follower_platform_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function influencer_group()
    {
        return $this->belongsTo(InfluencerGroup::class, 'influencer_group_id');
    }
    public function new_influencer_group()
    {
        return $this->belongsTo(InfluencerGroup::class, 'new_influencer_group_id');
    }
}
