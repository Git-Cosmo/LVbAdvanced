/**
 * Forum-specific JavaScript
 * Contains helper functions for forum interactions
 */

// Helper function to apply dynamic badge colors
function applyBadgeColors() {
    document.querySelectorAll('[data-badge-color]').forEach(element => {
        const color = element.dataset.badgeColor;
        if (color) {
            element.style.backgroundColor = color + '20'; // 20 = 12.5% opacity in hex
            element.style.color = color;
        }
    });
}

// Helper function to apply dynamic background images
function applyBackgroundImages() {
    document.querySelectorAll('[data-bg-image]').forEach(element => {
        const imageUrl = element.dataset.bgImage;
        if (imageUrl) {
            element.style.backgroundImage = `url('${imageUrl}')`;
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    applyBadgeColors();
    applyBackgroundImages();
});

// Export functions for use in Alpine components if needed
window.forumHelpers = {
    applyBadgeColors,
    applyBackgroundImages
};
