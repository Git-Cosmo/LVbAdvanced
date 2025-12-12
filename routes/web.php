<?php

use App\Http\Controllers\ActivityFeedController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\Forum\ForumController;
use App\Http\Controllers\Forum\PostController;
use App\Http\Controllers\Forum\ProfileController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\CheapSharkSyncController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;

// Public Portal Routes
Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/status', StatusController::class)->name('status');

// Health check endpoint for Docker
Route::get('/up', function () {
    return response()->json(['status' => 'ok'], 200);
})->name('health');

// Static Pages
Route::get('/terms', [\App\Http\Controllers\StaticPageController::class, 'terms'])->name('terms');
Route::get('/privacy', [\App\Http\Controllers\StaticPageController::class, 'privacy'])->name('privacy');
Route::get('/contact', [\App\Http\Controllers\StaticPageController::class, 'contact'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\StaticPageController::class, 'sendContact'])->middleware('throttle:3,10')->name('contact.send');

// Games Routes
Route::prefix('games')->name('games.')->group(function () {
    Route::get('/deals', [DealController::class, 'index'])->name('deals');
    Route::get('/stores', [StoreController::class, 'index'])->name('stores');
});

// Legacy deals routes (for backward compatibility)
Route::get('/deals', function () {
    return redirect()->route('games.deals');
})->name('deals.index');
Route::get('/game/{slug}', [DealController::class, 'show'])->name('deals.show');

// Universal Search Route
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:3,1');
    
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->middleware('throttle:3,10')->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->middleware('throttle:5,10')->name('password.update');
    
    // OAuth Routes
    Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect'])->name('oauth.redirect');
    Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback'])->name('oauth.callback');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])->middleware('throttle:6,1')->name('verification.send');
    
    // Two-Factor Authentication Routes
    Route::get('/2fa/setup', [\App\Http\Controllers\Auth\TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::post('/2fa/enable', [\App\Http\Controllers\Auth\TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable', [\App\Http\Controllers\Auth\TwoFactorController::class, 'disable'])->name('2fa.disable');
});

// 2FA Challenge (requires auth but not 2fa verification)
Route::middleware('auth')->group(function () {
    Route::get('/2fa/challenge', [\App\Http\Controllers\Auth\TwoFactorController::class, 'challenge'])->name('2fa.challenge');
    Route::post('/2fa/verify', [\App\Http\Controllers\Auth\TwoFactorController::class, 'verify'])->name('2fa.verify');
});

// Settings Routes
Route::middleware('auth')->prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [\App\Http\Controllers\SettingsController::class, 'index'])->name('index');
    Route::patch('/account', [\App\Http\Controllers\SettingsController::class, 'updateAccount'])->name('update.account');
    Route::patch('/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('update.password');
    Route::patch('/privacy', [\App\Http\Controllers\SettingsController::class, 'updatePrivacy'])->name('update.privacy');
    Route::patch('/notifications', [\App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('update.notifications');
});

// Notification Routes
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::post('/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark-as-read');
    Route::post('/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
    Route::delete('/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('destroy');
});

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
        Route::get('/poll/{poll}/results', [\App\Http\Controllers\Forum\PollController::class, 'results'])->name('poll.results');
        
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
    Route::get('/schedule-monitor', [\App\Http\Controllers\Admin\ScheduleMonitorController::class, 'index'])->name('schedule-monitor.index');
    
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('index');
        Route::get('/{user}/edit', [\App\Http\Controllers\Admin\UserManagementController::class, 'edit'])->name('edit');
        Route::patch('/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('update');
        Route::patch('/{user}/profile', [\App\Http\Controllers\Admin\UserManagementController::class, 'updateProfile'])->name('updateProfile');
        Route::post('/{user}/achievements', [\App\Http\Controllers\Admin\UserManagementController::class, 'grantAchievement'])->name('grantAchievement');
        Route::delete('/{user}/achievements', [\App\Http\Controllers\Admin\UserManagementController::class, 'revokeAchievement'])->name('revokeAchievement');
        Route::post('/{user}/badges', [\App\Http\Controllers\Admin\UserManagementController::class, 'grantBadge'])->name('grantBadge');
        Route::delete('/{user}/badges', [\App\Http\Controllers\Admin\UserManagementController::class, 'revokeBadge'])->name('revokeBadge');
        Route::delete('/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('destroy');
    });
    
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
        
        // Thread management
        Route::get('/merge-threads', [\App\Http\Controllers\Admin\ModerationController::class, 'mergeThreadsForm'])->name('merge-threads-form');
        Route::post('/merge-threads', [\App\Http\Controllers\Admin\ModerationController::class, 'mergeThreads'])->name('merge-threads');
        Route::get('/move-thread/{thread}', [\App\Http\Controllers\Admin\ModerationController::class, 'moveThreadForm'])->name('move-thread-form');
        Route::post('/move-thread/{thread}', [\App\Http\Controllers\Admin\ModerationController::class, 'moveThread'])->name('move-thread');
        
        // Approval queue
        Route::get('/approval-queue', [\App\Http\Controllers\Admin\ModerationController::class, 'approvalQueue'])->name('approval-queue');
        Route::post('/approve', [\App\Http\Controllers\Admin\ModerationController::class, 'approveContent'])->name('approve');
        Route::post('/deny', [\App\Http\Controllers\Admin\ModerationController::class, 'denyContent'])->name('deny');
    });
    
    // Reputation Management
    Route::prefix('reputation')->name('reputation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReputationController::class, 'index'])->name('index');
        Route::post('/{user}/award-xp', [\App\Http\Controllers\Admin\ReputationController::class, 'awardXP'])->name('award-xp');
        Route::post('/{user}/reset-level', [\App\Http\Controllers\Admin\ReputationController::class, 'resetLevel'])->name('reset-level');
        Route::post('/recalculate-karma', [\App\Http\Controllers\Admin\ReputationController::class, 'recalculateKarma'])->name('recalculate-karma');
    });

    // CheapShark Deals Sync
    Route::prefix('deals')->name('deals.')->group(function () {
        Route::get('/', [CheapSharkSyncController::class, 'index'])->name('index');
        Route::post('/sync', [CheapSharkSyncController::class, 'sync'])->name('sync');
    });

    // Media Management
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MediaManagementController::class, 'index'])->name('index');
        Route::post('/{gallery}/approve', [\App\Http\Controllers\Admin\MediaManagementController::class, 'approve'])->name('approve');
        Route::post('/{gallery}/feature', [\App\Http\Controllers\Admin\MediaManagementController::class, 'feature'])->name('feature');
        Route::delete('/{gallery}', [\App\Http\Controllers\Admin\MediaManagementController::class, 'destroy'])->name('destroy');
    });
    
    // News Management
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\NewsManagementController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\NewsManagementController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\NewsManagementController::class, 'store'])->name('store');
        Route::get('/{news}/edit', [\App\Http\Controllers\Admin\NewsManagementController::class, 'edit'])->name('edit');
        Route::patch('/{news}', [\App\Http\Controllers\Admin\NewsManagementController::class, 'update'])->name('update');
        Route::delete('/{news}', [\App\Http\Controllers\Admin\NewsManagementController::class, 'destroy'])->name('destroy');
    });
    
    // Patch Notes Management
    Route::prefix('patch-notes')->name('patch-notes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PatchNoteController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\PatchNoteController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\PatchNoteController::class, 'store'])->name('store');
        Route::get('/{patchNote}/edit', [\App\Http\Controllers\Admin\PatchNoteController::class, 'edit'])->name('edit');
        Route::patch('/{patchNote}', [\App\Http\Controllers\Admin\PatchNoteController::class, 'update'])->name('update');
        Route::delete('/{patchNote}', [\App\Http\Controllers\Admin\PatchNoteController::class, 'destroy'])->name('destroy');
        Route::patch('/{patchNote}/toggle-publish', [\App\Http\Controllers\Admin\PatchNoteController::class, 'togglePublish'])->name('toggle-publish');
        Route::patch('/{patchNote}/toggle-featured', [\App\Http\Controllers\Admin\PatchNoteController::class, 'toggleFeatured'])->name('toggle-featured');
    });
    
    // RSS Feed Management
    Route::prefix('rss')->name('rss.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RssFeedController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\RssFeedController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\RssFeedController::class, 'store'])->name('store');
        Route::get('/{rssFeed}/edit', [\App\Http\Controllers\Admin\RssFeedController::class, 'edit'])->name('edit');
        Route::patch('/{rssFeed}', [\App\Http\Controllers\Admin\RssFeedController::class, 'update'])->name('update');
        Route::delete('/{rssFeed}', [\App\Http\Controllers\Admin\RssFeedController::class, 'destroy'])->name('destroy');
        Route::post('/{rssFeed}/import', [\App\Http\Controllers\Admin\RssFeedController::class, 'import'])->name('import');
    });
    
    // Gamification Settings
    Route::prefix('gamification')->name('gamification.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\GamificationController::class, 'index'])->name('index');
        Route::post('/update-xp', [\App\Http\Controllers\Admin\GamificationController::class, 'updateXPSettings'])->name('update-xp');
        Route::post('/reset-season', [\App\Http\Controllers\Admin\GamificationController::class, 'resetSeason'])->name('reset-season');
    });
    
    // Reddit Management
    Route::prefix('reddit')->name('reddit.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RedditManagementController::class, 'index'])->name('index');
        Route::post('/scrape', [\App\Http\Controllers\Admin\RedditManagementController::class, 'scrape'])->name('scrape');
        Route::post('/subreddit/{subreddit}/toggle', [\App\Http\Controllers\Admin\RedditManagementController::class, 'toggleSubreddit'])->name('subreddit.toggle');
        Route::patch('/subreddit/{subreddit}', [\App\Http\Controllers\Admin\RedditManagementController::class, 'updateSubreddit'])->name('subreddit.update');
        Route::post('/post/{post}/toggle-publish', [\App\Http\Controllers\Admin\RedditManagementController::class, 'togglePublish'])->name('post.toggle-publish');
        Route::post('/post/{post}/toggle-feature', [\App\Http\Controllers\Admin\RedditManagementController::class, 'toggleFeature'])->name('post.toggle-feature');
        Route::delete('/post/{post}', [\App\Http\Controllers\Admin\RedditManagementController::class, 'deletePost'])->name('post.delete');
    });
    
    // StreamerBans Management
    Route::prefix('streamerbans')->name('streamerbans.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\StreamerBansManagementController::class, 'index'])->name('index');
        Route::post('/scrape', [\App\Http\Controllers\Admin\StreamerBansManagementController::class, 'scrape'])->name('scrape');
        Route::post('/scrape-streamer', [\App\Http\Controllers\Admin\StreamerBansManagementController::class, 'scrapeStreamer'])->name('scrape-streamer');
        Route::post('/{streamerBan}/toggle-publish', [\App\Http\Controllers\Admin\StreamerBansManagementController::class, 'togglePublish'])->name('toggle-publish');
        Route::post('/{streamerBan}/toggle-feature', [\App\Http\Controllers\Admin\StreamerBansManagementController::class, 'toggleFeature'])->name('toggle-feature');
        Route::delete('/{streamerBan}', [\App\Http\Controllers\Admin\StreamerBansManagementController::class, 'deleteStreamer'])->name('delete');
    });
    
    // Events Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\EventsManagementController::class, 'index'])->name('index');
        Route::post('/import', [\App\Http\Controllers\Admin\EventsManagementController::class, 'import'])->name('import');
        Route::post('/{event}/toggle-featured', [\App\Http\Controllers\Admin\EventsManagementController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{event}/toggle-published', [\App\Http\Controllers\Admin\EventsManagementController::class, 'togglePublished'])->name('toggle-published');
        Route::delete('/{event}', [\App\Http\Controllers\Admin\EventsManagementController::class, 'destroy'])->name('destroy');
    });
});

// Public Leaderboard Route
Route::get('/leaderboard', [\App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard.index');

// Activity Feed Routes
Route::prefix('activity')->name('activity.')->group(function () {
    Route::get('/whats-new', [ActivityFeedController::class, 'whatsNew'])->name('whats-new');
    Route::get('/trending', [ActivityFeedController::class, 'trending'])->name('trending');
    Route::get('/recent-posts', [ActivityFeedController::class, 'recentPosts'])->name('recent-posts');
    Route::get('/recommended', [ActivityFeedController::class, 'recommended'])->name('recommended')->middleware('auth');
});

// News Routes
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [\App\Http\Controllers\NewsController::class, 'index'])->name('index');
    Route::get('/{news}', [\App\Http\Controllers\NewsController::class, 'show'])->name('show');
});

// Patch Notes Routes
Route::prefix('patch-notes')->name('patch-notes.')->group(function () {
    Route::get('/', [\App\Http\Controllers\PatchNoteController::class, 'index'])->name('index');
    Route::get('/{patchNote}', [\App\Http\Controllers\PatchNoteController::class, 'show'])->name('show');
});

// Radio Routes
Route::prefix('radio')->name('radio.')->group(function () {
    Route::get('/', [\App\Http\Controllers\RadioController::class, 'index'])->name('index');
    Route::get('/home', [\App\Http\Controllers\RadioController::class, 'home'])->name('home');
    Route::get('/popout', [\App\Http\Controllers\RadioController::class, 'popout'])->name('popout');
    Route::get('/requests', [\App\Http\Controllers\RadioController::class, 'requests'])->name('requests');
    Route::post('/request', [\App\Http\Controllers\RadioController::class, 'submitRequest'])->name('request.submit')->middleware('auth');
});

// Reddit Content Routes
Route::get('/clips', [\App\Http\Controllers\RedditController::class, 'clips'])->name('clips.index');
Route::get('/aitah', [\App\Http\Controllers\RedditController::class, 'aitah'])->name('aitah.index');
Route::get('/reddit/{post}', [\App\Http\Controllers\RedditController::class, 'show'])->name('reddit.show');

// StreamerBans Routes
Route::get('/streamerbans', [\App\Http\Controllers\StreamerBansController::class, 'index'])->name('streamerbans.index');
Route::get('/streamerbans/{streamerBan}', [\App\Http\Controllers\StreamerBansController::class, 'show'])->name('streamerbans.show');

// Events Routes
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [\App\Http\Controllers\EventsController::class, 'index'])->name('index');
    Route::get('/{event}', [\App\Http\Controllers\EventsController::class, 'show'])->name('show');
});

// Downloads Routes (formerly Media & Gallery)
Route::prefix('downloads')->name('downloads.')->group(function () {
    Route::get('/', [MediaController::class, 'index'])->name('index');
    Route::get('/{gallery}', [MediaController::class, 'show'])->name('show');
    Route::get('/download/{mediaId}', [MediaController::class, 'download'])->name('download');
    
    Route::middleware('auth')->group(function () {
        Route::get('/create/upload', [MediaController::class, 'create'])->name('create');
        Route::post('/store', [MediaController::class, 'store'])->name('store');
        Route::delete('/{gallery}', [MediaController::class, 'destroy'])->name('destroy');
        Route::post('/{gallery}/comment', [MediaController::class, 'storeComment'])->name('comment.store');
    });
});

// Sitemap Route
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
