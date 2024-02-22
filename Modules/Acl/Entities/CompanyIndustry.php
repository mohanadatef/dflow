<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array)
 */
class CompanyIndustry extends Model
{
    protected $fillable = [
        'company_id', 'industry_id','id'
    ];

    protected $table = 'company_industries';

    public $timestamps = true;

    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
}
