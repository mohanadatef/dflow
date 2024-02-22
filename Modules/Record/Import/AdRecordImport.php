<?php

namespace Modules\Record\Import;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;
use Modules\Acl\Entities\Role;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\Location;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\PromotionType;
use Modules\CoreData\Entities\Service;
use Modules\Record\Entities\AdRecord;
use Modules\Record\Entities\AdRecordCategory;
use Modules\Record\Entities\AdRecordPromotionType;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AdRecordImport implements ToModel, WithStartRow, WithChunkReading, ShouldQueue
{
    public array $rows;

    public function __construct(){}

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $row = array_slice($row, 0, 16, true);
        try {
            $check = true;
            if ($row[1] == null || $row[2] == null || $row[5] == null || $row[3] == null || $row[10] == null || $row[11] == null) {
                $check = false;
            }
            $influencer = $this->setInfluencers($row);
            if (is_null($influencer)) {$check = false;}

            $service = $this->setService($row);
            if (is_null($service)) {$check = false;}

            $platform = $this->setPlatform($row);
            if (is_null($platform)) {$check = false;}

            $user = $this->setUser($row);
            if (is_null($user)) {$check = false;}

            $company = $this->setCompany($row);
            if (is_null($company)) {$check = false;}

            if ($check) {
                $this->setAdRecord($row, $influencer, $company, $service, $platform, $user);
            }
            elseif (!$this->containsOnlyNull($row)) {
                if ($row[1] == null) {
                    $row = array_merge($row, ['influencer missing']);
                }
                if ($row[2] == null) {$row = array_merge($row, ['company missing']);}
                if ($row[5] == null) {$row = array_merge($row, ['category missing']);}
                if ($row[3] == null) {$row = array_merge($row, ['platform missing']);}
                if ($row[10] == null) {$row = array_merge($row, ['ad type missing']);}
                if ($row[11] == null) {$row = array_merge($row, ['Promotion Type missing']);}
                if ($row[1] != null) {
                    if (is_null($influencer)) {
                    $row = array_merge($row, ['influencer does not exist']);
                    }
                }
                if ($row[2] != null) {
                    if (is_null($company)) {
                        $row = array_merge($row, ['Company does not exist']);
                    }
                }
                if ($row[10] != null) {
                    if (is_null($service)) {
                    $row = array_merge($row, ['service does not exist']);
                    }
                }
                if ($row[3] != null) {
                    if (is_null($platform)) {
                    $row = array_merge($row, ['platform does not exist']);
                    }
                }
                if ($row[12] != null) {
                    if (is_null($user)) {
                    $row = array_merge($row, ['user does not exist']);
                    }
                }
                session()->push('rows', $row);
                $this->rows[] = $row;
            }
        }
        catch (\Exception $e) {
            $row = array_merge($row,[$e->getMessage()]);
            session()->push('rows', $row);
            $this->rows[] = $row;
        }
    }

    private function setCompany($row)
    {
        if ($company = Company::where('name_en', $row[2])->orWhere('name_ar', $row[2])->first()) {
            return $company;
        }
    }

    private function setInfluencers($row)
    {
        return Influencer::where('name_en', $row[1])->orWhere('name_ar', $row[1])->first();
    }

    private function setAdRecord($row, $influencer, $company, $service, $platform, $user)
    {
        $price = DB::table('influencer_service_platforms')
            ->where('influencer_id', $influencer->id)
            ->where('service_id', $service->id)
            ->where('platform_id', $platform->id)
            ->value('price')
        ;

        if (is_int($row[0])) {
            $date = Carbon::instance(Date::excelToDateTimeObject($row[0]));
        } else {
            $row[0] = str_replace("\\", "/", $row[0]);
            $date = date('Y-m-d', strtotime($row[0]));
        }

        $ad_record = AdRecord::create([
            'influencer_id' => $influencer->id,
            'user_id' => $user->id,
            'company_id' => $company->id,
            'promoted_products' => $row[4],
            'mention_ad' => strtolower($row[13]) == 'yes' ? 1 : 0,
            'gov_ad' => strtolower($row[8]) == 'yes' ? 1 : 0,
            'date' => $date,
            'notes' => $row[15],
            'price' => $price ?? 0,
            'platform_id' => $platform->id,
            'service_id' => $service->id,
        ]);
        // set ad record categories

        $this->setCategories($row,$ad_record);
        if ($row[11]) {
            $promotion_type =
                PromotionType::where('name_en', $row[11])->first() ?? PromotionType::create(['name_en' => $row[11], 'name_ar' => $row[11]]);

            AdRecordPromotionType::create([
                'ad_record_id' => $ad_record->id,
                'promotion_type_id' => $promotion_type->id
            ]);
        }
        if ($row[9]) {
            $ad_record->target_market()->sync([Location::where('code', $row[9])->first()->id ?? 1]);
        }
    }

    private function setCategory($ad_record, $row): void
    {
        $categoryModel = Category::where('name_en', $row)->orWhere('name_ar', $row);
        $count = $categoryModel->count();
        if ($count) {
            $category = $categoryModel->first();
            AdRecordCategory::updateORCreate([
                'ad_record_id' => $ad_record,
                'category_id' => $category->id
            ]);
        }
        $categoryModel->first();
    }

    private function setService(array $row)
    {
        return Service::where('name_en', $row[10])->orWhere('name_ar', $row[10])->first();
    }

    private function setPlatform(array $row)
    {
        return Platform::where('name_en', $row[3])->orWhere('name_ar', $row[3])->first();
    }

    private function setUser(array $row)
    {
        return Role::find(3)->users()->where("name", $row[12])->first();
    }

    function containsOnlyNull($input): bool
    {
        return empty(array_filter($input, function ($a) {
            return $a !== null;
        }));
    }

    public function chunkSize(): int
    {
        return 30;
    }

    private function setCategories($row,$ad_record)
    {
        if ($row[5]) {
            $this->setCategory($ad_record->id, $row[5]);
        }
        if ($row[6]) {
            $this->setCategory($ad_record->id, $row[6]);
        }
        if ($row[7]) {
            $this->setCategory($ad_record->id, $row[7]);
        }
    }
}
