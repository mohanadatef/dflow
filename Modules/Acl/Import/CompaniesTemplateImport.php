<?php

namespace Modules\Acl\Import;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\CompanyMergeSheetTemplate;
use Modules\Basic\Imports\Import;

class CompaniesTemplateImport extends Import implements ToModel, WithStartRow, WithChunkReading, ShouldQueue
{
    public array $rows = [];

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $error = false;
         if (!$this->containsOnlyNull($row)) {
            $error = true;
            $row = array_merge($row, ['Company name is missing']);
            $this->rows[] = $row;
        }
        if ($error) {
            session()->push('companies', $row);
            $this->rows[] = $row;
        }
        CompanyMergeSheetTemplate::create([
           'company_id' => $row[0],
           'name_en' => $row[1],
           'name_ar' => $row[2]
        ]);
    }
    public function chunkSize(): int
    {
        return 30;
    }
}
