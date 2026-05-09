@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

<style>
    :root {
    --color-brand: #059669; /* Emerald 600 */
    --color-brand-light: #ecfdf5; /* Emerald 50 */
    --color-canvas: #f8fafc; /* Slate 50 */
    --color-surface: #ffffff;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
    --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.07), 0 2px 4px rgba(0, 0, 0, 0.04);
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 24px;
}

/* Enforcing Policy #10: Minimum Animation Layer */
.transition-saas {
    transition: all 180ms ease;
}
.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}
</style>

<div x-data="{ searching: false }" class="relative h-10 flex items-center">
    
    <div x-show="!searching" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-x-2"
         x-transition:enter-end="opacity-100 translate-x-0"
         class="flex justify-between items-center w-full">
        
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-bold text-gray-900">Assigned Tasks</h2>
            <button @click="searching = true; $nextTick(() => $refs.searchInput.focus())" 
                    class="p-2 hover:bg-slate-100 rounded-lg text-slate-500 transition">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>

        
    </div>

    <div x-show="searching" 
         x-trap="searching"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute inset-0 flex items-center bg-white z-10">
        
        <div class="relative w-full flex items-center gap-2">
            <button @click="searching = false" class="p-2 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <input x-ref="searchInput" 
                   type="text" 
                   placeholder="Search tasks..." 
                   class="w-full bg-white border border-slate-200 rounded-xl py-2 px-4 text-sm focus:ring-2 focus:ring-emerald-500/10 focus:border-emerald-500 text-slate-700 shadow-sm"
                   @keydown.escape.window="searching = false">

            <button @click="searching = false" class="absolute right-3 text-slate-300 hover:text-slate-500">
                <span class="text-xl">&times;</span>
            </button>
        </div>
    </div>
</div>

<div class="mt-6">
    <div class="grid grid-cols-4 gap-1">

        <button class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold bg-emerald-600 text-white shadow-sm whitespace-nowrap text-center">
            ALL
        </button>

        <button class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 whitespace-nowrap text-center">
            NEW
        </button>

        <button class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 whitespace-nowrap text-center">
            ONGOING
        </button>

        <button class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 whitespace-nowrap text-center">
            COMPLETED
        </button>

    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

    <!-- CARD -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 hover:shadow-md transition-all duration-200 cursor-pointer group">

        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3 flex-1">

                <div class="flex items-center gap-2 w-full max-w-[200px]">
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-emerald-600 h-1.5 rounded-full" style="width: 100%"></div>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-500">100%</span>
                </div>
            </div>

            <p class="text-[10px] text-slate-400 font-semibold uppercase">Feb 25</p>
        </div>

        <h4 class="font-semibold text-slate-800 mb-1 text-base group-hover:text-emerald-600 transition">
            Database Schema Design
        </h4>

        <p class="text-sm text-slate-500 leading-relaxed line-clamp-2">
            Design the ERD for the monitoring module and attendance relations.
        </p>
        
        <div class="mt-5 pt-4 border-t border-slate-100 flex justify-between items-center">
            <button @click="taskModal = true" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                View Details →
            </button>
            
             <span class="px-2.5 py-1 bg-emerald-600 text-white rounded-lg text-[10px] font-semibold uppercase tracking-widest">
                    Completed
                </span>
        </div>
    </div>

     <div class="bg-white p-5 rounded-2xl border border-slate-200 hover:shadow-md transition-all duration-200 cursor-pointer group">

        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3 flex-1">

                <div class="flex items-center gap-2 w-full max-w-[200px]">
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-emerald-600 h-1.5 rounded-full" style="width: 67%"></div>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-500">67%</span>
                </div>
            </div>

            <p class="text-[10px] text-slate-400 font-semibold uppercase">Feb 29</p>
        </div>

        <h4 class="font-semibold text-slate-800 mb-1 text-base group-hover:text-emerald-600 transition">
            Database Schema Design
        </h4>

        <p class="text-sm text-slate-500 leading-relaxed line-clamp-2">
            Design the ERD for the monitoring module and attendance relations.
        </p>
        
        <div class="mt-5 pt-4 border-t border-slate-100 flex justify-between items-center">
            <button @click="taskModal = true" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                View Details →
            </button>
            
             <span class="px-2.5 py-1 bg-orange-600 text-white rounded-lg text-[10px] font-semibold uppercase tracking-widest">
                    Ongoing
                </span>
        </div>
    </div>

</div>



<!-- MODAL -->
<div x-show="taskModal" x-cloak class="fixed inset-0 z-[10001] flex items-center justify-center p-4">

    <div @click="taskModal = false" 
         x-show="taskModal"
         x-transition
         class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

    <div x-show="taskModal"
         x-transition
         class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden z-10">
        
        <div class="p-6">

            <div class="flex justify-between items-center mb-4">
                <span class="px-2.5 py-1 bg-emerald-600 text-white rounded-lg text-[10px] font-semibold uppercase">
                    Completed
                </span>
                <button @click="taskModal = false" class="text-gray-400 hover:bg-gray-100 p-1 rounded-lg transition">
                    ✕
                </button>
            </div>

            <h3 class="text-lg font-semibold text-slate-900 mb-1">Database Schema Design</h3>
            <p class="text-[11px] text-slate-400 uppercase mb-5">Due Feb 25, 2026</p>

            <div class="bg-slate-50 rounded-xl p-4 mb-4 border border-slate-100">
                <h4 class="text-[10px] font-semibold text-emerald-600 uppercase mb-2 tracking-widest">Description</h4>
                <p class="text-sm text-slate-600">
                    Create a normalized database structure to handle student logs and task tracking efficiently.
                </p>
            </div>

            <div class="bg-slate-50 rounded-xl p-4 mb-4 border border-slate-100">
                <h4 class="text-[10px] font-semibold text-emerald-600 uppercase mb-2 tracking-widest">Guidelines</h4>
                <ul class="text-sm text-slate-600 space-y-1">
                    <li>• Identify all Primary and Foreign keys</li>
                    <li>• Ensure 3rd Normal Form (3NF)</li>
                    <li>• Create ERD diagram</li>
                </ul>
            </div>

            <div class="border border-dashed border-slate-200 rounded-xl p-4 text-center hover:bg-slate-50 cursor-pointer">
                <p class="text-sm font-semibold text-emerald-600">+ Add Proof Photo</p>
                <p class="text-xs text-slate-400">JPG or PNG</p>
            </div>

            <div class="mt-6 flex gap-2">
                <button @click="taskModal = false" class="flex-1 py-2 text-sm text-slate-400 hover:text-slate-600">
                    Cancel
                </button>
                <button class="flex-1 py-2 text-sm text-white bg-emerald-600 rounded-xl hover:bg-emerald-700">
                    Submit
                </button>
            </div>

        </div>
    </div>
</div>

@endsection