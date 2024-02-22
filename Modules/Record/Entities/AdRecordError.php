<?php

namespace Modules\Record\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static whereDate(string $string, string $string1, mixed $first)
 * @method static whereBetween(string $string, array $array)
 */
class AdRecordError extends Model
{
    protected $fillable = [
        'id',
        'ad_record_id',
        'created_by_id',
        'action_by_id',
        'message',
        'action_at',
        'action'
    ];
    protected $table = 'ad_record_errors';
    public $timestamps = true;
    public static $rules = [
        'ad_record_id' => 'required|exists:ad_records,id',
        'message' => 'required',
        'action_at' => 'nullable',
        'action_by_id' => 'nullable',
    ];
    /**
     * [columns that needs to has customed search such as like or where in]
     *
     * @var string[]
     */
    public $searchConfig = [];
    public $searchRelationShip = [
        'ad_record_owner_id' => 'ad_record->user_id'
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

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function action_by()
    {
        return $this->belongsTo(User::class, 'action_by_id');
    }


    public function ad_record_log()
    {
        return $this->hasMany(AdRecordLog::class, 'ad_record_id', 'ad_record_id');
    }

    public function ad_record()
    {
        return $this->belongsTo(AdRecord::class, 'ad_record_id');
    }

    public static function boot()
    {
        parent::boot();
    }
}
