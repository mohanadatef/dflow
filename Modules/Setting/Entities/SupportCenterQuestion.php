<?php

namespace Modules\Setting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Media;

class SupportCenterQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question', 'active', 'is_answered', 'user_id',
    ];

    public static $rules = [
        'question' => 'required|string',
    ];


    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function answers() {
        return $this->hasMany(SupportCenterAnswer::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'category');
    }

    public function medias()
    {
        return $this->media()->whereType(mediaType()['dm']);
    }
}
