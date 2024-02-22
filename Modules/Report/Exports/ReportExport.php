<?php

namespace Modules\Report\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Report\Entities\Report;

class ReportExport implements FromCollection
{
    public function headings(): array
    {
        return [
            'id',
            'name',
            'platform',
            'identifier',
            'type',
            'license_status',
            'status_date',
            'advertised_party',
            'advertise_category',
            'report_date',
            'advertise_url',
            'image',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report::all();
    }
}
