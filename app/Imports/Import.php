<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\CoreData\Entities\Category;

class Import
{
    function containsOnlyNull($input): bool
    {
        return empty(array_filter(
            $input,
            function ($a) {return $a !== null;}
        ));
    }
}
