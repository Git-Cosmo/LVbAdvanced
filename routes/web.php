<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/page/{slug}', [PortalController::class, 'show'])->name('page.show');
