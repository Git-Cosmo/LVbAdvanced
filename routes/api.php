<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\ThreadController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\DiscordBotStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API routes
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');

    // Public endpoints
    Route::get('/forums', [ForumController::class, 'index']);
    Route::get('/forums/{forum}', [ForumController::class, 'show']);
    Route::get('/threads', [ThreadController::class, 'index']);
    Route::get('/threads/{thread}', [ThreadController::class, 'show']);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{news}', [NewsController::class, 'show']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/search', [SearchController::class, 'search']);

    // Protected endpoints
    Route::middleware('auth:sanctum')->group(function () {
        // Forums
        Route::post('/forums/{forum}/threads', [ThreadController::class, 'store']);
        Route::put('/threads/{thread}', [ThreadController::class, 'update']);
        Route::delete('/threads/{thread}', [ThreadController::class, 'destroy']);
        Route::post('/threads/{thread}/subscribe', [ThreadController::class, 'subscribe']);
        Route::delete('/threads/{thread}/subscribe', [ThreadController::class, 'unsubscribe']);

        // Posts
        Route::post('/threads/{thread}/posts', [PostController::class, 'store']);
        Route::put('/posts/{post}', [PostController::class, 'update']);
        Route::delete('/posts/{post}', [PostController::class, 'destroy']);
        Route::post('/posts/{post}/reactions', [PostController::class, 'react']);

        // User Profile
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::post('/users/{user}/follow', [ProfileController::class, 'follow']);
        Route::delete('/users/{user}/follow', [ProfileController::class, 'unfollow']);

        // Notifications
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

        // Media
        Route::post('/media/upload', [MediaController::class, 'upload']);
        Route::get('/media', [MediaController::class, 'index']);
        Route::delete('/media/{media}', [MediaController::class, 'destroy']);
    });
});

// Discord Bot API (existing)
Route::prefix('discord-bot')->name('api.discord.')->group(function () {
    Route::get('/status', [DiscordBotStatusController::class, 'status'])->name('status');
    Route::get('/commands', [DiscordBotStatusController::class, 'commands'])->name('commands');
});
