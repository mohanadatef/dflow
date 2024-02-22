<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\InfluencerFollowerPlatform;

class Size extends Model
{
    protected $fillable = [
        'name_ar', 'name_en','power'
    ];
    protected $table = 'sizes';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|unique:sizes',
        'name_en' => 'required|unique:sizes',
        'power' => 'required|unique:sizes',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name_en'=>'like','name_ar'=>'like'];
    public $searchRelationShip = [
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

    public function influencer_follower_platform()
    {
        return $this->hasMany(InfluencerFollowerPlatform::class);
    }
}
