<?php

namespace Modules\CoreData\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\InfluencerInterest;

class Interest extends Model
{
    protected $fillable = [
        'name_ar', 'name_en'
    ];
    protected $table = 'interests';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|unique:interests',
        'name_en' => 'required|unique:interests',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
        'influencer' => 'influencer_interest->influencer_id',
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

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'influencer_interests');
    }

    public function influencer_interest()
    {
        return $this->hasMany(InfluencerInterest::class);
    }
}
