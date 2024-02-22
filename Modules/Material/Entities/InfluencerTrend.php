<?php

namespace Modules\Material\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\Influencer;
use Modules\CoreData\Entities\Location;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\Tag;

class InfluencerTrend extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from', 'date_to', 'country_id', 'subject', 'brief','audience_impression'
    ];
    protected $table = 'influencer_trends';
    public $timestamps = true;
    public static $rules = [
        'subject' => 'required|string|unique:brand_activities',
        'brief' => 'required|string',
        'audience_impression' => 'required|string',
        'country_id' => 'required|exists:locations,id',
        'tag' => 'required|array|exists:tags,id',
        'date_from' => 'required|date',
        'date_to' => 'required|date|after_or_equal:date_from',
        'influencer' => 'required|array|exists:influencers,id',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['brief' => 'like', 'subject' => 'like'];
    public $searchRelationShip = ['influencer' => 'influencer_trend_influencer->influencer_id',
        'tag' => 'influencer_trend_tag->tag_id' ];
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

    public function tag()
    {
        return $this->belongsToMany(Platform::class, 'influencer_trend_tags');
    }

    public function influencer_trend_tag()
    {
        return $this->hasMany(InfluencerTrendTag::class);
    }

    public function influencer()
    {
        return $this->belongsToMany(Platform::class, 'influencer_trend_influencers');
    }

    public function influencer_trend_influencer()
    {
        return $this->hasMany(InfluencerTrendInfluencer::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->influencer_trend_influencer()->delete();
            $data->influencer_trend_tag()->delete();
        });
    }
}
