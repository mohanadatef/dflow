<?php

namespace Database\Seeders;

use Modules\Acl\Entities\InfluencerGroup;
use Illuminate\Database\Seeder;

class InfluencerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InfluencerGroup::create([
            'name_en' => 'Marketing',
            'name_ar' => 'التسويق',
        ]);
    }
}
