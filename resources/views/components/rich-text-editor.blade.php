@props(['name' => 'content', 'value' => '', 'placeholder' => 'Write your content here...'])

{{-- 
    Simple Rich Text Editor Component
    
    NOTE: This is a basic implementation using contenteditable and document.execCommand().
    While document.execCommand() is deprecated, it still works in all major browsers.
    
    For production use, consider upgrading to:
    - TinyMCE (https://www.tiny.cloud/)
    - Quill.js (https://quilljs.com/)
    - Trix Editor (https://trix-editor.org/)
    
    SECURITY: Content is sanitized on the server side. Ensure backend validation
    and sanitization (e.g., using HTMLPurifier) before storing in database.
--}}

<div x-data="richTextEditor()" x-init="init()">
    <div class="border dark:border-dark-border-primary border-light-border-primary rounded-lg overflow-hidden">
        <!-- Toolbar -->
        <div class="flex flex-wrap items-center gap-1 p-2 dark:bg-dark-bg-tertiary bg-light-bg-tertiary border-b dark:border-dark-border-primary border-light-border-primary">
            <!-- Bold -->
            <button type="button" @click="format('bold')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Bold">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 4h6a3 3 0 110 6H6V4zm0 8h7a3 3 0 110 6H6v-6z"/>
                </svg>
            </button>
            
            <!-- Italic -->
            <button type="button" @click="format('italic')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Italic">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 5h4v2h-1.5l-2 6H12v2H8v-2h1.5l2-6H10V5z"/>
                </svg>
            </button>
            
            <!-- Underline -->
            <button type="button" @click="format('underline')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Underline">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 17h12v1H4v-1zm6-15a5 5 0 015 5v5a5 5 0 01-10 0V7a5 5 0 015-5z"/>
                </svg>
            </button>
            
            <div class="w-px h-6 dark:bg-dark-border-primary bg-light-border-primary"></div>
            
            <!-- Heading -->
            <button type="button" @click="format('h2')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors font-bold" title="Heading">
                H
            </button>
            
            <!-- Bullet List -->
            <button type="button" @click="format('insertUnorderedList')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Bullet List">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4h1v1H3V4zm3 0h11v1H6V4zM3 9h1v1H3V9zm3 0h11v1H6V9zm-3 5h1v1H3v-1zm3 0h11v1H6v-1z"/>
                </svg>
            </button>
            
            <!-- Numbered List -->
            <button type="button" @click="format('insertOrderedList')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Numbered List">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4v1h1V4H3zm0 5v1h2V9H3zm0 5v1h3v-1H3zm3-9h11v1H6V5zm0 5h11v1H6v-1zm0 5h11v1H6v-1z"/>
                </svg>
            </button>
            
            <div class="w-px h-6 dark:bg-dark-border-primary bg-light-border-primary"></div>
            
            <!-- Link -->
            <button type="button" @click="insertLink()" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Insert Link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
            </button>
            
            <!-- Quote -->
            <button type="button" @click="format('formatBlock', 'blockquote')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Quote">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                </svg>
            </button>
            
            <!-- Code -->
            <button type="button" @click="format('formatBlock', 'pre')" class="p-2 rounded dark:hover:bg-dark-bg-elevated hover:bg-light-bg-elevated transition-colors" title="Code">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
            </button>
        </div>
        
        <!-- Editor Area -->
        <div 
            contenteditable="true"
            x-ref="editor"
            @input="updateValue()"
            class="min-h-[200px] p-4 dark:bg-dark-bg-secondary bg-light-bg-secondary dark:text-dark-text-primary text-light-text-primary focus:outline-none prose dark:prose-invert max-w-none"
            placeholder="{{ $placeholder }}"
        >{!! $value !!}</div>
    </div>
    
    <!-- Hidden input to submit -->
    <input type="hidden" name="{{ $name }}" x-model="content">
</div>

<script>
function richTextEditor() {
    return {
        content: @json($value),
        
        init() {
            // Set initial content if provided
            if (this.content) {
                this.$refs.editor.innerHTML = this.content;
            }
        },
        
        format(command, value = null) {
            document.execCommand(command, false, value);
            this.updateValue();
        },
        
        insertLink() {
            // TODO: Replace with proper modal dialog in future iteration
            // Using prompt() temporarily for quick implementation
            const url = prompt('Enter URL (starting with http:// or https://):');
            if (url) {
                // Basic URL validation
                if (url.startsWith('http://') || url.startsWith('https://')) {
                    this.format('createLink', url);
                } else {
                    alert('Please enter a valid URL starting with http:// or https://');
                }
            }
        },
        
        updateValue() {
            this.content = this.$refs.editor.innerHTML;
        }
    }
}
</script>

<style>
[contenteditable]:empty:before {
    content: attr(placeholder);
    color: #6b7280;
    pointer-events: none;
}

[contenteditable] blockquote {
    border-left: 4px solid #6366f1;
    padding-left: 1rem;
    margin-left: 0;
    font-style: italic;
}

[contenteditable] pre {
    background: #1e293b;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    font-family: 'Courier New', monospace;
}
</style>
