<?php

use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Forum\PostController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/page/{slug}', [PortalController::class, 'show'])->name('page.show');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forum Routes
Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class, 'index'])->name('index');
    Route::get('/{slug}', [ForumController::class, 'show'])->name('show');
    
    // Thread routes
    Route::get('/thread/{slug}', [ThreadController::class, 'show'])->name('thread.show');
    Route::middleware('auth')->group(function () {
        Route::get('/{forum}/create', [ThreadController::class, 'create'])->name('thread.create');
        Route::post('/{forum}/thread', [ThreadController::class, 'store'])->name('thread.store');
        
        // Post routes
        Route::post('/thread/{thread}/post', [PostController::class, 'store'])->name('post.store');
        Route::patch('/post/{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    });
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pages', PageController::class);
    Route::resource('blocks', BlockController::class);
});
