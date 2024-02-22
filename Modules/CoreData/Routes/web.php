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
    Route::prefix('dflowplanner')->middleware('suspended')->group(function()
    {
        Route::resource('calendar', CalendarController::class, ['except' => ['show', 'update']])
            ->parameters(['category' => 'id'])
            ->middleware(['suspended']);
        Route::controller(CalendarController::class)
            ->prefix('/calendar')->name('calendar.')->group(function()
            {
                Route::get('/events', 'events')->name('events');
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('delete/{id}', 'destroy')->name('delete');
            });
    });
    Route::prefix('coredata')->middleware('suspended')->group(function()
    {
        /* category route list */
        Route::resource('category', CategoryController::class, ['except' => ['show', 'update']])
            ->parameters(['category' => 'id']);
        Route
            ::controller(CategoryController::class)
            ->prefix('/category')
            ->name('category.')
            ->group(function()
            {
                Route::get('child', 'child_categories')->name('child');
                Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('files/import', 'importView')->name('importView');
                Route::get('files/import/inf-ca', 'importViewInfCa')->name('importView-inf-ca');
                Route::post('files/import', 'import')->name('import');
                Route::get('files/export/', 'export')->name('export');
            });
        /* tag route list */
        Route::resource('tag', TagController::class, ['except' => ['show', 'update']])
            ->parameters(['tag' => 'id']);
        Route
            ::controller(TagController::class)
            ->prefix('/tag')
            ->name('tag.')
            ->group(function()
            {
                Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
                Route::get('/check', 'checkTag')->name('check');
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('files/export/', 'export')->name('export');
            });
        //Website module routes list
        Route::resource('website', WebsiteController::class, ['except' => ['show', 'update']])
            ->parameters(['website' => 'id']);
        Route::controller(WebsiteController::class)->prefix('/website')->name('website.')
            ->group(function()
            {
                Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
            });
        /* promotion_type route list */
        Route::resource('promotion_type', PromotionTypeController::class, ['except' => ['show', 'update']])
            ->parameters(['promotion_type' => 'id']);
        Route::controller(PromotionTypeController::class)->prefix('/promotion_type')->name('promotion_type.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('/files/import', 'importView')->name('import-view');
                Route::post('files/import', 'import')->name('import');
                Route::get('files/export/', 'export')->name('export');
            });
        /* service route list */
        Route::resource('service', ServiceController::class, ['except' => ['show', 'update']])
            ->parameters(['service' => 'id']);
        Route::controller(ServiceController::class)->prefix('/service')->name('service.')->group(function()
        {
            Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
            Route::get('files/export/', 'export')->name('export');
        });
        /* platform route list */
        Route::resource('platform', PlatformController::class, ['except' => ['show', 'update']])
            ->parameters(['platform' => 'id']);
        Route::controller(PlatformController::class)->prefix('/platform')->name('platform.')->group(function()
        {
            Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/files/import', 'importView')->name('import-view');
            Route::post('files/import', 'import')->name('import');
            Route::get('files/export/', 'export')->name('export');
        });
        /* size route list */
        Route::resource('size', SizeController::class, ['except' => ['show', 'update']])
            ->parameters(['size' => 'id']);
        Route::controller(SizeController::class)->prefix('/size')->name('size.')->group(function()
        {
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
        });
        /* location route list */
        Route::resource('location', LocationController::class, ['except' => ['show', 'update']])
            ->parameters(['location' => 'id']);
        Route::controller(LocationController::class)->prefix('/location')->name('location.')->group(function()
        {
            Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/files/import', 'importView')->name('import-view');
            Route::post('files/import', 'import')->name('import');
            Route::get('files/export/', 'export')->name('export');
            Route::get('/country/list-specific', 'listSpecific')->name('country.listSpecific');
        });
        /* link-tracking route list */
        Route::resource('linktracking', LinkTrackingController::class, ['except' => ['show', 'update']])
            ->parameters(['linktracking' => 'id']);
        Route::controller(LinkTrackingController::class)->prefix('/linktracking')->name('linktracking.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
            });
        Route::resource('link', LinkTrackingController::class, ['except' => ['show', 'update']])
            ->parameters(['link' => 'id']);
        Route::controller(LinkTrackingController::class)->prefix('/link')->name('link.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
            });
        /* influencer travel route list */
        Route::resource('influencer_travel', InfluencerTravelController::class, ['except' => ['show', 'update']])
            ->parameters(['influencer_travel' => 'id']);
        Route::controller(InfluencerTravelController::class)
            ->prefix('/influencer_travel')
            ->name('influencer_travel.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('files/export/', 'export')->name('export');
            });
        /* event route list */
        Route::resource('event', EventController::class, ['except' => ['show', 'update']])
            ->parameters(['event' => 'id']);
        Route::controller(EventController::class)
            ->prefix('/event')
            ->name('event.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('files/export/', 'export')->name('export');
            });
        /* brand activity route list */
        Route::resource('brand_activity', BrandActivityController::class, ['except' => ['show', 'update']])
            ->parameters(['brand_activity' => 'id']);
        Route::controller(BrandActivityController::class)
            ->prefix('/brand_activity')
            ->name('brand_activity.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('files/export/', 'export')->name('export');
            });
    });
});
Route::prefix('coredata')->group(function()
{
    Route::controller(LinkTrackingController::class)->prefix('/linktracking')->name('linktracking.')->group(function()
    {
        Route::get('visit/{id}', 'visit')->name('visit');
    });
    Route::controller(LinkTrackingController::class)->prefix('/link')->name('link.')->group(function()
    {
        Route::get('visit/{id}', 'visit')->name('visit');
    });
});

Route::controller(LinkTrackingController::class)->name('linktracking.')->group(function()
{
    Route::get('visit/{id}', 'visit')->name('visit');
});
Route::controller(LinkTrackingController::class)->name('link.')->group(function()
{
    Route::get('visit/{id}', 'visit')->name('visit');
});