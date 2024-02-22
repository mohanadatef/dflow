<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AdRecordAndInfluencerImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new AdRecordImport(),
            1 => new InfluencerImport(),
        ];
    }

}
