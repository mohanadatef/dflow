<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Entities\Influencer;

/**
 * @method static find(mixed $country_id)
 */
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar', 'name_en', 'code'
    ];
    protected $table = 'countries';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|unique:countries',
        'name_en' => 'required|unique:countries',
        'code' => 'required|unique:countries',
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

    public function influencer()
    {
        return $this->hasMany(Influencer::class);
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
