<?php

use Modules\Acl\Http\Controllers\Api\InfluencerController;

Route::name('api.')->group(function () {
    Route::prefix('acl')->group(function () {
        Route::prefix('/influencer')->name('influencer.')->group(function () {
            Route::get('/hander', [InfluencerController::class, 'listHander'])->name('hander');
        });
    });
});
