<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, array $row)
 */
class Fq extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question', 'answer'
    ];
    protected $table = 'fqs';
    public $timestamps = true;

    public static $rules = [
        'question' => 'required|string',
        'answer' => 'required|string',
    ];
    /**
     * [columns that needs to have custom search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
        'platform' => 'platform_service->platform_id',
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
}
