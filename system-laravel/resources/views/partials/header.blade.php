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

            {{-- Notes Button --}}
            <button id="diaryBtn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </button>

            {{-- Messages Button --}}
            <button id="msgBtn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <span id="studentUnreadBadge" class="absolute top-2 right-2 w-4 h-4 bg-[#D50000] border-2 border-white rounded-full text-[10px] text-white font-bold items-center justify-center hidden"></span>
            </button>

            {{-- Notifications Button --}}
            <button id="notifBtn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="absolute top-2 right-2 w-4 h-4 bg-[#D50000] border-2 border-white rounded-full text-[10px] text-white font-bold flex items-center justify-center">3</span>
            </button>

        </div>

        <div class="h-8 w-[1px] bg-gray-200 mx-2"></div>

        {{-- Profile Dropdown (Alpine — no external JS needed) --}}
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
                            <a href="{{ route('students.profile') }}"
                                @click="sidebarOpen = false"
                                class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 transition">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    My Profile
                                </div>
                            </a>
                            <button @click="view = 'settings'" class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 transition">
                                <div class="flex items-center gap-3">
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
</header>