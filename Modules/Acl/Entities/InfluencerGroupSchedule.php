<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static where(string $string, string $string1, string $string2 = "")
 * @method static whereHas(string $string, \Closure $param)
 * @method static create(array $array)
 * @method static find(array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\Request|string|null $request)
 * @method static first()
 */
class InfluencerGroupSchedule extends Model
{

    protected $fillable = [
        'researcher_id', 'day', 'influencer_group_id','shift'
    ];
    protected $table = 'influencer_group_schedules';
    public $timestamps = true;
    public static $rules = [
        'day' => 'required',
        'influencer_group_id' => 'required',
        'researcher_id' => 'required',
        'shift' => 'required',
    ];
    protected $appends = [];
    /**
     * [columns that needs to have customized search such as like or where in]
     *
     * @var string[]
     */
    public array $searchConfig = [];
    public array $searchRelationShip = [];
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    public static function getValidationRules(): array
    {
        return self::$rules;
    }

    public function influencer_group()
    {
        return $this->belongsTo(InfluencerGroup::class, 'influencer_group_id');
    }

    public function researcher()
    {
        return $this->belongsTo(User::class, 'researcher_id');
    }


}
