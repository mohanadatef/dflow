<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static where(string $string, $seederClass)
 */
class LinkTrackingClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_tracking_id',
        'data',
        'ip',
        'operating_system',
        'country',
        'city',
        'region',
        'country_code',
        'continent_name',
        'latitude',
        'longitude',
        'timezone',
        'currency_code',
        'currency_symbol',
        'device',
        'id'
    ];
    protected $table = 'link_tracking_clicks';

    public function linkTracking()
    {
        return $this->belongsTo(LinkTracking::class);
    }
}
