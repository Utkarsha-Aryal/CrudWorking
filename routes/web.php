<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CkeditorController;


Route::prefix('student')->name('student.')->group(function () {
    Route::get('/', [CkeditorController::class, 'index'])->name('welcome');


    Route::post('/save', [CkeditorController::class, 'save'])->name('save');
    Route::get('/form', [CkeditorController::class, 'form'])->name('form');
    Route::post('/delete', [CkeditorController::class, 'delete'])->name('delete');
    Route::post('/about', [CkeditorController::class, 'about'])->name('about');
    Route::get('/data', [CkeditorController::class, 'data'])->name('data');

    
});
Route::redirect('/','student');
