<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;

class Campaign extends Model
{
    protected $fillable = [
        'name_ar', 'name_en', 'url'
    ];
    protected $table = 'campaigns';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|string|unique:campaigns',
        'name_en' => 'required|string|unique:campaigns',
        'url' => 'required|url',
        'company' => 'required|array|exists:companies,id',
        'influencer' => 'required|array|exists:influencers,id',
        // 'date' => 'required|array',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
        'company' => 'campaign_company->company_id',
        'influencer' => 'campaign_influencer->influencer_id',
        'date' => 'campaign_date->date',
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

    public function company()
    {
        return $this->belongsToMany(Company::class, 'campaign_companies');
    }

    public function campaign_company()
    {
        return $this->hasMany(CampaignCompany::class);
    }

    public function campaign_date()
    {
        return $this->hasMany(CampaignDate::class);
    }

    public function influencer()
    {
        return $this->belongsToMany(Influencer::class, 'campaign_influencers');
    }

    public function campaign_influencer()
    {
        return $this->hasMany(CampaignInfluencer::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->campaign_company()->delete();
            $data->campaign_influencer()->delete();
            $data->campaign_date()->delete();
        });
    }
}
