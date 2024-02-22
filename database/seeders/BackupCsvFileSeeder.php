<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Company;
use Modules\Acl\Entities\Influencer;
use Modules\CoreData\Entities\Location;
use Modules\Record\Entities\AdRecord;
use Modules\CoreData\Entities\Service;
use Modules\CoreData\Entities\Category;
use Modules\CoreData\Entities\Platform;
use Modules\Acl\Entities\CompanyIndustry;
use Modules\CoreData\Entities\PromotionType;
use Modules\Record\Entities\AdRecordCategory;
use Modules\Record\Entities\AdRecordPromotionType;
use Modules\Record\Entities\AdRecordTargetMarket;

class BackupCsvFileSeeder extends Seeder
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
        $csvFile = fopen(base_path("database/seeders/ad_records_backup.csv"), "r");
        $firstLine = true;
        $counter = 1;
        $this->command->getOutput()->progressStart(5000);
        while(($data = fgetcsv($csvFile, 2000, ",")) !== false)
        {
            executionTime();
            $this->command->getOutput()->writeln("start " . $counter);
            if($firstLine)
            {
                $firstLine = false;
                continue;
            }
            $company = $this->setCompany($data);
            $influencer = $this->setInfluencers($data);
            $service = $this->setService($data);
            $platform = $this->setPlatform($data);
            $user = $this->setUser($data);
            $ad = AdRecord::find($data[1]);
            if($ad)
            {
                $this->command->getOutput()->writeln("update " . $counter);
                $this->setAdRecordUpdate($data, $influencer, $company, $service, $platform, $user, $ad);
            }else
            {
                $this->command->getOutput()->writeln("create " . $counter);
                $this->setAdRecordCreate($data, $influencer, $company, $service, $platform, $user);
            }
            $this->command->getOutput()->progressAdvance();
            $this->command->getOutput()->writeln("end " . $counter);
            $counter++;
        }
        fclose($csvFile);
    }

    private function setCompany($data)
    {
        if($company = Company::where('name_en', $data[4])->orWhere('name_ar', $data[5])->first())
        {
            return $company;
        }
        $company = Company::create([
            'name_en' => $data[4],
            'name_ar' => $data[5],
        ]);
        $this->setCategory(null, $data[14], false, $company->id);
        return $company;
    }

    private function setInfluencers($data)
    {
        if($influencer = Influencer::where('name_en', $data[2])->orWhere('name_ar', $data[2])->first())
        {
            return $influencer;
        }
        return Influencer::create([
            'name_en' => $data[2],
            'name_ar' => $data[2],
            'influencer_group_id' => 1,
        ]);
    }

    private function setAdRecordCreate($data, $influencer, $company, $service, $platform, $user)
    {
        $price = DB::table('influencer_service_platforms')
            ->where('influencer_id', $influencer->id)
            ->where('service_id', $service->id)
            ->where('platform_id', $platform->id)
            ->value('price');
        $ad_record = AdRecord::create([
            'id' => $data[1],
            'influencer_id' => $influencer->id,
            'user_id' => $user->id,
            'company_id' => $company->id,
            'promoted_products' => $data[6],
            'promoted_offer' => $data[7],
            'mention_ad' => strtolower($data[8]) == 'Yes' || strtolower($data[8]) == 'yes' ? 1 : 0,
            'gov_ad' => strtolower($data[9]) == 'Yes' || strtolower($data[9]) == 'yes' ? 1 : 0,
            'date' => date('Y-m-d', strtotime($data[0])),
            'notes' => $data[10],
            'price' => $price ?? 0,
            'platform_id' => $platform->id,
            'service_id' => $service->id,
        ]);
        $this->setCategory($ad_record->id, $data[14], false);
        $this->setPromotionType($ad_record->id, $data[16]);
        $this->setTarget_market($ad_record->id, $data[15]);
        return $ad_record;
    }

    private function setAdRecordUpdate($data, $influencer, $company, $service, $platform, $user, $ad)
    {
        $price = DB::table('influencer_service_platforms')
            ->where('influencer_id', $influencer->id)
            ->where('service_id', $service->id)
            ->where('platform_id', $platform->id)
            ->value('price');
        $ad_record = $ad->update([
            'influencer_id' => $influencer->id,
            'user_id' => $user->id,
            'company_id' => $company->id,
            'promoted_products' => $data[6],
            'promoted_offer' => $data[7],
            'mention_ad' => strtolower($data[8]) == 'Yes' || strtolower($data[8]) == 'yes' ? 1 : 0,
            'gov_ad' => strtolower($data[9]) == 'Yes' || strtolower($data[9]) == 'yes' ? 1 : 0,
            'notes' => $data[10],
            'price' => $price ?? 0,
            'platform_id' => $platform->id,
            'service_id' => $service->id,
        ]);
        $this->setCategory($ad->id, $data[14], true);
        $this->setPromotionType($ad->id, $data[16], true);
        $this->setTarget_market($ad->id, $data[15], true);
        return $ad_record;
    }

    private function setCategory($ad_record = null, $data, $type = false, $company = null)
    {
        $categoryArray = explode(' - ', $data);
        foreach($categoryArray as $c)
        {
            $count = $category = Category::where('name_en', $c)->orWhere('name_ar', $c);
            $count = $count->count();
            if($count)
            {
                $category = $category->first();
            }else
            {
                $category = Category::create(['name_en' => $c, 'name_ar' => $c, 'group' => 'industry_parent']);
            }
            if($ad_record)
            {
                if($type)
                {
                    AdRecordCategory::where('ad_record_id', $ad_record)->delete();
                    AdRecordCategory::create([
                        'ad_record_id' => $ad_record,
                        'category_id' => $category->id
                    ]);
                }else
                {
                    AdRecordCategory::updateORCreate([
                        'ad_record_id' => $ad_record,
                        'category_id' => $category->id
                    ]);
                }
            }else
            {
                CompanyIndustry::create([
                    'industry_id' => $category->id,
                    'company_id' => $company
                ]);
            }
        }
    }

    private function setPromotionType($ad_record, $data, $type = false)
    {
        $promotion_typeArray = explode(' - ', $data);
        foreach($promotion_typeArray as $p)
        {
            $count = $promotion_type = PromotionType::where('name_en', $p)->orWhere('name_ar', $p);
            $count = $count->count();
            if($count)
            {
                $promotion_type = $promotion_type->first();
            }else
            {
                $promotion_type = PromotionType::create(['name_en' => $p, 'name_ar' => $p, 'group' => 'industry_parent']);
            }
        }
        if($type)
        {
            AdRecordPromotionType::where('ad_record_id', $ad_record)->delete();
            AdRecordPromotionType::create([
                'ad_record_id' => $ad_record,
                'promotion_type_id' => $promotion_type->id
            ]);
        }else
        {
            AdRecordPromotionType::updateORCreate([
                'ad_record_id' => $ad_record,
                'promotion_type_id' => $promotion_type->id
            ]);
        }
    }

    private function setTarget_market($ad_record, $data, $type = false)
    {
        $promotion_typeArray = explode(' - ', $data);
        foreach($promotion_typeArray as $p)
        {
            $country = Location::where('name_en', $p)->first();
        }
        if($type)
        {
            AdRecordTargetMarket::where('ad_record_id', $ad_record)->delete();
            AdRecordTargetMarket::create([
                'ad_record_id' => $ad_record,
                'country_id' => $country->id
            ]);
        }else
        {
            AdRecordTargetMarket::updateORCreate([
                'ad_record_id' => $ad_record,
                'country_id' => $country->id
            ]);
        }
    }

    private function setService(array $data)
    {
        if($service = Service::where('name_en', $data[13])->orWhere('name_ar', $data[13])->first())
        {
            return $service;
        }
        return Service::create([
            'name_en' => $data[13],
            'name_ar' => $data[13],
        ]);
    }

    private function setPlatform(array $data)
    {
        if($platform = Platform::where('name_en', $data[12])->orWhere('name_ar', $data[12])->first())
        {
            return $platform;
        }
        return Platform::create([
            'name_en' => $data[13],
            'name_ar' => $data[13],
        ]);
    }

    private function setUser(array $data)
    {
        if($user = User::where('name', 'like', '%' . $data[3] . '%')->first())
        {
            return $user;
        }
        return User::create([
            'name' => $data[3],
            'email' => str_replace(' ', '', $data[3] . '@test.com'),
            'password' => Hash::make($data[3] . '@test.com'),
        ]);
    }
}
