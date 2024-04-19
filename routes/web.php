<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect::route('home');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //tasks are shown on home-page
Route::post('/apply/{taskId}/{userId}', [App\Http\Controllers\HomeController::class,'applyToTask'])->name('apply-to-task'); //student applying to task
Route::post('/assign-student', [App\Http\Controllers\TeacherController::class, 'assignStudent'])->name('assign-student'); //teacher accepting student on task

Route::get('/task/{lang}', [App\Http\Controllers\TeacherController::class, 'newTask'])->name('task');
Route::post('/create-task', [App\Http\Controllers\TeacherController::class, 'createTask'])->name('create-task');

