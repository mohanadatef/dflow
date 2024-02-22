<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\PlatformService;
use Modules\CoreData\Entities\Service;

class PlatformImport implements ToModel, WithStartRow, WithChunkReading
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
        executionTime();
        $row = array_slice($row, 0, 4, true);
        try {
            $checkArray = true;
            if ($row[0] == null || $row[1] == null || $row[2] == null || $row[3] == null) {
                $checkArray = false;
            }
            if ($checkArray) {
                $service = Service::where('name_en',$row[2])->orWhere('name_ar',$row[3])->first();
                if(!$service)
                {
                    $service = Service::create(['name_en'=>$row[2],'name_ar'=>$row[3]]);
                }
                $platform = Platform::where('name_en',$row[0])->orWhere('name_ar',$row[1])->first();
                if(!$platform)
                {
                    $platform = Platform::create(['name_en'=>$row[0],'name_ar'=>$row[1],'order'=>0]);
                }
                PlatformService::create([
                    'platform_id' => $platform->id,
                    'service_id' => $service->id
                ]);
            } elseif (!$this->containsOnlyNull($row)) {
                    if ($row[0] == null || $row[1] == null) {
                        $row = array_merge($row, ['platform missing']);
                    } elseif ($row[2] == null || $row[3] == null) {
                        $row = array_merge($row, ['service missing']);
                    } else {
                        $row = array_merge($row, ['wrong']);
                    }
                    $this->rows[] = $row;
            }
        }
        catch (\Exception $e) {
            $row = array_merge($row, [$e->getMessage()]);
            $this->rows[] = $row;
        }
    }

    function containsOnlyNull($input): bool
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }

    /**
     * must be used for big files issues
     * @return int
     */
    public function chunkSize(): int
    {
        return 10;
    }
}
