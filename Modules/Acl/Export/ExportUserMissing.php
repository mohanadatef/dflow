<?php

namespace Modules\Acl\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\Influencer;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUserMissing implements FromCollection, WithHeadings, WithStartRow
{
    public $data;

    public function headings(): array
    {
        return [
            'name',
            'email',
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
                'name' => $datum[0],
                'email' => $datum[1],
                'Errors' => $datum[2] ?? ""
            ];
        }

        return collect($data);
    }

    public function startRow(): int
    {
        return 1;
    }
}
