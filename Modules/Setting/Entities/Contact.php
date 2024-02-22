<?php

namespace Modules\Setting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 */
class Contact extends Model
{
    use HasFactory;

    public static $rules = [
        'subject' => 'required|string',
        'message' => 'required|string',
    ];

    protected $fillable = [
        'subject', 'message', 'user_id'
    ];

    public static function getValidationRules(): array
    {
        return self::$rules;
    }

    /**
     * Get the post that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
