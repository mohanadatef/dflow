<?php

namespace Modules\Setting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Notification extends Model
{
    use HasFactory;

    public static $rules = [
    ];
    protected $fillable = [
        'receiver_id',
        'action',
        'action_category',
        'action_id',
        'is_read',
        'pusher_id'
    ];

    public static function getValidationRules(): array
    {
        return self::$rules;
    }

    /**
     * Get the post that owns the comment.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function pusher()
    {
        return $this->belongsTo(User::class,'pusher_id');
    }

    public function url()
    {
        switch ($this->action){
            case "create_error" :
                return route('ad_record.edit',['id' => $this->action_id]);
            case "solve_error" :
                return route('ad_record.edit',['id' => $this->action_id]);
            case "cancel_error" :
                return route('ad_record_errors.index',['ad_record_id' => $this->action_id]);
            case "create_answer" :
                return route('question.show',['id' => $this->action_id]);
            default :
                return null;
        }
    }
}
