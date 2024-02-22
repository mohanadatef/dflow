<?php

namespace Modules\Acl\Import;

use Maatwebsite\Excel\Concerns\WithStartRow;
class InfluencerGroupCreate implements  WithStartRow
{
    public  $rows;

    public function startRow(): int
    {
        return 0;
    }

    public function array()
    {
        executionTime();
    }

    function containsOnlyNull($input): bool
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }
}
