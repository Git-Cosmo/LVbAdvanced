# Middleware Registration Instructions

## HandleApiErrors Middleware

The `HandleApiErrors` middleware has been created but is **not automatically registered** to allow you to decide where to use it.

### Option 1: Register Globally (Recommended for APIs)

To apply error handling to all routes, add to `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
    $middleware->web(append: [
        \App\Http\Middleware\UpdateLastActive::class,
        \App\Http\Middleware\HandleApiErrors::class,  // Add this line
    ]);
})
```

### Option 2: Register as Alias (Apply Selectively)

To apply only to specific routes, add as an alias:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'handle.errors' => \App\Http\Middleware\HandleApiErrors::class,  // Add this line
    ]);
    // ...
})
```

Then use in routes:

```php
Route::get('/api/something', [Controller::class, 'method'])
    ->middleware('handle.errors');
```

### Option 3: Apply to Route Groups

Apply to specific route groups:

```php
Route::middleware(['handle.errors'])->group(function () {
    // All routes in this group will use error handling
    Route::get('/api/users', [UserController::class, 'index']);
    Route::post('/api/users', [UserController::class, 'store']);
});
```

### What the Middleware Does

1. **Catches All Exceptions** - Wraps route execution in try-catch
2. **Logs with Context** - Logs error with URL, method, user_id, IP, file, line
3. **JSON for APIs** - Returns JSON response for API requests
4. **Redirects for Web** - Returns back with error message for web requests
5. **Debug Mode** - Shows detailed errors when `APP_DEBUG=true`

### Example Error Log

```
[2025-12-11 16:50:00] local.ERROR: Request failed 
{
    "url": "https://example.com/api/users",
    "method": "POST",
    "error": "Column not found",
    "file": "/app/Http/Controllers/UserController.php",
    "line": 42,
    "user_id": 123,
    "ip": "192.168.1.1"
}
```

### Example JSON Response (API)

```json
{
    "success": false,
    "error": "An error occurred while processing your request.",
    "message": "Column not found"  // Only when APP_DEBUG=true
}
```

### Example Web Response

- Redirects back to previous page
- Includes flash message: "An error occurred. Please try again."
- Preserves form input

## Recommendation

**For this application:** Register as a web middleware (Option 1) to catch errors globally and provide better user experience.

The middleware is production-ready and safe to use.
