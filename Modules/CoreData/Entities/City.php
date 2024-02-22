<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;


    protected $fillable = [
        'name_ar', 'name_en', 'code', 'country_id'
    ];

    protected $table = 'cities';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|unique:cities',
        'name_en' => 'required|unique:cities',
        'code' => 'required|unique:cities',
        'country_id' => 'required',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name_en'=>'like','name_ar'=>'like'];
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
        return $this->belongsTo(Country::class);
    }
    public function event()
    {
        return $this->hasMany(Event::class);
    }

    public function influencer_travel()
    {
        return $this->hasMany(InfluencerTravel::class);
    }
}
