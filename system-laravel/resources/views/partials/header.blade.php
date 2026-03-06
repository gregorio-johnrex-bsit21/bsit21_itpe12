 <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
    <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 shrink-0">
        
        <div class="flex items-center">
            <button @click="sidebarOpen = true" class="p-2 mr-3 lg:hidden hover:bg-slate-100 rounded-xl active:scale-90">
                <svg class="size-6 text-slate-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div class="flex items-center gap-1">
            
            <div class="flex items-center gap-1">
                <div class="relative">
                    <button id="diaryBtn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </button>

                    <div id="inboxModal" class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center hidden">
                        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
                            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                                <h3 class="font-bold text-gray-700">My Notes</h3>
                                <div class="flex gap-2">
                                    <button id="addNewBtn" class="bg-emerald-600 text-white p-1.5 rounded-full hover:bg-emerald-700 transition-transform active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                                    </button>
                                    <button id="closeInbox" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                                </div>
                            </div>
                            <div class="max-h-80 overflow-y-auto p-6 space-y-2">
                                <div class="p-3 border rounded-lg hover:border-emerald-300 hover:bg-emerald-50 cursor-pointer transition-all">
                                    <p class="text-sm font-semibold text-gray-800">Monday Reflections</p>
                                    <p class="text-xs text-gray-500">The project is going well...</p>
                                </div>
                                <div class="p-3 border rounded-lg hover:border-emerald-300 hover:bg-emerald-50 cursor-pointer transition-all">
                                    <p class="text-sm font-semibold text-gray-800">Debugging</p>
                                    <p class="text-xs text-gray-500">There was a bug...</p>
                                </div>
                                <div class="p-3 border rounded-lg hover:border-emerald-300 hover:bg-emerald-50 cursor-pointer transition-all">
                                    <p class="text-sm font-semibold text-gray-800">Coding Session</p>
                                    <p class="text-xs text-gray-500">We built some website...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="composeModal" class="fixed inset-0 bg-black/60 z-[70] flex items-center justify-center hidden">
                        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-in fade-in zoom-in-95 duration-200">
                            <div class="p-4 border-b flex justify-between items-center">
                                <h3 class="font-bold text-gray-800">New Note</h3>
                                <button id="closeCompose" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                            </div>
                            <div class="p-4">
                                <input type="text" placeholder="Title..." class="w-full mb-3 p-2 border-b font-semibold focus:outline-none focus:border-blue-500">
                                <textarea class="w-full h-48 p-2 text-gray-600 outline-none resize-none" placeholder="Start writing..."></textarea>
                            </div>
                            <div class="p-4 bg-gray-50 flex justify-end">
                                <button id="saveNote" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-medium shadow-md hover:bg-emerald-700 transition-colors">Save Note</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button id="msgBtn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        <span class="absolute top-2 right-2 w-4 h-4 bg-[#D50000] border-2 border-white rounded-full text-[10px] text-white font-bold flex items-center justify-center">2</span>
                    </button>
                    <div id="msgModal" class="hidden fixed inset-x-4 top-16 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-2 sm:w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[999] animate-in slide-in-from-top-4 duration-200 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-white">
                            <h3 class="text-sm font-black text-gray-800 uppercase tracking-tighter">Messages</h3>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">1 New</span>
                        </div>
                        <div class="max-h-[300px] overflow-y-auto">
                            <div onclick="openChat()" class="p-4 flex items-center gap-3 hover:bg-gray-50 cursor-pointer transition-colors active:bg-gray-100">
                                <div class="relative flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Miller&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full">
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-bold text-emerald-600 uppercase">Supervisor</span>
                                        <span class="text-[10px] text-gray-400 font-medium">2:55 PM</span>
                                    </div>
                                    <p class="text-sm font-bold text-gray-900 truncate">Sarah Miller</p>
                                    <p class="text-xs text-gray-500 truncate font-medium">"Please review the final Q1 slides..."</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex border-t border-gray-100 bg-gray-50/50">
                            <button onclick="closeAll()" class="flex-1 p-3 text-xs font-bold text-gray-400 hover:text-gray-600">Close</button>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button id="notifBtn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span class="absolute top-2 right-2 w-4 h-4 bg-[#D50000] border-2 border-white rounded-full text-[10px] text-white font-bold flex items-center justify-center">3</span>
                    </button>
                    <div id="notifModal" class="hidden fixed inset-x-4 top-16 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-2 sm:w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[999] animate-in slide-in-from-top-4 duration-200">
                        <div class="p-4 flex gap-3">
                            <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-800 leading-tight leading-5">Your <strong>Leave Request</strong> has been approved by the supervisor.</p>
                                <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase">Activity • Just now</p>
                            </div>
                        </div>
                        <button onclick="closeAll()" class="w-full p-3 text-xs font-bold text-gray-500 bg-gray-50 rounded-b-2xl">Dismiss</button>
                    </div>
                </div>
            </div>

            <div class="h-8 w-[1px] bg-gray-200 mx-2"></div>

            <div class="relative" x-data="{ profileOpen: false, view: 'main' }">
                <button @click="profileOpen = !profileOpen; view = 'main'" class="flex items-center justify-center h-10 w-10 rounded-full bg-emerald-500 text-white text-sm font-bold hover:bg-emerald-600 transition-all shadow-sm focus:outline-none">
                    CK
                </button>

                <div x-show="profileOpen" 
                     @click.away="profileOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     class="absolute right-0 mt-3 w-56 origin-top-right bg-white rounded-2xl shadow-xl border border-gray-100 py-1.5 z-50"
                     x-cloak>
                    
                    <template x-if="view === 'main'">
                        <div>
                            <div class="px-4 py-3 border-b border-gray-50">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Account</p>
                                <p class="text-sm font-black text-gray-800">Charlie Kirk</p>
                                <p class="text-[12px] text-gray-500 truncate">charlie.kirk.@neck.edu</p>
                            </div>
                            <div class="py-1.5">
                                
                        <a href="{{ route('profile') }}"
                            @click="sidebarOpen = false"
                            class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 transition">
                            <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                My Profile
                            </div>
                        </a>
                                <button @click="view = 'settings'" class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 transition">
                                    <div class="flex items-center gap-3 ">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        Settings
                                    </div>
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                            <div class="mt-1 pt-1 border-t border-gray-50">
                                <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-red-500 font-bold hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign Out
                                </a>
                            </div>
                        </div>
                    </template>

                    <template x-if="view === 'settings'">
                        <div>
                            <div class="px-3 py-3 flex items-center border-b border-gray-50">
                                <button @click="view = 'main'" class="p-1 text-gray-400 hover:text-emerald-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <span class="text-sm font-black text-gray-800 ml-2">Settings</span>
                            </div>
                            <div class="py-1 divide-y divide-gray-50/50">
                                <template x-for="item in ['Preferences', 'Support', 'FAQ', 'About']">
                                    <a href="#" class="flex items-center justify-between px-5 py-3 text-sm text-gray-600 hover:bg-gray-50 transition font-medium group">
                                        <span x-text="item" class="group-hover:text-emerald-700"></span>
                                        <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>


         <!--chatbox-->
    
<div id="chatBox" class="hidden fixed inset-0 sm:inset-auto sm:bottom-6 sm:right-4 sm:w-80 sm:h-[500px] bg-white sm:rounded-2xl shadow-2xl border-gray-200 z-[9999] flex flex-col overflow-hidden animate-in slide-in-from-bottom-full duration-300">
    
    <div class="p-4 bg-white border-b border-gray-100 flex items-center justify-between shrink-0 h-16 sm:h-auto">
        <div class="flex items-center gap-3">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name=Sarah+Miller&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
            <div>
                <p class="text-sm font-black text-gray-900 leading-none">Sarah Miller</p>
                <p class="text-[10px] text-green-500 font-bold uppercase mt-1">Active Now</p>
            </div>
        </div>
        
        <button onclick="closeChat()" class="p-2 hover:bg-gray-100 rounded-full text-gray-400 transition-colors">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>

    <div id="messageList" class="flex-1 overflow-y-auto p-4 flex flex-col gap-4 bg-gray-50/50">
        <div class="flex items-start gap-2 max-w-[85%]">
            <div class="bg-white border border-gray-200 p-3 rounded-2xl rounded-bl-none text-sm text-gray-700 shadow-sm">
                Hey! Please review the final Q1 slides when you have a chance.
            </div>
        </div>
    </div>

    <div class="p-4 border-t border-gray-100 bg-white pb-8 sm:pb-4 shrink-0">
        <div class="flex items-center gap-2">
            <input id="msgInput" type="text" placeholder="Aa" class="flex-1 bg-gray-100 border-none rounded-full px-4 py-3 text-sm focus:ring-1 focus:ring-blue-500 outline-none">
           <button id="sendBtn" class="text-emerald-600 p-1 active:scale-90 transition-transform">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
            </button>
        </div>
    </div>
</div>

    </header>



      
<script>
    
    const msgBtn = document.getElementById('msgBtn');
    const msgModal = document.getElementById('msgModal');
    const notifBtn = document.getElementById('notifBtn');
    const notifModal = document.getElementById('notifModal');
    const chatBox = document.getElementById('chatBox');

    function closeAll() {
        msgModal.classList.add('hidden');
        notifModal.classList.add('hidden');
    }

    // New Function to trigger the Chat Window
    function openChat() {
        msgModal.classList.add('hidden'); // Close the inbox list
        chatBox.classList.remove('hidden'); // Show the convo window
    }

    function closeChat() {
        chatBox.classList.add('hidden');
    }

    msgBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = msgModal.classList.contains('hidden');
        closeAll();
        if (isHidden) msgModal.classList.remove('hidden');
    });

    notifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = notifModal.classList.contains('hidden');
        closeAll();
        if (isHidden) notifModal.classList.remove('hidden');
    });

    document.addEventListener('click', (e) => {
        // Updated to not close if clicking inside the chatBox
        if (!msgModal.contains(e.target) && !notifModal.contains(e.target) && !chatBox.contains(e.target)) {
            closeAll();
        }
    });


    const msgInput = document.getElementById('msgInput');
const sendBtn = document.getElementById('sendBtn');
const messageList = document.getElementById('messageList');

// Append messages dynamically
function appendMessage(message, sender = "You") {
    const div = document.createElement('div');
    div.className = sender === "You" 
        ? "flex items-start gap-2 self-end max-w-[85%]" 
        : "flex items-start gap-2 max-w-[85%]";

    div.innerHTML = `<div class="${sender === "You" ? 'bg-emerald-600 text-white' : 'bg-white text-gray-700'} p-3 rounded-2xl ${sender === "You" ? 'rounded-br-none' : 'rounded-bl-none'} text-sm shadow-sm">${message}</div>`;

    messageList.appendChild(div);
    messageList.scrollTop = messageList.scrollHeight;
}

// Send message
sendBtn.addEventListener('click', () => {
    const message = msgInput.value.trim();
    if (!message) return;

    appendMessage(message, "You"); // show locally

    // Send to backend
    fetch('/send-message', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message: message, sender: "You" })
    });

    msgInput.value = '';
});

// Enter key sends
msgInput.addEventListener('keydown', (e) => {
    if (e.key === "Enter") sendBtn.click();
});

// Listen for Laravel Echo events
Echo.channel('chat')
.listen('MessageSent', (e) => {
    if (e.sender !== "You") appendMessage(e.message, e.sender);
});






//logic of diary/notes

// Elements
const diaryBtn = document.getElementById('diaryBtn');
const inboxModal = document.getElementById('inboxModal');
const composeModal = document.getElementById('composeModal');

const closeInbox = document.getElementById('closeInbox');
const closeCompose = document.getElementById('closeCompose');
const addNewBtn = document.getElementById('addNewBtn');
const saveNote = document.getElementById('saveNote');

// 1. Open Inbox
diaryBtn.onclick = () => inboxModal.classList.remove('hidden');

// 2. Open Composer from Inbox
addNewBtn.onclick = () => composeModal.classList.remove('hidden');

// 3. Close Inbox
closeInbox.onclick = () => inboxModal.classList.add('hidden');

// 4. Close Composer Only
closeCompose.onclick = () => composeModal.classList.add('hidden');

// 5. Save Note (Closes composer, keeps inbox)
saveNote.onclick = () => {
    // Here you would add the logic to save the data
    alert('Note saved!');
    composeModal.classList.add('hidden');
};

// Close when clicking outside content
window.onclick = (e) => {
    if (e.target === inboxModal) inboxModal.classList.add('hidden');
    if (e.target === composeModal) composeModal.classList.add('hidden');
};





        //profile modal
        // JS logic to show/hide the modal
        // Get elements
const profileModal = document.getElementById('profileModal');
const openProfileBtn = document.getElementById('openProfileModal');
const closeProfileBtn = document.getElementById('closeProfile');

// Function to open modal
openProfileBtn.addEventListener('click', () => {
    profileModal.classList.remove('hidden');
    // Optional: stops background scrolling
    document.body.classList.add('overflow-hidden'); 
});

// Function to close modal (Cancel button)
closeProfileBtn.addEventListener('click', () => {
    profileModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

// Optional: Close modal if they click the dark background overlay
profileModal.addEventListener('click', (e) => {
    if (e.target === profileModal) {
        profileModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
});


    </script>
