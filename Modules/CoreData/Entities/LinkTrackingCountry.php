<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinkTrackingCountry extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = "link_tracking_countries";

    public function linkTracking()
    {
        return $this->belongsTo(LinkTracking::class);
    }
}
