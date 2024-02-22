<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'admin', 'auth'], function()
{
    Route::prefix('material')->middleware('suspended')->group(function()
    {
        /* influencer trend route list */
        Route::resource('influencer_trend', InfluencerTrendController::class, ['except' => ['show', 'update']])
            ->parameters(['influencer_trend' => 'id']);
        Route::controller(InfluencerTrendController::class)
            ->prefix('/influencer_trend')
            ->name('influencer_trend.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('files/export/', 'export')->name('export');
            });
    });
});
