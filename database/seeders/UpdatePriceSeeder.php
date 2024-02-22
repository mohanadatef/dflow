<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Record\Entities\AdRecordService;

class UpdatePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ad_data = AdRecordService::with('ad_record','service.influencer_service_platform')->get();
        foreach ($ad_data as $ad) {
            executionTime();
            $price=  $ad->service->influencer_service_platform()->where('influencer_id', $ad->ad_record->influencer_id)
                ->where('platform_id', $ad->ad_record->platform_id)->first()->price ?? 0;
            $ad->update(['price' =>$price ]);
            $ad->ad_record->update(['price'=>$ad->ad_record->price + $price]);
        }
    }
}
