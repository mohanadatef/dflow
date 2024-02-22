<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Entities\Influencer;

class InfluencerTravel extends Model
{
    use HasFactory;


    protected $fillable = [
        'date_from', 'date_to', 'city_id', 'country_id','influencer_id'
    ];

    protected $table = 'influencer_travels';
    public $timestamps = true;

    public static $rules = [
        'country_id' => 'required|exists:locations,id',
        'influencer_id' => 'required|exists:influencers,id',
        'city_id' => 'required|exists:locations,id',
        'date_from' => 'required|date',
        'date_to' => 'required|date|after_or_equal:date_from',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
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

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }
}
