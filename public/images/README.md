# SEO Images Directory

This directory contains images used for SEO and social media optimization.

## Required Images

### 1. og-image.jpg
**Purpose:** Default Open Graph image for social media sharing  
**Dimensions:** 1200 x 630 pixels  
**Format:** JPG or PNG  
**File Size:** < 300KB recommended  

**Design Guidelines:**
- Include FPSociety logo prominently
- Add tagline: "Ultimate Gaming Community"
- Feature gaming-related imagery (Counter Strike, GTA, Fortnite themes)
- Use brand colors (from tailwind.config.js):
  - Primary: Blue (#3B82F6) / Purple (#A855F7)
  - Background: Dark theme preferred
- Ensure text is readable at small sizes
- Avoid placing important content in edges (safe zone: 1200x600)

**Usage:**
- Default image for pages without specific OG image
- Shared on Facebook, Twitter, LinkedIn, Discord, etc.
- Appears in social media previews

**Example Tools:**
- Canva (templates available)
- Figma
- Photoshop
- GIMP (free)

---

### 2. logo.png
**Purpose:** Organization logo for structured data  
**Dimensions:** 512 x 512 pixels (square)  
**Format:** PNG with transparency  
**File Size:** < 100KB recommended  

**Design Guidelines:**
- Square format
- Transparent background
- Clear, recognizable at small sizes
- High contrast
- Should work on both light and dark backgrounds

**Usage:**
- Organization schema markup
- Search engine knowledge panels
- Browser bookmarks/PWA icons
- Structured data rich results

---

## Optional Images

### 3. og-image-news.jpg
**Purpose:** Default image for news articles  
**Dimensions:** 1200 x 630 pixels  

### 4. og-image-forum.jpg
**Purpose:** Default image for forum threads  
**Dimensions:** 1200 x 630 pixels  

### 5. favicon-variants/
- favicon.ico (16x16, 32x32)
- apple-touch-icon.png (180x180)
- favicon-192.png (192x192)
- favicon-512.png (512x512)

---

## Testing Your Images

### Open Graph Testing
1. **Facebook Debugger:** https://developers.facebook.com/tools/debug/
2. **Twitter Card Validator:** https://cards-dev.twitter.com/validator
3. **LinkedIn Post Inspector:** https://www.linkedin.com/post-inspector/

### Structured Data Testing
1. **Google Rich Results Test:** https://search.google.com/test/rich-results
2. **Schema Markup Validator:** https://validator.schema.org/

---

## Current Implementation

These images are referenced in:
- `app/Services/SeoService.php` - Default meta tags
- `resources/views/layouts/app.blade.php` - Layout meta tags
- `app/Http/Controllers/SitemapController.php` - Organization schema

---

## Quick Setup

### Option 1: Use Placeholder
```bash
# Create a simple placeholder using ImageMagick
convert -size 1200x630 -background "#1a1a2e" \
  -fill "#fff" -gravity center \
  -font Arial -pointsize 72 label:"FPSociety" \
  og-image.jpg

convert -size 512x512 -background none \
  -fill "#3B82F6" -gravity center \
  -font Arial -pointsize 120 label:"FPS" \
  logo.png
```

### Option 2: Download Templates
Visit https://placeholders.dev/ for quick placeholders

### Option 3: Design Custom
Use the dimensions and guidelines above to create custom images

---

**Last Updated:** December 11, 2024
