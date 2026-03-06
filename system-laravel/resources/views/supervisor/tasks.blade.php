@extends('layouts.supervisor')

@section('title', 'Tasks & Grading')
@section('page_title', 'Tasks & Grading')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="font-bold text-2xl text-slate-800 tracking-tight">Project Delegation</h3>
            <p class="text-sm text-slate-500">Assign tasks and evaluate intern performance</p>
        </div>
        <button @click="showTaskModal = true" class="bg-[#2E7D32] text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-green-100 hover:bg-[#1B5E20] hover:-translate-y-1 transition-all flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Create New Task
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 flex flex-col group">
            <div class="p-6 flex-1">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-amber-50 text-[#FF8C00] text-[10px] font-black uppercase rounded-lg border border-amber-100">Ongoing</span>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Deadline</p>
                        <p class="text-xs font-bold text-slate-700">Feb 28, 2026</p>
                    </div>
                </div>
                <h4 class="font-black text-slate-800 text-lg leading-tight group-hover:text-[#2E7D32] transition-colors">Database Schema Design</h4>
                <p class="text-sm text-slate-500 mt-2 line-clamp-2">Normalize the existing user tables and create relationship diagrams for the new system architecture.</p>
                <div class="mt-5 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <h5 class="text-[10px] font-black text-slate-400 uppercase flex items-center gap-2 mb-2">
                        <i class="fas fa-info-circle text-[#2E7D32]"></i> Supervisor Guidelines
                    </h5>
                    <p class="text-xs text-slate-600 leading-relaxed italic">"Ensure all foreign keys are indexed and use Crow's Foot notation for the ERD."</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50/50 rounded-b-[2rem] border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2 cursor-pointer">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=Marcus+Wright&background=2E7D32&color=fff" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <span class="text-xs font-bold text-slate-700">M. Wright</span>
                </div>
                <div class="flex items-center gap-1">
                    <button class="p-2 text-slate-400 hover:text-[#2E7D32] hover:bg-white rounded-xl transition-all"><i class="fas fa-chart-pie text-sm"></i></button>
                    <button class="p-2 text-slate-400 hover:text-[#2E7D32] hover:bg-white rounded-xl transition-all"><i class="fas fa-pen-to-square text-sm"></i></button>
                    <button class="p-2 text-slate-400 hover:text-[#D50000] hover:bg-white rounded-xl transition-all"><i class="fas fa-trash-can text-sm"></i></button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('modals')
<div x-show="showTaskModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
     x-cloak>
    <div @click.away="showTaskModal = false" class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-slate-800">Assign New Task</h3>
                <button @click="showTaskModal = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Task Title</label>
                    <input type="text" placeholder="e.g. Front-end Refactoring" class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Assigned Student</label>
                        <select class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32] appearance-none">
                            <option>Select Intern...</option>
                            <option>Marcus Wright</option>
                            <option>Sarah Jenkins</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Deadline Date</label>
                        <input type="date" class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                    </div>
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Initial Status</label>
                    <select class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32] appearance-none">
                        <option value="pending">Pending</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Short Description</label>
                    <textarea placeholder="Briefly explain the goal..." class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm h-16 outline-none focus:ring-2 focus:ring-[#2E7D32] resize-none"></textarea>
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Supervisor Guidelines</label>
                    <textarea placeholder="Special instructions..." class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm h-16 outline-none focus:ring-2 focus:ring-[#2E7D32] resize-none"></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button @click="showTaskModal = false" class="flex-1 px-4 py-3 border border-slate-100 rounded-xl font-bold text-sm text-slate-400 hover:bg-slate-50">Cancel</button>
                    <button class="flex-1 px-4 py-3 bg-[#2E7D32] text-white rounded-xl font-bold text-sm shadow-md shadow-green-100 hover:bg-[#1B5E20]">Save Task</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@endsection