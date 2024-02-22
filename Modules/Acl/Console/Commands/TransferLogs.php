<?php

namespace Modules\Acl\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Acl\Entities\UserWorkingTime;

class TransferLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $users = User::with('role')->whereHas('role',function($query){
            $query->where('type',0);
        })->get();

        foreach ($users as $user) {
            UserWorkingTime::create([
                'user_id' => $user['id'],
                'working_hours' => $user['working_hours'],
                'date' => Carbon::parse('yesterday'),
                'last_seen_at' => $user['last_seen_at'] ?? "",
                'first_login' => $user['first_login'] ?? ""
            ]);
            $user->update(['working_hours' => "00:00:00",
                'last_seen_at' => null,
                'first_login' => null,
                'is_login' => 0,
            ]);
        }
    }
}
