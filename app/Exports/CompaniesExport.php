<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompaniesExport implements FromCollection, WithHeadings, WithStartRow
{
    public array $data;

    public function headings(): array
    {
        return [
            'Name',
            'Link',
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
                'Name'=> $datum[0],
                'Link'=> $datum[1],
                'Error' => $datum[2],
            ];
        }
        return collect($data);
    }

    public function startRow(): int
    {
        return 1;
    }
}
