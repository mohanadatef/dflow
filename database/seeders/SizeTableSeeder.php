<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\Size;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ['Nano','Micro', 'Macro', 'Power', 'Mega'];
        foreach ($array as $key => $arr) {
            Size::create([
                'name_en' => $arr,
                'name_ar' => $arr,
                'power'=>$key,
            ]);
        }
    }
}
