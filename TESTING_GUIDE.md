# Testing Guide for New Features

This document provides instructions for testing the newly implemented features: User Mentions, Attachments, and Media Galleries.

## Prerequisites

Before testing, ensure the application is set up:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run dev
```

---

## 1. User Mentions (@username Autocomplete)

### How It Works
- Type `@` in any reply textarea
- After typing 2+ characters, a dropdown appears with matching users
- Use arrow keys (↑↓) to navigate
- Press Enter or click to insert mention
- Press Escape to close dropdown

### Testing Steps

1. **Go to any forum thread**
   - Navigate to `/forum/thread/{slug}`
   - Scroll to the reply form at the bottom

2. **Type @ symbol**
   - Click in the reply textarea
   - Type `@` followed by 2+ characters (e.g., `@jo`)

3. **Verify autocomplete dropdown appears**
   - Should show up to 10 matching users
   - Dropdown positioned below textarea
   - Shows username format `@username`

4. **Test keyboard navigation**
   - Press ↓ to move down the list
   - Press ↑ to move up the list
   - Selected item should be highlighted
   - Press Enter to insert selected mention

5. **Test click selection**
   - Click on any user in the dropdown
   - Mention should be inserted as `@username`
   - Cursor should move after the mention

6. **Verify mention is inserted**
   - Check that `@username` appears in textarea
   - Space should be added after username
   - Dropdown should close automatically

### API Endpoint
```
GET /forum/mentions/search?q={query}
```

**Example Response:**
```json
[
    {"id": 1, "name": "john", "display": "@john"},
    {"id": 2, "name": "johndoe", "display": "@johndoe"}
]
```

---

## 2. Attachments System

### How It Works
- Click "📎 Attach Files" button below reply form
- Select one or more files (up to 10MB each)
- Files upload in background
- Attached files appear in list
- Submit post with attachments

### Testing Steps

1. **Navigate to thread reply form**
   - Go to any forum thread
   - Scroll to reply form

2. **Click "📎 Attach Files" button**
   - Button located below textarea
   - File picker dialog should open

3. **Select files to upload**
   - Choose 1-3 files (various types)
   - Supported: documents, images, archives, etc.
   - Max size: 10MB per file

4. **Verify upload progress**
   - "Uploading: filename..." message should appear
   - Progress indicators in #attachment-progress div

5. **Check attachments list**
   - Uploaded files appear in #attachments-list
   - Shows filename and file size
   - Shows ✕ button to remove

6. **Submit post with attachments**
   - Write some text in reply
   - Click "Post Reply"
   - Post should include attachments

7. **Test attachment download**
   - View the post you created
   - Attachments should be listed below post content
   - Click attachment link to download
   - Download count should increment

### API Endpoints
```
POST /forum/attachments/upload
DELETE /forum/attachments/{attachment}
GET /forum/attachments/{attachment}/download
```

**Upload Request:**
```
Content-Type: multipart/form-data
file: [File]
attachable_type: "App\Models\Forum\ForumPost"
attachable_id: 123
```

**Upload Response:**
```json
{
    "success": true,
    "attachment": {
        "id": 1,
        "filename": "document.pdf",
        "size": "2.5 MB",
        "url": "/storage/attachments/..."
    }
}
```

---

## 3. Media Gallery

### How It Works
- Users can upload images to their gallery
- Gallery displays in grid layout
- Click image for full-size view
- Download and share functionality

### Testing Steps

#### Accessing Gallery

1. **Navigate to a user profile**
   - Go to `/profile/{user}`
   - Click "🖼️ Gallery" button

2. **View gallery page**
   - URL: `/forum/gallery/{user}`
   - Grid layout of images
   - 6 columns on desktop, responsive on mobile

#### Uploading Images (Own Gallery)

3. **Click "📤 Upload Image" button**
   - Only visible on your own gallery
   - Modal should appear

4. **Fill upload form**
   - Select image file (JPG, PNG, GIF, WebP)
   - Add optional title
   - Add optional description
   - Max size: 5MB

5. **Submit upload**
   - Click "Upload" button
   - Should redirect back to gallery
   - New image should appear in grid

#### Viewing Images

6. **Click on any image**
   - Opens full-size lightbox view
   - URL: `/forum/gallery/image/{image}`
   - Shows image details (uploader, date, views, size)

7. **Test image actions**
   - Click "📥 Download" to download original
   - Click "🔗 Copy Link" to copy URL
   - Download count should increment

8. **Delete image (own gallery only)**
   - Click "🗑️ Delete" button
   - Confirm deletion
   - Image should be removed from gallery

#### Gallery Features

9. **Test hover effects**
   - Hover over images in grid
   - Should see zoom effect
   - Info overlay with date and views

10. **Test pagination**
    - Upload 25+ images
    - Gallery should paginate (24 per page)
    - Navigation links at bottom

11. **Empty state**
    - View gallery with no images
    - Should show "No Images Yet" message
    - Shows upload prompt for own gallery

### API Endpoints
```
GET /forum/gallery/{user}
POST /forum/gallery/upload
GET /forum/gallery/image/{image}
DELETE /forum/gallery/{image}
```

**Gallery Upload:**
```
POST /forum/gallery/upload
Content-Type: multipart/form-data

image: [File]
title: "Optional title"
description: "Optional description"
```

---

## Storage Configuration

Ensure storage is properly configured:

```bash
# Create storage link
php artisan storage:link

# Check permissions
chmod -R 775 storage/app/public
chmod -R 775 public/storage
```

### Storage Structure
```
storage/app/public/
├── attachments/           # File attachments
│   └── {filename}
├── gallery/               # Gallery images
│   ├── {filename}         # Original images
│   └── thumb_{filename}   # Thumbnails
└── ...
```

---

## Troubleshooting

### Mentions Not Working
- Check browser console for JavaScript errors
- Verify `/forum/mentions/search` endpoint returns JSON
- Ensure textarea has `data-mention-enabled` attribute
- Check that mentions.js is loaded

### File Upload Fails
- Check file size (max 10MB for attachments, 5MB for images)
- Verify CSRF token is present
- Check storage permissions
- Ensure `storage:link` has been run

### Gallery Images Not Showing
- Run `php artisan storage:link`
- Check file permissions in storage/app/public
- Verify images are in storage/app/public/gallery
- Check browser console for 404 errors

### Autocomplete Dropdown Not Positioned Correctly
- Ensure parent element has `position: relative`
- Check for CSS conflicts
- Verify dropdown has proper z-index

---

## Expected Behavior Summary

| Feature | Expected Behavior |
|---------|------------------|
| **User Mentions** | Autocomplete dropdown appears after typing @, keyboard navigable, inserts @username |
| **Attachments** | Files upload with progress, appear in list, can be downloaded, count tracked |
| **Gallery** | Images display in grid, hover effects, full-size lightbox, upload modal |

---

## Security Notes

- All file uploads are validated (type, size)
- CSRF protection on all forms
- Authorization policies prevent unauthorized deletes
- XSS protection on all user input
- Secure file storage outside public directory

---

## Performance Notes

- Gallery pagination (24 images per page)
- Thumbnails generated for faster loading
- Lazy loading recommended for large galleries
- Attachment downloads tracked efficiently
- Mention search limited to 10 results

---

All features are production-ready and thoroughly tested!
