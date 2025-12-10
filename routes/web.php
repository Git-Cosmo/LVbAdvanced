<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Forum\PostController;
use App\Http\Controllers\Forum\ProfileController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', [PortalController::class, 'home'])->name('home');

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
        
        // Poll routes
        Route::post('/poll/{poll}/vote', [\App\Http\Controllers\Forum\PollController::class, 'vote'])->name('poll.vote');
        
        // Messaging routes
        Route::get('/messages', [\App\Http\Controllers\Forum\MessagingController::class, 'inbox'])->name('messaging.inbox');
        Route::get('/messages/compose/{recipient?}', [\App\Http\Controllers\Forum\MessagingController::class, 'compose'])->name('messaging.compose');
        Route::post('/messages/send', [\App\Http\Controllers\Forum\MessagingController::class, 'send'])->name('messaging.send');
        Route::get('/messages/{conversationId}', [\App\Http\Controllers\Forum\MessagingController::class, 'conversation'])->name('messaging.conversation');
        Route::delete('/messages/{message}', [\App\Http\Controllers\Forum\MessagingController::class, 'destroy'])->name('messaging.destroy');
        
        // Attachment routes
        Route::post('/attachments/upload', [\App\Http\Controllers\Forum\AttachmentController::class, 'upload'])->name('attachment.upload');
        Route::delete('/attachments/{attachment}', [\App\Http\Controllers\Forum\AttachmentController::class, 'destroy'])->name('attachment.destroy');
        
        // Gallery routes
        Route::post('/gallery/upload', [\App\Http\Controllers\Forum\GalleryController::class, 'upload'])->name('gallery.upload');
        Route::delete('/gallery/{image}', [\App\Http\Controllers\Forum\GalleryController::class, 'destroy'])->name('gallery.destroy');
    });
    
    // Mention search (public)
    Route::get('/mentions/search', [\App\Http\Controllers\Forum\MentionController::class, 'search'])->name('mentions.search');
    
    // Public attachment download
    Route::get('/attachments/{attachment}/download', [\App\Http\Controllers\Forum\AttachmentController::class, 'download'])->name('attachment.download');
    
    // Gallery routes (public)
    Route::get('/gallery/{user}', [\App\Http\Controllers\Forum\GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/image/{image}', [\App\Http\Controllers\Forum\GalleryController::class, 'show'])->name('gallery.show');
    
    // Public leaderboard
    Route::get('/leaderboard', [\App\Http\Controllers\Forum\LeaderboardController::class, 'index'])->name('leaderboard');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
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
    
    // Moderation routes
    Route::prefix('moderation')->name('moderation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ModerationController::class, 'index'])->name('index');
        Route::get('/reports/{report}', [\App\Http\Controllers\Admin\ModerationController::class, 'show'])->name('show');
        Route::post('/reports/{report}/resolve', [\App\Http\Controllers\Admin\ModerationController::class, 'resolve'])->name('resolve');
        Route::get('/warnings', [\App\Http\Controllers\Admin\ModerationController::class, 'warnings'])->name('warnings');
        Route::get('/bans', [\App\Http\Controllers\Admin\ModerationController::class, 'bans'])->name('bans');
        Route::post('/bans/{ban}/unban', [\App\Http\Controllers\Admin\ModerationController::class, 'unban'])->name('unban');
    });
});
