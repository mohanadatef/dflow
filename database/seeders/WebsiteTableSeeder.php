<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\CoreData\Entities\Website;
use Modules\CoreData\Entities\WebsiteKey;

class WebsiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            ['name_en' => 'General', 'name_ar' =>'General', 'active' => 1],
            ['name_en' => 'Website', 'name_ar' =>'Website', 'active' => 1],
            ['name_en' => 'Facebook', 'name_ar' =>'Facebook', 'active' => 1],
            ['name_en' => 'Instagram', 'name_ar' =>'Instagram', 'active' => 1],
            ['name_en' => 'Snapchat', 'name_ar' =>'Snapchat', 'active' => 1],
            ['name_en' => 'Whatsapp', 'name_ar' =>'Whatsapp', 'active' => 1],
            ['name_en' => 'App Store', 'name_ar' =>'App Store', 'active' => 1],
            ['name_en' => 'Google Play', 'name_ar' =>'Google Play', 'active' => 1],
            ['name_en' => 'Salla', 'name_ar' =>'Salla', 'active' => 1],
            ['name_en' => 'Amazon', 'name_ar' =>'Amazon', 'active' => 1],
            ['name_en' => 'Aliexpress', 'name_ar' =>'Aliexpress', 'active' => 1],
        ];

        $keys = [
            ['website_id' => 1, 'key' =>'general'],
            ['website_id' => 2, 'key' =>'website'],
            ['website_id' => 3, 'key' =>'facebook'],
            ['website_id' => 4, 'key' =>'instagram'],
            ['website_id' => 5, 'key' =>'snapchat'],
            ['website_id' => 6, 'key' =>['whatsapp','wa']],
            ['website_id' => 7, 'key' =>['store', 'app', 'appstore']],
            ['website_id' => 8, 'key' =>['play','google','googleplay']],
            ['website_id' => 9, 'key' =>'salla'],
            ['website_id' => 10, 'key' =>'amazon'],
            ['website_id' => 11, 'key' =>'aliexpress'],
        ];

        DB::table('websites')->insert($sites);
        foreach ($keys as $key){
            if(is_array($key['key'])){
                foreach ($key['key'] as $va){
                    WebsiteKey::create([
                        'website_id' => $key['website_id'],
                        'key' => $va
                    ]);
                }
            }
            else {
                WebsiteKey::create([
                    'website_id' => $key['website_id'],
                    'key' => $key['key']
                ]);
            }
        }
    }
}
