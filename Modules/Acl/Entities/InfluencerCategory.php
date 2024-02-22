<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Category;

class InfluencerCategory extends Model
{
    protected $fillable = [
        'influencer_id', 'category_id','id'
    ];
    protected $table = 'influencer_categories';
    public $timestamps = true;


    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
