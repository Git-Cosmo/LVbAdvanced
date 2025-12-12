# HTML Sanitization Guide for Rich Text Editor

## ⚠️ Security Warning

The rich text editor component (`resources/views/components/rich-text-editor.blade.php`) uses `contenteditable`, which accepts raw HTML input from users. **This creates a serious XSS (Cross-Site Scripting) vulnerability if content is not properly sanitized before storage.**

---

## 🔒 Required Implementation

### Critical: Server-Side Sanitization

You **MUST** sanitize all HTML content from the rich text editor on the server side before storing it in the database. Client-side protection is not sufficient.

---

## 📋 Implementation Options

### Option 1: HTMLPurifier (Recommended)

HTMLPurifier is a standards-compliant HTML filter library that provides comprehensive XSS protection.

#### Installation

```bash
composer require ezyang/htmlpurifier
```

#### Setup

1. **Rename the example service:**
   ```bash
   mv app/Services/HtmlSanitizerService.php.example app/Services/HtmlSanitizerService.php
   ```

2. **Use in your controllers:**

```php
<?php

namespace App\Http\Controllers\Forum;

use App\Services\HtmlSanitizerService;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function store(Request $request, Forum $forum)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        // ✅ SANITIZE BEFORE STORING
        $sanitizer = app(HtmlSanitizerService::class);
        $safeContent = $sanitizer->sanitize($validated['content']);
        
        // Now safe to store
        $post = Post::create([
            'title' => $validated['title'],
            'content' => $safeContent, // Sanitized content
        ]);
        
        return redirect()->route('post.show', $post);
    }
}
```

---

### Option 2: Simple strip_tags() (Basic Protection)

If you cannot install HTMLPurifier, use `strip_tags()` as a minimum:

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'content' => 'required|string',
    ]);
    
    // Allow only specific HTML tags
    $allowedTags = '<p><strong><em><u><h2><ul><ol><li><blockquote><code><pre><a>';
    $content = strip_tags($validated['content'], $allowedTags);
    
    // Remove dangerous attributes and protocols
    $content = preg_replace('/href\s*=\s*["\']?\s*javascript:/i', 'href="#"', $content);
    $content = preg_replace('/href\s*=\s*["\']?\s*data:/i', 'href="#"', $content);
    $content = preg_replace('/\s*on\w+\s*=\s*["\']?[^"\']*["\']?/i', '', $content);
    
    Post::create(['content' => $content]);
}
```

**Note:** This is less secure than HTMLPurifier but better than nothing.

---

## 🎯 Allowed HTML Tags

The rich text editor produces these HTML tags:

| Tag | Purpose | Safe? |
|-----|---------|-------|
| `<p>` | Paragraphs | ✅ Yes |
| `<strong>` | Bold text | ✅ Yes |
| `<em>` | Italic text | ✅ Yes |
| `<u>` | Underline | ✅ Yes |
| `<h2>` | Headings | ✅ Yes |
| `<ul>`, `<ol>`, `<li>` | Lists | ✅ Yes |
| `<blockquote>` | Quotes | ✅ Yes |
| `<code>`, `<pre>` | Code blocks | ✅ Yes |
| `<a href="">` | Links | ⚠️ Requires validation |

### Link Validation

Links are the most dangerous element. You must:

1. **Validate URL protocol** - Only allow `http://` and `https://`
2. **Block dangerous protocols** - `javascript:`, `data:`, `vbscript:`
3. **Remove event handlers** - `onclick`, `onload`, etc.
4. **Consider adding** `rel="nofollow"` for user-generated links

---

## 🚨 What Happens Without Sanitization?

### Attack Example

User submits:
```html
<img src=x onerror="alert('XSS')">
<a href="javascript:alert('XSS')">Click me</a>
<script>steal_cookies()</script>
```

**Without sanitization:** This code executes when another user views the post, stealing cookies, redirecting users, or worse.

**With sanitization:** HTMLPurifier removes all malicious code, leaving only safe HTML.

---

## ✅ Implementation Checklist

### Before Going Live

- [ ] Install HTMLPurifier: `composer require ezyang/htmlpurifier`
- [ ] Rename `HtmlSanitizerService.php.example` to `HtmlSanitizerService.php`
- [ ] Update `ThreadController` to sanitize content before storing
- [ ] Update any other controllers that accept rich text input
- [ ] Test with malicious HTML payloads to verify sanitization works
- [ ] Add automated tests for XSS protection

### Testing Sanitization

Test with these payloads to ensure they're neutralized:

```html
<!-- Test 1: Script injection -->
<script>alert('XSS')</script>

<!-- Test 2: Event handler -->
<img src=x onerror="alert('XSS')">

<!-- Test 3: JavaScript link -->
<a href="javascript:alert('XSS')">Click</a>

<!-- Test 4: Data URI -->
<a href="data:text/html,<script>alert('XSS')</script>">Click</a>

<!-- Test 5: On* attributes -->
<p onclick="alert('XSS')">Text</p>

<!-- Test 6: Style injection -->
<div style="background:url('javascript:alert(1)')">Text</div>
```

All of these should be stripped or neutralized by your sanitization.

---

## 📝 Code Example: Complete Implementation

### ThreadController with Sanitization

```php
<?php

namespace App\Http\Controllers\Forum;

use App\Models\Forum\Forum;
use App\Models\Forum\ForumThread;
use App\Services\HtmlSanitizerService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ThreadController extends Controller
{
    protected HtmlSanitizerService $sanitizer;
    
    public function __construct(HtmlSanitizerService $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }
    
    public function store(Request $request, Forum $forum): RedirectResponse
    {
        $this->authorize('create', [ForumThread::class, $forum]);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:50000', // Max length for rich content
        ]);
        
        // ✅ CRITICAL: Sanitize HTML content before storing
        $safeContent = $this->sanitizer->sanitize($validated['content']);
        
        // Create thread with sanitized content
        $thread = $this->threadService->createThread([
            'forum_id' => $forum->id,
            'title' => $validated['title'],
        ], $request->user());
        
        // Create first post with sanitized content
        $this->threadService->createPost($thread, [
            'content' => $safeContent, // Using sanitized content
        ], $request->user());
        
        // Award XP for creating a thread
        $this->gamificationService->awardActionXP($request->user(), 'create_thread');
        
        return redirect()->route('forum.thread.show', $thread->slug)
            ->with('success', 'Thread created successfully!');
    }
}
```

---

## 🔍 Displaying Sanitized Content

When displaying sanitized content in Blade templates:

### ✅ Correct (for sanitized HTML)

```blade
{!! $post->content !!}  {{-- Use {!! !!} for sanitized HTML --}}
```

### ❌ Incorrect

```blade
{{ $post->content }}  {{-- This will escape HTML tags, showing them as text --}}
```

**Important:** Only use `{!! !!}` for content that has been sanitized server-side!

---

## 📚 Additional Resources

- [HTMLPurifier Documentation](http://htmlpurifier.org/docs)
- [OWASP XSS Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html)
- [Laravel Security Best Practices](https://laravel.com/docs/security)

---

## ⚡ Quick Reference

### Installation Command
```bash
composer require ezyang/htmlpurifier
```

### Minimum Code Required
```php
use App\Services\HtmlSanitizerService;

$sanitizer = app(HtmlSanitizerService::class);
$safeContent = $sanitizer->sanitize($validated['content']);
```

### Files to Update
- `app/Http/Controllers/Forum/ThreadController.php` - Add sanitization in `store()` method
- Any other controller that accepts rich text input

---

## 🎯 Summary

1. **Install HTMLPurifier** - Best protection available
2. **Use HtmlSanitizerService** - Centralized sanitization logic
3. **Sanitize before storing** - Never trust user input
4. **Test thoroughly** - Verify XSS attacks are blocked
5. **Display with {!! !!}** - Only for sanitized content

**Remember:** XSS vulnerabilities are one of the most common and dangerous web security issues. Always sanitize user-generated HTML!

---

**Last Updated:** December 2025  
**Status:** ⚠️ CRITICAL - Implement before production deployment  
**Priority:** HIGH
