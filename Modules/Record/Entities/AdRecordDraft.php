<?php

namespace Modules\Record\Entities;

use App\Models\User;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\Location;
use Modules\CoreData\Entities\Service;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\PromotionType;

/**
 * @method static truncate()
 * @method static whereDate(string $string, string $string1, mixed $first)
 * @method static whereBetween(string $string, array $array)
 */
class AdRecordDraft extends Model
{
    protected $fillable = [
        'id',
        'influencer_id',
        'company_id',
        'user_id',
        'mention_ad',
        'date',
        'promoted_products',
        'promoted_offer',
        'mention_ad',
        'gov_ad',
        'notes',
        'price',
        'platform_id',
        'url_post',
        'red_flag'
    ];
    protected $table = 'ad_record_drafts';
    public $timestamps = true;
    public static $rules = [];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
        'category' => 'ad_record_draft_category->category_id',
        'category_from_index' => 'ad_record_draft_category->category_id',
        'service' => 'service->service_id',
        'service_from_index' => 'service->service_id',
        'promotion_type' => 'ad_record_draft_promotion_type->promotion_type_id',
    ];
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'ad_record_draft_categories');
    }

    public function ad_record_draft_category()
    {
        return $this->hasMany(AdRecordDraftCategory::class);
    }

    public function target_market()
    {
        return $this->belongsToMany(Location::class, 'ad_record_draft_target_markets','ad_record_draft_id','country_id');
    }

    public function ad_record_draft_target_market()
    {
        return $this->hasMany(AdRecordDraftTargetMarket::class);
    }

    public function promotion_type()
    {
        return $this->belongsToMany(PromotionType::class, 'ad_record_draft_promotion_types');
    }

    public function ad_record_draft_promotion_type()
    {
        return $this->hasMany(AdRecordDraftPromotionType::class);
    }

    public function service()
    {
        return $this->belongsToMany(Service::class, 'ad_record_drafts_services');
    }

    public function ad_record_draft_services()
    {
        return $this->hasMany(AdRecordDraftService::class);
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'category');
    }

    public function medias()
    {
        return $this->media()->whereType(mediaType()['dm']);
    }

    public function mediasS3()
    {
        return $this->media()->whereType(mediaType()['s3']);
    }

    public function ad_record_draft_log()
    {
        return $this->hasMany(AdRecordDraftLog::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->ad_record_draft_category()->delete();
            $data->ad_record_draft_services()->delete();
            $data->ad_record_draft_promotion_type()->delete();
            $data->ad_record_draft_target_market()->delete();
            $data->ad_record_draft_log()->delete();
            $data->mediasS3()->delete();
        });
    }
}
