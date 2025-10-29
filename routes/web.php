<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'main'])->name('main');

Route::post('/check_bank', [MainController::class, 'check_bank']);

Route::get('/incomes', [MainController::class, 'incomes'])->name('incomes');

Route::get('/spending', [MainController::class, 'spending'])->name('spending');
