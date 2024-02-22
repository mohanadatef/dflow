<?php

namespace Modules\Report\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Acl\Entities\Company;
use Modules\CoreData\Entities\Category;

class ExternalDashboard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'start_date', 'end_date', 'active',
    ];
    protected static $rules = [
        'name' => 'required|unique:external_dashboards',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'company_id' => 'exists:companies,id',
        'category_id' => 'exists:categories,id',
    ];
    public $searchConfig = ['name'=>'like'];
    public $searchRelationShip = [
        'category' => 'category->category_id',
        'company' => 'company->company_id',
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class, 'external_dashboard_categories');
    }

    public function external_dashboard_category()
    {
        return $this->hasMany(ExternalDashboardCategory::class);
    }

    public function company()
    {
        return $this->belongsToMany(Company::class, 'external_dashboard_companies');
    }

    public function external_dashboard_company()
    {
        return $this->hasMany(ExternalDashboardCompany::class);
    }

    public function external_dashboard_log()
    {
        return $this->hasMany(ExternalDashboardLog::class);
    }

    public function version()
    {
        return $this->external_dashboard_version()->where('default', 1)->first();
    }

    public function defaultVersion()
    {
        $data = $this->external_dashboard_version()->where('default', 1)->first();
        return $data->major . '.' . $data->minor . '.' . $data->batch;
    }

    public function external_dashboard_version()
    {
        return $this->hasMany(ExternalDashboardVersion::class);
    }

    public function assignedUser()
    {
        return $this->belongsToMany(User::class, 'external_dashboard_users');
    }

    public function external_dashboard_user()
    {
        return $this->hasMany(ExternalDashboardUser::class);
    }

    public static function getValidationRules()
    {
        return self::$rules;
    }

    public function changeVersion()
    {
        if(in_array(user()->role_id, [1, 10]) || in_array(user()->id, $this->assignedUser->pluck('id')->toArray()))
        {
            return true;
        }
        return false;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($data)
        {
            $data->external_dashboard_company()->delete();
            $data->external_dashboard_category()->delete();
            $data->external_dashboard_log()->delete();
            $data->external_dashboard_version()->delete();
            $data->assignedUser()->delete();
        });
    }
}
