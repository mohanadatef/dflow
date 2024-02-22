<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'key'
    ];
    protected $table = 'websites_keys';
    public $timestamps = true;

    public static $rules = [
        'key' => 'required|string|unique:websites',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['key'=>'like'];
    public $searchRelationShip = [
        'website' => 'websites_keys->website_id',
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

    public function website()
    {
        return $this->belongsToMany(Website::class, 'websites_keys');
    }



    public static function boot()
    {
        parent::boot();
    }
}
