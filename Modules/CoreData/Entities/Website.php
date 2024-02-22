<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Acl\Entities\Company;
/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $int)
 */
class Website extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_ar', 'name_en', 'active'
    ];
    protected $table = 'websites';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|string|unique:websites',
        'name_en' => 'required|string|unique:websites',
        'key.*' => 'required|unique:websites_keys,key',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name_en'=>'like','name_ar'=>'like', 'id' => 'in'];
    public $searchRelationShip = [
        'company' => 'websites_companies->website_id',
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
        return $this->belongsToMany(Company::class, 'websites_companies');
    }

    public function websiteKeys()
    {
        return $this->hasMany(WebsiteKey::class, 'website_id');
    }



    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->websiteKeys()->delete();
        });
    }
}
