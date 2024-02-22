<?php

namespace Modules\CoreData\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MissingPromotionsExport implements FromCollection, WithHeadings, WithStartRow
{

    public $data;

    public function headings(): array
    {
        return [
            'Promotion Type EN',
            'Promotion Type AR',
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
                'Promotion Type EN'=> $datum[0],
                'Promotion Type AR'=> $datum[1],
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
