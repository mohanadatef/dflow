<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminMiddelware
{
    /**
     * Handle an incoming request.
     * @Target check user is admin and can log in if status column active
     * @param Request $request
     * @param Closure $next
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (user() && user()->active == 1) {
            if(user()->role->type)
            {
            if(user()->session != $request->session()->token())
            {
                Auth::logout();
                return redirect('/login')->with('message_false', getCustomTranslation('places_call_support'));
            }
            }
            if(user()->is_login == 0){
                user()->update(['is_login' => 1]);
            }
            if(user()->role->type == 0){
                Cache::put('user_' . user()->id, true);
                if(!empty(user()->last_seen_at) && user()->last_seen_at != "0000-00-00 00:00:00"){
                    $mins = Carbon::now()->diff(Carbon::parse(user()->last_seen_at));
                    if($mins->i <= 20){
                        $x= Carbon::parse(user()->working_hours)
                            ->addHours($mins->h)->addMinutes($mins->i)->addSeconds($mins->s);
                        user()->update(['working_hours' => $x]);
                    }
                }else{
                    if(empty(user()->first_login))
                    {
                        user()->update(['first_login' => Carbon::now()]);
                    }
                }
                user()->update(['last_seen_at' => Carbon::now()]);

            }
            App::setlocale(user()->lang);
            return $next($request);
        }
        Auth::logout();
        return redirect('/login')->with('message_false', getCustomTranslation('places_call_support'));
    }
}
