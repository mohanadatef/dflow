<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\Platform;
use Modules\CoreData\Entities\Service;

class PlatformServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service_array = [];
        /*1*/
        $service = Service::create([
            'name_en' => "Location Visit",
            'name_ar' => "Location Visit",
        ]);
        $service_array[] = $service->id;
        /*2*/
        $service = Service::create([
            'name_en' => "Home Endorsement",
            'name_ar' => "Home Endorsement",
        ]);
        $service_array[] = $service->id;
        /*1*/
        $platform = Platform::create([
            'name_en' => "Snapchat",
            'name_ar' => "Snapchat",
        ]);
        $platform->service()->sync((array)$service_array);
        $service_array = [];
        $service = Service::create([
            'name_en' => "Tweet",
            'name_ar' => "Tweet",
        ]);
        $service_array[] = $service->id;
        $service = Service::create([
            'name_en' => "Quote Tweet",
            'name_ar' => "Quote Tweet",
        ]);
        $service_array[] = $service->id;
        $service = Service::create([
            'name_en' => "Retweet",
            'name_ar' => "Retweet",
        ]);
        $service_array[] = $service->id;
        $platform = Platform::create([
            'name_en' => "Twitter",
            'name_ar' => "Twitter",
        ]);
        $platform->service()->sync((array)$service_array);
        $service_array = [];
        $service = Service::create([
            'name_en' => "Story",
            'name_ar' => "Story",
        ]);
        $service_array[] = $service->id;
        $service = Service::create([
            'name_en' => "Reel",
            'name_ar' => "Reel",
        ]);
        $service_array[] = $service->id;
        $service = Service::create([
            'name_en' => "Post",
            'name_ar' => "Post",
        ]);
        $service_array[] = $service->id;
        $platform = Platform::create([
            'name_en' => "Instagram",
            'name_ar' => "Instagram",
        ]);
        $platform->service()->sync((array)$service_array);
        $service_array = [];
        $service = Service::create([
            'name_en' => "Live",
            'name_ar' => "Live",
        ]);
        $service_array[] = $service->id;
        $service = Service::where('name_en', "Post")->first();
        $service_array[] = $service->id;
        $platform = Platform::create([
            'name_en' => "TikTok",
            'name_ar' => "TikTok",
        ]);
        $platform->service()->sync((array)$service_array);
        $service_array = [];
        $service = Service::where('name_en', "Post")->first();
        $service_array[] = $service->id;
        $platform = Platform::create([
            'name_en' => "FaceBook",
            'name_ar' => "FaceBook",
        ]);
        $platform->service()->sync((array)$service_array);
    }
}
