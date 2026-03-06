@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


<div class="mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-gray-400 text-xs font-bold uppercase tracking-widest">Welcome back,</h2>
            <div class="flex items-center gap-2 mt-1">
                <h1 class="text-3xl font-black text-gray-800">Charlie Kirk</h1>
            </div>
        </div>
</div>


<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

  <div class="group relative overflow-hidden bg-white p-4 rounded-2xl border border-slate-300 shadow-sm hover:shadow-md transition-all duration-300">
    <div class="flex items-center justify-between mb-2">
      <span class="text-slate-400 text-[10px] font-bold uppercase tracking-wider">Required</span>
      <div class="p-1.5 bg-gray-100 rounded-lg text-slate-500">
        <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
      </div>
    </div>
    <div class="flex items-baseline gap-0.5">
      <p class="text-xl font-black text-slate-900 leading-none">500</p>
      <p class="text-[11px] font-bold text-slate-400">h</p>
    </div>
  </div>

  <div class="group relative overflow-hidden bg-white p-4 rounded-2xl border border-slate-300 shadow-sm hover:shadow-md transition-all duration-300">
    <div class="flex items-center justify-between mb-2">
      <span class="text-emerald-500 text-[10px] font-bold uppercase tracking-wider">Accumulated</span>
      <div class="p-1.5 bg-emerald-500 rounded-lg text-white">
        <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4.5v15m7.5-7.5h-15"/></svg>
      </div>
    </div>
    <div class="flex items-baseline gap-0.5">
      <p class="text-xl font-black text-emerald-600 leading-none">124</p>
      <p class="text-[11px] font-bold text-emerald-400">h</p>
    </div>
  </div>

  <div class="group relative overflow-hidden p-4 rounded-2xl bg-white border border-slate-300 shadow-sm hover:shadow-md transition-all duration-300">
    <div class="flex items-center justify-between mb-2">
      <span class="text-orange-600 text-[10px] font-bold uppercase tracking-wider">Remaining</span>
      <div class="p-1.5 bg-orange-500 rounded-lg text-white">
        <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 12L6 2h12l-6 10zm0 0l6 10H6l6-10zM6 2c0 2.21 1.79 4 4 4m4 0c2.21 0 4-1.79 4-4M6 22c0-2.21 1.79-4 4-4m4 0c2.21 0 4 1.79 4 4" />
        </svg>
      </div>
    </div>
    <div class="flex items-baseline gap-0.5">
      <p class="text-xl font-black text-orange-700 leading-none">376</p>
      <p class="text-[11px] font-bold text-orange-400">h</p>
    </div>
  </div>

  <div class="group relative overflow-hidden p-4 rounded-2xl bg-white border border-slate-300 shadow-sm hover:shadow-md transition-all duration-300">
    <div class="flex items-center justify-between mb-2">
      <span class="text-rose-600 text-[10px] font-bold uppercase tracking-wider">Missed</span>
      <div class="p-1.5 bg-rose-500 rounded-lg text-white">
        <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
      </div>
    </div>
    <div class="flex items-baseline gap-0.5">
      <p class="text-xl font-black text-rose-700 leading-none">24</p>
      <p class="text-[11px] font-bold text-rose-400">h</p>
    </div>
  </div>
</div>




                   <div class="bg-white p-6 rounded-[2rem] border border-slate-300 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all hover:shadow-[0_20px_40px_rgb(0,0,0,0.06)]">
    <div class="flex justify-between items-end mb-4">
        <div>
            <h3 class="font-bold text-slate-800 text-lg leading-none">OJT Progress</h3>
        </div>
        <div class="flex flex-col items-end">
            <span class="text-emerald-600 font-black text-2xl tracking-tight leading-none">24.8%</span>
        </div>
    </div>

    <div class="relative w-full bg-slate-100 rounded-2xl h-4 overflow-hidden p-1 shadow-inner">
        <div 
            class="relative h-full rounded-xl bg-gradient-to-r from-emerald-500 via-emerald-400 to-emerald-600 transition-all duration-1000 shadow-[0_1px_10px_rgba(16,185,129,0.4)]" 
            style="width: 24.8%"
        >
            <div class="absolute inset-0 bg-gradient-to-b from-white/20 to-transparent opacity-50 rounded-xl"></div>
        </div>
    </div>

    <div class="flex justify-between mt-4 text-[11px] font-bold text-slate-400 uppercase tracking-tighter">
        <span>72h</span>
        <span class="text-slate-300">Target: 500h</span>
    </div>
</div>




                    <!--start of the ojt table area-->

                <div class="bg-white rounded-[2rem] border border-slate-300 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden flex flex-col">
    <div class="p-6 flex flex-col gap-4 bg-white">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-bold text-slate-800 text-xl leading-none tracking-tight">My Logs</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 mt-1.5">Daily Time Record</p>
            </div>
            <div class="relative group">
                <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 hover:border-emerald-400 transition-all cursor-pointer active:scale-95">
                    <svg class="w-3.5 h-3.5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-tight">Filter Date</span>
                    <input type="date" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                </div>
            </div>
        </div>

       <div class="flex flex-row items-center justify-between bg-emerald-50/50 rounded-2xl px-5 py-3.5 border border-emerald-100/50">
    
    <div class="flex flex-col">
        <p class="text-[9px] font-bold uppercase tracking-widest text-emerald-600/70">Current Date</p>
        <p class="text-sm font-bold text-slate-700" 
           x-data="{ date: new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }" 
           x-text="date">
           March 1, 2026
        </p>
    </div>

    <div class="flex flex-col text-right" 
         x-data="{ 
            time: '',
            updateTime() {
                this.time = new Date().toLocaleTimeString('en-US', { 
                    hour12: true, 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                });
            },
            init() {
                this.updateTime();
                setInterval(() => this.updateTime(), 1000);
            }
         }">
        <p class="text-[9px] font-bold uppercase tracking-widest text-emerald-600/70">Local Time</p>
        <p class="text-sm font-mono font-bold text-slate-700" x-text="time">00:00:00 AM</p>
    </div>

</div>
    </div>
    
    <div class="overflow-x-auto scrollbar-hide">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4 border-b border-slate-100 sticky left-0 bg-slate-50 z-20 border-r border-slate-100">Date</th>
                    <th colspan="2" class="px-6 py-2 border-b border-l border-slate-100 text-center bg-gray-50/30 text-gray-700">AM Session</th>
                    <th colspan="2" class="px-6 py-2 border-b border-l border-slate-100 text-center bg-gray-50/30 text-gray-700">PM Session</th>
                    <th class="px-6 py-4 border-b border-l border-slate-100 text-center bg-slate-100/30 text-slate-600">Total</th>
                    <th class="px-6 py-4 border-b border-l border-slate-100 text-center bg-gray-50/50 text-rose-600 uppercase">Missed</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <tr class="group hover:bg-emerald-50/20 transition-colors">
                    <td class="px-6 py-4 sticky left-0 bg-white z-10 border-r border-slate-100 group-hover:bg-emerald-50/5 transition-colors shadow-[2px_0_5px_rgba(0,0,0,0.01)]">
                        <p class="text-sm font-bold text-slate-800 whitespace-nowrap">Feb 21, 2026</p>
                        <p class="text-[9px] text-slate-400 font-medium whitespace-nowrap">Regular Day</p>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="text-xs font-bold text-slate-700">08:00 AM</span>
                        <p class="text-[9px] text-slate-400 font-mono">07:32</p>
                    </td>
                    <td class="px-4 py-4 text-center border-r border-slate-50/50">
                        <span class="text-xs text-slate-700 font-medium">12:00 PM</span>
                        <p class="text-[9px] text-slate-400 font-mono">12:01</p>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="text-xs font-bold text-slate-700">01:00 PM</span>
                        <p class="text-[9px] text-slate-400 font-mono">12:45</p>
                    </td>
                    <td class="px-4 py-4 text-center border-r border-slate-50/50">
                        <span class="text-xs text-slate-700 font-medium">05:00 PM</span>
                        <p class="text-[9px] text-slate-400 font-mono">05:05</p>
                    </td>
                    <td class="px-4 py-4 text-center font-bold text-slate-600 text-xs">8.0h</td>
                    <td class="px-4 py-4 text-center border-l border-slate-50 font-medium text-slate-300 text-xs">0.0</td>
                </tr>

                <tr class="bg-rose-50/10 hover:bg-rose-50/20 transition-colors">
                    <td class="px-6 py-4 sticky left-0 bg-white z-10 border-r border-slate-100 shadow-[2px_0_5px_rgba(0,0,0,0.01)]">
                        <p class="text-sm font-bold text-slate-800 whitespace-nowrap">Feb 20, 2026</p>
                        <p class="text-[9px] text-rose-500 font-bold uppercase tracking-tight whitespace-nowrap">Undertime</p>
                    </td>
                    <td class="px-4 py-4 text-center"><span class="text-xs font-bold text-slate-700">08:15 AM</span>
                    <p class="text-[9px] text-slate-400 font-mono">8:15</p></td>
                    <td class="px-4 py-4 text-center border-r border-slate-50/50"><span class="text-xs text-slate-700">12:00 PM</span>
                    <p class="text-[9px] text-slate-400 font-mono">12:03</p></td>
                    <td class="px-4 py-4 text-center"><span class="text-xs font-bold text-slate-700">01:00 PM</span>
                    <p class="text-[9px] text-slate-400 font-mono">1:00</p></td>
                    <td class="px-4 py-4 text-center border-r border-slate-50/50">
                        <span class="text-xs font-bold text-rose-600 decoration-rose-200">03:00 PM</span>
                        <p class="text-[9px] text-slate-400 font-mono">3:00</p>
                    </td>
                    <td class="px-4 py-4 text-center font-bold text-slate-700 text-xs">5.75h</td>
                    <td class="px-4 py-4 text-center border-l border-slate-50 font-black text-rose-600 text-xs bg-rose-50/30">2.25</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="px-6 py-5 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Showing <span class="text-emerald-600">1-5</span> of 45 Logs
            </p>
            <div class="flex items-center space-x-2">
                <button class="p-2 text-slate-400 hover:bg-white hover:text-emerald-600 rounded-xl border border-transparent hover:border-slate-200 transition-all active:scale-90">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <button class="size-8 flex items-center justify-center text-[10px] font-black bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-200 transition-transform active:scale-90">1</button>
                <button class="size-8 flex items-center justify-center text-[10px] font-bold text-slate-400">2</button>
                <button class="p-2 text-slate-400 hover:bg-white hover:text-emerald-600 rounded-xl border border-transparent hover:border-slate-200 transition-all active:scale-90">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>





        <div class="px-5 py-3.5 rounded-2xl flex justify-between items-center shadow-lg group">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl text-rose-600 group-hover:rotate-12 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <span class="text-[10px] font-black text-black uppercase tracking-widest block leading-none">Monthly Missed</span>
                    <span class="text-black/80 text-[9px] font-medium">Total accumulated undertime</span>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xl font-black text-rose-600">2.25 <span class="text-xs font-normal opacity-70">Hrs</span></span>
            </div>
        </div>



        


@endsection