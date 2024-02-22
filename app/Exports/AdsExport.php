<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Modules\Record\Entities\AdRecord;

class AdsExport implements FromQuery
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return AdRecord::query();
    }
}
