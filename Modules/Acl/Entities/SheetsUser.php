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
class SheetsUser extends Model
{
    public $table = 'sheets_users';
    public $fillable = [
        'id',
        'intgration_account_id',
        'user_id',
        'sheet_name',
        'sheet_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::Class, 'user_id');
    }

    public function intgration_account()
    {
        return $this->belongsTo(IntgrationAccount::Class, 'intgration_account_id');
    }
}

