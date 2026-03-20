<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OJT Manager')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
    font-family: 'Poppins', sans-serif;
}
    </style>
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: false, activeTab: 'dashboard', taskModal: false }">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Header --}}
        @include('partials.header')

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
            <div class="space-y-6">
                @yield('content')
            </div>
        </main>

    </div>

</div>

{{-- ============================================================
     MODALS — all here so scripts below can find them
     ============================================================ --}}

{{-- Notes Inbox Modal --}}
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
        </div>
    </div>
</div>

{{-- Compose Note Modal --}}
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

{{-- Messages Dropdown --}}
<div id="msgModal" class="hidden fixed top-16 right-4 w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[999] overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-white">
        <h3 class="text-sm font-black text-gray-800 uppercase tracking-tighter">Messages</h3>
        <span id="studentNewLabel" class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full hidden"></span>
    </div>
    <div class="max-h-[300px] overflow-y-auto">
       <div onclick="openChat()" class="p-4 flex items-center gap-3 hover:bg-gray-50 cursor-pointer transition-colors active:bg-gray-100">
    <div class="relative flex-shrink-0">
       <img src="https://ui-avatars.com/api/?name=Sarah+Miller&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full supervisor-avatar">
        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
    </div>
    <div class="flex-1 min-w-0">
    <p id="supervisorName" class="text-sm font-bold text-gray-900 truncate transition-colors supervisor-name">Sarah Miller</p>
    <div class="flex items-center gap-1">
        <p id="studentMsgPreview" class="text-xs text-gray-500 truncate font-medium transition-colors">No messages yet</p>
        <span id="studentMsgTime" class="text-[11px] text-gray-400 font-medium shrink-0 before:content-['·'] before:mr-1"></span>
    </div>
</div>
</div>
    </div>
    <div class="flex border-t border-gray-100 bg-gray-50/50">
        <button onclick="closeAll()" class="flex-1 p-3 text-xs font-bold text-gray-400 hover:text-gray-600">Close</button>
    </div>
</div>

{{-- Notifications Dropdown --}}
<div id="notifModal" class="hidden fixed top-16 right-4 w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[999]">
    <div class="p-4 flex gap-3">
        <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
        </div>
        <div class="flex-1">
            <p class="text-sm text-gray-800 leading-5">Your <strong>Leave Request</strong> has been approved by the supervisor.</p>
            <p class="text-[10px] text-gray-400 mt-1 font-bold uppercase">Activity • Just now</p>
        </div>
    </div>
    <button onclick="closeAll()" class="w-full p-3 text-xs font-bold text-gray-500 bg-gray-50 rounded-b-2xl">Dismiss</button>
</div>

{{-- Profile Edit Modal --}}
<div id="profileModal" class="hidden fixed inset-0 bg-black/50 z-[80] flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Edit Profile</h3>
            <button id="closeProfile" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Full Name</label>
                <input type="text" value="Charlie Kirk" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Email</label>
                <input type="email" value="charlie.kirk@neck.edu" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
        </div>
        <div class="p-4 bg-gray-50 flex justify-end gap-2">
            <button id="cancelProfile" class="px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button>
            <button class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-medium text-sm hover:bg-emerald-700">Save</button>
        </div>
    </div>
</div>

{{-- Chat Window --}}
<div id="chatBox" class="hidden fixed inset-0 sm:inset-auto sm:bottom-6 sm:right-4 sm:w-80 sm:h-[500px] bg-white sm:rounded-2xl shadow-2xl border-gray-200 z-[9999] flex flex-col overflow-hidden animate-in slide-in-from-bottom-full duration-300">
    <div class="p-4 bg-white border-b border-gray-100 flex items-center justify-between shrink-0 h-16 sm:h-auto">
        <div class="flex items-center gap-3">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name=Sarah+Miller&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full supervisor-avatar">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
            <div>
                <p class="text-sm font-black text-gray-900 leading-none supervisor-name">Sarah Miller</p>  
                <p class="text-[10px] text-green-500 font-bold uppercase mt-1">Active Now</p>
            </div>
        </div>
        <button onclick="closeChat()" class="p-2 hover:bg-gray-100 rounded-full text-gray-400 transition-colors">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
    <div id="messageList" class="flex-1 overflow-y-auto p-4 flex flex-col gap-4 bg-gray-50/50"></div>
    <div class="p-4 border-t border-gray-100 bg-white pb-8 sm:pb-4 shrink-0">
    <div class="flex items-center gap-2">
        <input id="msgInput" type="text" placeholder="Aa" class="flex-1 min-w-0 bg-gray-100 border-none rounded-full px-4 py-3 text-sm focus:ring-1 focus:ring-blue-500 outline-none">
        
        <button id="imageBtn" class="text-gray-500 hover:text-emerald-500 p-1 active:scale-90 transition-transform shrink-0">
            <input type="file" id="mediaInput" accept="image/jpeg,image/png,image/gif,video/mp4,video/webm,video/ogg" class="hidden">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </button>

        <button id="sendBtn" class="text-emerald-600 p-1 active:scale-90 transition-transform shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
        </button>
    </div>
</div>
</div>


<div id="mediaPreviewModal" class="fixed inset-0 bg-black/70 z-[999] flex items-center justify-center hidden"
     style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Send Media</h3>
            <button id="closeMediaPreview" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="p-4 flex items-center justify-center bg-gray-50 min-h-48">
            <img id="imagePreview" class="max-h-64 max-w-full rounded-lg object-contain hidden" />
            <video id="videoPreview" class="max-h-64 max-w-full rounded-lg object-contain hidden" controls></video>
        </div>
        <div class="p-4 flex justify-between items-center gap-2">
            <button id="cancelMediaBtn" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">Cancel</button>
            <button id="sendMediaBtn" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-medium shadow-md hover:bg-emerald-700 transition-colors">Send</button>
        </div>
    </div>
</div>


{{-- ============================================================
     SCRIPTS — loads after ALL html above
     ============================================================ --}}
@stack('scripts')
<script>
    const ChatConfig = { 
        conversation: '{{ str_replace(" ", "_", session("student")->name) }}' 
    };

    // Load supervisor info dynamically
    fetch('/student/supervisor')
        .then(r => r.json())
        .then(supervisor => {
            // Update supervisor name in chat
            const nameEls = document.querySelectorAll('#supervisorName, .supervisor-name');
            nameEls.forEach(el => el.textContent = supervisor.name);

            // Update avatar
            const avatarEls = document.querySelectorAll('.supervisor-avatar');
            avatarEls.forEach(el => el.src = `https://ui-avatars.com/api/?name=${supervisor.name}&background=0ea5e9&color=fff`);
        });
</script>

 <script src="{{ asset('js/student-header.js') }}"></script> 

</body>
</html>