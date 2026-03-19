@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


<div class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 p-6 md:p-10 rounded-2xl shadow-lg mb-8 relative overflow-hidden">
    
    <div class="flex justify-between items-center relative z-10">
        <div class="flex flex-col gap-1">
            <h2 class="text-white/80 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em]">
                Good day,
            </h2>
            <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                {{ session('student')->name }}
            </h1>
        </div>

        <div class="text-white/60">
            <svg class="w-16 h-16 md:w-24 md:h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
            </svg>
        </div>
    </div>

    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
</div>


<div class="grid grid-cols-2 gap-4 mb-8">
    
    <div class="bg-white p-4 rounded-2xl border border-slate-300 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Required</span>
            <div class="p-1.5 bg-slate-100 rounded-lg">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="text-2xl font-black text-slate-900">500</span>
            <span class="text-sm font-bold text-slate-400">h</span>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-slate-300 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Accumulated</span>
            <div class="p-1.5 bg-emerald-50 rounded-lg">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="text-2xl font-black text-slate-900">124</span>
            <span class="text-sm font-bold text-emerald-500">h</span>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-slate-300 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-[10px] font-bold uppercase tracking-wider text-orange-500">Remaining</span>
            <div class="p-1.5 bg-orange-50 rounded-lg">
                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="text-2xl font-black text-slate-900">376</span>
            <span class="text-sm font-bold text-orange-500">h</span>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-slate-300 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <span class="text-[10px] font-bold uppercase tracking-wider text-rose-500">Missed</span>
            <div class="p-1.5 bg-rose-50 rounded-lg">
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="text-2xl font-black text-slate-900">24</span>
            <span class="text-sm font-bold text-rose-500">h</span>
        </div>
    </div>

</div>


<div class="w-full bg-white p-6 md:p-8 rounded-2xl border border-slate-300 shadow-sm">
    
    <div class="flex items-center gap-2 mb-2">
        <svg class="w-6 h-6 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 13h2v7H3zm5-6h2v13H8zm5 5h2v8h-2zm5-8h2v16h-2z"/>
        </svg>
        <h3 class="text-xl md:text-xl font-bold text-slate-900 tracking-tight">Total Progress</h3>
    </div>
    
    <p class="text-slate-500 text-sm mb-6 md:mb-4">Overall OJT completion status</p>

    <div class="flex flex-col items-center py-4">
        <div class="relative flex items-center justify-center">
            <svg class="w-40 h-40 md:w-44 md:h-44 transform -rotate-90">
                <circle
                    cx="50%"
                    cy="50%"
                    r="45%"
                    stroke-width="10"
                    stroke="currentColor"
                    fill="transparent"
                    class="text-slate-100"
                />
                <circle
                    cx="50%"
                    cy="50%"
                    r="45%"
                    stroke-width="10"
                    stroke-dasharray="283" 
                    stroke-dashoffset="141.5"
                    stroke-linecap="round"
                    stroke="currentColor"
                    fill="transparent"
                    class="text-emerald-500 transition-all duration-1000"
                />
            </svg>
            
            <div class="absolute text-center">
                <div class="text-4xl md:text-4xl font-black text-slate-900 leading-none">50%</div>
                <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Done</div>
            </div>
        </div>
    </div>
</div>



                    




        


@endsection