<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['*'],
            function($view)
            {
                $user = user();
                $view->with('lang', $user->lang ?? 'en');
                $view->with('userLogin', $user ?? []);
                $view->with('userType', $user->role->type ?? 0);
                $view->with('notifications', user() ? $user->notifications()->limit(10)->get() : []);
            }
        );
    }
}
