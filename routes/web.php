<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Modules\Acl\Http\Controllers\CompanyController;
use Modules\Acl\Http\Controllers\UserController;
use Modules\CoreData\Http\Controllers\CategoryController;
use Modules\CoreData\Http\Controllers\PlatformController;
use Modules\CoreData\Http\Controllers\ServiceController;
use Modules\CoreData\Http\Controllers\LocationController;
use Modules\CoreData\Http\Controllers\WebsiteController;

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
Route::get('/', [HomeController::class, 'home'])->middleware(['auth:web','suspended'])->name('home');



//city
Route::prefix('/location')->group(function () {
    Route::get('/city/list', [LocationController::class, 'cityList'])
        ->name('location.city.list');
});
//service
Route::prefix('/service')->group(function () {
    Route::get('/list', [ServiceController::class, 'list'])
        ->name('service.list');
});
//platform
Route::prefix('/platform')->group(function () {
    Route::get('/list', [PlatformController::class, 'list'])
        ->name('platform.list');
});

//category
Route::prefix('/category')->group(function () {
    Route::get('/list', [CategoryController::class, 'list'])
        ->name('category.list');
    Route::get('/list/industry', [CategoryController::class, 'listIndustry'])
        ->name('category.list.industry');
    Route::get('/list/search', [CategoryController::class, 'search_categories'])
        ->name('category.list_search');
});

Route::prefix('/website')->group(function () {
    Route::get('/list', [WebsiteController::class, 'list'])
        ->name('website.list');
    Route::get('/list/search', [WebsiteController::class, 'search_websites'])
        ->name('website.list_search');
});
//company
Route::prefix('/company')->group(function () {

    Route::get('/InCategories', [CompanyController::class, 'company_in_categories'])
        ->name('company.InCategories');

});
/* cache list */
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return redirect('admin');
})->name('clear_cache');





Route::post('update-user-layout', [UserController::class, 'update_user_layout'])->name('user.update_user_layout');
