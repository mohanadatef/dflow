<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Entities\Influencer;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_from', 'date_to', 'city_id', 'country_id', 'tag_id', 'subject', 'brief'
    ];
    protected $table = 'events';
    public $timestamps = true;
    public static $rules = [
        'subject' => 'required|string|unique:events',
        'brief' => 'required|string',
        'country_id' => 'required|exists:locations,id',
        'tag_id' => 'required|exists:tags,id',
        'city_id' => 'required|exists:locations,id',
        'date_from' => 'required|date',
        'date_to' => 'required|date|after_or_equal:date_from',
        'category' => 'required|array|exists:categories,id',
        'influencer' => 'required|array|exists:influencers,id',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['brief' => 'like', 'subject' => 'like'];
    public $searchRelationShip = ['category' => 'event_category->category_id',
        'influencer' => 'event_influencer->influencer_id',];
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

    public function category()
    {
        return $this->belongsToMany(Category::class, 'event_categories');
    }

    public function event_category()
    {
        return $this->hasMany(EventCategory::class);
    }

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'event_influencers');
    }

    public function event_influencer()
    {
        return $this->hasMany(EventInfluencer::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->event_influencer()->delete();
            $data->event_category()->delete();
        });
    }
}
