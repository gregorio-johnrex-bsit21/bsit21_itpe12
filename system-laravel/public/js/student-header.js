/**
 * student-header.js — public/js/student-header.js
 * Requires: <script>const ChatConfig = { conversation: 'Marcus_Wright' };</script>
 */

const STUDENT_CONVERSATION = window.ChatConfig?.conversation || 'Marcus_Wright';
const STUDENT_ROLE = 'Student';

console.log('STUDENT_CONVERSATION:', STUDENT_CONVERSATION);

// ── DOM elements ─────────────────────────────────────────────
const msgBtn      = document.getElementById('msgBtn');
const msgModal    = document.getElementById('msgModal');
const notifBtn    = document.getElementById('notifBtn');
const notifModal  = document.getElementById('notifModal');
const chatBox     = document.getElementById('chatBox');
const msgInput    = document.getElementById('msgInput');
const sendBtn     = document.getElementById('sendBtn');
const messageList = document.getElementById('messageList');

// ── Flag to prevent document listener from closing a modal we just opened ──
let justOpenedModal = false;

// ── Modal open/close ──────────────────────────────────────────
function closeAll() {
    msgModal.classList.add('hidden');
    notifModal.classList.add('hidden');
}

function openChat() {
    msgModal.classList.add('hidden');
    chatBox.classList.remove('hidden');
    startChatPolling();
    markAsRead();
    markRead(); // ✅ reset the highlight when user opens chat
}

function closeChat() {
    chatBox.classList.add('hidden');
    stopChatPolling();
    lastMessageIndex = 0; 
}

// ── Button listeners ──────────────────────────────────────────
msgBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isHidden = msgModal.classList.contains('hidden');
    closeAll();
    if (isHidden) {
        msgModal.classList.remove('hidden');
        justOpenedModal = true;
    }
});

notifBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isHidden = notifModal.classList.contains('hidden');
    closeAll();
    if (isHidden) {
        notifModal.classList.remove('hidden');
        justOpenedModal = true;
        loadNotifications(); // ← ADD THIS
    }
});
 
// ── Close on outside click/tap ────────────────────────────────
document.addEventListener('click', (e) => {
    if (justOpenedModal) {
        justOpenedModal = false;
        return;
    }
    const clickedInsideMsg   = msgModal.contains(e.target)   || msgBtn.contains(e.target);
    const clickedInsideNotif = notifModal.contains(e.target) || notifBtn.contains(e.target);
    const clickedInsideChat  = chatBox.contains(e.target);

    if (!clickedInsideMsg && !clickedInsideNotif && !clickedInsideChat) {
        closeAll();
    }
});

// ── Chat state ────────────────────────────────────────────────
let lastMessageIndex = 0;
const renderedIds = new Set();
let studentPollInterval    = null;
let studentPreviewInterval = null;

// ── Helpers ───────────────────────────────────────────────────
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// ── Render a message bubble ───────────────────────────────────
function appendMessage(message, sender, id = null) {
    if (id !== null) {
        if (renderedIds.has(id)) return; // ← skip duplicates
        renderedIds.add(id);
    }
    const isStudent = (sender === 'Student');
    const wrapper = document.createElement('div');
    wrapper.className = isStudent
        ? 'flex items-start gap-2 self-end max-w-[85%] ml-auto'
        : 'flex items-start gap-2 max-w-[85%]';

    let content = '';
    if (message.startsWith('[image]')) {
        const url = message.replace('[image]', '');
        content = `<img src="${url}" class="max-w-[200px] max-h-48 rounded-xl object-cover cursor-pointer shadow-sm" onclick="window.open('${url}', '_blank')" />`;
    } else if (message.startsWith('[video]')) {
        const url = message.replace('[video]', '');
        content = `<video src="${url}" controls class="max-w-[200px] max-h-48 rounded-xl shadow-sm"></video>`;
    } else {
        content = `<div class="${isStudent
            ? 'bg-emerald-600 text-white rounded-2xl rounded-br-none'
            : 'bg-white border border-gray-200 text-gray-700 rounded-2xl rounded-bl-none shadow-sm'
        } p-3 text-sm">${escapeHtml(message)}</div>`;
    }

    wrapper.innerHTML = content;
    messageList.appendChild(wrapper);
    messageList.scrollTop = messageList.scrollHeight;
}

// ── Poll messages ─────────────────────────────────────────────
function pollStudentMessages() {
    fetch(`/get-messages?conversation=${STUDENT_CONVERSATION}&after=${lastMessageIndex}&role=${STUDENT_ROLE}`)
        .then(r => r.json())
        .then(data => {
            data.messages.forEach(msg => {
                appendMessage(msg.message, msg.sender, msg.id); // ← pass id
            });
            lastMessageIndex = data.total;
        })
        .catch(() => {});
}

function startChatPolling() {
    lastMessageIndex = 0;
    renderedIds.clear(); // ← add this
    messageList.innerHTML = '';
    pollStudentMessages();
    if (!studentPollInterval) studentPollInterval = setInterval(pollStudentMessages, 2000);
}

function stopChatPolling() {
    clearInterval(studentPollInterval);
    studentPollInterval = null;
}

function closeChat() {
    chatBox.classList.add('hidden');
    stopChatPolling();
    lastMessageIndex = 0;
    renderedIds.clear(); // ← add this
}

// ── Mark as read ──────────────────────────────────────────────
function markAsRead() {
    fetch('/mark-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ conversation: STUDENT_CONVERSATION, role: STUDENT_ROLE })
    }).then(() => updateStudentPreview());
}

// ── Preview + unread badge ────────────────────────────────────
function updateStudentPreview() {
    fetch(`/get-messages?conversation=${STUDENT_CONVERSATION}&after=0&role=${STUDENT_ROLE}`)
        .then(r => r.json())
        .then(data => {
            const unread = data.unread ?? 0;
            const msgs   = data.messages;
            const last   = msgs.length > 0 ? msgs[msgs.length - 1] : null;

            const preview  = document.getElementById('studentMsgPreview');
            const timeEl   = document.getElementById('studentMsgTime');
            const badge    = document.getElementById('studentUnreadBadge');
            const newLabel = document.getElementById('studentNewLabel');

            if (last && preview) preview.textContent = last.message.length > 35 ? last.message.substring(0, 35) + '...' : last.message;
            if (last && timeEl)  timeEl.textContent  = last.time || '';

            if (badge) {
                badge.textContent = unread > 9 ? '9+' : unread;
                badge.classList.toggle('hidden', unread === 0);
                badge.classList.toggle('flex',   unread > 0);
            }
            if (newLabel) {
                newLabel.textContent = unread > 0 ? unread + ' New' : '';
                newLabel.classList.toggle('hidden', unread === 0);
            }

            // ✅ THIS is what was missing — trigger the highlight based on unread count
            if (unread > 0) {
                markUnread();
            } else {
                markRead();
            }
        })
        .catch(() => {});
}
// ── Send message ──────────────────────────────────────────────
/* 
function sendStudentMessage() {
    const message = msgInput.value.trim();  
    if (!message) return;
    const tempId = 'temp_' + Date.now();
    appendMessage(message, 'Student', tempId); // ← temp id for optimistic bubble
    msgInput.value = '';
    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message, sender: 'Student', conversation: STUDENT_CONVERSATION })
    }).then(r => r.json()).then(data => {
        // Replace temp id with real id so poller skips it
        renderedIds.delete(tempId);
        renderedIds.add(data.id);
    });
}

sendBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    sendStudentMessage();
});

msgInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') sendStudentMessage(); });
*/ 
//chat function


// ── Notes / Diary ─────────────────────────────────────────────
const diaryButtons = document.querySelectorAll('.diaryBtn');
const inboxModal   = document.getElementById('inboxModal');
const inboxInner   = document.getElementById('inboxInner');
const composeModal = document.getElementById('composeModal');
const composeInner = document.getElementById('composeInner');
const closeInbox   = document.getElementById('closeInbox');
const closeCompose = document.getElementById('closeCompose');
const addNewBtn    = document.getElementById('addNewBtn');
const saveNoteBtn  = document.getElementById('saveNote');
const notesList    = document.querySelector('#inboxModal .space-y-2');
const titleInput   = document.querySelector('#composeModal input');
const bodyInput    = document.querySelector('#composeModal textarea');

let editingId = null;

// --- Animation Helpers ---
function openModal(modal, inner) {
    modal.classList.remove('hidden');
    void modal.offsetWidth;
    modal.classList.add('backdrop-enter-active');
    inner.classList.add('modal-enter');
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            inner.classList.remove('modal-enter');
            inner.classList.add('modal-enter-active');
        });
    });
    setTimeout(() => {
        modal.classList.remove('backdrop-enter-active');
        inner.classList.remove('modal-enter-active');
    }, 300);  // ← must match CSS enter duration (0.3s = 300ms)
}

function closeModal(modal, inner, callback) {
    modal.classList.add('backdrop-exit-active');
    inner.classList.add('modal-exit-active');
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('backdrop-exit-active');
        inner.classList.remove('modal-exit-active');
        if (callback) callback();
    }, 400);  // ← must match CSS exit duration (0.2s = 200ms)
}

// --- Opening Logic ---
diaryButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        openModal(inboxModal, inboxInner);
        renderNotes();
    });
});

// --- Storage Helpers ---
function getNotes() {
    return JSON.parse(localStorage.getItem('my_notes') || '[]');
}
function saveNotes(notes) {
    localStorage.setItem('my_notes', JSON.stringify(notes));
}

// --- Render Notes List ---
function renderNotes() {
    const notes = getNotes();
    notesList.innerHTML = '';
    if (notes.length === 0) {
        notesList.innerHTML = `<p class="text-center text-sm text-gray-400 py-6">No notes yet. Hit + to add one!</p>`;
        return;
    }
    notes.forEach(note => {
        const div = document.createElement('div');
        div.className = 'p-3 border rounded-lg hover:border-emerald-300 hover:bg-emerald-50 cursor-pointer transition-all flex justify-between items-start group';
        div.innerHTML = `
            <div class="flex-1 min-w-0" data-id="${note.id}">
                <p class="text-sm font-semibold text-gray-800 truncate">${note.title || 'Untitled'}</p>
                <p class="text-xs text-gray-500 truncate">${note.body || ''}</p>
            </div>
            <div class="delete-idle ml-2 transition-opacity self-center">
                <button data-delete="${note.id}" class="text-red-400 hover:text-red-600 active:text-red-600 leading-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </button>
            </div>
            <div class="delete-confirm ml-2 hidden items-center gap-1">
                <span class="text-xs text-gray-500">Delete this note?</span>
                <button data-confirm="${note.id}" class="text-xs px-2 py-0.5 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">Yes</button>
                <button data-cancel class="text-xs px-2 py-0.5 bg-gray-200 text-gray-600 rounded hover:bg-gray-300 transition-colors">No</button>
            </div>
        `;
        const idleEl = div.querySelector('.delete-idle');
        const confirmEl = div.querySelector('.delete-confirm');
        div.querySelector('[data-id]').addEventListener('click', () => openNote(note.id));
        div.querySelector('[data-delete]').addEventListener('click', (e) => {
            e.stopPropagation();
            idleEl.classList.add('hidden');
            confirmEl.classList.remove('hidden');
            confirmEl.classList.add('flex');
        });
        div.querySelector('[data-confirm]').addEventListener('click', (e) => {
            e.stopPropagation();
            const notes = getNotes().filter(n => n.id !== note.id);
            saveNotes(notes);
            renderNotes();
        });
        div.querySelector('[data-cancel]').addEventListener('click', (e) => {
            e.stopPropagation();
            confirmEl.classList.add('hidden');
            confirmEl.classList.remove('flex');
            idleEl.classList.remove('hidden');
        });
        notesList.appendChild(div);
    });
}

// --- Open Note for Editing ---
function openNote(id) {
    const note = getNotes().find(n => n.id === id);
    if (!note) return;
    editingId = id;
    titleInput.value = note.title;
    bodyInput.value = note.body;
    document.querySelector('#composeModal h3').textContent = 'Edit Note';
    openModal(composeModal, composeInner);
}

// --- Save / Update Note ---
saveNoteBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const title = titleInput.value.trim();
    const body = bodyInput.value.trim();
    if (!title && !body) return;
    const notes = getNotes();
    if (editingId) {
        const idx = notes.findIndex(n => n.id === editingId);
        if (idx > -1) { notes[idx].title = title; notes[idx].body = body; }
    } else {
        notes.unshift({ id: Date.now(), title, body, createdAt: new Date().toISOString() });
    }
    saveNotes(notes);
    renderNotes();
    resetCompose();
    closeModal(composeModal, composeInner);
});

function resetCompose() {
    editingId = null;
    titleInput.value = '';
    bodyInput.value = '';
    document.querySelector('#composeModal h3').textContent = 'New Note';
}

// --- Event Listeners ---
addNewBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    resetCompose();
    openModal(composeModal, composeInner);
});

closeInbox.addEventListener('click', (e) => {
    e.stopPropagation();
    closeModal(inboxModal, inboxInner);
});

closeCompose.addEventListener('click', (e) => {
    e.stopPropagation();
    resetCompose();
    closeModal(composeModal, composeInner);
});

inboxModal.addEventListener('click', (e) => {
    if (e.target === inboxModal) closeModal(inboxModal, inboxInner);
});

composeModal.addEventListener('click', (e) => {
    if (e.target === composeModal) {
        resetCompose();
        closeModal(composeModal, composeInner);
    }
});



// ── Start preview polling on load ─────────────────────────────
updateStudentPreview();
studentPreviewInterval = setInterval(updateStudentPreview, 3000);

function markUnread() {
    
    document.getElementById('supervisorName').classList.add('font-black', 'text-green-600');
    document.getElementById('studentMsgPreview').classList.add('font-black', 'text-gray-900');
    document.getElementById('studentMsgPreview').classList.remove('text-gray-500', 'font-medium');
}

function markRead() {
   
    document.getElementById('supervisorName').classList.remove('font-black', 'text-green-600');
    document.getElementById('studentMsgPreview').classList.remove('font-black', 'text-gray-900');
    document.getElementById('studentMsgPreview').classList.add('text-gray-500', 'font-medium');
}


const imageBtn          = document.getElementById('imageBtn');
const mediaInput        = document.getElementById('mediaInput');
const mediaPreviewModal = document.getElementById('mediaPreviewModal');
const imagePreview      = document.getElementById('imagePreview');
const videoPreview      = document.getElementById('videoPreview');
const closeMediaPreview = document.getElementById('closeMediaPreview');
const cancelMediaBtn    = document.getElementById('cancelMediaBtn');
const sendMediaBtn      = document.getElementById('sendMediaBtn');

let selectedMediaFile = null;

// Trigger file picker
imageBtn.addEventListener('click', () => mediaInput.click());

// On file selected
mediaInput.addEventListener('change', () => {
    const file = mediaInput.files[0];
    if (!file) return;

    selectedMediaFile = file;
    const url = URL.createObjectURL(file);
    const isVideo = file.type.startsWith('video/');

    // Show correct preview
    imagePreview.classList.add('hidden');
    videoPreview.classList.add('hidden');

    if (isVideo) {
        videoPreview.src = url;
        videoPreview.classList.remove('hidden');
    } else {
        imagePreview.src = url;
        imagePreview.classList.remove('hidden');
    }

    mediaPreviewModal.classList.remove('hidden');
    mediaInput.value = ''; // reset so same file can be re-selected
});

// Send media as a chat bubble
sendMediaBtn.addEventListener('click', async () => {
    if (!selectedMediaFile) return;

    const formData = new FormData();
    formData.append('file', selectedMediaFile);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    sendMediaBtn.disabled = true;
    sendMediaBtn.textContent = 'Sending...';

    try {
        // 1. Upload media
        const uploadRes = await fetch('/upload-media', { method: 'POST', body: formData });
        if (!uploadRes.ok) {
            const err = await uploadRes.text();
            throw new Error(`Upload failed (${uploadRes.status}): ${err}`);
        }
        const uploadData = await uploadRes.json();
        if (!uploadData.url) throw new Error('Server did not return a URL');

        const url = uploadData.url;
        const isVideo = selectedMediaFile.type.startsWith('video/');
        const mediaMessage = isVideo ? `[video]${url}` : `[image]${url}`;

        // 2. Send chat message
        const msgRes = await fetch('/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                message: mediaMessage,
                sender: 'Student',
                conversation: STUDENT_CONVERSATION
            })
        });

        if (!msgRes.ok) {
            const err = await msgRes.text();
            throw new Error(`Message failed (${msgRes.status}): ${err}`);
        }

        const msgData = await msgRes.json();

        // Optimistically render so user sees it immediately
        renderedIds.add(msgData.id);
        appendMessage(msgData.message, msgData.sender, msgData.id);

        closePreview();
    } catch (err) {
        console.error('Media send error:', err);
        alert('Failed to send photo. Check console for details.');
    } finally {
        sendMediaBtn.disabled = false;
        sendMediaBtn.textContent = 'Send';
    }
});

function closePreview() {
    mediaPreviewModal.classList.add('hidden');
    imagePreview.src = '';
    videoPreview.src = '';
    imagePreview.classList.add('hidden');
    videoPreview.classList.add('hidden');
    selectedMediaFile = null;
}

closeMediaPreview.addEventListener('click', closePreview);
cancelMediaBtn.addEventListener('click', closePreview);
mediaPreviewModal.addEventListener('click', (e) => { if (e.target === mediaPreviewModal) closePreview(); });

// ── Notifications ─────────────────────────────────────────────
const notifBadge = document.getElementById('notifBadge');
const notifList = document.getElementById('notifList');

let notifPollInterval = null;

function loadNotifications() {
    fetch('/student/notifications')
        .then(r => r.json())
        .then(data => {
            const { notifications, unread_count } = data;

            // Update badge
            if (unread_count > 0) {
                notifBadge.textContent = unread_count > 9 ? '9+' : unread_count;
                notifBadge.classList.remove('hidden');
            } else {
                notifBadge.classList.add('hidden');
            }

            // Render list
            if (notifications.length === 0) {
                notifList.innerHTML = `<div class="p-4 text-center text-xs text-gray-400">No notifications</div>`;
                return;
            }

            notifList.innerHTML = notifications.map(n => `
                <div onclick="handleNotifClick(${n.id}, '${n.url}')" 
                     class="p-4 flex gap-3 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-50 ${n.is_read ? 'opacity-60' : 'bg-emerald-50/30'}">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${getNotifIconBg(n.type)}">
                        ${getNotifIcon(n.type)}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-800">${n.title}</p>
                        <p class="text-xs text-gray-500 truncate">${n.message}</p>
                        <p class="text-[10px] text-gray-400 mt-1">${timeAgo(n.created_at)}</p>
                    </div>
                    ${!n.is_read ? `<div class="w-2 h-2 bg-emerald-500 rounded-full flex-shrink-0 mt-1"></div>` : ''}
                </div>
            `).join('');
        })
        .catch(err => console.error('Notif load error:', err));
}

function getNotifIconBg(type) {
    const map = {
        'task_assigned': 'bg-blue-100 text-blue-600',
        'task_approved': 'bg-emerald-100 text-emerald-600',
        'task_rejected': 'bg-red-100 text-red-600',
        'submission_approved': 'bg-emerald-100 text-emerald-600',   // ← green check
        'submission_rejected': 'bg-red-100 text-red-600',             // ← red X
    };
    return map[type] || 'bg-gray-100 text-gray-600';
}

function getNotifIcon(type) {
    const icons = {
        'task_assigned': '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>',
        'task_approved': '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>',
        'task_rejected': '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        'submission_approved': '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>',   // ← green checkmark
        'submission_rejected': '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>', // ← red X
    };
    return icons[type] || '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg>';
}

function timeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    
    if (seconds < 60) return 'Just now';
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) return `${minutes}m ago`;
    const hours = Math.floor(minutes / 60);
    if (hours < 24) return `${hours}h ago`;
    const days = Math.floor(hours / 24);
    return `${days}d ago`;
}

function handleNotifClick(notifId, url) {
    // Mark as read
    fetch(`/student/notifications/${notifId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => {
        loadNotifications();
        if (url) window.location.href = url;
    });
}

function markAllNotifsRead() {
    fetch('/student/notifications/read-all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(() => loadNotifications());
}

// Poll every 30 seconds
loadNotifications();
notifPollInterval = setInterval(loadNotifications, 30000);

