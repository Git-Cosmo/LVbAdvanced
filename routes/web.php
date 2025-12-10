<?php

use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Forum\PostController;
use App\Http\Controllers\Forum\ProfileController;
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

// Profile Routes
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/{user}', [ProfileController::class, 'show'])->name('show');
    
    Route::middleware('auth')->group(function () {
        Route::get('/edit/me', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/{user}/follow', [ProfileController::class, 'follow'])->name('follow');
        Route::post('/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('unfollow');
        Route::post('/{user}/wall', [ProfileController::class, 'postOnWall'])->name('wall.post');
    });
});

// Forum Routes
Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class, 'index'])->name('index');
    Route::get('/search', [\App\Http\Controllers\Forum\SearchController::class, 'index'])->name('search');
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
        
        // Reaction routes
        Route::post('/post/{post}/reaction', [\App\Http\Controllers\Forum\ReactionController::class, 'toggle'])->name('reaction.toggle');
        Route::get('/post/{post}/reactions', [\App\Http\Controllers\Forum\ReactionController::class, 'show'])->name('reaction.show');
        
        // Subscription routes
        Route::post('/thread/{thread}/subscribe', [\App\Http\Controllers\Forum\SubscriptionController::class, 'subscribe'])->name('thread.subscribe');
        Route::post('/thread/{thread}/unsubscribe', [\App\Http\Controllers\Forum\SubscriptionController::class, 'unsubscribe'])->name('thread.unsubscribe');
    });
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pages', PageController::class);
    Route::resource('blocks', BlockController::class);
    
    // Forum Management
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ForumManagementController::class, 'index'])->name('index');
        
        // Category routes
        Route::get('/category/create', [\App\Http\Controllers\Admin\ForumManagementController::class, 'createCategory'])->name('category.create');
        Route::post('/category', [\App\Http\Controllers\Admin\ForumManagementController::class, 'storeCategory'])->name('category.store');
        Route::get('/category/{category}/edit', [\App\Http\Controllers\Admin\ForumManagementController::class, 'editCategory'])->name('category.edit');
        Route::patch('/category/{category}', [\App\Http\Controllers\Admin\ForumManagementController::class, 'updateCategory'])->name('category.update');
        Route::delete('/category/{category}', [\App\Http\Controllers\Admin\ForumManagementController::class, 'deleteCategory'])->name('category.delete');
        
        // Forum routes
        Route::get('/forum/create', [\App\Http\Controllers\Admin\ForumManagementController::class, 'createForum'])->name('forum.create');
        Route::post('/forum', [\App\Http\Controllers\Admin\ForumManagementController::class, 'storeForum'])->name('forum.store');
        Route::get('/forum/{forum}/edit', [\App\Http\Controllers\Admin\ForumManagementController::class, 'editForum'])->name('forum.edit');
        Route::patch('/forum/{forum}', [\App\Http\Controllers\Admin\ForumManagementController::class, 'updateForum'])->name('forum.update');
        Route::delete('/forum/{forum}', [\App\Http\Controllers\Admin\ForumManagementController::class, 'deleteForum'])->name('forum.delete');
    });
});
