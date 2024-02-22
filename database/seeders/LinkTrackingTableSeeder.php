<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\LinkTracking;
use Illuminate\Support\Str;

class LinkTrackingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LinkTracking::create([
            'link_id' => Str::random(10),
            "destination" => "https://www.facebook.com/",
            "title" => "facebook",
            "ios_url" => "https://www.facebook.com/ios",
            "android_url" => "https://www.facebook.com/android",
            "windows_url" => "https://www.facebook.com/windows",
            "linux_url" => "https://www.facebook.com/linux",
            "mac_url" => "https://www.facebook.com/mac",
            'user_id' => 1,
            "note" => "Note",
        ]);
    }
}
