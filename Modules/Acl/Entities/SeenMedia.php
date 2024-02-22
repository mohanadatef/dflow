<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Platform;

class SeenMedia extends Model
{
    protected $fillable = [
        'name'
    ];
    protected $table = 'researchers_seen_medias';
    public $timestamps = true;
    public static $rules = [];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
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

}
