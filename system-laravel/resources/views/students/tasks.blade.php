@extends('layouts.app')

@section('title', 'Tasks')

@section('content')


<div class="flex justify-between items-center">
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Assigned Tasks</h2>
        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100">
            2 Active
        </span>
    </div>

   <div class="relative">
        <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white to-transparent pointer-events-none z-10 sm:hidden"></div>
        
        <div class="flex items-center gap-2 overflow-x-auto pb-4 -mx-1 px-1 scrollbar-hide snap-x select-none">
            <button class="snap-start flex-shrink-0 px-5 py-2.5 rounded-xl text-[10px] font-black tracking-widest uppercase transition-all bg-emerald-600 text-white shadow-lg shadow-emerald-200 active:scale-95">
                All
            </button>

            <button class="snap-start flex-shrink-0 px-5 py-2.5 rounded-xl text-[10px] font-bold tracking-widest uppercase transition-all text-slate-500 bg-slate-50 border border-slate-100 active:scale-95">
                New
            </button>

            <button class="snap-start flex-shrink-0 px-5 py-2.5 rounded-xl text-[10px] font-bold tracking-widest uppercase transition-all text-slate-500 bg-slate-50 border border-slate-100 active:scale-95">
                Ongoing
            </button>

            <button class="snap-start flex-shrink-0 px-5 py-2.5 rounded-xl text-[10px] font-bold tracking-widest uppercase transition-all text-slate-500 bg-slate-50 border border-slate-100 active:scale-95">
                Completed
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.06)] hover:border-emerald-300 transition-all group hover:-translate-y-2 duration-500 cursor-pointer relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

            <div class="flex justify-between items-center mb-5 relative z-10">
                <div class="flex items-center gap-3 flex-1">
                    <span class="px-3 py-1 bg-emerald-500 text-white rounded-lg text-[10px] font-black uppercase tracking-tighter shadow-sm">Completed</span>
                    <div class="flex items-center gap-2 w-full max-w-[80px]">
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-1000" style="width: 100%"></div>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600">100%</span>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 font-bold uppercase">Due Feb 25</p>
            </div>

            <h4 class="font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors text-lg">Database Schema Design</h4>
            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">Design the ERD for the monitoring module and attendance relations.</p>
            
            <div class="mt-6 pt-6 border-t border-slate-50 flex justify-between items-center relative z-10">
                <div class="flex items-center justify-between w-full">
                    <button @click="taskModal = true" class="text-xs font-black text-emerald-600 hover:text-emerald-700 flex items-center gap-1 group/btn">
                        View Details 
                        <span class="transition-transform group-hover/btn:translate-x-1">→</span>
                    </button>
                    
                    <span class="flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 rounded-xl text-[9px] font-black border border-amber-200 shadow-sm uppercase tracking-tighter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-amber-500">
                            <circle cx="12" cy="8" r="7"></circle>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                        </svg>
                        Top Performer
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.06)] hover:border-emerald-300 transition-all group hover:-translate-y-2 duration-500 cursor-pointer relative overflow-hidden">
            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center gap-3 flex-1">
                    <span class="px-3 py-1 bg-amber-100 text-amber-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">New Task</span>
                    <div class="flex items-center gap-2 w-full max-w-[80px]">
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-emerald-300 h-1.5 rounded-full" style="width: 67%"></div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400">67%</span>
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 font-bold uppercase">Due Mar 01</p>
            </div>

            <h4 class="font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors text-lg">API Documentation</h4>
            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">Document all RESTful endpoints for the intern management system including authentication headers.</p>
            
            <div class="mt-6 pt-6 border-t border-slate-50 flex justify-between items-center">
                <div class="flex items-center justify-between w-full">
                    <button @click="taskModal = true" class="text-xs font-black text-emerald-600 hover:text-emerald-700 flex items-center gap-1 group/btn">
                        View Details 
                        <span class="transition-transform group-hover/btn:translate-x-1">→</span>
                    </button>
                    
                    <span class="flex items-center gap-1 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-xl text-[10px] font-black border border-emerald-100 shadow-sm">
                        500 <span class="text-[8px] opacity-70">PTS</span>
                    </span>
                </div>
            </div>
        </div>
    </div>



    
<div x-show="taskModal" class="fixed inset-0 z-[10001] flex items-center justify-center p-4" x-cloak>
    <div @click="taskModal = false" 
         x-show="taskModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

    <div x-show="taskModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="relative w-full max-w-sm bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden z-10">
        
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <span class="px-3 py-1 bg-emerald-600 text-white rounded-full text-[10px] font-bold uppercase tracking-wider">Completed</span>
                <button @click="taskModal = false" class="text-gray-400 hover:bg-gray-100 p-1 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
                </button>
            </div>

            <h3 class="text-xl font-black text-gray-900 leading-tight mb-1">Database Schema Design</h3>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-5">Due Feb 25, 2026</p>


            <div class="bg-gray-50 rounded-2xl p-4 mb-5 border border-gray-100">
                <h4 class="text-[10px] font-bold text-emerald-600 uppercase mb-2 tracking-widest">Description</h4>
                <div class="space-y-2">
                    <div class="flex items-start gap-2 text-xs text-gray-600 font-medium">
                        <span>Create a normalized database structure to handle student logs and task tracking efficiently.</span>
                    </div>
                   
                </div>
            </div>


            <div class="bg-gray-50 rounded-2xl p-4 mb-5 border border-gray-100">
                <h4 class="text-[10px] font-bold text-emerald-600 uppercase mb-2 tracking-widest">Guidelines</h4>
                <div class="space-y-2">
                    <div class="flex items-start gap-2 text-xs text-gray-600 font-medium">
                        <div class="mt-1.5 w-1 h-1 rounded-full bg-indigo-400 shrink-0"></div>
                        <span>Identify all Primary and Foreign keys.</span>
                    </div>
                     <div class="flex items-start gap-2 text-xs text-gray-600 font-medium">
                        <div class="mt-1.5 w-1 h-1 rounded-full bg-indigo-400 shrink-0"></div>
                        <span>Ensure 3rd Normal Form (3NF) compliance.</span>
                    </div>
                     <div class="flex items-start gap-2 text-xs text-gray-600 font-medium">
                        <div class="mt-1.5 w-1 h-1 rounded-full bg-indigo-400 shrink-0"></div>
                        <span>Create a visual ERD diagram for submission.</span>
                    </div>
                   
                </div>
            </div>

            <div class="relative group border-2 border-dashed border-gray-100 rounded-2xl p-4 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all cursor-pointer text-center">
                <input type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                <p class="text-xs font-bold text-emerald-600">+ Add Proof Photo</p>
                <p class="text-[9px] text-gray-400 font-medium mt-0.5">JPG or PNG</p>
            </div>

            <div class="mt-6 flex gap-2">
                <button @click="taskModal = false" class="flex-1 py-3 text-xs font-bold text-gray-400 hover:text-gray-600 transition">Cancel</button>
                <button class="flex-1 py-3 text-xs font-bold text-white bg-emerald-600 rounded-xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 active:scale-95 transition-all">Submit Task</button>
            </div>
        </div>
    </div>
</div>

@endsection