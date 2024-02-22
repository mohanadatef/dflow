<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;

class PromotionType extends Model
{
    protected $fillable = [
        'name_ar', 'name_en'
    ];
    protected $table = 'promotion_types';
    public $timestamps = true;

    public static $rules = [
        'name_ar' => 'required|unique:promotion_types',
        'name_en' => 'required|unique:promotion_types',
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

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
        });
    }
}
