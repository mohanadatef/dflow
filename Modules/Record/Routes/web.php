<?php

use Illuminate\Support\Facades\Route;

// use Modules\Record\Http\Controllers\ContentRecordController;
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
    Route::prefix('record')->group(function()
    {
        Route::controller(AdRecordErrorController::class)->prefix('/ad_record_errors')->name('ad_record_errors.')
            ->group(function()
            {
                Route::get('/', 'index')->name('index');
                Route::post('/store', 'store')->name('store');
                Route::get('/update', 'update')->name('update');
                Route::get('/cancel', 'cancel')->name('cancel');
            });
        /* campaign route list */
        Route::resource('campaign', CampaignController::class, ['except' => ['show', 'update']])
            ->parameters(['campaign' => 'id']);
        Route::controller(CampaignController::class)->prefix('/campaign')->name('campaign.')->group(function()
        {
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
        });
        /* ad_record route list */
        Route::resource('ad_record', AdRecordController::class, ['except' => ['show', 'update']])
            ->parameters(['ad_record' => 'id']);
        Route::controller(AdRecordController::class)->prefix('/ad_record')->name('ad_record.')->group(function()
        {
            Route::get('/duplicateAd', 'duplicateAd')->name('duplicate_ad');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/files/import', 'importView')->name('import-view');
            Route::post('files/import', 'import')->name('import');
            Route::get('files/export/', 'export')->name('export');
            Route::get('files/download', 'download')->name('download');
            Route::get('files/names', 'file_names')->name('names');
            Route::get('files/import/status', 'status')->name('status');
            Route::post('files/upload', 'dropzoneStore')->name('upload');
            Route::get('files/read', 'readFiles')->name('read_files');
            Route::get('files/get', 'getFiles')->name('get_files');
            Route::get('delete/one/{id}', 'deleteOne')->name('delete_one');
            Route::get('category/fix', 'fixCategoryAd')->name('category.fix');
            Route::post('category/fixed', 'fixCategory')->name('category.fixed');
            Route::post('duplicates/check', 'checkDuplicates')->name('checkDuplicates');

        });


        /* ad_record_draft route list */
        Route::resource('ad_record_draft', AdRecordDraftController::class, ['except' => ['show', 'update']])
            ->parameters(['ad_record_draft' => 'id']);
        Route::controller(AdRecordDraftController::class)->prefix('/ad_record_draft')->name('ad_record_draft.')->group(function()
        {
            Route::post('/convert/{id}', 'convertToAdRecord')->name('convert');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/files/import', 'importView')->name('import-view');
            Route::post('files/import', 'import')->name('import');
            Route::get('files/export/', 'export')->name('export');
            Route::get('files/download', 'download')->name('download');
            Route::get('files/names', 'file_names')->name('names');
            Route::get('files/import/status', 'status')->name('status');
            Route::post('files/upload', 'dropzoneStore')->name('upload');
            Route::get('files/read', 'readFiles')->name('read_files');
            Route::get('files/get', 'getFiles')->name('get_files');
            Route::get('delete/one/{id}', 'deleteOne')->name('delete_one');
            Route::post('duplicates/check', 'checkDuplicates')->name('checkDuplicates');

        });

        Route::resource('ad_record_log', AdRecordLogController::class, ['except' => ['show', 'update']])
            ->parameters(['ad_record_log' => 'id']);
        Route::resource('ad_record_draft_log', AdRecordDraftLogController::class, ['except' => ['show', 'update']])
            ->parameters(['ad_record_draft_log' => 'id']);
        /* Content_record route list */
        Route::resource('content_record', ContentRecordController::class, ['except' => ['show', 'update']])
            ->parameters(['content_record' => 'id']);
        Route::controller(ContentRecordController::class)->prefix('/content_record')->name('content_record.')
            ->group(function()
            {
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('generate-short-link/{code}', 'shortLinkCode')
                    ->withoutMiddleware(['middleware' => 'admin', 'auth']);
            });
        Route::resource('request_ad_media_access', RequestAdMediaAccessController::class,
            ['except' => ['show', 'update']])
            ->parameters(['request_ad_media_access' => 'id']);
        Route::controller(RequestAdMediaAccessController::class)->prefix('/request_ad_media_access')
            ->name('request_ad_media_access.')->group(function()
            {
                Route::get('my_request', 'myRequest')->name('myRequest');
                Route::get('my_request_ِavailable', 'myRequestِAvailable')->name('myRequestِAvailable');
                Route::post('cancellation', 'cancellation')->name('cancellation');
                Route::post('update', 'update')->name('update');
            });
        Route::resource('request_ad_media_access_log', RequestAdMediaAccessLogController::class,
            ['except' => ['show', 'update']])
            ->parameters(['request_ad_media_access_log' => 'id']);
        Route::controller(RequestAdMediaAccessLogController::class)->prefix('/request_ad_media_access_log')
            ->name('request_ad_media_access_log.')->group(function()
            {
                Route::get('client', 'client')->name('client');
            });
    });
});
