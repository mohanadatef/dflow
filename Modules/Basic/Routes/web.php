<?php

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

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('basic')->group(function () {
        //media
        Route::controller(MediaController::class)->prefix('/media')->group(function () {
            Route::delete('del', 'remove')->name('media.remove');
            Route::delete('delete/file', 'removeByName')->name('media.removeByName');
        });
        Route::get('/language/change', function () {
            user()->update(['lang' => request('lang')]);
            return true;
        })->name('language.change');
    });
});
