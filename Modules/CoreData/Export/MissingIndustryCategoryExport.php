<?php

namespace Modules\CoreData\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MissingIndustryCategoryExport implements FromCollection, WithHeadings, WithStartRow
{
    public array $data;

    public function headings(): array
    {
        return [
            'Parent Category EN',
            'Parent Category AR',
            'Category EN',
            'Category EN',
            'Errors'
        ];
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        $data = [];

        foreach ($this->data as $datum) {
            $data [] = [
                'ParentCategory EN'=> $datum[0],
                'Parent Category AR'=> $datum[1],
                'Category EN'=> $datum[2],
                'Category AR'=> $datum[3],
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
