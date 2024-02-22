<?php

namespace Modules\Basic\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Modules\Basic\Entities\Seeder;

class GenerateSeeders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:seed';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allSeedersFiles = config('seeder');
        if(count($allSeedersFiles) > 0)
        {
            Artisan::call('optimize:clear');
            foreach($allSeedersFiles as $seederClass)
            {
                $is_exist = Seeder::where('seeder', $seederClass)->count();
                if($is_exist == 0 ||
                    (str_contains($seederClass, 'Permission') || str_contains($seederClass, 'permission')))
                {
                    $this->info($seederClass . ' start been run');
                    Artisan::call('db:seed', ['--class' => $seederClass]);
                    $this->info($seederClass . ' has been run');
                    if(!(str_contains($seederClass, 'Permission') || str_contains($seederClass, 'permission')))
                    {
                        Seeder::create(['seeder' => $seederClass]);
                    }
                }
            }
        }
    }
}
