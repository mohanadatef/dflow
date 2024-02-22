<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Influencer;
use Modules\CoreData\Entities\Size;
use Modules\CoreData\Entities\Location;

class InfluencerCsvFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        executionTime();

        $csvFile = fopen(base_path("database/seeders/influencers.csv"), "r");

        $firstLine = true;
        $secandLine = true;
        $counter = 1;

        $this->command->getOutput()->progressStart(1);

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            executionTime();
            if ($counter < 1) {
                $counter++;
                continue;
            }

            if ($firstLine) {
                $firstLine = false;
                continue;
            }
            if ($secandLine) {
                $secandLine = false;
                continue;
            }

            $this->setInfluencers($data);
            $this->command->getOutput()->progressAdvance();
            $counter++;
        }

        fclose($csvFile);
    }

    private function setInfluencers($data)
    {
        $faker = \Faker\Factory::create();
        if ($data[11]) {
            $city = Location::where('name_en', $data[11])->orWhere('name_ar', $data[11])->orWhere('name_fr', $data[11])->first();
            if ($city) {
                $country = $city->country_id;
                $city = $city->id;
            } else {
                $country = Location::inRandomOrder()->first()->id;
                $city = Location::where('country_id', $country)->inRandomOrder()->first()->id ?? 1;
            }
        } else {
            $country = Location::inRandomOrder()->first()->id;
            $city = Location::where('country_id', $country)->inRandomOrder()->first()->id ?? 1;
        }

        $influencer = Influencer::where('name_en', $data[0])->orWhere('name_ar', $data[1])->first();

        if ($influencer) {
            return $influencer;
        }

        $influencer = Influencer::create([
            'name_en' => $data[0] ?? $data[1],
            'name_ar' => $data[1] ?? $data[0],
            'gender' => $data[8],
            'birthdate' => $faker->dateTimeBetween('1970-01-01', '2012-12-31'),
            'country_id' => $country,
            'city_id' => $city,
            'nationality_id' => $country,
            'active' => $data[38] == TRUE ? 1 : 0,
        ]);
        $platform = [];
        $influencer_service_platform = [];
        $influencer_follower_platform = [];
        if ($data[2]) {
            $platform [] = 1;
            if ($data[14]) {
                $influencer_service_platform [] = ['platform_id' => 1, 'price' => $data[14], 'service_id' => 2];
            }
            if ($data[15]) {
                $influencer_service_platform [] = ['platform_id' => 1, 'price' => $data[15], 'service_id' => 2];
            }
            if ($data[16]) {
                $size = Size::where('name_en', $data[16])->first();
                if (is_null($size)) {
                    $size = Size::create(['name_en' => $data[16], 'name_ar' => $data[16]]);
                }
                $influencer_follower_platform [] = ['platform_id' => 1, 'followers' => 0, 'url' => $data[2], 'size_id' => $size->id];
            }
        }
        if ($data[3]) {
            $platform [] = 3;
            if ($data[19]) {
                $influencer_service_platform [] = ['platform_id' => 3, 'price' => $data[19], 'service_id' => 6];
            }
            if ($data[20]) {
                $influencer_service_platform [] = ['platform_id' => 3, 'price' => $data[20], 'service_id' => 8];
            }
            if ($data[21]) {
                $size = Size::where('name_en', $data[21])->first();
                if (is_null($size)) {
                    $size = Size::create(['name_en' => $data[21], 'name_ar' => $data[21]]);
                }
                $influencer_follower_platform [] = ['platform_id' => 3, 'followers' => 0, 'url' => $data[3], 'size_id' => $size->id];
            }
        }
        if ($data[4]) {
            $platform [] = 4;
            if ($data[24]) {
                $influencer_service_platform [] = ['platform_id' => 4, 'price' => $data[24], 'service_id' => 8];
            }
            if ($data[25]) {
                $influencer_service_platform [] = ['platform_id' => 4, 'price' => $data[25], 'service_id' => 9];
            }
            if ($data[26]) {
                $size = Size::where('name_en', $data[26])->first();
                if (is_null($size)) {
                    $size = Size::create(['name_en' => $data[26], 'name_ar' => $data[26]]);
                }
                $influencer_follower_platform [] = ['platform_id' => 4, 'followers' => 0, 'url' => $data[4], 'size_id' => $size->id];
            }
        }
        if ($data[5]) {
            $platform [] = 2;
            if ($data[29]) {
                $influencer_service_platform [] = ['platform_id' => 2, 'price' => $data[29], 'service_id' => 4];
            }
            if ($data[30]) {
                $influencer_service_platform [] = ['platform_id' => 2, 'price' => $data[30], 'service_id' => 5];
            }
            if ($data[31]) {
                $size = Size::where('name_en', $data[31])->first();
                if (is_null($size)) {
                    $size = Size::create(['name_en' => $data[31], 'name_ar' => $data[31]]);
                }
                $influencer_follower_platform [] = ['platform_id' => 2, 'followers' => 0, 'url' => $data[5], 'size_id' => $size->id];
            }
        }
        if ($data[6]) {
            $platform [] = 5;
            if ($data[34]) {
                $influencer_service_platform [] = ['platform_id' => 5, 'price' => $data[34], 'service_id' => 8];
            }
            if ($data[35]) {
                $size = Size::where('name_en', $data[35])->first();
                if (is_null($size)) {
                    $size = Size::create(['name_en' => $data[35], 'name_ar' => $data[35]]);
                }
                $influencer_follower_platform [] = ['platform_id' => 5, 'followers' => 0, 'url' => $data[5], 'size_id' => $size->id];
            }
        }
        if (count($platform)) {
            $influencer->platform()->sync($platform);
            if (count($influencer_service_platform)) {
                foreach ($influencer_service_platform as $service) {
                    $influencer->influencer_service_platform()->create($service);
                }
            }
            if (count($influencer_follower_platform)) {
                foreach ($influencer_follower_platform as $follower) {
                    $influencer->influencer_follower_platform()->create($follower);
                }
            }
        }
    }

}
