<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LinkTrackingDevice extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = "link_tracking_devices";

    public function linkTracking()
    {
        return $this->belongsTo(LinkTracking::class);
    }
}
