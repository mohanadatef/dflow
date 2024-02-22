<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\BrandActivity;
use Modules\CoreData\Entities\BrandActivitySponsorship;
use Modules\CoreData\Entities\Category;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Entities\Campaign;
use Modules\Record\Entities\CampaignCompany;

/**
 * @method static where(string $string, string $string1, string $string2 = "")
 * @method static whereHas(string $string, \Closure $param)
 * @method static create(array $array)
 * @method static find(array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Request|string|null $request)
 * @method static first()
 */
class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_ar', 'name_en', 'active', 'contact_info','id'
    ];
    protected $table = 'companies';
    public $timestamps = true;
    public static array $rules = [
        'name_ar' => 'required|string',
        'name_en' => 'required|string',
        'contact_info' => 'string|nullable',
        'industry' => 'required|array|exists:categories,id',
        'icon' => 'image|mimes:jpg,jpeg,png,gif',
        'link.*' => 'required|url',
    ];
    protected $appends = ['iconUrl'];
    /**
     * [columns that needs to have customized search such as like or where in]
     *
     * @var string[]
     */
    public array $searchConfig = ['name_en' => 'like', 'name_ar' => 'like'];
    public array $searchRelationShip = [
        'industry' => 'company_industry->industry_id',
        'campaign' => 'campaign_company->campaign_id',
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    public static function getValidationRules(): array
    {
        return self::$rules;
    }

    public function industry()
    {
        return $this->belongsToMany(Category::class, 'company_industries', 'company_id', 'industry_id');
    }

    public function ad_record()
    {
        return $this->hasMany(AdRecord::class, 'company_id', 'id');
    }

    public function company_industry()
    {
        return $this->hasMany(CompanyIndustry::class);
    }

    public function company_website()
    {
        return $this->hasMany(CompanyWebsite::class);
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function icon()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->media()->whereType(mediaType()['im']);
    }

    public function getIconUrlAttribute()
    {
        return ($this->icon->file ?? 0) ? getFile($this->icon->file ?? null, pathType()['ip'],
            getFileNameServer($this->icon)) : 0;
    }

    public function campaign()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_companies');
    }

    public function campaign_company()
    {
        return $this->hasMany(CampaignCompany::class);
    }

    public function company_socials()
    {
        return $this->hasMany(CompanySocial::class);
    }
    public function brand_activity()
    {
        return $this->belongsToMany(BrandActivity::class, 'brand_activity_sponsorships');
    }

    public function brand_activity_sponsorship()
    {
        return $this->hasMany(BrandActivitySponsorship::class);
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->company_industry()->delete();
            $data->media()->delete();
            $data->company_website()->delete();
        });
    }
}
