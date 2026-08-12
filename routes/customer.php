<?php

use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return "<h1>Dashboard</h1>";
})->name('dashboard');
