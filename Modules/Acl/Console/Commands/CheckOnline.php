<?php

namespace Modules\Acl\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CheckOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onlineusers:check';
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
        $users = User::where('last_seen_at','<=', Carbon::parse(Carbon::now()->subMinutes(20)->format('Y-m-d H:i:s')))->get();
       foreach($users as $user)
       {
           $user->update(['last_seen_at' => null, 'is_login' => 0,'session'=>null]);
           Cache::put('user_' . $user->id, false);
           Cache::put('competitive_start_' . $user->id, null);
           Cache::put('competitive_end_' . $user->id, null);
           Cache::put('market_start_' . $user->id, null);
           Cache::put('market_end_' . $user->id, null);
       }
    }
}
