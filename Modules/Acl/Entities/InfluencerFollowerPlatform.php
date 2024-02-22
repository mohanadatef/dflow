<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\Size;

class InfluencerFollowerPlatform extends Model
{
    protected $fillable = [
        'influencer_id', 'platform_id', 'followers', 'size_id', 'url','influencer_group_id','id'
    ];
    protected $table = 'influencer_follower_platforms';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    public function influencer_group()
    {
        return $this->belongsTo(InfluencerGroup::class);
    }

    public function reseacher_influencers_daily()
    {
        return $this->hasMany(ReseacherInfluencersDaily::class,'influencer_follower_platform_id');
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->reseacher_influencers_daily()->delete();
        });
    }
}
