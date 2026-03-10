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
    <aside :class="sidebarOpen ? 'w-72' : 'w-20'"
           class="fixed left-0 top-0 h-screen bg-white border-r border-slate-200 transition-all duration-300 z-50 overflow-hidden hidden md:flex flex-col">

        <div class="p-6 flex items-center gap-3 border-b border-slate-200 shrink-0">
            <div class="bg-[#2E7D32] p-2 rounded-xl shadow-lg shadow-green-200">
                <i class="fas fa-shield-halved text-white"></i>
            </div>
            <span x-show="sidebarOpen" class="font-bold text-lg tracking-tight whitespace-nowrap">CHMSU<span class="text-[#2E7D32]">Supervison</span></span>
        </div>

        <nav class="mt-8 px-4 space-y-2 flex-grow overflow-y-auto custom-scrollbar">

            <a href="{{ route('supervisor.dashboard') }}"
               class="{{ request()->routeIs('supervisor.dashboard') ? 'bg-[#2E7D32] text-white shadow-md shadow-green-100' : 'text-slate-500 hover:bg-slate-50' }}
                      w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200">
                <i class="fas fa-grid-2 w-5 text-center"></i>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Dashboard</span>
            </a>

            <a href="{{ route('supervisor.attendance') }}"
               class="{{ request()->routeIs('supervisor.attendance') ? 'bg-[#2E7D32] text-white shadow-md shadow-green-100' : 'text-slate-500 hover:bg-slate-50' }}
                      w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200">
                <i class="fas fa-calendar-check w-5 text-center"></i>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Attendance</span>
            </a>

            <a href="{{ route('supervisor.tasks') }}"
               class="{{ request()->routeIs('supervisor.tasks') ? 'bg-[#2E7D32] text-white shadow-md shadow-green-100' : 'text-slate-500 hover:bg-slate-50' }}
                      w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200">
                <i class="fas fa-list-check w-5 text-center"></i>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Tasks & Grading</span>
            </a>

            <a href="{{ route('supervisor.evaluation') }}"
               class="{{ request()->routeIs('supervisor.evaluation') ? 'bg-[#2E7D32] text-white shadow-md shadow-green-100' : 'text-slate-500 hover:bg-slate-50' }}
                      w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200">
                <i class="fas fa-poll w-5 text-center"></i>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Evaluation</span>
            </a>

            <a href="{{ route('supervisor.students') }}"
               class="{{ request()->routeIs('supervisor.students') ? 'bg-[#2E7D32] text-white shadow-md shadow-green-100' : 'text-slate-500 hover:bg-slate-50' }}
                      w-full flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200">
                <i class="fas fa-user-group w-5 text-center"></i>
                <span x-show="sidebarOpen" class="font-medium whitespace-nowrap">Student Directory</span>
            </a>

        </nav>

        <div class="p-4 border-t border-slate-100 shrink-0">
            <div class="flex items-center gap-3 px-2 py-3 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center shrink-0">
                    <i class="fas fa-building text-slate-400 text-xs"></i>
                </div>
                <div x-show="sidebarOpen" x-cloak class="overflow-hidden">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Company</p>
                    <p class="text-xs font-bold text-slate-700 truncate">TechSolutions Corp.</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <main :class="sidebarOpen ? 'md:ml-72' : 'md:ml-20'" class="transition-all duration-300 min-h-screen pb-12">

        {{-- Header --}}
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 px-4 md:px-8 py-4 flex justify-between items-center">

            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-100 rounded-lg text-slate-500 transition-colors">
                    <i class="fas fa-bars-staggered"></i>
                </button>
                <div class="hidden sm:block">
                    <p class="text-lg font-bold text-slate-800">@yield('page_title')</p>
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-4">

                {{-- Messages --}}
                <div class="relative">
                   <button @click="msgOpen = !msgOpen; notifOpen = false; profileOpen = false"
                    class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 relative transition-all">
                    <i class="far fa-comment-alt text-xl"></i>
                     <span id="totalUnreadBadge" class="absolute top-2 right-2 w-4 h-4 bg-[#2E7D32] border-2 border-white rounded-full text-[10px] text-white font-bold items-center justify-center hidden"></span>
                  </button>

                    <div x-show="msgOpen" @click.away="msgOpen = false" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-3 w-80 bg-white rounded-[1.5rem] shadow-xl border border-slate-100 overflow-hidden z-50">

                        <div class="p-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                            <span class="font-black text-slate-800 text-xs uppercase tracking-widest">Messages</span>
                            <i class="fas fa-edit text-slate-400 hover:text-[#2E7D32] cursor-pointer text-sm"></i>
                        </div>

                        <div class="max-h-80 overflow-y-auto custom-scrollbar">
    {{-- Marcus Wright --}}
    <div @click="chatOpen = true; chatWith = 'Marcus Wright'; chatColor = '2E7D32'; msgOpen = false; openSupervisorChat('Marcus Wright')"
         class="p-4 hover:bg-slate-50 border-b border-slate-50 flex gap-3 cursor-pointer group transition-all">
        <div class="relative shrink-0">
            <img src="https://ui-avatars.com/api/?name=Marcus+Wright&background=2E7D32&color=fff" class="w-10 h-10 rounded-xl group-hover:scale-105 transition-transform shadow-sm">
            <span id="unread-Marcus_Wright" class="absolute -top-1 -right-1 w-4 h-4 bg-[#2E7D32] border-2 border-white rounded-full text-[9px] text-white font-bold items-center justify-center hidden"></span>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex justify-between items-start">
                <p class="text-sm font-bold text-slate-800">Marcus Wright</p>
                <span id="time-Marcus_Wright" class="text-[9px] text-slate-400 font-black"></span>
            </div>
            <p id="preview-Marcus_Wright" class="text-xs text-slate-500 line-clamp-1 font-medium italic">No messages yet</p>
        </div>
    </div>

    {{-- Sarah Jenkins --}}
    <div @click="chatOpen = true; chatWith = 'Sarah Jenkins'; chatColor = 'D50000'; msgOpen = false; openSupervisorChat('Sarah Jenkins')"
         class="p-4 hover:bg-slate-50 border-b border-slate-50 flex gap-3 cursor-pointer group transition-all">
        <div class="relative shrink-0">
            <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=D50000&color=fff" class="w-10 h-10 rounded-xl group-hover:scale-105 transition-transform shadow-sm">
            <span id="unread-Sarah_Jenkins" class="absolute -top-1 -right-1 w-4 h-4 bg-[#D50000] border-2 border-white rounded-full text-[9px] text-white font-bold items-center justify-center hidden"></span>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex justify-between items-start">
                <p class="text-sm font-bold text-slate-800">Sarah Jenkins</p>
                <span id="time-Sarah_Jenkins" class="text-[9px] text-slate-400 font-black"></span>
            </div>
            <p id="preview-Sarah_Jenkins" class="text-xs text-slate-500 line-clamp-1 font-medium italic">No messages yet</p>
        </div>
    </div>
</div>
                    </div>
                </div>

                {{-- Notifications --}}
                <div class="relative">
                    <button @click="notifOpen = !notifOpen; msgOpen = false; profileOpen = false"
                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 relative transition-all">
                        <i class="far fa-bell text-xl"></i>
                        <span class="absolute top-2 right-2 w-4 h-4 bg-[#D50000] border-2 border-white rounded-full text-[10px] text-white font-bold flex items-center justify-center">3</span>
                    </button>

                    <div x-show="notifOpen" @click.away="notifOpen = false" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-3 w-80 bg-white rounded-[1.5rem] shadow-xl border border-slate-100 overflow-hidden">
                        <div class="p-4 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                            <span class="font-black text-slate-800 text-xs uppercase tracking-widest">Notifications</span>
                            <span class="text-[10px] text-[#2E7D32] font-bold cursor-pointer">Mark all read</span>
                        </div>
                        <div class="max-h-72 overflow-y-auto custom-scrollbar">
                            <template x-for="i in 3">
                                <div class="p-4 hover:bg-slate-50 border-b border-slate-50 cursor-pointer transition-colors">
                                    <p class="text-sm font-bold text-slate-800">New Log Submission</p>
                                    <p class="text-xs text-slate-500 line-clamp-1">Marcus Wright submitted 8 hours for Feb 22.</p>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase font-medium">2 mins ago</p>
                                </div>
                            </template>
                        </div>
                        <div class="p-3 text-center border-t border-slate-50">
                            <button class="text-xs font-bold text-slate-400 hover:text-[#2E7D32] transition-colors">View All Notifications</button>
                        </div>
                    </div>
                </div>

                {{-- Profile --}}
                <div class="relative flex items-center pl-4 border-l border-slate-200 ml-2">
                    <button @click="profileOpen = !profileOpen; notifOpen = false; msgOpen = false"
                            class="flex items-center gap-3 group focus:outline-none">
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name=Supervisor&background=2E7D32&color=fff"
                                 class="w-8 h-8 rounded-2xl ring-2 ring-white shadow-md group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                    </button>

                    <div x-show="profileOpen" @click.away="profileOpen = false" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="absolute right-0 top-full mt-3 w-64 bg-white rounded-[1.5rem] shadow-xl border border-slate-100 py-2">

                        <div class="px-4 py-3 border-b border-slate-50 mb-1">
                            <p class="text-[15px] font-black text-slate-400 uppercase tracking-widest">ACCOUNT</p>
                            <p class="text-[12px] font-bold text-slate-400 truncate">Supervisor Rodriguez</p>
                            <p class="text-[11px] text-[#2E7D32] font-medium italic">supervisor@company.com</p>
                        </div>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-green-50 hover:text-[#2E7D32] transition-all">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-[#2E7D32]">
                                <i class="far fa-user text-sm"></i>
                            </div>
                            Profile Settings
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <i class="fas fa-cog text-sm"></i>
                            </div>
                            Account Security
                        </a>
                        <hr class="my-2 border-slate-50">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-[#D50000] hover:bg-red-50 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-[#D50000]">
                                <i class="fas fa-sign-out-alt text-sm"></i>
                            </div>
                            Logout
                        </a>
                    </div>
                </div>

            </div>
        </header>

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
                           class="flex-1 bg-transparent border-none focus:ring-0 text-xs text-slate-700 px-2 h-8">
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

    const CONVERSATIONS = ['Marcus_Wright', 'Sarah_Jenkins'];

    let currentConversation = null;
    let lastMessageIndex    = 0;
    let pollInterval        = null;
    let previewInterval     = null;
    let chatIsOpen          = false;

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function conversationKey(displayName) {
        return displayName.replace(/\s+/g, '_');
    }

    function appendSupervisorMessage(message, sender) {
        const isSupervisor = (sender === 'Supervisor');
        const wrapper = document.createElement('div');
        wrapper.className = isSupervisor
            ? 'flex gap-2 items-start max-w-[90%] self-end ml-auto'
            : 'flex gap-2 items-start max-w-[90%]';
        wrapper.innerHTML = `
            <div class="${isSupervisor
                ? 'bg-[#2E7D32] text-white rounded-2xl rounded-br-none'
                : 'bg-white border border-slate-100 text-slate-700 rounded-2xl rounded-bl-none'
            } p-3 shadow-sm text-[11px] font-medium leading-relaxed">
                ${escapeHtml(message)}
            </div>
        `;
        supervisorMsgList.appendChild(wrapper);
        supervisorMsgList.scrollTop = supervisorMsgList.scrollHeight;
    }

    function openSupervisorChat(displayName) {
        const newConversation = conversationKey(displayName);

        if (newConversation !== currentConversation) {
            currentConversation = newConversation;
            lastMessageIndex    = 0;
            supervisorMsgList.innerHTML = '';
        }

        clearInterval(pollInterval);
        pollInterval = null;
        chatIsOpen   = true;

        pollMessages();
        markSupervisorRead();
        pollInterval = setInterval(pollMessages, 2000);
    }

    function closeSupervisorChat() {
        chatIsOpen = false;
        clearInterval(pollInterval);
        pollInterval     = null;
        lastMessageIndex = 0;
    }

    function pollMessages() {
        if (!currentConversation) return;
        fetch(`/get-messages?conversation=${currentConversation}&after=${lastMessageIndex}&role=Supervisor`)
            .then(r => r.json())
            .then(data => {
                data.messages.forEach(msg => {
                    appendSupervisorMessage(msg.message, msg.sender);
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
        appendSupervisorMessage(message, 'Supervisor');
        lastMessageIndex++;
        supervisorMsgInput.value = '';
        fetch('/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                message,
                sender: 'Supervisor',
                conversation: currentConversation
            })
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

</body>
</html>