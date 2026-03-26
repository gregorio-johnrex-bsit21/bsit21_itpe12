@extends('layouts.supervisor')

@section('title', 'Evaluation')
@section('page_title', 'Evaluation')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-between items-end gap-4 border-b border-slate-100 pb-6">
        <div>
            <h3 class="font-black text-2xl text-slate-800 tracking-tight">Student Performance</h3>
            <p class="text-sm text-slate-500">Overview of OJT hour completion and earned milestones.</p>
        </div>
        <div class="flex gap-2 bg-slate-100 p-1 rounded-xl">
            <button @click="evalFilter = 'all'" :class="evalFilter === 'all' ? 'bg-white shadow-sm text-[#2E7D32]' : 'text-slate-500'" class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">All Students</button>
            <button @click="evalFilter = 'behind'" :class="evalFilter === 'behind' ? 'bg-white shadow-sm text-[#D50000]' : 'text-slate-500'" class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">Attention Needed</button>
        </div>
    </div>

    <div class="flex flex-wrap gap-8 justify-start">

        <div x-show="evalFilter === 'all'" class="w-full md:w-[22rem] bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://ui-avatars.com/api/?name=Marcus+Wright&background=2E7D32&color=fff" class="w-14 h-14 rounded-2xl shadow-inner">
                    <div>
                        <h2 class="font-black text-slate-800 text-lg">Marcus Wright</h2>
                        <span class="px-2 py-0.5 bg-green-50 text-[#2E7D32] text-[8px] font-black uppercase rounded border border-green-100">On Track</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <p class="text-[10px] font-black text-slate-400 uppercase">600 Total Hours Required</p>
                        <p class="text-xl font-black text-slate-800">420.0 <span class="text-[10px] text-slate-400">Hrs</span></p>
                    </div>
                    <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#2E7D32] rounded-full" style="width: 70%"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Missed</p>
                            <p class="font-black text-slate-700 text-sm">0.0</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Remaining</p>
                            <p class="font-black text-[#2E7D32] text-sm">180.0</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 space-y-2">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Achievement History</p>
                    <div class="flex items-center gap-3 p-2 bg-green-50/50 rounded-xl border border-green-100/50">
                        <i class="fas fa-award text-[#2E7D32]"></i>
                        <span class="text-[11px] font-bold text-slate-700">Early Submission Milestone</span>
                    </div>
                    <div class="flex items-center gap-3 p-2 bg-amber-50/50 rounded-xl border border-amber-100/50">
                        <i class="fas fa-star text-[#FF8C00]"></i>
                        <span class="text-[11px] font-bold text-slate-700">Excellent Work Badge</span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="evalFilter === 'all' || evalFilter === 'behind'" class="w-full md:w-[22rem] bg-white rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://ui-avatars.com/api/?name=Sarah+Jenkins&background=D50000&color=fff" class="w-14 h-14 rounded-2xl shadow-inner">
                    <div>
                        <h2 class="font-black text-slate-800 text-lg">Sarah Jenkins</h2>
                        <span class="px-2 py-0.5 bg-red-50 text-[#D50000] text-[8px] font-black uppercase rounded border border-red-100">Behind Schedule</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <p class="text-[10px] font-black text-slate-400 uppercase">600 Total Hours Required</p>
                        <p class="text-xl font-black text-[#D50000]">120.0 <span class="text-[10px] text-slate-400">Hrs</span></p>
                    </div>
                    <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#D50000] rounded-full" style="width: 20%"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="p-3 bg-red-50 rounded-2xl border border-red-100 text-center">
                            <p class="text-[9px] font-bold text-red-400 uppercase">Missed</p>
                            <p class="font-black text-[#D50000] text-sm">24.0</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Remaining</p>
                            <p class="font-black text-slate-700 text-sm">480.0</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Achievement History</p>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-center">
                        <p class="text-[10px] font-bold text-slate-400 italic">No achievements earned yet.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection