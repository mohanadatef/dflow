<?php

namespace Modules\Record\Import;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Acl\Import\InfluencerImport;

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
