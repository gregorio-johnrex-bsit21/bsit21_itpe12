@extends('layouts.supervisor')

@section('title', 'Student Directory')
@section('page_title', 'Student Directory')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <h4 class="font-bold text-slate-800">Student Directory</h4>
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

@endsection