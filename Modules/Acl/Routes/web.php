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
Route::controller(AuthController::class)->name('auth.')->group(function()
{
    Route::get('/login', 'loginForm')->name('login.form');
    Route::post('/login', 'login')->name('login');
    Route::get('/reset/password/generate', 'resetPasswordForm')->name('reset.password.generate');
    Route::post('/reset/password/generate', 'resetPassword')->name('reset.password.generate.post');
    Route::post('/logout', 'logout')->name('logout');
});
// todo remove the duplicate code
Route::controller(AuthController::class)->group(function()
{
    Route::get('/reset/password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset/password', 'submitResetPasswordForm')->name('reset.password.post');
});
Route::group(['middleware' => 'admin', 'auth'], function()
{
    Route::prefix('acl')->group(function()
    {
        /* company route list */
        Route::resource('company', CompanyController::class, ['except' => ['show', 'update', 'mergeduplicate']])
            ->parameters(['company' => 'id']);
        Route::controller(CompanyController::class)->prefix('/company')->name('company.')->group(function()
        {
            Route::get('get/edit/ad', 'getEdit')->name('getEdit');
            Route::get('merge', 'merge')->name('merge.merge');
            Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
            Route::get('/brands/all', 'allBrands')->name('allBrands');
            Route::get('/brands/companyByid', 'companyByid')->name('companyByid');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/files/import', 'importView')->name('import-view');
            Route::post('/files/import', 'import')->name('import');
            Route::get('files/download', 'download')->name('download');
            Route::get('files/import/status', 'status')->name('status');
            Route::get('merge/info', 'mergeInfo')->name('merge.info');
            Route::get('merge/search', 'mergeSearch')->name('merge.search');
            Route::get('merge/get', 'mergeGet')->name('merge.get');
            Route::get('merge/get/company', 'mergeGetCompany')->name('merge.get.company');
            Route::get('files/export/', 'export')->name('export');
            Route::get('check', 'checkCompany')->name('check');
            Route::get('list', 'list')->name('list');
			Route::get('/duplicate_company', 'duplicateCompany')->name('duplicate_company');
			Route::get('/mergeduplicate', 'mergeduplicate')->name('mergeduplicate');
			// Route::post('mergeduplicate', 'CompanyController@mergeduplicate')->name('mergeduplicate');
        });

        Route::resource('company_merge_template', CompanyMergeSheetTemplateController::class)->except(['show'])
            ->parameters(['company_merge_template' => 'id']);
        Route::controller(CompanyMergeSheetTemplateController::class)->prefix('/company_merge_template')->name('company_merge_template.')->group(function()
        {
            Route::get('/merge/all', 'mergeAll')->name('MergeAll');

            Route::get('/files/import', 'importView')->name('import-view');
            Route::post('/files/import', 'import')->name('import');
            Route::get('/files/import/status', 'status')->name('status');
            Route::get('/checkDuplicates', 'checkDuplicates')->name('checkDuplicates');
            Route::get('/DeleteAll', 'DeleteAll')->name('DeleteAll');
            Route::get('/merge/{id}', 'merge')->name('merge');
        });

        /* User route list */
        Route::resource('user', UserController::class, ['except' => ['show', 'update']])
            ->parameters(['user' => 'id']);
        Route::controller(UserController::class)->prefix('/user')->name('user.')->group(
            function()
            {
                Route::post('toggleActive', 'toggleActive')->name('toggleActive');
                Route::post('toggleSearch', 'toggleSearch')->name('toggleSearch');
                Route::get('password/{id}', 'changePassword')->name('changePassword');
                Route::post('password/{id}', 'updatePassword')->name('updatePassword');
                Route::post('{id}', 'update')->name('update');
                Route::get('{id}', 'show')->name('show');
                Route::get('files/import', 'importView')->name('import-view');
                Route::post('files/import', 'import')->name('import');
                Route::get('files/export/', 'export')->name('export');
            });
        Route::controller(ResearcherDashboardController::class)->prefix('/researcher_dashboard')
            ->name('researcher_dashboard.')->group(
            function()
            {
                Route::get('', 'researcherDashboard')->name('researcherDashboard');
                Route::get('getresearcherchart', 'getResearcherChart')->name('getResearcherChart');
                Route::get('influencerTable', 'getInfluencerTable')->name('getInfluencerTable');
                Route::get('markAdComplete', 'markAdComplete')->name('markAdComplete');
                Route::post('get_files', 'mediaFileHtml')->name('researcherDashboard.get_files');
                Route::get('seen_get_files', 'mediaFileSeen')->name('researcherDashboard.seen_get_files');
                Route::get('ads_count', 'adsCount')->name('researcherDashboard.adsCount');
                Route::get('drafts_count', 'draftsCount')->name('researcherDashboard.draftsCount');
                Route::get('ads_chart', 'adsChart')->name('researcherDashboard.adsChart');
                Route::get('completed_ads_chart', 'completedAdsChart')->name('researcherDashboard.completedAdsChart');
                Route::get('media_seen_chart', 'mediaSeenChart')->name('researcherDashboard.mediaSeenChart');
                Route::get('error_count', 'error_count')->name('researcherDashboard.error_count');
                Route::get('log_researcher_dashboard', 'logResearcherDashboard')->name('researcherDashboard.logResearcherDashboard');
            });
        Route::controller(AdminDashboardController::class)->prefix('/admin-dashboard')->name('admin.')->group(
            function() {
                Route::get('', 'adminDashboard')->name('dashboard');
                Route::get('log', 'logAdminDashboard')->name('dashboard.log');
            });
        Route::resource('client', ClientController::class, ['except' => ['show', 'update']])
            ->parameters(['client' => 'id']);
        Route::controller(ClientController::class)->prefix('/client')->name('client.')->group(
            function()
            {
                Route::post('toggleActive', 'toggleActive')->name('toggleActive');
                Route::get('password/{id}', 'changePassword')->name('changePassword');
                Route::post('password/{id}', 'updatePassword')->name('updatePassword');
                Route::post('{id}', 'update')->name('update');
                Route::get('{id}', 'show')->name('show');
                Route::get('files/export/', 'export')->name('export');
            });
        Route::controller(RoleController::class)->prefix('/role')->name('role.')->group(function()
        {
            Route::get('/', 'index')->name('index');
            Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/update', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
        /* Influencer route list */
        Route::resource('influencer', InfluencerController::class, ['except' => ['show', 'update']])
            ->parameters(['influencer' => 'id'])
            ->middleware('suspended');
        Route::controller(InfluencerController::class)
            ->prefix('/influencer')
            ->name('influencer.')
            ->middleware('suspended')
            ->group(function()
            {  
                Route::post('merge/{id}', 'merge')->name('merge.merge');
                Route::post('image', 'uploadImage')->name('image.upload');
                Route::get('image', 'getImage')->name('image.get');
                Route::post('/toggleActive', 'toggleActive')->name('toggleActive');
                Route::post('/link_tracker', 'linkTracker')->name('link_tracker');
                Route::post('/discover_calander', 'discoverCalander')->name('discoverCalander');
                Route::post('/{id}', 'update')->name('update');
                Route::get('/discover', 'discover')->name('discover');
                Route::get('/unique-influencers', 'uniqueInfluencers')->name('uniqueInfluencers');
                Route::get('/InfluencersByids', 'InfluencersByids')->name('InfluencersByids');
                Route::get('/discover_export', 'discoverExport')->name('discoverExport');
                Route::get('/{id}', 'show')->name('show');
                Route::get('/files/import', 'importView')->name('import-view');
                Route::post('files/import', 'import')->name('import');
                Route::get('files/export/', 'export')->name('export');
                Route::get('/api/search', 'search')->name('search');
                Route::get('/api/searchDiscover', 'searchDiscover')->name('searchDiscover');
                Route::get('merge/info/{id}', 'mergeInfo')->name('merge.info');
                Route::get('merge/search', 'mergeSearch')->name('merge.search');
                Route::get('merge/get', 'mergeGet')->name('merge.get');
            });
        /* Influencer group route list */
        Route::resource('influencer_group', InfluencerGroupController::class, ['except' => ['show', 'update']])
            ->parameters(['influencer_group' => 'id']);
        Route::controller(InfluencerGroupController::class)
            ->prefix('/influencer_group')
            ->name('influencer_group.')
            ->group(function()
            {
                Route::post('upload_influencer_check', 'uploadInfluencerCheck')->name('upload_influencer_check');
                Route::post('upload_influencer', 'uploadInfluencer')->name('upload_influencer');
                Route::post('/{id}', 'update')->name('update');
                Route::get('/{id}', 'show')->name('show');
                Route::get('files/export/', 'export')->name('export');
                Route::get('influencer/search', 'influencerSearch')->name('influencer.search');
            });
        Route::resource('influencer_group_log', InfluencerGroupLogController::class, ['except' => ['show', 'update']])
            ->parameters(['influencer_group_log' => 'id']);
        Route::resource('influencer_group_schedule', InfluencerGroupScheduleController::class, ['except' => ['show', 'edit','update']])
            ->parameters(['influencer_group_schedule' => 'id']);
        Route::controller(InfluencerGroupScheduleController::class)
            ->prefix('/influencer_group_schedule')
            ->name('influencer_group_schedule.')
            ->group(function()
            {
                Route::get('edit/{researcher_id}', 'edit')->name('edit');
                Route::get('influencer_group/remainder', 'influencerGroupRemainder')->name('influencer_group.remainder');
                Route::get('scan', 'scanTable')->name('scanTable');
            });
        Route::controller(ReseacherInfluencersDailyController::class)
            ->prefix('/reseacher_influencers_daily')
            ->name('reseacher_influencers_daily.')
            ->group(function()
            {
                Route::post('change', 'changeResearcher')->name('changeResearcher');
            });
    });
});
