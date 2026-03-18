 <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden"></div>


           <!--sidebar-->

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col">
            
          <div class="flex items-center justify-between p-6">
    <div class="flex items-center gap-4">
        <div class="w-[50px] h-[50px] flex-shrink-0">
            <img src="{{ asset('images/harvard.png') }}" alt="Harvard"
                 class="w-full h-full object-contain filter drop-shadow-sm">
        </div>

        <div class="flex flex-col">
            <span class="text-xl font-black leading-tight tracking-tighter text-slate-800">Harvard OJT</span>
            <span class="text-xs font-bold leading-tight text-emerald-600 uppercase tracking-[0.2em]">Manager</span>
        </div>
    </div>

    <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>



         
            
          <nav class="flex-1 px-4 space-y-1">
    <a href="{{ route('students.dashboard') }}"
       @click="sidebarOpen = false"
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
       @click="sidebarOpen = false"
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
       @click="sidebarOpen = false"
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
       @click="sidebarOpen = false"
       class="w-full flex items-center space-x-3 p-3 rounded-xl font-semibold transition
       {{ request()->routeIs('students.profile') ? 'bg-emerald-600 text-white' : 'text-gray-500 hover:bg-gray-50' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <span>Profile</span>
    </a>
</nav>
           
           <div class="p-4 border-t border-gray-100">
    <div class="relative h-20 w-full rounded-2xl overflow-hidden group">
       <img src="{{ asset('images/microsoft.webp') }}" alt="Microsoft" class="absolute inset-0 w-full h-50 object-cover">
        
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>

        <div class="absolute bottom-3 left-3 right-3">
            <p class="text-[9px] font-bold text-emerald-400 tracking-widest uppercase">Partner Company</p>
            <h4 class="text-white font-bold text-sm leading-tight">RRL Tech Solutions</h4>
        </div>
    </div>
</div>
        </aside>