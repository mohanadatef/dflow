<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;

class BrandActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from', 'date_to', 'city_id', 'country_id', 'tag_id', 'subject', 'brief','event_location'
    ];
    protected $table = 'brand_activities';
    public $timestamps = true;
    public static $rules = [
        'subject' => 'required|string|unique:brand_activities',
        'brief' => 'required|string',
        'event_location' => 'required|string',
        'country_id' => 'required|exists:locations,id',
        'tag_id' => 'required|exists:tags,id',
        'city_id' => 'required|exists:locations,id',
        'date_from' => 'required|date',
        'date_to' => 'required|date|after_or_equal:date_from',
        'platform' => 'required|array|exists:platforms,id',
        'sponsorship' => 'required|array|exists:companies,id',
        'influencer' => 'required|array|exists:influencers,id',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['brief' => 'like', 'subject' => 'like', 'event_location' => 'like'];
    public $searchRelationShip = ['sponsorship' => 'brand_activity_sponsorship->company_id',
        'influencer' => 'brand_activity_influencer->influencer_id',
        'platform' => 'brand_activity_platform->platform_id',];
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
        return $this->belongsTo(Location::class,'country_id');
    }

    public function city()
    {
        return $this->belongsTo(Location::class,'city_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function platform()
    {
        return $this->belongsToMany(Platform::class, 'brand_activity_platforms');
    }

    public function brand_activity_platform()
    {
        return $this->hasMany(BrandActivityPlatform::class);
    }

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'brand_activity_influencers');
    }

    public function brand_activity_influencer()
    {
        return $this->hasMany(BrandActivityInfluencer::class);
    }

    public function sponsorship()
    {
        return $this->belongsToMany(Company::class, 'brand_activity_sponsorships');
    }

    public function brand_activity_sponsorship()
    {
        return $this->hasMany(BrandActivitySponsorship::class,'company_id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->brand_activity_influencer()->delete();
            $data->brand_activity_platform()->delete();
            $data->brand_activity_sponsorship()->delete();
        });
    }
}
