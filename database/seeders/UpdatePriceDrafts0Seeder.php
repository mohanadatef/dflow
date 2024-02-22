<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Record\Entities\AdRecordDraftService;

class UpdatePriceDrafts0Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ad_data = AdRecordDraftService::with('ad_record_draft','service.influencer_service_platform')->where('price', 0)->get();
        foreach ($ad_data as $ad) {
            executionTime();
            if ($ad->service){
                  $price=  $ad->service->influencer_service_platform()->where('influencer_id', $ad->ad_record_draft->influencer_id)
                        ->where('platform_id', $ad->ad_record_draft->platform_id)->first()->price ?? 0;
                $ad->update(['price' =>$price ]);
                $ad->ad_record_draft->update(['price'=>$ad->ad_record_draft->price + $price]);
            }
        }
    }
}
