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
                <i class="fas fa-tachometer-alt w-5 text-center"></i>
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