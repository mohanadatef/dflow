<?php

namespace Modules\Acl\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Modules\Acl\Service\InfluencerGroupScheduleService;
use Modules\Acl\Service\ReseacherInfluencersDailyService;

class ResearcherSchedule8 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'researcher:schedule8';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $service;
    protected $completedAdsService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InfluencerGroupScheduleService $service, ReseacherInfluencersDailyService $completedAdsService)
    {
        $this->service = $service;
        $this->completedAdsService = $completedAdsService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $day = weekScheduleKey()[strtolower(Carbon::today()->format('l'))];
        $influencer_groups = $this->service->findBy(new Request(['day' => $day]));
        foreach ($influencer_groups as $group){
            foreach ($group->influencer_group->influencer_follower_platform as $follower)
            {
                $this->completedAdsService->store(new Request(
                    [
                        'influencer_follower_platform_id' => $follower->id,
                        'researcher_id' => $group->researcher_id,
                        'shift' => $group->shift,
                        'date' => Carbon::today()->format('Y-m-d H:i:s')
                    ]
                ));
            }
        }
        return 0;
    }
}
