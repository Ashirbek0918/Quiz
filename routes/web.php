<?php

use App\Http\Controllers\{AuthController,
    DashboardController,
    PermissionController,
    Quiz\ExamController,
    Quiz\TopicController,
    RoleController,
    UserController};
use Illuminate\Support\Facades\Route;
Route::get('/',function(){
    return to_route('dashboard.index');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('login', 'login')->name('web.loginPost');
    Route::post('login-participant', 'loginParticipant')->name('web.loginParticipant');

});

Route::middleware(['auth', 'lang'])->prefix('admin')->group(function () {
    Route::controller(DashboardController::class)->name('dashboard.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('change-lang/{lang}', 'changeLang')->name('changeLang');
    });

    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Permissions
    Route::controller(PermissionController::class)->name('permissions.')->prefix('permissions')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('delete/{id}', 'delete')->name('delete');
    });

    // Roles
    Route::controller(RoleController::class)->name('roles.')->prefix('roles')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('new', 'new')->name('new');
        Route::post('store', 'store')->name('store');
        Route::get('create', 'create')->name('create');
        Route::put('update/{id}', 'update')->name('update');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('delete/{id}', 'delete')->name('delete');
    });

    //users
    Route::controller(UserController::class)->name('users.')->prefix('users')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('create', 'create')->name('create');
        Route::get('updateProfile', 'updateProfile')->name('updateProfile');
        Route::put('update/{id}', 'update')->name('update');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('delete/{id}', 'delete')->name('delete');
    });


    Route::controller(TopicController::class)->prefix('topics')->group(function () {
        Route::get('index', 'index')->name('topics.index');
        Route::post('store', 'store')->name('topics.store');
        Route::get('create', 'create')->name('topics.create');
        Route::put('update/{id}', 'update')->name('topics.update');
        Route::get('edit/{id}', 'edit')->name('topics.edit');
        Route::get('delete/{id}', 'delete')->name('topics.delete');
        Route::get('get/{lang}', 'getAll')->name('topics.getAll');

        //questions
        Route::get('{topic}/get-questions', 'getQuestions')->name('questions.index');
        Route::post('{topic}/store-question', 'storeQuestion')->name('questions.store');
        Route::get('{topic}/create-question', 'createQuestion')->name('questions.create');
        Route::post('{topic}/import-question', 'import')->name('questions.import');
        Route::put('{topic}/update-question/{id}', 'updateQuestion')->name('questions.update');
        Route::get('{topic}/edit-question/{id}', 'editQuestion')->name('questions.edit');
        Route::get('{topic}/delete-question/{id}', 'deleteQuestion')->name('questions.delete');
    });
    Route::controller(ExamController::class)->prefix('exams')->name('exams.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::get('create', 'create')->name('create');
        Route::put('update/{id}', 'update')->name('update');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::get('result/{id}', 'result')->name('result');
        Route::get('{id}/export', 'exportAttempt')->name('exportAttempt');
        Route::get('{id}/attempt', 'showAttempt')->name('showAttempt');
        Route::post('{id}/check-attempt', 'checkAttempt')->name('checkAttempt');
        Route::get('delete/{id}', 'delete')->name('delete');
    });
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');


    Route::controller(\App\Http\Controllers\FileUploadController::class)->prefix('fileUpload')->name('fileUpload.')->group(function () {
        Route::post('upload', 'upload')->name('upload');
        Route::get('view', 'view')->name('view');
    });
});
