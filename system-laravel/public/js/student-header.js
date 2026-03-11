/**
 * student-header.js — public/js/student-header.js
 * Requires: <script>const ChatConfig = { conversation: 'Marcus_Wright' };</script>
 */

const STUDENT_CONVERSATION = window.ChatConfig?.conversation || 'Marcus_Wright';
const STUDENT_ROLE = 'Student';

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
let lastMessageIndex       = 0;
let studentPollInterval    = null;
let studentPreviewInterval = null;

// ── Helpers ───────────────────────────────────────────────────
function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// ── Render a message bubble ───────────────────────────────────
function appendMessage(message, sender) {
    const isStudent = (sender === 'Student');
    const wrapper = document.createElement('div');
    wrapper.className = isStudent
        ? 'flex items-start gap-2 self-end max-w-[85%] ml-auto'
        : 'flex items-start gap-2 max-w-[85%]';
    wrapper.innerHTML = `
        <div class="${isStudent
            ? 'bg-emerald-600 text-white rounded-2xl rounded-br-none'
            : 'bg-white border border-gray-200 text-gray-700 rounded-2xl rounded-bl-none shadow-sm'
        } p-3 text-sm">${escapeHtml(message)}</div>
    `;
    messageList.appendChild(wrapper);
    messageList.scrollTop = messageList.scrollHeight;
}

// ── Poll messages ─────────────────────────────────────────────
function pollStudentMessages() {
    fetch(`/get-messages?conversation=${STUDENT_CONVERSATION}&after=${lastMessageIndex}&role=${STUDENT_ROLE}`)
        .then(r => r.json())
        .then(data => {
            data.messages.forEach(msg => {
                appendMessage(msg.message, msg.sender);
            });
            lastMessageIndex = data.total;
        })
        .catch(() => {});
}

function startChatPolling() {
    lastMessageIndex = 0;
    messageList.innerHTML = '';
    pollStudentMessages();
    if (!studentPollInterval) studentPollInterval = setInterval(pollStudentMessages, 2000);
}

function stopChatPolling() {
    clearInterval(studentPollInterval);
    studentPollInterval = null;
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
function sendStudentMessage() {
    const message = msgInput.value.trim();
    if (!message) return;
    appendMessage(message, 'Student');
    lastMessageIndex++;
    msgInput.value = '';
    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message, sender: 'Student', conversation: STUDENT_CONVERSATION })
    });
}

sendBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    sendStudentMessage();
});

msgInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') sendStudentMessage(); });

// ── Notes / Diary ─────────────────────────────────────────────
const diaryBtn     = document.getElementById('diaryBtn');
const inboxModal   = document.getElementById('inboxModal');
const composeModal = document.getElementById('composeModal');
const closeInbox   = document.getElementById('closeInbox');
const closeCompose = document.getElementById('closeCompose');
const addNewBtn    = document.getElementById('addNewBtn');
const saveNote     = document.getElementById('saveNote');

diaryBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    justOpenedModal = true;
    inboxModal.classList.remove('hidden');
});

addNewBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    justOpenedModal = true;
    composeModal.classList.remove('hidden');
});

closeInbox.addEventListener('click', (e) => {
    e.stopPropagation();
    inboxModal.classList.add('hidden');
});

closeCompose.addEventListener('click', (e) => {
    e.stopPropagation();
    composeModal.classList.add('hidden');
});

saveNote.addEventListener('click', (e) => {
    e.stopPropagation();
    alert('Note saved!');
    composeModal.classList.add('hidden');
});

// Close notes modals on backdrop tap
inboxModal.addEventListener('click',   (e) => { if (e.target === inboxModal)   inboxModal.classList.add('hidden'); });
composeModal.addEventListener('click', (e) => { if (e.target === composeModal) composeModal.classList.add('hidden'); });

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