<?php

use App\Http\Controllers\Api\WorkerController;
use App\Http\Controllers\Api\WorktimeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('workers', [WorkerController::class, 'store'])->name('workers.store');

Route::post('worktimes', [WorktimeController::class, 'store'])->name('worktimes.store');