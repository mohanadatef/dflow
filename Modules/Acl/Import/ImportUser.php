<?php

namespace Modules\Acl\Import;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportUser implements ToModel, WithStartRow
{
    public  $rows;

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        executionTime();
        try {
            if ($row[0] != null && $row[1] != null) {
                $data = User::where('email', $row[1])->first();
                if (is_null($data)) {
                    $data = User::create(['email' => $row[1], 'name' => $row[0], 'password' => Hash::make('12345678'), 'role_id' => 3]);
                }
            }
            elseif (!$this->containsOnlyNull($row)) {
                $this->rows[] = $row;
            }
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    function containsOnlyNull($input): bool
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }
}
