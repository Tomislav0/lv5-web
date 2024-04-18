<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Redirect::route('home');
});
// Route::get('/{locale}', function (string $locale) {
//     if (! in_array($locale, ['en', 'hr'])) {
//         abort(400);
//     }
 
//     App::setLocale($locale);
 
// });
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/task/{lang}', [App\Http\Controllers\TeacherController::class, 'newTask'])->name('task');
Route::post('/store-form', [App\Http\Controllers\TeacherController::class, 'storeForm'])->name('store-form');

Route::post('/locale-switch', [App\Http\Controllers\LocaleController::class,'switchLocale'])->name('locale-switch');
Route::post('/assign/{taskId}/{userId}', [App\Http\Controllers\HomeController::class,'assign'])->name('assign');