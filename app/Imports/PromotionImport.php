<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\CoreData\Entities\PromotionType;

class PromotionImport implements ToModel, WithStartRow
{
    use SkipsFailures;

    public array $rows = [];

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            executionTime();
            try {
                $checkArray = true;
                if ($row[0] == null || $row[1] == null ) {
                    $checkArray = false;
                }
                if ($checkArray) {
                    $promotion = PromotionType::where('name_en',$row[0])->orWhere('name_ar',$row[1])->count();
                    if($promotion == 0)
                    {
                        PromotionType::create(['name_en'=>$row[0],'name_ar'=>$row[1]]);
                    }
                } elseif (!$this->containsOnlyNull($row)) {
                    if ($row[0] == null || $row[1] == null) {
                        $row = array_merge($row, ['promotion missing']);
                    } else {
                        $row = array_merge($row, ['wrong']);
                    }
                    $this->rows[] = $row;
                }
            } catch (\Exception $e) {
                 //return $e->getMessage();
            }
        });
    }

    function containsOnlyNull($input): bool
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }
}
