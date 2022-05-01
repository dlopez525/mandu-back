<?php

use App\Http\Controllers\DivisionsController;
use Illuminate\Support\Facades\Route;

Route::post('/divisions/store', [DivisionsController::class, 'store'])->name('divisions.store');
Route::post('/divisions/update/{id}', [DivisionsController::class, 'update'])->name('divisions.update');
Route::post('/divisions/delete/{id}', [DivisionsController::class, 'delete'])->name('divisions.delete');
Route::get('/divisions/get-division/{id}', [DivisionsController::class, 'getDivision'])->name('division.get');
Route::get('/divisions/get-divisions/', [DivisionsController::class, 'getDivisions'])->name('divisions.get');
