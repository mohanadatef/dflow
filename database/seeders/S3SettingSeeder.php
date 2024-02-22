<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class S3SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['key' => 'AWS_ACCESS_KEY_ID', 'value' => 'AKIAYVEQJM3HU2ZTBHV7'],
            ['key' => 'AWS_SECRET_ACCESS_KEY', 'value' => '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'],
            ['key' => 'AWS_DEFAULT_REGION', 'value' => 'us-east-1'],
            ['key' => 'AWS_BUCKET', 'value' => 'dflow-smd'],
            ['key' => 'AWS_USE_PATH_STYLE_ENDPOINT', 'value' => 'false'],
        ]);
    }
}
