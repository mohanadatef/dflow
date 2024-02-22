<?php

use Modules\Report\Http\Controllers\CompetitiveAnalysisController;
use Modules\Report\Http\Controllers\AnalysisPdfController;
use Modules\Report\Http\Controllers\HomeController;

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

//Competitive analysis

Route::prefix('report')->group(function() {
    Route::get('/', 'ReportController@index');

    Route::controller(CompetitiveAnalysisController::class)->prefix('reports')->middleware(['auth:web','suspended'])->name('reports.')->group(function () {

        Route::get('/dashboard/getdatechartbycompany', [CompetitiveAnalysisController::class, 'getdatechartbycompany'])->name('getdatechartbycompany');
        Route::get('/dashboard/getdatechartbydiscount', [CompetitiveAnalysisController::class, 'getdatechartbydiscount'])->name('getdatechartbydiscount');
        Route::get('/dashboard/getdatechartbypromotedProducts', [CompetitiveAnalysisController::class, 'getdatechartbypromotedProducts'])->name('getdatechartbypromotedProducts');

        Route::get('/competitive_analysis', [CompetitiveAnalysisController::class, 'index'])
            ->name('competitive_analysis');
        Route::post('/competitive_analysis/search_companies', [CompetitiveAnalysisController::class, 'search_companies'])
            ->name('search_companies');

    });

    Route::resource('external_dashboard', ExternalDashboardController::class, ['except' => ['show', 'update']])
        ->parameters(['external_dashboard' => 'id']);
    Route::controller(ExternalDashboardController::class)
        ->prefix('/external_dashboard')->name('external_dashboard.')->group(function()
    {
        Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
        Route::post('/{id}', 'update')->name('update');
        Route::get('/listAssign', 'listAssign')->name('listAssign');
        Route::get('/{id}', 'show')->name('show');
        Route::get('delete/one/{id}', 'delete')->name('delete');
    });
    Route::resource('external_dashboard_log', ExternalDashboardLogController::class, ['except' => ['show', 'update']])
        ->parameters(['external_dashboard_log' => 'id']);
    Route::resource('external_dashboard_version', ExternalDashboardVersionController::class, ['except' => ['show', 'update']])
        ->parameters(['external_dashboard_version' => 'id']);
    Route::controller(ExternalDashboardVersionController::class)
        ->prefix('/external_dashboard_version')->name('external_dashboard_version.')->group(function()
        {
            Route::get('/change/{id}', 'change')->name('change');
        });
    Route::resource('external_dashboard_client', ExternalDashboardClientController::class, ['except' => ['show', 'update']])
        ->parameters(['external_dashboard_client' => 'id']);
    Route::controller(ExternalDashboardClientController::class)
        ->prefix('/external_dashboard_client')->name('external_dashboard_client.')->group(function()
        {
            Route::get('/listAssign', 'listAssign')->name('listAssign');
            Route::post('/{id}', 'update')->name('update');
        });
    //Reports sheet
    Route::controller(ReportsSheetController::class)->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'upload')->name('upload');
        Route::post('toggleActive', 'toggleActive')->name('toggleActive');
        Route::post('files/import', 'import')->name('import');
        Route::get('files/export/', 'export')->name('export');
    });

    Route::post('/reports', [ReportsSheetController::class, 'upload'])->name('reports.upload');

        Route::controller(ReportsSheetController::class)->prefix('reports')->name('reports.')->middleware(['auth:web','suspended'])
        ->group(function () {
        Route::get('/analysis/view', [AnalysisPdfController::class, 'view'])
            ->name('analysis.view');

        Route::post('/competitive_analysis/viewPost', [AnalysisPdfController::class, 'viewPost'])
            ->name('analysis.viewPost');

        Route::get('/competitive_analysis/prepare', [AnalysisPdfController::class, 'prepare'])
            ->name('analysis.prepare');

        Route::get('/competitive_analysis/download', [AnalysisPdfController::class, 'download'])
            ->name('analysis.download');

    });
    //Analysis PDF


    //Home Controller
    Route::get('/market_overview', [HomeController::class, 'index'])->middleware(['auth:web','suspended'])->name('dashboard');
    Route::get('/dashboard/getdatechart', [HomeController::class, 'getdatechart'])->middleware(['auth:web','suspended'])->name('getdatechart');

});

