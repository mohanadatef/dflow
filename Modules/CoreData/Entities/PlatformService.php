<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class PlatformService extends Model
{
    protected $fillable = [
        'platform_id', 'service_id'
    ];

    protected $table = 'platform_services';

    public $timestamps = true;

    /**
     * [columns that needs to have custom search such as like or where in]
     *
     * @var string[]
     */
    public array $searchConfig = [];

    public array $searchRelationShip = [];

}
