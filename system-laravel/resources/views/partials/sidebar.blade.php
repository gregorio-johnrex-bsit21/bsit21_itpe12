{{-- MOBILE BOTTOM BAR (lg:hidden) --}}
<style>
    /* Sidebar dark mode */
    html.dark aside {
        background-color: var(--sidebar-bg) !important;
        border-color: var(--border-color) !important;
    }
    html.dark aside a.text-gray-500 { color: var(--text-tertiary) !important; }
    html.dark aside a:hover { background-color: var(--bg-secondary) !important; }
    html.dark aside .bg-slate-900,
    html.dark aside [class*="bg-slate-9"] { background-color: #0f172a !important; }

    /* Bottom nav dark mode */
    html.dark nav.fixed.bottom-0 {
        background-color: var(--header-bg) !important;
        border-color: var(--border-color) !important;
    }
    html.dark nav.fixed.bottom-0 a { color: var(--text-tertiary) !important; }
    html.dark nav.fixed.bottom-0 a.text-emerald-600 { color: #10b981 !important; }

    /* Company card at bottom of sidebar */
    html.dark aside .bg-gradient-to-br { background: var(--bg-secondary) !important; }
</style>

<nav class="fixed bottom-0 left-0 right-0 z-30 bg-white border-t border-gray-200 flex items-center justify-around px-2 py-2 lg:hidden">

    {{-- Dashboard --}}
    <a href="{{ route('students.dashboard') }}"
       data-tutorial="dashboard"
       class="flex flex-col items-center gap-1 px-3 py-1 rounded-xl transition
       {{ request()->routeIs('students.dashboard') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        <span class="text-[10px] font-semibold">Dashboard</span>
    </a>

    {{-- My Tasks --}}
    <a href="{{ route('students.tasks') }}"
       data-tutorial="tasks"
       class="flex flex-col items-center gap-1 px-3 py-1 rounded-xl transition
       {{ request()->routeIs('students.tasks') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
            <rect x="9" y="3" width="6" height="4" rx="1"/>
            <polyline points="9 12 11 14 15 10"/>
        </svg>
        <span class="text-[10px] font-semibold">Tasks</span>
    </a>

    {{-- NEW: Floating Plus Button (Diary/Notes) --}}
    <div class="flex flex-col items-center -mt-8">
        <button class="diaryBtn flex items-center justify-center w-14 h-14 bg-emerald-600 text-white rounded-full shadow-lg active:scale-95 transition-transform">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </button>
        <span class="text-[10px] font-bold text-emerald-600 mt-1">Add Note</span>
    </div>

    {{-- My Logs --}}
    <a href="{{ route('students.logs') }}"
       data-tutorial="logs"
       class="flex flex-col items-center gap-1 px-3 py-1 rounded-xl transition
       {{ request()->routeIs('students.logs') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <rect x="5" y="3" width="14" height="18" rx="2"/>
            <line x1="9" y1="8" x2="15" y2="8"/>
            <line x1="9" y1="12" x2="15" y2="12"/>
            <line x1="9" y1="16" x2="12" y2="16"/>
        </svg>
        <span class="text-[10px] font-semibold">Logs</span>
    </a>

    {{-- Profile --}}
    <a href="{{ route('students.profile') }}"
       data-tutorial="profile"
       class="flex flex-col items-center gap-1 px-3 py-1 rounded-xl transition
       {{ request()->routeIs('students.profile') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        <span class="text-[10px] font-semibold">Profile</span>
    </a>

</nav>

{{-- DESKTOP SIDEBAR (hidden on mobile) --}}
<aside class="hidden lg:flex fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 flex-col">

    <div class="flex items-center gap-4 p-6">
        <div class="w-[50px] h-[50px] flex-shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Harvard"
                 class="w-full h-full object-contain filter drop-shadow-sm">
        </div>
        <div class="flex flex-col">
            <span class="text-xl font-black leading-tight tracking-tighter text-slate-800">CHMSU</span>
            <span class="text-xs font-bold leading-tight text-emerald-600 uppercase tracking-[0.2em]">OJT Manager</span>
        </div>
    </div>

    <nav class="flex-1 px-4 space-y-1">
        <a href="{{ route('students.dashboard') }}"
           class="w-full flex items-center space-x-3 p-3 rounded-xl font-semibold transition
           {{ request()->routeIs('students.dashboard') ? 'bg-emerald-600 text-white' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('students.tasks') }}"
           class="w-full flex items-center space-x-3 p-3 rounded-xl font-semibold transition
           {{ request()->routeIs('students.tasks') ? 'bg-emerald-600 text-white' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
                <polyline points="9 12 11 14 15 10"/>
            </svg>
            <span>Tasks</span>
        </a>

        <a href="{{ route('students.logs') }}"
           class="w-full flex items-center space-x-3 p-3 rounded-xl font-semibold transition
           {{ request()->routeIs('students.logs') ? 'bg-emerald-600 text-white' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <rect x="5" y="3" width="14" height="18" rx="2"/>
                <line x1="9" y1="8" x2="15" y2="8"/>
                <line x1="9" y1="12" x2="15" y2="12"/>
                <line x1="9" y1="16" x2="12" y2="16"/>
            </svg>
            <span>My Logs</span>
        </a>

        <a href="{{ route('students.profile') }}"
           class="w-full flex items-center space-x-3 p-3 rounded-xl font-semibold transition
           {{ request()->routeIs('students.profile') ? 'bg-emerald-600 text-white' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Profile</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-300">
        <div class="relative h-20 w-full rounded-2xl overflow-hidden">
            <img src="{{ asset('images/microsoft.webp') }}" alt="Microsoft" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            <div class="absolute bottom-3 left-3 right-3">
                <p class="text-[9px] font-bold text-emerald-400 tracking-widest uppercase">Partner Company</p>
                <h4 class="text-white font-bold text-sm leading-tight">{{ $company->name ?? 'No Company' }}</h4>
            </div>
        </div>
    </div>

</aside>