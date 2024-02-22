<?php

namespace Modules\Record\Entities;

use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;
use Illuminate\Database\Eloquent\Model;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\Platform;

class ContentRecord extends Model
{
    protected $fillable = [
        'influencer_id', 'company_id', 'platform_id', 'date'
    ];
    protected $table = 'content_records';
    public $timestamps = true;

    public static $rules = [
        'influencer_id' => 'required|exists:influencers,id',
        'company_id' => 'required|exists:companies,id',
        'platform_id' => 'required|exists:platforms,id',
        'date' => 'required',
        'video' => 'required|mimes:mp4,mov,ogg',
    ];

    public static $edit_rules = [
        'influencer_id' => 'required|exists:influencers,id',
        'company_id' => 'required|exists:companies,id',
        'platform_id' => 'required|exists:platforms,id',
        'date' => 'required',
        'video' => 'nullable|mimes:mp4,mov,ogg',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [];
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

    public static function getEditValidationRules()
    {
        return self::$edit_rules;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function video()
    {
        return $this->media()->whereType(mediaType()['vm']);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->media()->delete();
        });
    }

    /**
     * Get the phone record associated with the user.
     */
    public function shortLinkRelation()
    {
        return $this->hasOne(ShortLink::class, 'record_id');
    }
}
