<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreData\Entities\Service;

class ServiceOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = ['Location Visit',
            'Coverage',
            'Home Endorsement',
            'Post',
            'Tweet',
            'Quote',
            'Reels',
            'Retweet',
            'Story',
            'Live',
            'Sponsorship'];
        $x=1;
        foreach($array as $arr)
        {
           $s= Service::where('name_en', 'like', '%'.$arr.'%')->first();
           if($s)
           {
               $s->update(['order'=>$x]);
           }
            $x++;
        }
    }
}
