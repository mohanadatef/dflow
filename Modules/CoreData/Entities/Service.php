<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerServicePlatform;
use Modules\Record\Entities\AdRecord;

/**
 * @method static where(string $string, array $row)
 * @method static create(array $array)
 */
class Service extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'active','order'
    ];
    protected $table = 'services';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|unique:services',
        'name_en' => 'required|unique:services',
        'order' => 'nullable|numeric|unique:services',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name_en'=>'like','name_ar'=>'like'];
    public $searchRelationShip = [
        'platform' => 'platform_service->platform_id',
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

    public function platform()
    {
        return $this->belongsToMany(Platform::class, 'platform_services');
    }

    public function platform_service()
    {
        return $this->hasMany(PlatformService::class);
    }

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'influencer_service_platforms');
    }

    public function influencer_service_platform()
    {
        return $this->hasMany(InfluencerServicePlatform::class);
    }
    public function ad_records()
    {
        return $this->hasMany(AdRecord::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->platform_service()->delete();
            $data->influencer_service_platform()->delete();
        });
    }
}
