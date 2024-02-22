<?php

namespace Modules\Report\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Report\Entities\Report;

class ReportsImport implements ToModel, WithStartRow
{

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Report([
            "name" => $row[0],
            "platform" => $row[1],
            "identifier" => $row[2],
            "type" => $row[3],
            "license_status" => $row[4],
            "status_date" => \Carbon\Carbon::createFromFormat('m/d/Y', $row[5])->format('d-m-Y'),
            "advertised_party" => $row[6],
            "advertise_category" => $row[7],
            "report_date" => \Carbon\Carbon::createFromFormat('m/d/Y', $row[8])->format('d-m-Y'),
            "advertise_url" =>$row[9],
            "image" => $row[10],
        ]);

    }
}
