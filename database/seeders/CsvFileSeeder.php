<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\CompanyIndustry;
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
use Modules\Record\Export\MissingAdRecordsExport;

class CsvFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        executionTime();
        $datasError = [];
        $csvFile = fopen(base_path("database/seeders/AdRecordRecords.csv"), "r");

        $firstLine = true;
        $counter = 1;

        $this->command->getOutput()->progressStart(5000);

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            executionTime();
            $this->command->getOutput()->writeln("start " . $counter);
            $check = true;
            if ($firstLine) {
                $firstLine = false;
                continue;
            }

            if ($data[1] == null || $data[2] == null || $data[3] == null || $data[10] == null || $data[11] == null) {

                $this->command->getOutput()->writeln("error " . $counter);
                $check = false;
            }
            $influencer = $this->setInfluencers($data);
            if (is_null($influencer)) {
                $check = false;
            }
            $service = $this->setService($data);
            if (is_null($service)) {
                $check = false;
            }
            $user = $this->setUser($data);
            if (is_null($user)) {
                $check = false;
            }
            $platform = $this->setPlatform($data);
            if (is_null($platform)) {
                $check = false;
            }
            if ($check) {
                $company = $this->setCompany($data);
                $r = $this->setAdRecord($data, $influencer, $company, $service, $platform, $user);
                if ($r) {
                    $this->command->getOutput()->writeln("good " . $counter);
                } else {
                    $this->command->getOutput()->writeln("bad " . $counter);
                }

            } else {
                if ($data[1] == null) {
                    $data = array_merge($data, ['influencer missing']);
                    $this->command->getOutput()->writeln("error  influencer missing " . $counter);
                } elseif ($data[2] == null) {
                    $data = array_merge($data, ['company missing']);
                    $this->command->getOutput()->writeln("error  company missing " . $counter);
                } elseif ($data[3] == null) {
                    $data = array_merge($data, ['platform missing']);
                    $this->command->getOutput()->writeln("error  platform missing " . $counter);
                } elseif ($data[10] == null) {
                    $data = array_merge($data, ['ad type missing']);
                    $this->command->getOutput()->writeln("error  ad type missing " . $counter);
                } elseif ($data[11] == null) {
                    $data = array_merge($data, ['Promotion Type missing']);
                    $this->command->getOutput()->writeln("error  Promotion Type  missing " . $counter);
                } elseif ($data[1] != null) {
                    $influencer = $this->setInfluencers($data);
                    if (is_null($influencer)) {
                        $data = array_merge($data, ['influencer missing']);
                        $this->command->getOutput()->writeln("error  influencer missing " . $counter);
                    }
                } elseif ($data[10] != null) {
                    $service = $this->setService($data);
                    if (is_null($service)) {
                        $data = array_merge($data, ['service missing']);
                    }
                } elseif ($data[3] != null) {
                    $platform = $this->setPlatform($data);
                    if (is_null($platform)) {
                        $data = array_merge($data, ['platform missing']);
                    }
                } elseif ($data[12] != null) {
                    $user = $this->setUser($data);
                    if (is_null($user)) {
                        $data = array_merge($data, ['user missing']);
                    }
                } else {
                    $this->command->getOutput()->writeln($data);
                }
                $datasError[] = $data;
                $this->command->getOutput()->writeln("error " . $counter);
            }
            $this->command->getOutput()->progressAdvance();
            $this->command->getOutput()->writeln("end " . $counter);
            $counter++;

        }

        fclose($csvFile);
        Excel::store(new MissingAdRecordsExport($datasError), 'missing_ad_records_data.xlsx');
    }

    private function setCompany($data)
    {
        if ($company = Company::where('name_en', $data[2])->orWhere('name_ar', $data[2])->first()) {
            return $company;
        }

        return Company::create([
            'name_en' => $data[2],
            'name_ar' => $data[2],
        ]);
    }

    private function setInfluencers($data)
    {
        return Influencer::where('name_en', $data[1])->orWhere('name_ar', $data[1])->first();
    }

    private function setAdRecord($data, $influencer, $company, $service, $platform, $user)
    {
        $price = DB::table('influencer_service_platforms')
            ->where('influencer_id', $influencer->id)
            ->where('service_id', $service->id)
            ->where('platform_id', $platform->id)
            ->value('price');
        $ad_record = AdRecord::create([
            'influencer_id' => $influencer->id,
            'user_id' => $user->id,
            'company_id' => $company->id,
            'promoted_products' => $data[4],
            'mention_ad' => strtolower($data[13]) == 'yes' ? 1 : 0,
            'gov_ad' => strtolower($data[8]) == 'yes' ? 1 : 0,
            'date' => date('Y-m-d', strtotime($data[0])),
            'notes' => $data[15],
            'price' => $price ?? 0,
            'platform_id' => $platform->id,
            'service_id' => $service->id,
        ]);
        // set ad record categories
        if ($data[5]) {
            $this->setCategory($ad_record->id, $data[5], $company->id);
        }
        if ($data[6]) {
            $this->setCategory($ad_record->id, $data[6], $company->id);
        }
        if ($data[7]) {
            $this->setCategory($ad_record->id, $data[7], $company->id);
        }
        if ($data[11]) {
            $promotion_type =
                PromotionType::where('name_en', $data[11])->first() ?? PromotionType::create(['name_en' => $data[11], 'name_ar' => $data[11]]);

            AdRecordPromotionType::create([
                'ad_record_id' => $ad_record->id,
                'promotion_type_id' => $promotion_type->id
            ]);
        }
        if ($data[9]) {
            $ad_record->target_market()->sync([Location::where('code', $data[9])->first()->id ?? 1]);
        }
        return $ad_record;
    }

    private function setCategory($ad_record, $data, $company)
    {
        $count = $category = Category::where('name_en', $data)->orWhere('name_ar', $data);
        $count = $count->count();
        if ($count) {
            $category = $category->first();
        } else {
            $category = Category::create(['name_en' => $data, 'name_ar' => $data, 'group' => 'industry']);
        }
        CompanyIndustry::updateORCreate([
            'industry_id' => $category->id,
            'company_id' => $company
        ]);
        AdRecordCategory::updateORCreate([
            'ad_record_id' => $ad_record,
            'category_id' => $category->id
        ]);
    }

    private function setService(array $data)
    {
        return Service::where('name_en', $data[10])->orWhere('name_ar', $data[10])->first();
    }

    private function setPlatform(array $data)
    {
        return Platform::where('name_en', $data[3])->orWhere('name_ar', $data[3])->first();
    }

    private function setUser(array $data)
    {
        return Role::find(3)->users()->where("name", $data[12])->first();
    }
}
