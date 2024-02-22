<?php

namespace Modules\Setting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Basic\Entities\Media;

class SupportCenterAnswer extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'answer', 'support_center_question_id', 'user_id',
    ];

    public static $rules = [
        'answer' => 'required|string',
        'support_center_question_id' => 'required|exists:support_center_questions,id'
    ];

    public static function getValidationRules()
    {
        return self::$rules;
    }
    public function question() {
        return $this->belongsTo(SupportCenterQuestion::class, 'support_center_question_id');
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
