<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OJT Monitoring & Evaluation System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2E7D32; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900" x-data="{
    sidebarOpen: true,
    showTaskModal: false,
    showViewModal: false,    
    showEditModal: false,    
    showDeleteModal: false,
    showUserModal: false,
    notifOpen: false,
    msgOpen: false,
    chatOpen: false,
    chatWith: '',
    chatColor: '',
    profileOpen: false,
    evalFilter: 'all'
}">

    {{-- Sidebar --}}
    @include('supervisor.super_sidebar')


    {{-- Main --}}
    <main :class="sidebarOpen ? 'md:ml-72' : 'md:ml-20'" class="transition-all duration-300 min-h-screen pb-12">

        {{-- Header --}}
        @include('supervisor.super_header')

        {{-- Page Content --}}
        <div class="p-4 md:p-8 max-w-7xl mx-auto">
            @yield('content')
        </div>

        {{-- ===================== CHAT WINDOW ===================== --}}
        <div x-show="chatOpen" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-full"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="fixed bottom-0 right-8 w-[340px] bg-white shadow-2xl rounded-t-3xl border border-slate-200 z-[60] flex flex-col overflow-hidden">

            {{-- Chat Header --}}
            <div class="p-4 bg-white border-b border-slate-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <img :src="`https://ui-avatars.com/api/?name=${chatWith}&background=${chatColor}&color=fff`" class="w-8 h-8 rounded-lg shadow-sm">
                    <div>
                        <p class="text-xs font-black text-slate-800 leading-tight" x-text="chatWith"></p>
                        <p class="text-[9px] font-bold text-green-500 uppercase tracking-widest">Active Now</p>
                    </div>
                </div>
                <button @click="chatOpen = false; closeSupervisorChat()" class="text-slate-300 hover:text-red-500 transition-colors">
                    <i class="fas fa-times-circle text-lg"></i>
                </button>
            </div>

            {{-- Messages Area --}}
            <div id="supervisorMessageList"
                 class="h-64 overflow-y-auto p-4 space-y-3 bg-slate-50/30 custom-scrollbar flex flex-col">
                {{-- Messages rendered by JS --}}
            </div>

            {{-- Input Area --}}
            <div class="p-3 bg-white border-t border-slate-100">
                <div class="flex items-center gap-2 p-1.5 rounded-xl border border-transparent focus-within:bg-white focus-within:border-[#2E7D32] transition-all">
                    <input id="supervisorMsgInput"
                           type="text"
                           placeholder="Type a message..."
                           class="flex-1 bg-transparent border-none focus:ring-0 focus:outline-none text-xs text-slate-700 px-2 h-8">
                    <button id="supervisorSendBtn"
                            class="bg-[#2E7D32] text-white h-8 w-8 rounded-lg shadow-sm hover:bg-[#256629] transition-all flex items-center justify-center">
                        <i class="fas fa-paper-plane text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>
        {{-- ================== END CHAT WINDOW =================== --}}

    </main>

   {{-- ===================== CHAT JAVASCRIPT ===================== --}}
<script>
    const supervisorMsgInput = document.getElementById('supervisorMsgInput');
    const supervisorSendBtn  = document.getElementById('supervisorSendBtn');
    const supervisorMsgList  = document.getElementById('supervisorMessageList');

    let CONVERSATIONS = [];

const COLORS = ['2E7D32', 'D50000', '1565C0', 'E65100', '6A1B9A'];

function openChat(name, color) {
    const alpineEl = document.querySelector('[x-data]');
    const alpine = Alpine.$data(alpineEl);
    alpine.chatOpen = true;
    alpine.chatWith = name;
    alpine.chatColor = color;
    alpine.msgOpen = false;
    openSupervisorChat(name);
}

fetch('/supervisor/chat/students')
    .then(r => r.json())
    .then(students => {
        CONVERSATIONS = students.map(s => s.name.replace(/\s+/g, '_'));
        
        const list = document.getElementById('conversationList');
        
        if (students.length === 0) {
            list.innerHTML = '<p class="text-center text-xs text-slate-400 p-4">No students yet.</p>';
            return;
        }

        list.innerHTML = students.map((s, i) => {
            const key   = s.name.replace(/\s+/g, '_');
            const color = COLORS[i % COLORS.length];
            return `
                <div onclick="openChat('${s.name}', '${color}')"
                     class="p-4 hover:bg-slate-50 border-b border-slate-50 flex gap-3 cursor-pointer group transition-all">
                    <div class="relative shrink-0">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(s.name)}&background=${color}&color=fff" 
                             class="w-10 h-10 rounded-xl group-hover:scale-105 transition-transform shadow-sm">
                        <span id="unread-${key}" class="absolute -top-1 -right-1 w-4 h-4 bg-[#${color}] border-2 border-white rounded-full text-[9px] text-white font-bold items-center justify-center hidden"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <p class="text-sm font-bold text-slate-800">${s.name}</p>
                            <span id="time-${key}" class="text-[9px] text-slate-400 font-black"></span>
                        </div>
                        <p id="preview-${key}" class="text-xs text-slate-500 line-clamp-1 font-medium italic">No messages yet</p>
                    </div>
                </div>
            `;
        }).join('');

        updatePreviews();
    });

    let currentConversation = null;
    let lastMessageIndex    = 0;
    let pollInterval        = null;
    let previewInterval     = null;
    let chatIsOpen          = false;
    const supervisorRenderedIds = new Set(); // ← add this  

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function conversationKey(displayName) {
        return displayName.replace(/\s+/g, '_');
    }

    function appendSupervisorMessage(message, sender, id = null) {
    if (id !== null) {
        if (supervisorRenderedIds.has(id)) return;
        supervisorRenderedIds.add(id);
    }    
    const isSupervisor = (sender === 'Supervisor');
    const wrapper = document.createElement('div');
    wrapper.className = isSupervisor
        ? 'flex gap-2 items-start max-w-[90%] self-end ml-auto'
        : 'flex gap-2 items-start max-w-[90%]';

    let content = '';
    if (message.startsWith('[image]')) {
        const url = message.replace('[image]', '');
        content = `<img src="${url}" class="max-w-[200px] max-h-48 rounded-xl object-cover cursor-pointer shadow-sm" onclick="window.open('${url}', '_blank')" />`;
    } else if (message.startsWith('[video]')) {
        const url = message.replace('[video]', '');
        content = `<video src="${url}" controls class="max-w-[200px] max-h-48 rounded-xl shadow-sm"></video>`;
    } else {
        content = `<div class="${isSupervisor
            ? 'bg-[#2E7D32] text-white rounded-2xl rounded-br-none'
            : 'bg-white border border-slate-100 text-slate-700 rounded-2xl rounded-bl-none'
        } p-3 shadow-sm text-[11px] font-medium leading-relaxed">${escapeHtml(message)}</div>`;
    }

    wrapper.innerHTML = content;
    supervisorMsgList.appendChild(wrapper);
    supervisorMsgList.scrollTop = supervisorMsgList.scrollHeight;
}

    function openSupervisorChat(displayName) {
    const newConversation = conversationKey(displayName);
    if (newConversation !== currentConversation) {
        currentConversation = newConversation;
        lastMessageIndex = 0;
        supervisorMsgList.innerHTML = '';
        supervisorRenderedIds.clear(); // ← add this
    }
    clearInterval(pollInterval);
    pollInterval = null;
    chatIsOpen = true;
    pollMessages();
    markSupervisorRead();
    pollInterval = setInterval(pollMessages, 2000);
}

    function closeSupervisorChat() {
    chatIsOpen = false;
    clearInterval(pollInterval);
    pollInterval = null;
    lastMessageIndex = 0;
    supervisorRenderedIds.clear(); // ← add this
}

    function pollMessages() {
    if (!currentConversation) return;
    fetch(`/get-messages?conversation=${currentConversation}&after=${lastMessageIndex}&role=Supervisor`)
        .then(r => r.json())
        .then(data => {
            data.messages.forEach(msg => {
                appendSupervisorMessage(msg.message, msg.sender, msg.id); // ← add msg.id
            });
            lastMessageIndex = data.total;
        })
        .catch(() => {});
    }

    function updatePreviews() {
        const params = CONVERSATIONS.map(n => `names[]=${n}`).join('&');
        fetch(`/get-conversations?${params}`)
            .then(r => r.json())
            .then(data => {
                let totalUnread = 0;
                CONVERSATIONS.forEach(key => {
                    const info    = data[key];
                    const preview = document.getElementById(`preview-${key}`);
                    const timeel  = document.getElementById(`time-${key}`);
                    const badge   = document.getElementById(`unread-${key}`);

                    if (!info || !info.last) return;

                    if (preview) preview.textContent = info.last.message.length > 35
                        ? info.last.message.substring(0, 35) + '...'
                        : info.last.message;
                    if (timeel) timeel.textContent = info.last.time || '';

                    if (badge) {
                        if (info.unread > 0) {
                            badge.textContent = info.unread > 9 ? '9+' : info.unread;
                            badge.classList.remove('hidden');
                            badge.classList.add('flex');
                        } else {
                            badge.classList.add('hidden');
                            badge.classList.remove('flex');
                        }
                    }
                    totalUnread += info.unread || 0;
                });

                const mainBadge = document.getElementById('totalUnreadBadge');
                if (mainBadge) {
                    if (totalUnread > 0) {
                        mainBadge.textContent = totalUnread > 9 ? '9+' : totalUnread;
                        mainBadge.classList.remove('hidden');
                        mainBadge.classList.add('flex');
                    } else {
                        mainBadge.classList.add('hidden');
                        mainBadge.classList.remove('flex');
                    }
                }
            })
            .catch(() => {});
    }

    function markSupervisorRead() {
        if (!currentConversation) return;
        fetch('/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ conversation: currentConversation, role: 'Supervisor' })
        }).then(() => updatePreviews());
    }

    function sendSupervisorMessage() {
    const message = supervisorMsgInput.value.trim();
    if (!message || !currentConversation) return;
    const tempId = 'temp_' + Date.now();
    appendSupervisorMessage(message, 'Supervisor', tempId);
    supervisorMsgInput.value = '';
    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message, sender: 'Supervisor', conversation: currentConversation })
    }).then(r => r.json()).then(data => {
        supervisorRenderedIds.delete(tempId);
        supervisorRenderedIds.add(data.id);
    });
}

    supervisorSendBtn.addEventListener('click', sendSupervisorMessage);
    supervisorMsgInput.addEventListener('keydown', e => {
        if (e.key === 'Enter') sendSupervisorMessage();
    });

    updatePreviews();
    previewInterval = setInterval(updatePreviews, 3000);
</script>
{{-- ================== END CHAT JAVASCRIPT =================== --}}

@stack('scripts') {{-- add this! --}}

</body>
</html>