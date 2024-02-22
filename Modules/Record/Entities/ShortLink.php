<?php

namespace Modules\Record\Entities;

use Illuminate\Database\Eloquent\Model;

class ShortLink  extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'link', 'record_id'
    ];
    protected $table = 'short_links';
    public $timestamps = true;

    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];

    /**
     * Get the user that owns the contact info.
     */
    public function contentRecordRelation()
    {
        return $this->belongsTo(ContentRecord::class);
    }
}
