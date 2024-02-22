<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Acl\Entities\InfluencerGroupSchedule;
use Modules\Acl\Entities\ReseacherInfluencersDaily;
use Modules\Acl\Entities\Role;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\UserCategory;
use Modules\Basic\Entities\Media;
use Modules\CoreData\Entities\Category;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Entities\RequestAdMediaAccess;
use Modules\Setting\Entities\Notification;

/**
 * @method static where(string $string, mixed $email)
 * @method static whereHas(string $string, \Closure $param)
 * @method static create(array $array)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'website', 'influencer_list', 'working_hours', 'match_search', 'first_login', 'balance', 'unlimit_balance',
        'email', 'company_size', 'password', 'active', 'suspended', 'last_seen_at', 'company_id','access_media_ad',
        'role_id', 'lang', 'start_access', 'end_access', 'competitive_analysis_pdf', 'change_language','session'

    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * [columns that needs to have customised search such as like or where in]
     *
     * @var string[]
     */

     public array $searchConfig = ['name' => 'like', 'email' => 'like'];

    public array $searchRelationShip = [
        'category' => 'user_category->category_id'
    ];

    protected $dates = [];

    public static array $rules = [
        'name' => 'required|unique:users',
        'email' => 'required|email:rfc,dns,strict|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]/|unique:users',
        'role_id' => 'required|exists:roles,id',
        'category' => 'required_if:type,1',
        'avatar' => 'image|mimes:jpg,jpeg,png,gif',
    ];

    public static array $external_users_required_data = [
        'website','conatact_person_email','conatact_person_name','company_size'
    ];

    protected static array $PasswordRules = ['password' => 'required|min:8'];
    protected static array $PasswordCreateRules = ['password' => 'required|min:8|confirmed'];

    public static function getValidationRules(): array
    {
        return array_merge(self::$rules, self::$PasswordCreateRules);
    }

    public static function getValidationRulesLogin(): array
    {
        return self::$PasswordRules;
    }

    public static function getValidationRulesUpdate(): array
    {
        return self::$rules;
    }

    public static function getValidationRulesPassword()
    {
        return self::$PasswordCreateRules;
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'category');
    }

    public function avatar()
    {
        return $this->media()->whereType(mediaType()['am']);
    }


    public function influencer_group_schedule()
    {
        return $this->hasMany(InfluencerGroupSchedule::class);
    }
    public function reseacher_influencers_daily()
    {
        return $this->hasMany(ReseacherInfluencersDaily::class, 'researcher_id');
    }
    public function reseacher_influencers_daily_count()
    {
        return $this->reseacher_influencers_daily()
            ->where('is_complete',0)
            ->whereBetween('date',[Carbon::today()->startofDay(),Carbon::today()->endofDay()])
            ->count();
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, 'user_categories');
    }

    public function user_category()
    {
        return $this->hasMany(UserCategory::class);
    }

    public function adRecords(){
        return $this->hasMany(AdRecord::class);
    }

    public function request_ad_media_access()
    {
        return $this->hasMany(RequestAdMediaAccess::class,'client_id');
    }

    public function request_ad_media_access_approve_balance()
    {
        return $this->request_ad_media_access()->where('status',2)->where('is_balance',1)->count();
    }
    public function request_ad_media_access_approve_unlimit()
    {
        return $this->request_ad_media_access()->where('status',2)->where('is_balance',0)->count();
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->media()->delete();
            $data->request_ad_media_access()->delete();
        });
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id')->orderBy('created_at','DESC');
    }
}
