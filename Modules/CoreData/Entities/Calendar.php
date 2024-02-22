<?php

namespace Modules\CoreData\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Acl\Entities\Influencer;

/**
 * @method static whereDate(string $string, string $string1, mixed $from)
 */
class Calendar extends Model
{
    protected $fillable = [
        'description',
        'from',
        'to',
        'user_id',
        'campaign',
        'color',
        'title',
        'shared'
    ];

    protected $table = 'calendars';

    public $timestamps = true;

    public static array $rules = [
        'title' => 'required',
        'from' => 'required',
        'to' => 'nullable|after_or_equal:from',
        'campaign' => 'required'
    ];

    public static array $update_rules = [
        'title' => 'required',
        'from' => 'required',
        'to' => 'nullable|after_or_equal:from',
        'campaign' => 'required'
    ];

    /**
     * [columns that needs to have custom search such as like or where in]
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

    public static function getUpdateValidationRules(): array
    {
        return self::$update_rules;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function influencers(): BelongsToMany
    {
        return $this->belongsToMany(
            Influencer::class,
            'calendar_influencer'
        );
    }
}
