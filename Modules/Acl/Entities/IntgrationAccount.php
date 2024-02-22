<?php

namespace Modules\Acl\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Channel
 * @package App\Models
 * @version December 11, 2019, 11:23 am UTC
 *
 * @property string name
 * @property integer group
 */
class IntgrationAccount extends Model
{

    public $table = 'intgration_account';
    public $fillable = [
        'id',
        'account_id',
        'user_id',
        'code',
        'name',
        'email',
        'access_token',
        'refresh_token',
        'avater', 'login'
    ];

    public function user()
    {
        return $this->belongsTo(User::Class, 'user_id');
    }

    public function sheets()
    {
        return $this->hasMany(SheetsUser::Class);
    }
}

