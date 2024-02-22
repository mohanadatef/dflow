<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
    protected $fillable = [
        'name', 'active'
    ];
    protected $table = 'tags';
    public $timestamps = true;
    public static $rules = [
        'name' => 'required|unique:tags',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = ['name' => 'like'];
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

    public function event()
    {
        return $this->hasMany(Event::class);
    }
}
