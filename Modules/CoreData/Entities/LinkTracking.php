<?php

namespace Modules\CoreData\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Acl\Entities\Influencer;

/**
 * @method static where(string $string, $linkId)
 */
class LinkTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'destination', 'title', 'options', 'user_id', 'countries',
        'ios_url',
        'android_url',
        'windows_url',
        'linux_url',
        'mac_url',
        'influencer_id',
        'note'
    ];

    protected $table = 'link_tracking';

    public static $rules = [
        'destination' => 'required|url',
        'title' => 'required',
        'countries.*.country_id' => 'nullable|exists:locations,id',
        'countries.*.destination' => 'nullable|url',
        'ios_url' => 'nullable|url',
        'android_url' => 'nullable|url',
        'windows_url' => 'nullable|url',
        'linux_url' => 'nullable|url',
        'mac_url' => 'nullable|url',
        'influencer_id'=>'required'
    ];

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function clicks()
    {
        return $this->hasMany(LinkTrackingClick::class);
    }

    public function countries()
    {
        return $this->hasMany(LinkTrackingCountry::class);
    }

    public function devices()
    {
        return $this->hasMany(LinkTrackingDevice::class);
    }

    /**
     * Get the post that owns the comment.
     */
    public function influencer(): BelongsTo
    {
        return $this->belongsTo(Influencer::class);
    }
}
