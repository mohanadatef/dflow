<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\CoreData\Entities\Platform;

class InfluencerGroup extends Model
{
    protected $fillable = [
        'name_en', 'name_ar',
    ];
    protected $table = 'influencer_groups';
    public $timestamps = true;
    public static $rules = [
        'name_en' => 'required|string|unique:influencer_groups',
        'name_ar' => 'required|string|unique:influencer_groups',
        'platform_id' => 'required',
        'influencer_Platform' => 'required',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public array $searchConfig = ['name_en' => 'like', 'name_ar' => 'like'];
    public $searchRelationShip = [
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

    public function influencer_follower_platform()
    {
        return $this->hasMany(InfluencerFollowerPlatform::class);
    }

    public function influencer_group_log()
    {
        return $this->hasMany(InfluencerGroupLog::class);
    }

    public function info()
    {
        if(Carbon::now()->format('H') == '00')
        {
            $now = Carbon::yesterday();
            $start = Carbon::parse('yesterday 9am');
            $end = Carbon::parse('today 9am');
        }else
        {
            $now = Carbon::today();
            $start = Carbon::parse('today 9am');
            $end = Carbon::parse('tomorrow 9am');
        }
        $average_ads = 0;
        $count_ads = 0;
        $total_influencer = 0;
        $researcher = [];
        $complete = 0;
        $complete_all = $complete_done = 0;
        foreach($this->influencer_follower_platform as $influencer_group_platform)
        {
            $ad_record = $influencer_group_platform->influencer->ad_record;
            $average_ads += ceil($ad_record->whereBetween('date',
                    [Carbon::yesterday()->subDays(30)->startOfDay(), Carbon::yesterday()->endOfDay()])
                    ->where('platform_id', $influencer_group_platform->platform_id)->count() / 30);
            $count_ads += $ad_record->whereBetween('date', [$start, $end])
                ->where('platform_id', $influencer_group_platform->platform_id)->count();
            $total_influencer++;
            $reseacher_influencers_daily = $influencer_group_platform->reseacher_influencers_daily->where('date', $now);
            $complete_all += $reseacher_influencers_daily->count();
            $complete_done += $reseacher_influencers_daily->where('is_complete',1)->count();
            $researcher[] = $reseacher_influencers_daily->first()->researcher->name ?? "" ;
        }
        $researcher = array_unique($researcher);
        if($complete_done)
        {
            $complete = (( $complete_done / $complete_all) * 100);
        }
        return ['average_ads' => $average_ads, 'total_influencer' => $total_influencer, 'researcher' => $researcher, 'count_ads' => $count_ads, 'complete' => $complete];
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->influencer_group_log()->delete();
        });
    }
}
