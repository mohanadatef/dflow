<?php

namespace Modules\Basic\Entities;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'file', 'type','created_at','id'
    ];

    protected $table = 'medias';
    public $searchRelationShip = [];
    public $timestamps = true;


    public function media()
    {
        return $this->morphTo();
    }

    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
}
