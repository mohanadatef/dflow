<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;

class InfluencerTrend extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from', 'date_to', 'influencer_id', 'country_id', 'tag_id', 'subject', 'brief','audience_impression'
    ];
    protected $table = 'influencer_trends';
    public $timestamps = true;
    public static $rules = [
        'subject' => 'required|string|unique:brand_activities',
        'brief' => 'required|string',
        'audience_impression' => 'required|string',
        'country_id' => 'required|exists:countries,id',
        'tag_id' => 'required|exists:tags,id',
        'date_from' => 'required|date',
        'date_to' => 'required|date|after_or_equal:date_from',
        'platform' => 'required|array|exists:platforms,id',
        'influencer_id' => 'required|exists:influencers,id',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['brief' => 'like', 'subject' => 'like'];
    public $searchRelationShip = ['platform' => 'influencer_trend_platform->platform_id'];
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
        return $this->belongsTo(Country::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    public function platform()
    {
        return $this->belongsToMany(Platform::class, 'influencer_trend_platforms');
    }

    public function influencer_trend_platform()
    {
        return $this->hasMany(InfluencerTrendPlatform::class);
    }


    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->influencer_trend_platform()->delete();
        });
    }
}
