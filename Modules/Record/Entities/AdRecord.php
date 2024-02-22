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
class AdRecord extends Model
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
    protected $table = 'ad_records';
    public $timestamps = true;
    public static $rules = [
        'influencer_id' => 'required|exists:influencers,id',
        'company_id' => 'required_without:name_en',
        'date' => 'required',
        'mention_ad' => 'nullable',
        'gov_ad' => 'nullable',
        'target_market' => 'required|array|exists:locations,id',
        'category' => 'required|array|exists:categories,id',
        'platform_id' => 'required|exists:platforms,id',
        'promotion_type' => 'required|array|exists:promotion_types,id',
        'service_id' => 'required|array|exists:services,id',
        'images' => 'array|max:10'
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
        'category' => 'ad_record_category->category_id',
        'category_from_index' => 'ad_record_category->category_id',
        'service' => 'service->service_id',
        'service_from_index' => 'service->service_id',
        'promotion_type' => 'ad_record_promotion_type->promotion_type_id',
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
        return $this->belongsTo(Company::class)->withTrashed();
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
        return $this->belongsToMany(Category::class, 'ad_record_categories');
    }

    public function ad_record_category()
    {
        return $this->hasMany(AdRecordCategory::class);
    }

    public function target_market()
    {
        return $this->belongsToMany(Location::class, 'ad_record_target_markets','ad_record_id','country_id');
    }

    public function ad_record_target_market()
    {
        return $this->hasMany(AdRecordTargetMarket::class, 'country_id');
    }

    public function promotion_type()
    {
        return $this->belongsToMany(PromotionType::class, 'ad_record_promotion_types');
    }

    public function ad_record_promotion_type()
    {
        return $this->hasMany(AdRecordPromotionType::class);
    }

    public function service()
    {
        return $this->belongsToMany(Service::class, 'ad_records_services');
    }

    public function ad_record_services()
    {
        return $this->hasMany(AdRecordService::class);
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

    public function accessMediaUser()
    {
        if(user()->access_media_ad == 0)
        {
            $status = $this->request_ad_media_access()->where('client_id', user()->id)
                ->where('status', requestAccessType()['apr'])->count();
            if($status == 0)
            {
                return 0;
            }
        }
        return 1;
    }

    public function accessMediaUserInfo()
    {
        return $this->request_ad_media_access->where('client_id', user()->id)->last();
    }

    public function request_ad_media_access()
    {
        return $this->hasMany(RequestAdMediaAccess::class);
    }

    public function ad_record_log()
    {
        return $this->hasMany(AdRecordLog::class);
    }

    public function ad_record_errors()
    {
        return $this->hasMany(AdRecordError::class);
    }


    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->ad_record_category()->delete();
            $data->ad_record_services()->delete();
            $data->request_ad_media_access()->delete();
            $data->ad_record_promotion_type()->delete();
            $data->ad_record_log()->delete();
            $data->ad_record_errors()->delete();
        });
    }
}
