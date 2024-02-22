<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerFollowerPlatform;
use Modules\Acl\Entities\InfluencerPlatform;
use Modules\Acl\Entities\InfluencerServicePlatform;
use Modules\Basic\Entities\Media;
use Modules\Material\Entities\InfluencerTrendPlatform;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $int)
 */
class Platform extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'order', 'active'
    ];
    protected $table = 'platforms';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|string|unique:platforms',
        'name_en' => 'required|string|unique:platforms',
        'service' => 'required|array|exists:services,id',
        'icon' => 'image|mimes:jpg,jpeg,png,gif',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name_en'=>'like','name_ar'=>'like'];
    public $searchRelationShip = [
        'service' => 'platform_service->service_id',
        'influencer' => 'influencer_platform->influencer_id',
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

    public function service()
    {
        return $this->belongsToMany(Service::class, 'platform_services');
    }

    public function platform_service()
    {
        return $this->hasMany(PlatformService::class);
    }

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'influencer_platforms');
    }
    public function influencer_platform()
    {
        return $this->hasMany(InfluencerPlatform::class);
    }
    public function influencer_service_platform()
    {
        return $this->hasMany(InfluencerServicePlatform::class);
    }

    public function influencer_follower_platform()
    {
        return $this->hasMany(InfluencerFollowerPlatform::class);
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function icon()
    {
        return $this->media()->whereType(mediaType()['im']);
    }

    public function brand_activity()
    {
        return $this->belongsToMany(BrandActivity::class, 'brand_activity_platforms');
    }

    public function brand_activity_platform()
    {
        return $this->hasMany(BrandActivityPlatform::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->platform_service()->delete();
            $data->brand_activity_platform()->delete();
            $data->influencer_service_platform()->delete();
            $data->influencer_follower_platform()->delete();
            $data->media()->delete();
        });
    }
}
