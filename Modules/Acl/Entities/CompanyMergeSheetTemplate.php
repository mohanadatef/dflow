<?php

namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyMergeSheetTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name_en', 'name_ar', 'merge_id_sheet', 'merge_id_system'];
    protected $table = 'company_merge_sheet_templates';
    public $timestamps = true;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
