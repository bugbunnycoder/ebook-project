<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EbookController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ebooks', [EbookController::class, 'index'])->name('ebooks.index');
Route::get('/show', [EbookController::class, 'show'])->name('ebooks.show');
Route::get('/ebooks/create', [EbookController::class, 'create'])->name('ebooks.create');
Route::post('/ebooks', [EbookController::class, 'store'])->name('ebooks.store');

