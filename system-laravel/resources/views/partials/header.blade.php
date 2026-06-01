<header class="h-16 bg-white border-b border-gray-300 flex items-center justify-between px-4 lg:px-8 shrink-0">
    
    <div class="flex items-center">
        {{-- Mobile-only branding (hidden on lg and above) --}}
        <div class="flex items-center gap-2 lg:hidden">
            <img src="{{ asset('images/logo_2.0.png') }}" alt="CHMSU Logo" class="h-12 w-12 object-contain">
            <div class="leading-tight">
                <p class="text-sm font-black text-gray-800 tracking-wide">CHMSU</p>
                <p class="text-[10px] font-semibold text-emerald-600 uppercase tracking-widest">
                    <span class="xs:inline">OJT Manager</span>
                </p>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-1">
        <div class="flex items-center gap-1 lg:gap-0.5">

    {{-- Notes Button (Hidden on mobile, visible on desktop) --}}
    <button class="diaryBtn hidden lg:block p-1 lg:p-1.5 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="lg:w-[23px] lg:h-[23px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"></path>
            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
        </svg>
    </button>

    {{-- Messages Button (Always visible) --}}
    <button id="msgBtn" class="p-1 lg:p-1.5 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="lg:w-6 lg:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
        <span id="studentUnreadBadge" class="absolute top-0 right-0 w-4 h-4 lg:w-5 lg:h-5 bg-[#D50000] border-2 border-white rounded-full text-[9px] lg:text-[12px] text-white font-bold items-center justify-center hidden"></span>
    </button>

    {{-- Notifications Button --}}
<button id="notifBtn" class="p-1 lg:p-1.5 text-gray-500 hover:bg-gray-100 rounded-full transition-colors relative">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" class="lg:w-6 lg:h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
    </svg>
    <span id="notifBadge" class="absolute top-0 right-0 w-4 h-4 lg:w-5 lg:h-5 bg-[#D50000] border-2 border-white rounded-full text-[9px] lg:text-[12px] text-white font-bold flex items-center justify-center hidden">0</span>
</button>

</div>

        <div class="h-8 w-[1px] bg-gray-200 mx-2"></div>

        {{-- Profile Dropdown (Alpine — no external JS needed) --}}
        <div x-data="{ profileOpen: false, view: 'main' }" class="relative">

    <!-- Avatar Button -->
    <button
        @click="
            if (window.innerWidth >= 768) { profileOpen = !profileOpen; view = 'main'; }
            else { document.getElementById('mobileOverlay').classList.add('open'); document.getElementById('mobileDrawer').classList.add('open'); }
        "
        class="flex items-center justify-center h-10 w-10 rounded-full bg-emerald-500 text-white text-sm font-bold hover:bg-emerald-600 transition-all shadow-sm focus:outline-none">
        {{ strtoupper(substr(explode(' ', session('student')->name)[0], 0, 1)) . strtoupper(substr(explode(' ', session('student')->name)[1] ?? '', 0, 1)) }}
    </button>

    <!-- ═══════════════════════════════════════════
         DESKTOP DROPDOWN (unchanged, md and above)
         ═══════════════════════════════════════════ -->
    <!-- ── DESKTOP DROPDOWN ── -->
<div x-show="profileOpen"
     @click.away="profileOpen = false"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="transform opacity-0 scale-95"
     x-transition:enter-end="transform opacity-100 scale-100"
     class="hidden md:block absolute right-0 mt-3 w-56 origin-top-right bg-white rounded-2xl shadow-xl border border-gray-100 py-1.5 z-50"
     x-cloak>

    <template x-if="view === 'main'">
        <div>
            <!-- Account info -->
            <div class="px-4 py-3 border-b border-gray-50">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Account</p>
                <p class="text-sm font-black text-gray-800">{{ session('student')->name }}</p>
                <p class="text-[11px] font-medium text-gray-400 tracking-wide">ID: {{ session('student')->student_id }}</p>
            </div>

            <!-- Account section -->
            <div class="py-1">
                <a href="{{ route('students.profile') }}"
                   class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    My Profile
                </a>
                <button @click="view = 'settings'" class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                        Settings
                    </div>
                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <!-- Divider + Help label -->
            <div class="border-t border-gray-50 pt-1">
                <p class="px-4 pt-2 pb-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Help</p>
                <!-- Support & FAQ -->
<a href="#" onclick="openSupportPage(); return false;" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    Support & FAQ
</a>

<!-- About -->
<a href="#" onclick="openAboutPage(); return false;" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    About
</a>
            </div>

            <!-- Divider + Logout -->
            <div class="border-t border-gray-50 pt-1 pb-1">
                <button
                    onclick="document.getElementById('logoutModal').classList.add('open'); document.getElementById('logoutModal').classList.remove('hidden');"
                    class="flex items-center gap-3 px-4 py-2 text-sm text-red-500 font-bold hover:bg-red-50 transition w-full text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </div>
        </div>
    </template>

    <template x-if="view === 'settings'">
    <div>
        <div class="px-3 py-3 flex items-center border-b border-gray-50">
            <button @click="view = 'main'" class="p-1 text-gray-400 hover:text-emerald-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <span class="text-sm font-black text-gray-800 ml-2">Settings</span>
        </div>
        <div class="py-1">
            <p class="px-4 pt-2 pb-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Options</p>

            {{-- Dark Mode Toggle --}}
            <div class="flex items-center justify-between px-4 py-2">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                    </svg>
                    <span class="text-sm text-gray-600">Dark Mode</span>
                </div>
                <button id="darkToggleDesktop" class="dark-toggle" onclick="toggleDarkMode()" aria-label="Toggle dark mode"></button>
            </div>

            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                Preferences
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Notifications
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Privacy & Security
            </a>
        </div>
    </div>
</template>

</div>


<!-- ═══════════════════════════════════════════════════════
     MOBILE DRAWER (outside Alpine scope, shown on mobile)
     ═══════════════════════════════════════════════════════ -->

<!-- Backdrop overlay -->
<div id="mobileOverlay"
     class="md:hidden fixed inset-0 z-40 bg-black/60 opacity-0 transition-opacity duration-300 pointer-events-none"
     onclick="closeMobileDrawer()">
</div>

<!-- Drawer panel -->
<div id="mobileDrawer"
     class="md:hidden fixed top-0 right-0 bottom-0 z-50 w-[90%] max-w-xs bg-white shadow-2xl flex flex-col translate-x-full transition-transform duration-300 ease-[cubic-bezier(0.32,0.72,0,1)]">

    <!-- Main view -->
    <div id="drawerMain" class="flex flex-col flex-1 overflow-hidden">

        
        <!-- Green header -->
<div class="relative overflow-hidden px-5 pt-12 pb-5 flex-shrink-0" style="min-height: 160px;">

    <!-- Nature background image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1448375240586-882707db888b?w=600&q=80');"></div>

    <!-- Dark emerald overlay so text stays readable -->
    <div class="absolute inset-0 bg-emerald-900/50"></div>

    <!-- Close button -->
    <button onclick="closeMobileDrawer()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-black/20 flex items-center justify-center text-white hover:bg-black/40 transition z-10">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>

    <!-- Avatar -->
    <div class="relative z-10 w-12 h-12 rounded-full bg-white/25 border-2 border-white/60 flex items-center justify-center text-white text-lg font-extrabold mb-3 tracking-wide backdrop-blur-sm">
        {{ strtoupper(substr(explode(' ', session('student')->name)[0], 0, 1)) . strtoupper(substr(explode(' ', session('student')->name)[1] ?? '', 0, 1)) }}
    </div>
    <p class="relative z-10 text-white font-bold text-base leading-tight drop-shadow-sm">{{ session('student')->name }}</p>
    <p class="relative z-10 text-white/80 text-[11px] mt-0.5 tracking-wide drop-shadow-sm">ID: {{ session('student')->student_id }}</p>
</div>

        <!-- Menu items -->
        <div class="flex-1 overflow-y-auto py-2">
            <p class="px-5 pt-3 pb-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Account</p>

            <a href="{{ route('students.profile') }}" onclick="closeMobileDrawer()"
               class="flex items-center gap-4 px-5 py-3.5 text-sm text-gray-700 font-medium hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                My Profile
            </a>

            <button onclick="showDrawerSettings()"
                    class="w-full flex items-center gap-4 px-5 py-3.5 text-sm text-gray-700 font-medium hover:bg-gray-50 transition text-left">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                Settings
                <svg class="w-3.5 h-3.5 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div class="h-px bg-gray-100 my-1 mx-5"></div>
            <p class="px-5 pt-3 pb-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Help</p>

            <a href="#" class="flex items-center gap-4 px-5 py-3.5 text-sm text-gray-700 font-medium hover:bg-gray-50 transition">
            <!-- Support & FAQ -->
<a href="#" onclick="openSupportPage(); return false;" class="flex items-center gap-4 px-5 py-3.5 text-sm text-gray-700 font-medium hover:bg-gray-50 transition">
    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    Support & FAQ
</a>

<!-- About -->
<a href="#" onclick="openAboutPage(); return false;" class="flex items-center gap-4 px-5 py-3.5 text-sm text-gray-700 font-medium hover:bg-gray-50 transition">
    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    About
</a>

            <div class="h-px bg-gray-100 my-1 mx-5"></div>

            <button onclick="document.getElementById('logoutModal').classList.add('open')"
                    class="w-full flex items-center gap-4 px-5 py-3.5 text-sm text-red-500 font-bold hover:bg-red-50 transition text-left">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </div>
    </div>

    <!-- Settings sub-view (hidden by default) -->
    <div id="drawerSettings" class="hidden flex-col flex-1 overflow-hidden">
        <div class="flex items-center gap-2 px-3 py-4 border-b border-gray-100 flex-shrink-0">
            <button onclick="showDrawerMain()" class="w-9 h-9 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <span class="text-sm font-black text-gray-800">Settings</span>
        </div>
        <div class="flex-1 overflow-y-auto py-2">
            <p class="px-5 pt-3 pb-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Options</p>
           <div class="flex items-center justify-between px-5 py-3.5">
    <div class="flex items-center gap-4">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
        </svg>
        <span class="text-sm text-gray-700 font-medium">Dark Mode</span>
    </div>
    <button id="darkToggleMobile" class="dark-toggle" onclick="toggleDarkMode()" aria-label="Toggle dark mode"></button>
</div>
            <a href="#" class="flex items-center justify-between px-5 py-3.5 text-sm text-gray-700 font-medium hover:bg-gray-50 transition">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifications
                </div>
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
            <a href="#" class="flex items-center justify-between px-5 py-3.5 text-sm text-gray-700 font-medium hover:bg-gray-50 transition">
                <div class="flex items-center gap-4">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Privacy & Security
                </div>
                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

</div>


<!-- ═══════════════════════════════════════════════════════
     LOGOUT MODAL (bottom sheet on mobile, centered on desktop)
     ═══════════════════════════════════════════════════════ -->
<!-- LOGOUT MODAL -->
<div id="logoutModal"
     class="hidden fixed inset-0 z-[60] bg-black/70"
     onclick="handleLogoutBackdrop(event)">

    <div class="absolute inset-0 flex items-end justify-center md:items-center">

        <!-- ── MOBILE: TikTok bottom sheet (hidden on md+) ── -->
        <div class="w-full z-10 pb-2 animate-slide-up md:hidden">

            <!-- Top card -->
            <div class="mx-3 mb-2 bg-white rounded-2xl overflow-hidden shadow-xl">
                <div class="px-5 py-5 border-b border-gray-100">
                    <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-3">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <h3 class="text-center text-gray-800 font-semibold text-base">Log Out</h3>
                    <p class="text-center text-gray-400 text-sm mt-1">Are you sure you want to logout?</p>
                </div>
                <button onclick="logoutUser()"
                        class="w-full px-5 py-4 text-center text-red-500 text-base font-bold hover:bg-red-50 transition">
                    Yes, Logout
                </button>
            </div>

            <!-- Cancel card -->
            <div class="mx-3 mb-3 bg-white rounded-2xl overflow-hidden shadow-xl">
                <button onclick="closeLogoutModal()"
                        class="w-full px-5 py-4 text-center text-gray-600 text-base font-semibold hover:bg-gray-50 transition">
                    Cancel
                </button>
            </div>
        </div>

        <!-- ── DESKTOP: Original small centered modal (hidden on mobile) ── -->
        <div class="hidden md:block relative bg-white w-full max-w-sm rounded-2xl shadow-xl p-6 z-10">

            <!-- Icon -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mx-auto mb-4">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>

            <h3 class="text-center text-gray-800 font-semibold text-lg">Log Out</h3>
            <p class="text-center text-gray-500 text-sm mt-1">Are you sure you want to logout?</p>

            <div class="flex gap-3 mt-6">
                <button onclick="closeLogoutModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 font-medium hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button onclick="logoutUser()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                    Yes, Logout
                </button>
            </div>
        </div>

    </div>
</div>


<style>
    #mobileOverlay.open {
        opacity: 1;
        pointer-events: auto;
    }
    #mobileDrawer.open {
        transform: translateX(0);
    }
    #logoutModal.open {
        display: flex;
    }

    @keyframes slideUp {
        from { transform: translateY(100%); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }
    .animate-slide-up {
        animation: slideUp 0.28s cubic-bezier(0.32, 0.72, 0, 1) forwards;
    }
    @media (min-width: 768px) {
        .animate-slide-up { animation: none; }
    }
</style>

<script>
    function closeMobileDrawer() {
        document.getElementById('mobileOverlay').classList.remove('open');
        document.getElementById('mobileDrawer').classList.remove('open');
        setTimeout(() => showDrawerMain(), 350);
    }

    function showDrawerSettings() {
        document.getElementById('drawerMain').classList.add('hidden');
        document.getElementById('drawerSettings').classList.remove('hidden');
        document.getElementById('drawerSettings').classList.add('flex');
    }

    function showDrawerMain() {
        document.getElementById('drawerSettings').classList.add('hidden');
        document.getElementById('drawerSettings').classList.remove('flex');
        document.getElementById('drawerMain').classList.remove('hidden');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
        document.getElementById('logoutModal').classList.remove('open');
    }

    function handleLogoutBackdrop(e) {
        if (e.target === document.getElementById('logoutModal') ||
            e.target === document.querySelector('#logoutModal > div')) {
            closeLogoutModal();
        }
    }

    function logoutUser() {
        fetch("{{ route('logout') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            redirect: 'manual'
        })
        .then(async res => {
            if (res.type === 'opaqueredirect') {
                window.location.href = '/landing';
                return;
            }
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error('Not JSON: ' + text.substring(0, 100));
            }
        })
        .then(data => {
            if (data && data.success) {
                window.location.href = data.redirect;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            window.location.href = '/landing';
        });
    }
</script>

<script>
    function toggleDarkMode() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        html.classList.toggle('dark', !isDark);
        html.classList.toggle('light', isDark);
        localStorage.setItem('theme', isDark ? 'light' : 'dark');
        syncDarkToggles();
    }

    function syncDarkToggles() {
        const isDark = document.documentElement.classList.contains('dark');
        document.querySelectorAll('#darkToggleDesktop, #darkToggleMobile').forEach(btn => {
            btn.classList.toggle('active', isDark);
        });
    }

    // Sync toggle state on load
    document.addEventListener('DOMContentLoaded', syncDarkToggles);




    // ── Support & FAQ page ──
function openSupportPage() {
    document.getElementById('supportPage').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    closeMobileDrawer();
}

function closeSupportPage() {
    document.getElementById('supportPage').classList.add('hidden');
    document.body.style.overflow = '';
}

// ── About page ──
function openAboutPage() {
    document.getElementById('aboutPage').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    closeMobileDrawer();
}

function closeAboutPage() {
    document.getElementById('aboutPage').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
</header>

<!-- ═══════════════════════════════════════════════════════
     SUPPORT & FAQ PAGE (full-screen overlay)
     ═══════════════════════════════════════════════════════ -->
<div id="supportPage" class="hidden fixed inset-0 z-[70] bg-white flex flex-col">
    <!-- Header -->
    <div class="h-16 flex items-center px-4 border-b border-gray-100 shrink-0">
        <button onclick="closeSupportPage()" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <h1 class="ml-3 text-lg font-bold text-gray-800">Support & FAQ</h1>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-5 py-6">
        <!-- System Info -->
        <div class="mb-8">
            <h2 class="text-sm font-bold text-emerald-600 uppercase tracking-widest mb-3">About the System</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-3">
                The <strong>OJT Manager Portal</strong> is a comprehensive web-based platform designed to streamline the On-the-Job Training (OJT) process for students, supervisors, and administrators at Carlos Hilado Memorial State University (CHMSU).
            </p>
            <p class="text-gray-600 text-sm leading-relaxed">
                It handles student registration, daily time logging, diary entries, document submissions, supervisor evaluations, and real-time status tracking — all in one place.
            </p>
        </div>

        <!-- FAQ Section -->
        <div class="mb-8">
            <h2 class="text-sm font-bold text-emerald-600 uppercase tracking-widest mb-4">Frequently Asked Questions</h2>

            <div class="space-y-3">
                <details class="group bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                    <summary class="flex items-center justify-between px-4 py-4 cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-700">How do I register?</span>
                        <svg class="w-4 h-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-gray-500 leading-relaxed">
                        Tap "Get Started" on the landing page to go directly to Sign Up. If you're already on the login screen, tap "Sign Up" to create your account. Fill in your Student ID, full name, Company ID, and password. Your supervisor must approve your registration before you can log in.
                    </div>
                </details>

                <details class="group bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                    <summary class="flex items-center justify-between px-4 py-4 cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-700">Why is my account pending?</span>
                        <svg class="w-4 h-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-gray-500 leading-relaxed">
                        New registrations require supervisor approval for security. You'll see a "Pending Approval" screen until your supervisor activates your account.
                    </div>
                </details>

                <details class="group bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                    <summary class="flex items-center justify-between px-4 py-4 cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-700">How do I log my OJT hours?</span>
                        <svg class="w-4 h-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-gray-500 leading-relaxed">
                        You need to go to your supervisor's desk to time in and time out. Your supervisor will log your attendance manually in the system.
                    </div>
                </details>

                <details class="group bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                    <summary class="flex items-center justify-between px-4 py-4 cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-700">What if I forgot my password?</span>
                        <svg class="w-4 h-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-gray-500 leading-relaxed">
                        Contact your OJT supervisor or the system administrator to reset your password. Password resets are handled manually for security reasons.
                    </div>
                </details>

                <details class="group bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                    <summary class="flex items-center justify-between px-4 py-4 cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-700">Who can see my diary entries?</span>
                        <svg class="w-4 h-4 text-gray-400 group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="px-4 pb-4 text-sm text-gray-500 leading-relaxed">
                        Only you can view your diary entries. Your notes are private and for your personal use only.
                    </div>
                </details>
            </div>
        </div>

        <!-- Contact -->
        <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100">
            <h3 class="text-sm font-bold text-emerald-700 mb-2">Still need help?</h3>
            <p class="text-sm text-emerald-600 mb-3">Reach out to your OJT coordinator or IT support.</p>
            <div class="flex items-center gap-2 text-sm text-emerald-700 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                support@chmsu.edu.ph
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════
     ABOUT PAGE (full-screen overlay)
     ═══════════════════════════════════════════════════════ -->
<div id="aboutPage" class="hidden fixed inset-0 z-[70] bg-white flex flex-col">
    <!-- Header -->
    <div class="h-16 flex items-center px-4 border-b border-gray-100 shrink-0">
        <button onclick="closeAboutPage()" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <h1 class="ml-3 text-lg font-bold text-gray-800">About</h1>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-5 py-8 text-center">
        <!-- Logo -->
        <div class="w-20 h-20 rounded-2xl bg-emerald-500 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-200">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>

        <h2 class="text-xl font-black text-gray-800 mb-1">OJT Manager Portal</h2>
        <p class="text-sm text-gray-400 mb-6">Version 1.0.0</p>

        <p class="text-sm text-gray-600 leading-relaxed max-w-sm mx-auto mb-6">
            A dedicated platform for managing On-the-Job Training programs at <strong>Carlos Hilado Memorial State University</strong>. Built to simplify student tracking, documentation, and evaluation.
        </p>

        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 max-w-sm mx-auto text-left mb-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Key Features</h3>
           <ul class="space-y-3">
    <li class="flex items-start gap-3 text-sm text-gray-600">
        <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span><strong>Smart Dashboard</strong> — Track your OJT journey at a glance: accumulated hours, remaining targets, missed logs, and real-time progress visualization.</span>
    </li>
    <li class="flex items-start gap-3 text-sm text-gray-600">
        <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span><strong>Personal Diary</strong> — Capture daily experiences, reflections, and learnings in your private notes space.</span>
    </li>
    <li class="flex items-start gap-3 text-sm text-gray-600">
        <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span><strong>Seamless Communication</strong> — Stay connected with your supervisor through rich messaging — send text, photos, and videos instantly.</span>
    </li>
    <li class="flex items-start gap-3 text-sm text-gray-600">
        <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span><strong>Intelligent Notifications</strong> — Never miss a beat. Get alerts for new task assignments, request approvals, rejections, and important updates.</span>
    </li>
    <li class="flex items-start gap-3 text-sm text-gray-600">
        <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span><strong>Attendance Logs</strong> — Access your complete daily time-in and time-out history with detailed records.</span>
    </li>
    <li class="flex items-start gap-3 text-sm text-gray-600">
        <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span><strong>Customizable Profile</strong> — Manage and update your personal information, preferences, and account settings effortlessly.</span>
    </li>
    <li class="flex items-start gap-3 text-sm text-gray-600">
        <svg class="w-4 h-4 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
        <span><strong>Task Management</strong> — View assigned tasks, upload completion proof, and monitor your task progress from start to finish.</span>
    </li>
</ul>
        </div>

        <div class="text-xs text-gray-400">
            <p>© 2026 CHMSU OJT Manager.</p>
            <p>All rights reserved.</p>
        </div>
    </div>
</div>