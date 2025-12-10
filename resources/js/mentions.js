// User Mentions Autocomplete
document.addEventListener('DOMContentLoaded', function() {
    const textareas = document.querySelectorAll('[data-mention-enabled]');
    
    textareas.forEach(textarea => {
        let mentionDropdown = null;
        let selectedIndex = -1;
        let mentionQuery = '';
        let mentionStartPos = -1;

        textarea.addEventListener('input', function(e) {
            const cursorPos = this.selectionStart;
            const text = this.value;
            
            // Check if @ was just typed
            const beforeCursor = text.substring(0, cursorPos);
            const match = beforeCursor.match(/@(\w*)$/);
            
            if (match) {
                mentionStartPos = cursorPos - match[0].length;
                mentionQuery = match[1];
                
                if (mentionQuery.length >= 2) {
                    searchUsers(mentionQuery);
                } else if (mentionQuery.length === 0) {
                    showMentionDropdown([], cursorPos);
                }
            } else {
                hideMentionDropdown();
            }
        });

        textarea.addEventListener('keydown', function(e) {
            if (!mentionDropdown || mentionDropdown.classList.contains('hidden')) return;
            
            const items = mentionDropdown.querySelectorAll('[data-mention-item]');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
                updateSelection(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, 0);
                updateSelection(items);
            } else if (e.key === 'Enter' && selectedIndex >= 0) {
                e.preventDefault();
                items[selectedIndex].click();
            } else if (e.key === 'Escape') {
                hideMentionDropdown();
            }
        });

        function searchUsers(query) {
            fetch(`/forum/mentions/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(users => {
                    const rect = textarea.getBoundingClientRect();
                    showMentionDropdown(users, rect);
                });
        }

        function showMentionDropdown(users, rect) {
            if (!mentionDropdown) {
                mentionDropdown = document.createElement('div');
                mentionDropdown.className = 'absolute z-50 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto';
                mentionDropdown.style.minWidth = '200px';
                textarea.parentElement.style.position = 'relative';
                textarea.parentElement.appendChild(mentionDropdown);
            }

            if (users.length === 0) {
                hideMentionDropdown();
                return;
            }

            selectedIndex = 0;
            mentionDropdown.innerHTML = users.map((user, index) => `
                <div data-mention-item data-user-id="${user.id}" data-user-name="${user.name}"
                     class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 ${index === 0 ? 'bg-gray-100 dark:bg-gray-700' : ''}">
                    <div class="font-medium text-gray-900 dark:text-white">@${user.name}</div>
                </div>
            `).join('');

            // Position dropdown below textarea
            mentionDropdown.style.top = (textarea.offsetTop + textarea.offsetHeight + 4) + 'px';
            mentionDropdown.style.left = textarea.offsetLeft + 'px';
            mentionDropdown.classList.remove('hidden');

            // Add click handlers
            mentionDropdown.querySelectorAll('[data-mention-item]').forEach(item => {
                item.addEventListener('click', function() {
                    insertMention(this.dataset.userName);
                });
            });
        }

        function hideMentionDropdown() {
            if (mentionDropdown) {
                mentionDropdown.classList.add('hidden');
            }
            selectedIndex = -1;
        }

        function updateSelection(items) {
            items.forEach((item, index) => {
                if (index === selectedIndex) {
                    item.classList.add('bg-gray-100', 'dark:bg-gray-700');
                } else {
                    item.classList.remove('bg-gray-100', 'dark:bg-gray-700');
                }
            });
        }

        function insertMention(userName) {
            const text = textarea.value;
            const beforeMention = text.substring(0, mentionStartPos);
            const afterMention = text.substring(textarea.selectionStart);
            
            textarea.value = beforeMention + '@' + userName + ' ' + afterMention;
            textarea.selectionStart = textarea.selectionEnd = beforeMention.length + userName.length + 2;
            
            hideMentionDropdown();
            textarea.focus();
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target !== textarea && !mentionDropdown?.contains(e.target)) {
                hideMentionDropdown();
            }
        });
    });
});

// File Attachment Upload
function initializeFileUpload() {
    const uploadBtns = document.querySelectorAll('[data-upload-attachment]');
    
    uploadBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '*/*';
            input.multiple = true;
            
            input.addEventListener('change', function() {
                const files = Array.from(this.files);
                const attachableType = btn.dataset.attachableType;
                const attachableId = btn.dataset.attachableId;
                
                files.forEach(file => {
                    uploadFile(file, attachableType, attachableId);
                });
            });
            
            input.click();
        });
    });
}

function uploadFile(file, attachableType, attachableId) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('attachable_type', attachableType);
    formData.append('attachable_id', attachableId);
    
    // Show upload progress
    const progressId = 'upload-' + Date.now();
    showUploadProgress(progressId, file.name);
    
    fetch('/forum/attachments/upload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addAttachmentToList(data.attachment);
            hideUploadProgress(progressId);
        }
    })
    .catch(error => {
        console.error('Upload failed:', error);
        hideUploadProgress(progressId);
    });
}

function showUploadProgress(id, filename) {
    const container = document.getElementById('attachment-progress');
    if (!container) return;
    
    const div = document.createElement('div');
    div.id = id;
    div.className = 'p-2 bg-blue-50 dark:bg-blue-900/20 rounded text-sm';
    div.textContent = `Uploading: ${filename}...`;
    container.appendChild(div);
}

function hideUploadProgress(id) {
    const element = document.getElementById(id);
    if (element) {
        element.remove();
    }
}

function addAttachmentToList(attachment) {
    const container = document.getElementById('attachments-list');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-700 rounded';
    div.innerHTML = `
        <span class="flex-1 text-sm">📎 ${attachment.filename} (${attachment.size})</span>
        <button onclick="removeAttachment(${attachment.id})" class="text-red-600 hover:text-red-800">✕</button>
    `;
    container.appendChild(div);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeFileUpload();
});
