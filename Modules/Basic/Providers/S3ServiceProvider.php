<?php

namespace Modules\Basic\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class S3ServiceProvider extends ServiceProvider
{
    public function register(){}

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
        if(Schema::hasTable('settings'))
        {
            $config = config('filesystems.disks');
            $config['s3'] = [
                'driver' => 's3',
                'key' => DB::table('settings')->where('key', 'AWS_ACCESS_KEY_ID')->value('value') ?? '',
                'secret' => DB::table('settings')->where('key', 'AWS_SECRET_ACCESS_KEY')->value('value') ?? '',
                'region' => DB::table('settings')->where('key', 'AWS_DEFAULT_REGION')->value('value') ?? '',
                'bucket' => DB::table('settings')->where('key', 'AWS_BUCKET')->value('value') ?? '',
                'url' => env('AWS_URL'),
                'endpoint' => env('AWS_ENDPOINT'),
                'use_path_style_endpoint' => (bool)DB::table('settings')
                        ->where('key', 'AWS_USE_PATH_STYLE_ENDPOINT')->value('value') ?? false,
            ];
            Config::set('filesystems.disks', $config);
        }
    }
}
