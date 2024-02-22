<?php

namespace Modules\CoreData\Import;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\CoreData\Entities\Category;

class CategoriesImport implements ToModel, WithStartRow
{
    public array $rows = [];

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $required_rows = array_slice($row, 0, 2, true);

        // todo refactor the code to remove the redundant code
        return DB::transaction(function () use ($row,$required_rows) {
            try {
                if (!in_array(null,$required_rows)) {
                    $parent_cat = Category::where('group', '=', 'industry')
                        ->where(function($query) use ($row) {
                            $query
                                ->where('name_en', $row[0])
                                ->orWhere('name_ar',$row[1])
                            ;
                        })
                        ->first()
                    ;
                    if (is_null($parent_cat)) {
                        $parent_cat = Category::create(
                            [
                                'parent_id' => 0,
                                'name_en' => $row[0],
                                'name_ar' => $row[1],
                                'group' => 'industry',
                                'active' => 1,
                            ]
                        );
                    }
                    if ($row[2] && $row[3]){
                        $cat = Category::where('group', '=', 'industry')
                            ->where(function($query) use ($row) {
                                $query
                                    ->where('name_en', $row[2])
                                    ->orWhere('name_ar',$row[3])
                                ;
                            })
                            ->first()
                        ;
                        if (is_null($cat)) {
                            Category::create(
                                [
                                    'parent_id' => $parent_cat->id,
                                    'name_en' => $row[2],
                                    'name_ar' => $row[3],
                                    'group' => 'industry',
                                    'active' => 1,
                                ]
                            );
                        }
                    }
                }
                elseif (!$this->containsOnlyNull($row)) {
                    $row = array_merge($row, ['category missing']);
                    $this->rows[] = $row;
                }
            }
            catch (\Exception $e) {
                $row = array_merge($row,[$e->getMessage()]);
                $this->rows[] = $row;
            }
        });
    }

    function containsOnlyNull($input): bool
    {
        return empty(array_filter(
            $input,
            function ($a) {return $a !== null;}
        ));
    }
}
