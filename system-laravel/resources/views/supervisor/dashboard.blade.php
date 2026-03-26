@extends('layouts.supervisor')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Interns</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-black text-slate-800">24</h3>
                <span class="text-green-500 text-xs font-bold"><i class="fas fa-arrow-up"></i> 12%</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hours Rendered</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-black text-slate-800">1,240</h3>
                <span class="text-blue-500 text-xs font-bold">Total</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Tasks</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-black text-slate-800">15</h3>
                <span class="text-amber-500 text-xs font-bold">Active</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Overall Success</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-black text-slate-800">94%</h3>
                <span class="text-purple-500 text-xs font-bold">Rating</span>
            </div>
        </div>
    </div>

    {{-- Student Completion Progress --}}
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-slate-800 text-lg">Student Completion Progress</h4>
            <button class="text-sm text-[#2E7D32] font-semibold hover:underline">View All Students</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-transparent hover:border-slate-200 transition-all">
                <img src="https://ui-avatars.com/api/?name=Marcus+Wright&background=2E7D32&color=fff" class="w-12 h-12 rounded-xl shadow-sm">
                <div class="flex-1">
                    <h5 class="font-bold text-slate-800 leading-tight">Marcus Wright</h5>
                    <p class="text-xs text-slate-500 mt-1 mb-3">8 of 10 tasks completed</p>
                    <div x-data="{ progress: 80 }">
                        <div class="flex items-center gap-3">
                            <div class="h-2 flex-1 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-[#2E7D32] rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                            <span class="text-xs font-black text-[#2E7D32]" x-text="progress + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-transparent hover:border-slate-200 transition-all">
                <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=FF8C00&color=fff" class="w-12 h-12 rounded-xl shadow-sm">
                <div class="flex-1">
                    <h5 class="font-bold text-slate-800 leading-tight">Sarah Jenkins</h5>
                    <p class="text-xs text-slate-500 mt-1 mb-3">6 of 10 tasks completed</p>
                    <div x-data="{ progress: 60 }">
                        <div class="flex items-center gap-3">
                            <div class="h-2 flex-1 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-[#FF8C00] rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                            <span class="text-xs font-black text-[#FF8C00]" x-text="progress + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-transparent hover:border-slate-200 transition-all">
                <img src="https://ui-avatars.com/api/?name=Kevin+Lee&background=FF4500&color=fff" class="w-12 h-12 rounded-xl shadow-sm">
                <div class="flex-1">
                    <h5 class="font-bold text-slate-800 leading-tight">Kevin Lee</h5>
                    <p class="text-xs text-slate-500 mt-1 mb-3">9 of 10 tasks completed</p>
                    <div x-data="{ progress: 90 }">
                        <div class="flex items-center gap-3">
                            <div class="h-2 flex-1 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-[#FF4500] rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                            <span class="text-xs font-black text-[#FF4500]" x-text="progress + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-transparent hover:border-slate-200 transition-all">
                <img src="https://ui-avatars.com/api/?name=Anna+Cruz&background=D50000&color=fff" class="w-12 h-12 rounded-xl shadow-sm">
                <div class="flex-1">
                    <h5 class="font-bold text-slate-800 leading-tight">Anna Cruz</h5>
                    <p class="text-xs text-slate-500 mt-1 mb-3">3 of 10 tasks completed</p>
                    <div x-data="{ progress: 30 }">
                        <div class="flex items-center gap-3">
                            <div class="h-2 flex-1 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-[#D50000] rounded-full" :style="`width: ${progress}%`"></div>
                            </div>
                            <span class="text-xs font-black text-[#D50000]" x-text="progress + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Top Interns --}}
    <div class="space-y-6">
        <h4 class="font-bold text-slate-800 text-lg flex items-center gap-2">
            <i class="fas fa-award text-amber-500"></i> Top Interns in Performance
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-3xl border-2 border-amber-100 shadow-xl shadow-amber-50 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-3">
                    <i class="fas fa-crown text-amber-400 text-2xl transform rotate-12 opacity-50 group-hover:scale-110 transition-transform"></i>
                </div>
                <div class="flex flex-col items-center text-center">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Kevin+Lee&background=FF4500&color=fff" class="w-20 h-20 rounded-2xl shadow-md border-4 border-white mb-4">
                        <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-amber-500 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter shadow-sm">Top 1</span>
                    </div>
                    <h5 class="font-bold text-slate-800 text-lg leading-none">Kevin Lee</h5>
                    <span class="mt-2 px-4 py-1.5 bg-green-50 text-[#2E7D32] text-xs font-black rounded-xl uppercase tracking-wider">Highest Performance Rating</span>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed italic">"Consistently delivers high-quality code and assists peers during sprints."</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex flex-col items-center text-center">
                    <img src="https://ui-avatars.com/api/?name=Marcus+Wright&background=2E7D32&color=fff" class="w-16 h-16 rounded-2xl shadow-sm border-2 border-white mb-4">
                    <h5 class="font-bold text-slate-800 text-lg leading-none">Marcus Wright</h5>
                    <span class="mt-2 px-4 py-1.5 bg-green-50 text-[#2E7D32] text-xs font-black rounded-xl uppercase tracking-wider">Most Productive Intern</span>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed">Logged over 160 hours this month with 100% attendance rate.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex flex-col items-center text-center">
                    <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=FF8C00&color=fff" class="w-16 h-16 rounded-2xl shadow-sm border-2 border-white mb-4">
                    <h5 class="font-bold text-slate-800 text-lg leading-none">Jane Doe</h5>
                    <span class="mt-2 px-4 py-1.5 bg-orange-50 text-[#FF8C00] text-xs font-black rounded-xl uppercase tracking-wider">Fastest Task Completion</span>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed">Average completion time per ticket is 35% faster than department average.</p>
                </div>
            </div>

        </div>
    </div>

</div>


@endsection