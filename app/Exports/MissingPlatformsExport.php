<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MissingPlatformsExport implements FromCollection, WithHeadings, WithStartRow
{

    public $data;

    public function headings(): array
    {
        return [
            'Platform EN',
            'Platform AR',
            'Service EN',
            'Service AR',
            'Errors'
        ];
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        foreach ($this->data as $datum) {
            $data [] = [
                'Platform EN'=> $datum[0],
                'Platform AR'=> $datum[1],
                'Service EN'=> $datum[2],
                'Service AR'=> $datum[3],
                'Error' => $datum[4],
            ];

        }
        return collect($data);
    }

    public function startRow(): int
    {
        return 1;
    }
}
