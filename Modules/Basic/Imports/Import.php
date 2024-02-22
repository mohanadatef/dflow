<?php

namespace Modules\Basic\Imports;

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
