<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\BrandActivity;
use Modules\CoreData\Entities\BrandActivityInfluencer;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\Event;
use Modules\CoreData\Entities\EventInfluencer;
use Modules\CoreData\Entities\InfluencerTravel;
use Modules\CoreData\Entities\Location;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\Service;
use Modules\Material\Entities\InfluencerTrend;
use Modules\Record\Entities\AdRecord;

/**
 * @method static where(string $string, $int)
 * @method static truncate()
 */
class Influencer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_en', 'gender', 'nationality_id', 'birthdate', 'active', 'name_ar', 'id', 'mawthooq','bio','contact_number',
        'contact_email','mawthooq_license_number'
    ];
    protected $table = 'influencers';
    public $timestamps = true;
    public static array $rules = [
        'name_en' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/|unique:influencers',
        'name_ar' => 'required|string|unique:influencers',
        'category' => 'required|array|exists:categories,id',
        'platform' => 'required|array|exists:platforms,id',
        'country_id' => 'required|array|exists:locations,id',
        'nationality_id' => 'nullable|exists:locations,id',
        'city_id' => 'nullable|exists:locations,id',
        'birthdate' => 'nullable|date',
        'bio' => 'nullable|string|max:366',
        'mawthooq_license_number' => 'nullable|numeric',
        'contact_number' => 'nullable|string|digits:14',
        'contact_email' => 'nullable|email:rfc,dns,strict|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]/',
        'gender' => 'required',
        'service' => 'array',
        'service.*.price' => 'string',
        'service.*.service_id' => 'exists:services,id',
        'service.*.platform_id' => 'exists:platforms,id',
        'follower' => 'array',
        'follower.*.price' => 'string',
        'follower.*.size' => 'string',
        'follower.*.followers' => 'nullable|numeric',
        'follower.*.platform_id' => 'exists:platforms,id',
        'audienceCountry' => 'array',
        'audienceCountry.*.rate' => 'string',
        'audienceCountry.*.country_id' => 'exists:locations,id',
        'audienceCategory' => 'array',
        'audienceCategory.*.rate' => 'string',
        'audienceCategory.*.country_id' => 'exists:categories,id',
        'genderPercentage' => 'array',
        'genderPercentage.*.rate' => 'string',
        'image' => 'image|mimes:jpg,jpeg,png,gif',
    ];
    /**
     * [columns that needs to have customised search such as like or where in]
     *
     * @var string[]
     */
    public array $searchConfig = ['name_en' => 'like', 'name_ar' => 'like'];
    public $searchRelationShip = [
        'category' => 'influencer_category->category_id',
        'platform' => 'platform->platform_id',
        'service' => 'influencer_service_platform->service_id',
        'country_id' => 'influencer_country->country_id',
        'country' => 'influencer_country->country_id',
        'city_id' => 'influencer_city->city_id',
        'city' => 'influencer_city->city_id',
        'follower' => 'influencer_follower_platform->followers',
        'size' => 'influencer_follower_platform->size_id',
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

    public function country()
    {
        return $this->belongsToMany(Location::class, 'influencer_countries','influencer_id','country_id');
    }

    public function influencer_country()
    {
        return $this->hasMany(InfluencerCountry::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Location::class, 'nationality_id');
    }

    public function city()
    {
        return $this->belongsToMany(Location::class, 'influencer_cities','influencer_id','city_id');
    }

    public function influencer_city()
    {
        return $this->hasMany(InfluencerCity::class);
    }

    public function platform()
    {
        return $this->belongsToMany(Platform::class, 'influencer_platforms');
    }

    public function service()
    {
        return $this->belongsToMany(Service::class, 'influencer_service_platforms');
    }

    public function influencer_service_platform()
    {
        return $this->hasMany(InfluencerServicePlatform::class);
    }

    public function influencer_follower_platform()
    {
        return $this->hasMany(InfluencerFollowerPlatform::class);
    }

    public function influencer_group()
    {
        return $this->belongsToMany(InfluencerGroup::class, 'influencer_group_platforms');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'influencer_categories');
    }

    public function influencer_category()
    {
        return $this->hasMany(InfluencerCategory::class);
    }

    public function influencer_country_audience()
    {
        return $this->hasMany(InfluencerCountryAudience::class);
    }

    public function influencer_category_audience()
    {
        return $this->hasMany(InfluencerCategoryAudience::class);
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function image()
    {
        return $this->media()->whereType(mediaType()['mm']);
    }

    public function mawthooq_license()
    {
        return $this->media()->whereType(mediaType()['mml']);
    }

    public function ad_record()
    {
        return $this->hasMany(AdRecord::class);
    }

    public function ads_cost()
    {
        $price = 0;

        $influencer_service_platform = $this->influencer_service_platform;
        $services = Service::orderBy('order','asc')->get();
        foreach($services as $service)
        {
            if($influencer_service_platform->where('service_id', $service->id)->count())
            {
                $price = $influencer_service_platform->where('service_id', $service->id)->sortBy('price')
                    ->last();
                if($price->price)
                {
                    return $price;
                }
            }
        }
        return $price;
    }

    public function influencer_gender()
    {
        return $this->hasMany(InfluencerGender::class);
    }

    public function influencer_travel()
    {
        return $this->hasMany(InfluencerTravel::class);
    }

    public function influencer_trend()
    {
        return $this->hasMany(InfluencerTrend::class);
    }
    public function event()
    {
        return $this->belongsToMany(Event::class, 'event_influencers');
    }

    public function event_influencer()
    {
        return $this->hasMany(EventInfluencer::class);
    }
    public function brand_activity()
    {
        return $this->belongsToMany(BrandActivity::class, 'brand_activity_influencers');
    }

    public function brand_activity_influencer()
    {
        return $this->hasMany(BrandActivityInfluencer::class);
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->influencer_category()->delete();
            $data->influencer_country()->delete();
            $data->influencer_city()->delete();
            $data->influencer_service_platform()->delete();
            $data->influencer_follower_platform()->delete();
            $data->influencer_country_audience()->delete();
            $data->influencer_category_audience()->delete();
            $data->influencer_gender()->delete();
            $data->media()->delete();
        });
    }
}
