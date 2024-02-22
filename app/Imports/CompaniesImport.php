<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanyIndustry;
use Modules\CoreData\Entities\Category;

class CompaniesImport extends Import implements ToModel, WithStartRow, WithChunkReading, ShouldQueue
{
    public array $rows = [];

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        /*return DB::transaction(function () use ($row) {
            try {*/
        $import = true;
        $error = false;
        $category = null;
        if ($row[0] != null && $row[1] != null) {
            if ($row[3] != null) {
                $category = Category::where('group', 'industry')
                    ->where(function ($query) use ($row) {
                        $query->where('name_en', $row[3])
                            ->orWhere('name_ar', $row[3]);
                    })->first();
                if (!$category) {
                    $import = false;
                }
            }
            if ($import) {
                // extract the company
                $company = Company::
                where('name_en', $row[0])->where('name_ar', $row[1])
                    ->first();
                if (is_null($company)) {
                    if (!str_contains($row[2], "http")) $row[2] = "https://" . $row[2];
                    $company = Company::create(
                        [
                            'name_en' => $row[0],
                            'name_ar' => $row[1],
                            'link' => filter_var($row[2], FILTER_VALIDATE_URL) ? $row[2] : null,
                            'active' => 1,
                        ]
                    );
                }else{
                    $error = true;
                    $row = array_merge($row, ['dublicat company']);
                    $this->rows[] = $row;
                }
                if ($category && $company) {
                    CompanyIndustry::updateOrCreate([
                        'industry_id' => $category->id,
                        'company_id' => $company->id
                    ]);
                }
            } else {
                $error = true;
                $row = array_merge($row, ['Category not correct']);
                $this->rows[] = $row;
            }
        } elseif (!$this->containsOnlyNull($row)) {
            $error = true;
            $row = array_merge($row, ['Company name is missing']);
            $this->rows[] = $row;
        }
        /*}*/
        /*catch (\Exception $e) {
            $error = true;
            $row = array_merge($row,[$e->getMessage()]);
            $this->rows[] = $row;
        }*/
        if ($error) {
            session()->push('companies', $row);
            $this->rows[] = $row;
        }
        /*});*/
    }
    public function chunkSize(): int
    {
        return 30;
    }
}
