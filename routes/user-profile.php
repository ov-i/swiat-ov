<?php

use Illuminate\Support\Facades\Route;

Route::middleware($dashboardMiddlewares)->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
