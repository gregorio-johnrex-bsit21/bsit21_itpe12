@extends('layouts.app')

@section('title', 'Attendance Logs')

@section('content')

<style>
    html.dark [data-log-card] {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }
    html.dark [data-log-card] p.text-white { color: #ffffff !important; }
    html.dark .bg-slate-50\/80 { background-color: var(--bg-secondary) !important; }
    html.dark .bg-slate-50 { background-color: var(--bg-secondary) !important; }
    html.dark .border-slate-200 { border-color: var(--border-color) !important; }
    html.dark .text-slate-700, html.dark .text-slate-800 { color: var(--text-secondary) !important; }
    html.dark .text-slate-400, html.dark .text-slate-500 { color: var(--text-muted) !important; }

    /* Clock widget */
    html.dark .bg-white.border-slate-200\/60 {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }
    html.dark .bg-slate-50.rounded-xl { background-color: var(--bg-secondary) !important; }
    html.dark .bg-emerald-50 { background-color: rgba(6, 78, 59, 0.3) !important; }

    /* Missed hours modals */
    html.dark .bg-white.rounded-2xl,
    html.dark .bg-white.rounded-t-3xl {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }
    html.dark .bg-slate-50.rounded-xl.border { background-color: var(--bg-secondary) !important; border-color: var(--border-color) !important; }
</style>

<style>
    [x-cloak] { display: none !important; }
    .modal-open { overflow: hidden; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
</style>

<div x-data="{ 
    monthFilter: false, 
    missedHoursModal: false, 
    missedMonthDropdown: false,
    selectedMonth: 'All',
    missedMonthFilter: 'All',
    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
}" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">

{{-- Pass PHP logs data to JS --}}
<script>
    const allLogs = @json($logs->values());
</script>

<!-- Page Title Section -->


<!-- Clean SaaS Clock Widget - Full Width Mobile, Compact Desktop -->
<div class="w-[calc(100%+2rem)] -mx-4 sm:w-full sm:mx-0">

    <div class="mb-4">
    <h2 class="text-xl font-bold text-gray-900">Daily Time Record</h2>
    </div>

    <div class="relative overflow-hidden rounded-none sm:rounded-2xl bg-white border-y sm:border border-slate-200/60 shadow-none sm:shadow-sm p-4 sm:p-5 mb-3">
        
        <!-- Top accent line -->
        <div class="absolute top-0 left-0 right-0 sm:left-4 sm:right-4 h-0.5 bg-gradient-to-r from-emerald-400 to-teal-500 sm:rounded-full"></div>
        
        <div class="flex items-center justify-between gap-3 sm:gap-4">
            
            <!-- Left: Analog Clock + Digital -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Analog Clock -->
                <div class="relative w-14 h-14 sm:w-16 sm:h-16 flex-shrink-0">
                    <svg class="w-full h-full" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="46" fill="none" stroke="#e2e8f0" stroke-width="2"/>
                        <circle cx="50" cy="50" r="42" fill="none" stroke="#f1f5f9" stroke-width="1"/>
                        <g stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round">
                            <line x1="50" y1="8" x2="50" y2="14" />
                            <line x1="50" y1="86" x2="50" y2="92" />
                            <line x1="8" y1="50" x2="14" y2="50" />
                            <line x1="86" y1="50" x2="92" y2="50" />
                        </g>
                        <circle cx="50" cy="50" r="3" fill="#10b981"/>
                        <line id="hourHand" x1="50" y1="50" x2="50" y2="28" stroke="#334155" stroke-width="3" stroke-linecap="round" transform="rotate(0 50 50)"/>
                        <line id="minuteHand" x1="50" y1="50" x2="50" y2="18" stroke="#64748b" stroke-width="2" stroke-linecap="round" transform="rotate(0 50 50)"/>
                        <line id="secondHand" x1="50" y1="50" x2="50" y2="14" stroke="#10b981" stroke-width="1" stroke-linecap="round" transform="rotate(0 50 50)"/>
                    </svg>
                </div>
                
                <!-- Digital Time + Date -->
                <div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl sm:text-3xl font-bold text-slate-800 font-mono tracking-tight">
                            <span id="clockHours">--</span><span>:</span><span id="clockMinutes">--</span><span>:</span><span id="clockSeconds">--</span>
                        </span>
                        <span class="text-xs sm:text-sm font-medium text-slate-400 lowercase" id="clockPeriod">--</span>
                    </div>
                    <div class="flex items-center gap-1 mt-0.5">
                        <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-[11px] font-medium text-slate-500">{{ now('Asia/Manila')->format('l, d F Y') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Right: Status -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Shift - desktop only -->
                <div class="hidden sm:flex flex-col items-end bg-slate-50 rounded-xl px-3 py-2 border border-slate-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Shift</span>
                    <span class="text-xs font-semibold text-slate-700">Standard OJT</span>
                </div>
                
                <!-- Location badge -->
                <div class="flex items-center gap-1.5 bg-emerald-50 rounded-xl px-2.5 sm:px-3 py-2 border border-emerald-100">
                    <span class="relative flex h-2 w-2">
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                    </span>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest leading-none hidden sm:block">Location</span>
                        <span class="text-xs font-semibold text-emerald-700">Online</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- 2. Controls Section (Filters aligned to the right) -->
<div class="flex flex-row justify-between items-center mb-4">
    <!-- Left Side: Logs Label -->
    <div class="flex items-center gap-2 md:gap-3">
        <!-- Log SVG Icon -->
        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        
        <h3 class="text-xs md:text-sm font-bold text-slate-700 uppercase tracking-widest">Attendance Logs</h3>
    </div>

    <!-- Right Side: Filter and Modal Buttons -->
    <div class="flex items-center gap-2 md:gap-3">
        <div class="relative">
            <button @click="monthFilter = !monthFilter" class="flex items-center gap-2 p-2.5 md:px-4 md:py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="hidden md:block" x-text="selectedMonth === 'All' ? 'All Months' : selectedMonth"></span>
            </button>
            <div x-show="monthFilter" @click.away="monthFilter = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl z-[70] max-h-60 overflow-y-auto">
    <button @click="selectedMonth = 'All'; monthFilter = false; filterLogs('All')" 
        class="w-full text-left px-4 py-3 text-sm hover:bg-emerald-50 hover:text-emerald-700 transition font-semibold">
        All Months
    </button>
    <template x-for="month in months" :key="month">
        <button @click="selectedMonth = month; monthFilter = false; filterLogs(month)" 
            class="w-full text-left px-4 py-3 text-sm hover:bg-emerald-50 hover:text-emerald-700 transition" 
            x-text="month">
        </button>
    </template>
</div>
        </div>

        <button @click="missedHoursModal = true" class="p-2.5 bg-white border border-slate-200 rounded-xl shadow-sm text-slate-600 hover:text-emerald-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>
</div>

<!-- Divider: Signals data below -->
<div class="flex items-center gap-3 mb-6">
    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-slate-200 to-slate-200"></div>
    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest whitespace-nowrap">Recent Entries</span>
    <div class="flex-1 h-px bg-slate-200"></div>
</div>

<!-- 3. Log Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0 md:gap-6 items-start -mx-4 md:mx-0 ">
    
    @forelse($logs as $log)
    <div class="flex flex-col bg-white md:border md:border-slate-200 md:shadow-sm overflow-hidden border-b border-slate-200 last:border-b-0" 
    data-log-card
    data-month="{{ \Carbon\Carbon::parse($log['date'])->format('F') }}">
        
        <p class="text-[11px] font-bold text-white uppercase tracking-widest py-2 px-4 md:px-6 bg-emerald-600 border-b border-slate-200">
            {{ $log['date'] }}
        </p>

        <div class="p-3 md:p-6 flex-1">
            <!-- AM Block -->
            <div class="mb-3 pb-3 md:mb-6 md:pb-5 border-b border-slate-200 md:border-0">
                <div class="relative flex items-center justify-center mb-3 md:mb-4">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-dashed border-slate-300"></div>
                    </div>
                    <span class="relative px-3 py-1 bg-white text-slate-900 text-[10px] font-bold rounded-full border border-slate-200 uppercase tracking-wider shadow-sm">
                        AM Shift
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 md:gap-4">
                    <div>
                        <p class="text-[9px] text-slate-500 uppercase font-bold tracking-tight">Time In</p>
                        <p class="text-base md:text-lg font-bold text-slate-800 leading-tight">
                            {{ $log['am_in_display'] ?? '--:--' }}
                        </p>
                        @if($log['am_in_raw'])
                        <p class="text-[9px] font-medium mt-0.5 flex items-center gap-1">
                            @if($log['am_in_status'] === 'early')
                                <svg class="w-2.5 h-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-emerald-500">Arr: {{ $log['am_in_raw'] }}</span>
                            @elseif($log['am_in_status'] === 'late')
                                <svg class="w-2.5 h-2.5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-rose-500">Arr: {{ $log['am_in_raw'] }}</span>
                            @else
                                <span class="text-slate-400">Arr: {{ $log['am_in_raw'] }}</span>
                            @endif
                        </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] text-slate-500 uppercase font-bold tracking-tight">Time Out</p>
                        <p class="text-base md:text-lg font-bold text-slate-800 leading-tight">
                            {{ $log['am_out_display'] ?? '--:--' }}
                        </p>
                        @if($log['am_out_raw'])
                        <p class="text-[9px] font-medium mt-0.5 flex items-center justify-end gap-1">
                            @if($log['am_out_status'] === 'early')
                                <svg class="w-2.5 h-2.5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-rose-500">Dep: {{ $log['am_out_raw'] }}</span>
                            @elseif($log['am_out_status'] === 'late')
                                <svg class="w-2.5 h-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-emerald-500">Dep: {{ $log['am_out_raw'] }}</span>
                            @else
                                <span class="text-slate-400">Dep: {{ $log['am_out_raw'] }}</span>
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- PM Block -->
            <div>
                <div class="relative flex items-center justify-center mb-3 md:mb-4">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-dashed border-slate-300"></div>
                    </div>
                    <span class="relative px-3 py-1 bg-white text-slate-600 text-[10px] font-bold rounded-full border border-slate-200 uppercase tracking-wider shadow-sm">
                        PM Shift
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 md:gap-4">
                    <div>
                        <p class="text-[9px] text-slate-500 uppercase font-bold tracking-tight">Time In</p>
                        <p class="text-base md:text-lg font-bold text-slate-800 leading-tight">
                            {{ $log['pm_in_display'] ?? '--:--' }}
                        </p>
                        @if($log['pm_in_raw'])
                        <p class="text-[9px] font-medium mt-0.5 flex items-center gap-1">
                            @if($log['pm_in_status'] === 'early')
                                <svg class="w-2.5 h-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-emerald-500">Arr: {{ $log['pm_in_raw'] }}</span>
                            @elseif($log['pm_in_status'] === 'late')
                                <svg class="w-2.5 h-2.5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-rose-500">Arr: {{ $log['pm_in_raw'] }}</span>
                            @else
                                <span class="text-slate-400">Arr: {{ $log['pm_in_raw'] }}</span>
                            @endif
                        </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] text-slate-500 uppercase font-bold tracking-tight">Time Out</p>
                        <p class="text-base md:text-lg font-bold text-slate-800 leading-tight">
                            {{ $log['pm_out_display'] ?? '--:--' }}
                        </p>
                        @if($log['pm_out_raw'])
                        <p class="text-[9px] font-medium mt-0.5 flex items-center justify-end gap-1">
                            @if($log['pm_out_status'] === 'early')
                                <svg class="w-2.5 h-2.5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-rose-500">Dep: {{ $log['pm_out_raw'] }}</span>
                            @elseif($log['pm_out_status'] === 'late')
                                <svg class="w-2.5 h-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                <span class="text-emerald-500">Dep: {{ $log['pm_out_raw'] }}</span>
                            @else
                                <span class="text-slate-400">Dep: {{ $log['pm_out_raw'] }}</span>
                            @endif
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Collapsible Footer -->
        <div class="bg-slate-50/80 border-t border-slate-200">
            <button class="toggle-details w-full flex items-center justify-center gap-2 py-2.5 md:py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider hover:text-slate-800 hover:bg-slate-100/50 transition-all cursor-pointer select-none" aria-expanded="false">
                <span>View Details</span>
                <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <div class="details-content grid grid-rows-[0fr] transition-all duration-300 ease-in-out">
                <div class="overflow-hidden">
                    <div class="px-3 md:px-6 pb-3 md:pb-6 pt-2">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-[9px] text-slate-500 uppercase font-extrabold tracking-tight">Total Worked</span>
                                <p class="text-sm font-bold text-slate-700">{{ $log['total_formatted'] }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] text-slate-500 uppercase font-extrabold tracking-tight">Missed</span>
                                <p class="text-sm font-bold {{ $log['missed_minutes'] > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    {{ $log['missed_minutes'] > 0 ? $log['missed_minutes'] . 'm' : '0m' }}
                                </p>
                            </div>
                        </div>
                        @if($log['missed_minutes'] > 0)
                        <div class="mt-3 pt-3 border-t border-slate-200 flex justify-between items-center text-[10px] text-slate-400">
                            <span>Late/Early deductions applied</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div id="no-logs-msg" class="col-span-full text-center py-12 text-slate-400">
        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-sm font-medium">No attendance records yet</p>
        <p class="text-xs mt-1">Clock in to start logging your hours</p>
    </div>
    @endforelse
</div>

<!-- Mobile Bottom Sheet -->
<div 
    x-show="missedHoursModal" 
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="md:hidden fixed inset-0 z-[100]"
>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/40" @click="missedHoursModal = false"></div>

    <!-- Sheet -->
    <div 
        x-show="missedHoursModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl max-h-[75vh] flex flex-col"
        @click.stop
    >
        <!-- Drag Handle -->
        <div class="flex justify-center pt-3 pb-1">
            <div class="w-10 h-1 bg-slate-300 rounded-full"></div>
        </div>

        <!-- Header -->
        <div class="px-5 py-3 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest">Missed Hours</h3>
            <button @click="missedHoursModal = false" class="p-1.5 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Scrollable Content -->
        <div class="overflow-y-auto p-5 space-y-4">
            
            <!-- Month Filter -->
            <div class="relative">
                <button 
                    @click="missedMonthDropdown = !missedMonthDropdown" 
                    class="flex items-center gap-2 w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 active:bg-slate-50 transition"
                >
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span x-text="missedMonthFilter === 'All' ? 'All Months' : missedMonthFilter"></span>
                    <svg 
                        class="w-4 h-4 ml-auto text-slate-400 transition-transform duration-200"
                        :class="missedMonthDropdown ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <div 
                    x-show="missedMonthDropdown" 
                    @click.away="missedMonthDropdown = false" 
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="absolute left-0 right-0 mt-2 bg-white border border-slate-200 rounded-xl shadow-xl z-10 max-h-56 overflow-y-auto"
                >
                    <button 
                        @click="missedMonthFilter = 'All'; missedMonthDropdown = false; renderMissedModal('All')" 
                        class="w-full text-left px-4 py-3 text-sm hover:bg-emerald-50 hover:text-emerald-700 transition"
                        :class="missedMonthFilter === 'All' ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700'"
                    >All Months</button>
                    <template x-for="month in months" :key="month">
                        <button 
                            @click="missedMonthFilter = month; missedMonthDropdown = false; renderMissedModal(month)" 
                            class="w-full text-left px-4 py-3 text-sm hover:bg-emerald-50 hover:text-emerald-700 transition"
                            :class="missedMonthFilter === month ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700'"
                            x-text="month"
                        ></button>
                    </template>
                </div>
            </div>

           <!-- Stats -->
<div class="grid grid-cols-3 gap-3">
    <div class="text-center p-3 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Days</p>
        <p class="text-xl font-bold text-slate-800" id="mobile-stat-days">0</p>
    </div>
    <div class="text-center p-3 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Late</p>
        <p class="text-xl font-bold text-rose-500" id="mobile-stat-late">0</p>
    </div>
    <div class="text-center p-3 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Early Out</p>
        <p class="text-xl font-bold text-orange-500" id="mobile-stat-early">0</p>
    </div>
</div>

<!-- List -->
<div class="space-y-2.5" id="mobile-missed-list">
    {{-- Filled by JS --}}
</div>

<!-- Total -->
<div class="pt-3 border-t border-slate-200 flex justify-between items-center">
    <span class="text-xs text-slate-500 font-medium">Total missed</span>
    <span class="text-sm font-bold text-rose-500" id="mobile-stat-total">0m</span>
</div>
        </div>
    </div>
</div>

<!-- Desktop Modal -->
<div 
    x-show="missedHoursModal" 
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="hidden md:flex fixed inset-0 z-[100] items-center justify-center p-4"
>
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/40" @click="missedHoursModal = false"></div>

    <!-- Modal -->
    <div 
        x-show="missedHoursModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[600px] flex flex-col"
        @click.stop
    >
        <!-- Header -->
        <div class="px-5 py-3 border-b border-slate-100 flex items-center justify-between shrink-0">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Missed Hours</h3>
            <button @click="missedHoursModal = false" class="p-1 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Scrollable Content -->
        <div class="overflow-y-auto p-5 space-y-4">
            
            <!-- Month Filter -->
            <div class="relative">
                <button 
                    @click="missedMonthDropdown = !missedMonthDropdown" 
                    class="flex items-center gap-2 w-full px-3 py-2.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 transition"
                >
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span x-text="missedMonthFilter === 'All' ? 'All Months' : missedMonthFilter"></span>
                    <svg 
                        class="w-3.5 h-3.5 ml-auto text-slate-400 transition-transform duration-200"
                        :class="missedMonthDropdown ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <div 
                    x-show="missedMonthDropdown" 
                    @click.away="missedMonthDropdown = false" 
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="absolute left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-lg shadow-xl z-10 max-h-48 overflow-y-auto"
                >
                    <button 
                        @click="missedMonthFilter = 'All'; missedMonthDropdown = false; renderMissedModal('All')" 
                        class="w-full text-left px-3 py-2.5 text-xs hover:bg-emerald-50 hover:text-emerald-700 transition"
                        :class="missedMonthFilter === 'All' ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700'"
                    >All Months</button>
                    <template x-for="month in months" :key="month">
                        <button 
                            @click="missedMonthFilter = month; missedMonthDropdown = false; renderMissedModal(month)" 
                            class="w-full text-left px-3 py-2.5 text-xs hover:bg-emerald-50 hover:text-emerald-700 transition"
                            :class="missedMonthFilter === month ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-700'"
                            x-text="month"
                        ></button>
                    </template>
                </div>
            </div>

            <!-- Stats -->
<div class="grid grid-cols-3 gap-2.5">
    <div class="text-center p-3 bg-slate-50 rounded-lg border border-slate-100">
        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Days</p>
        <p class="text-lg font-bold text-slate-800" id="desktop-stat-days">0</p>
    </div>
    <div class="text-center p-3 bg-slate-50 rounded-lg border border-slate-100">
        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Late</p>
        <p class="text-lg font-bold text-rose-500" id="desktop-stat-late">0</p>
    </div>
    <div class="text-center p-3 bg-slate-50 rounded-lg border border-slate-100">
        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Early Out</p>
        <p class="text-lg font-bold text-orange-500" id="desktop-stat-early">0</p>
    </div>
</div>

<!-- List -->
<div class="space-y-2" id="desktop-missed-list">
    {{-- Filled by JS --}}
</div>

<!-- Total -->
<div class="pt-3 border-t border-slate-200 flex justify-between items-center">
    <span class="text-xs text-slate-500 font-medium">Total missed</span>
    <span class="text-base font-bold text-rose-500" id="desktop-stat-total">0m</span>
</div>
        </div>
    </div>
</div>

    
</div>




<script>
// ── Log card toggle ──────────────────────────────────────────
document.querySelectorAll('[data-log-card]').forEach(card => {
    const btn     = card.querySelector('.toggle-details');
    const content = card.querySelector('.details-content');
    const icon    = btn.querySelector('svg');
    const label   = btn.querySelector('span');

    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = btn.getAttribute('aria-expanded') === 'true';
        if (isOpen) {
            content.classList.remove('grid-rows-[1fr]');
            content.classList.add('grid-rows-[0fr]');
            icon.style.transform = 'rotate(0deg)';
            label.textContent = 'View Details';
            btn.setAttribute('aria-expanded', 'false');
        } else {
            content.classList.remove('grid-rows-[0fr]');
            content.classList.add('grid-rows-[1fr]');
            icon.style.transform = 'rotate(180deg)';
            label.textContent = 'Hide Details';
            btn.setAttribute('aria-expanded', 'true');
        }
    });
});

// ── Month filter ─────────────────────────────────────────────
function filterLogs(month) {
    const cards    = document.querySelectorAll('[data-log-card]');
    const emptyMsg = document.getElementById('no-logs-msg');
    let visible    = 0;

    cards.forEach(card => {
        const cardMonth = card.getAttribute('data-month');
        const show      = month === 'All' || cardMonth === month;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    if (emptyMsg) emptyMsg.style.display = visible === 0 ? '' : 'none';

    // Update missed modal for the selected month too
    renderMissedModal(month);
}

// ── Missed hours modal ────────────────────────────────────────
function renderMissedModal(month) {
    const filtered = month === 'All'
        ? allLogs
        : allLogs.filter(log => {
            const d = new Date(log.date);
            return d.toLocaleString('default', { month: 'long' }) === month;
        });

    // Stats
    let days     = filtered.length;
    let lateCount = 0;
    let earlyCount = 0;
    let totalMissed = 0;
    let listItems = [];

    filtered.forEach(log => {
        if (log.missed_minutes > 0) {
            totalMissed += log.missed_minutes;

            // Determine late/early type for label
            let reasons = [];
            if (log.am_in_status === 'late')   { lateCount++;  reasons.push('Late arrival'); }
            if (log.am_out_status === 'early')  { earlyCount++; reasons.push('Early AM out'); }
            if (log.pm_in_status === 'late')    { lateCount++;  reasons.push('Late PM in'); }
            if (log.pm_out_status === 'early')  { earlyCount++; reasons.push('Early departure'); }

            listItems.push({
                date:    log.date,
                reason:  reasons.join(' + ') || 'Time deduction',
                minutes: log.missed_minutes,
            });
        }
    });

    // Format total
    const totalH = Math.floor(totalMissed / 60);
    const totalM = totalMissed % 60;
    const totalStr = totalH > 0 ? `${totalH}h ${totalM}m` : `${totalM}m`;

    // Update stats — both mobile and desktop
    ['mobile', 'desktop'].forEach(prefix => {
        const daysEl  = document.getElementById(`${prefix}-stat-days`);
        const lateEl  = document.getElementById(`${prefix}-stat-late`);
        const earlyEl = document.getElementById(`${prefix}-stat-early`);
        const totalEl = document.getElementById(`${prefix}-stat-total`);
        const listEl  = document.getElementById(`${prefix}-missed-list`);

        if (daysEl)  daysEl.textContent  = days;
        if (lateEl)  lateEl.textContent  = lateCount;
        if (earlyEl) earlyEl.textContent = earlyCount;
        if (totalEl) totalEl.textContent = totalMissed === 0 ? '0m' : totalStr;

        if (listEl) {
            if (listItems.length === 0) {
                listEl.innerHTML = `
                    <div class="text-center py-6 text-slate-400">
                        <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-medium">No missed hours — great work!</p>
                    </div>`;
            } else {
                listEl.innerHTML = listItems.map(item => `
                    <div class="flex items-center justify-between p-3 border border-slate-200 rounded-xl hover:border-rose-200 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">${item.date}</p>
                                <p class="text-[10px] text-slate-400">${item.reason}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-rose-500">${item.minutes}m</span>
                    </div>`
                ).join('');
            }
        }
    });
}

// Init modal with all data on page load
renderMissedModal('All');

// Re-render when missed modal opens (sync with current month filter)
document.querySelector('[\\@click="missedHoursModal = true"]')?.addEventListener('click', () => {
    const currentMonth = document.querySelector('[x-data]')?.__x?.$data?.selectedMonth ?? 'All';
    renderMissedModal(currentMonth);
});

// ── Clock ────────────────────────────────────────────────────
function updateClock() {
    const now     = new Date();
    const hours   = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();

    const displayHours   = (hours % 12 || 12).toString().padStart(2, '0');
    const displayMinutes = minutes.toString().padStart(2, '0');
    const displaySeconds = seconds.toString().padStart(2, '0');
    const period         = hours >= 12 ? 'pm' : 'am';

    const hoursEl   = document.getElementById('clockHours');
    const minutesEl = document.getElementById('clockMinutes');
    const secondsEl = document.getElementById('clockSeconds');
    const periodEl  = document.getElementById('clockPeriod');

    if (hoursEl.textContent   !== displayHours)   hoursEl.textContent   = displayHours;
    if (minutesEl.textContent !== displayMinutes)  minutesEl.textContent = displayMinutes;
    if (secondsEl.textContent !== displaySeconds)  secondsEl.textContent = displaySeconds;
    if (periodEl.textContent  !== period)          periodEl.textContent  = period;

    const hourDeg   = (hours % 12) * 30 + minutes * 0.5;
    const minuteDeg = minutes * 6 + seconds * 0.1;
    const secondDeg = seconds * 6;

    document.getElementById('hourHand').setAttribute('transform',   `rotate(${hourDeg} 50 50)`);
    document.getElementById('minuteHand').setAttribute('transform', `rotate(${minuteDeg} 50 50)`);
    document.getElementById('secondHand').setAttribute('transform', `rotate(${secondDeg} 50 50)`);
}

updateClock();
setInterval(updateClock, 1000);
</script>



@endsection