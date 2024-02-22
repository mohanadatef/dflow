<?php

namespace Modules\CoreData\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MissingInfluenceCategoryExport implements FromCollection, WithHeadings, WithStartRow
{
    public array $data;

    public function headings(): array
    {
        return [
            'Category EN',
            'Category AR',
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
                'Category EN'=> $datum[0],
                'Category AR'=> $datum[1],
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
