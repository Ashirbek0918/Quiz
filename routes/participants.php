<?php


use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::middleware(['participants','lang'])->prefix('participants')->group(function () {
    Route::view('/home', 'participants.dashboard.home')->name('participants.dashboard.home');

    Route::controller(ExamController::class)->prefix('exams')->name('participants.exams.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('{examId}/show', 'showExam')->name('showExam');
        Route::get('{examId}/start-test', 'startTest')->name('startTest');
        Route::get('{attemptId}/attempt', 'getAttempt')->name('getAttempt');
        Route::post('{attemptId}/finish-attempt', 'finishAttempt')->name('finishAttempt');
    });
});
