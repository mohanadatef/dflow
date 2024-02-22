<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Acl\Entities\Influencer;

class MawthooqCsvFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        executionTime();
        $csvFile = fopen(base_path("database/seeders/influencersMawthooq.csv"), "r");
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
            $influencer = Influencer::where('name_en', $data[0])->orWhere('name_ar', $data[1])->first();
            if($influencer){
                if($data[2] == 'TRUE'){
                    $influencer->update(['mawthooq' => true]);
                }else{
                    $influencer->update(['mawthooq' => false]);

                }
            }

            $this->command->getOutput()->progressAdvance();
            $this->command->getOutput()->writeln("end " . $counter);
            $counter++;
        }
        fclose($csvFile);
    }
}
