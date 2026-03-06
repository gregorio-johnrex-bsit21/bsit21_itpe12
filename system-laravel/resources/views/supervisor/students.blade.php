@extends('layouts.supervisor')

@section('title', 'Student Directory')
@section('page_title', 'Student Directory')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h4 class="font-bold text-slate-800">Student Directory</h4>
            <button @click="showUserModal = true" class="text-[#2E7D32] font-bold text-sm hover:underline">+ Add Student</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Full Name</th>
                        <th class="px-6 py-4">Student ID</th>
                        <th class="px-6 py-4">Department</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <tr class="group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center font-bold text-[#2E7D32]">MW</div>
                                <span class="font-bold">Marcus Wright</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">2023-00452</td>
                        <td class="px-6 py-4 text-slate-500 font-medium">College of IT</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-green-50 text-[#2E7D32] rounded-lg text-[10px] font-bold">INTERN</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-slate-400 group-hover:text-[#2E7D32] transition-colors"><i class="fas fa-ellipsis-v"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('modals')
<div x-show="showUserModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
     x-cloak>
    <div @click.away="showUserModal = false" class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-slate-800">Add New Student</h3>
                <button @click="showUserModal = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-lg"></i></button>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Full Name</label>
                    <input type="text" placeholder="e.g. John Doe" class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Student ID</label>
                    <input type="text" placeholder="e.g. 2023-00000" class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Department</label>
                    <select class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32] appearance-none">
                        <option>College of IT</option>
                        <option>College of Engineering</option>
                        <option>College of Business</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-2">
                    <button @click="showUserModal = false" class="flex-1 px-4 py-3 border border-slate-100 rounded-xl font-bold text-sm text-slate-400 hover:bg-slate-50">Cancel</button>
                    <button class="flex-1 px-4 py-3 bg-[#2E7D32] text-white rounded-xl font-bold text-sm shadow-md shadow-green-100 hover:bg-[#1B5E20]">Add Student</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@endsection