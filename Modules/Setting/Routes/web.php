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

use Modules\Setting\Http\Controllers\ContactController;
use Modules\Setting\Http\Controllers\SupportCenterController;

Route::group(['middleware' => 'admin', 'auth'], function () {
    Route::prefix('setting')->group(function () {

        /* fq route list */
        Route::resource('fq', FqController::class, ['except' => ['show', 'update']])
            ->parameters(['fq' => 'id']);
        Route::controller(FqController::class)->prefix('/fq')->name('fq.')->group(function () {
            Route::get('/show_user', 'show_user')->name('show_user');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
        });
        Route::resource('notification', NotificationController::class, ['except' => ['show', 'update']])
            ->parameters(['notification' => 'id']);
        Route::controller(NotificationController::class)->prefix('/notification')->name('notification.')->group(function () {
            Route::get('/read', 'readNotification')->name('read');
        });
        Route::get('/supportCenter/faq', [SupportCenterController::class, 'faq'])->name('supportCenter.faq');

        Route::get('/contacts/create', [ContactController::class, 'create'])->name('contact.create');
        Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');

        Route::resource('support_center', SupportCenterQuestionController::class, ['except' => ['show', 'update']])
            ->parameters(['question' => 'id']);
        Route::controller(SupportCenterQuestionController::class)->prefix('/support_center')->name('question.')->group(function()
        {

            Route::post('toggleActive', 'toggleActive')->name('toggleActive');
            Route::post('toggleAnswer', 'toggleAnswer')->name('toggleAnswer');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/my_questions', 'myQuestions')->name('myQuestions');
            Route::get('/hidden_questions', 'getHiddenQuestions')->name('getHiddenQuestions');
            Route::post('/{id}', 'update')->name('update');
            Route::get('/{id}', 'show')->name('show');
            Route::post('files/upload', 'dropzoneStore')->name('upload');
            Route::get('files/read', 'readFiles')->name('read_files');
            Route::get('files/get', 'getFiles')->name('get_files');
            Route::get('delete/one/{id}', 'delete')->name('delete');

        });

        Route::resource('answers', SupportCenterAnswerController::class, ['except' => ['show', 'update']])
            ->parameters(['answer' => 'id']);

        Route::controller(SupportCenterAnswerController::class)->prefix('/answer')->name('answers.')->group(function()
        {
            Route::get('delete/one', 'delete')->name('delete');
        });

    });
});
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('setting')->group(function () {
        Route::controller(NotificationController::class)->prefix('/notification')->name('notification.')->group(function () {
            Route::get('/get', 'getNotification')->name('get');
        });

    });
});
