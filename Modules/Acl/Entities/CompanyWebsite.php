<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Website;

class CompanyWebsite extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'website_id', 'url','id'
    ];
    protected $table = 'companies_websites';
    public $timestamps = true;
    public array $searchConfig = ['url' => 'like'];
    public static $rules = [
        'company_id' => 'required|numeric',
        'website_id' => 'required|numeric',
        'url' => 'required|string',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */

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
        return $this->belongsToMany(Company::class, 'websites_companies');
    }

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }



    public static function boot()
    {
        parent::boot();
    }
}
