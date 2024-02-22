<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\Influencer;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MissingAdRecordsExport implements FromCollection, WithHeadings, WithStartRow
{
    public $data;

    public function headings(): array
    {
        return [
            'Date',
            'Influencer Name',
            'Company',
            'Platform',
            'Promoted products',
            'Category 1',
            'Category 2',
            'Category 3',
            'Gov. entity?',
            'Target Market',
            'Ad Type',
            'Promotion Type',
            'Agent',
            'Does AD word was mentioned ?',
            'Discount',
            'Notes',
            'Errors'
        ];
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        $data = [];

        foreach ($this->data as $datum) {
            $data [] = [
                'Date' => $datum[0],
                'Influencer Name' => $datum[1],
                'Company' => $datum[2],
                'Platform' => $datum[3],
                'Promoted products' => $datum[4],
                'Category 1' => $datum[5],
                'Category 2' => $datum[6],
                'Category 3' => $datum[7],
                'Gov. entity?' => $datum[8],
                'Target Market' => $datum[9],
                'Ad Type' => $datum[10],
                'Promotion Type' => $datum[11],
                'Agent' => $datum[12],
                'Does AD word was mentioned ?' => $datum[13],
                'Discount' => $datum[14],
                'Notes' => $datum[15],
                'Errors' => $datum[16] ?? ""
            ];
        }

        return collect($data);
    }

    public function startRow(): int
    {
        return 1;
    }
}
