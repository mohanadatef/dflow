<?php

namespace Modules\Acl\Console\Commands;

use Illuminate\Console\Command;
use Modules\Acl\Service\InfluencerGroupScheduleService;

class ResearcherSchedule5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'researcher:schedule5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $service;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InfluencerGroupScheduleService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->service->scanTable();
        return 0;
    }
}
