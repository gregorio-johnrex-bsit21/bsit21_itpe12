@extends('layouts.supervisor')

@section('title', 'Attendance')
@section('page_title', 'Attendance')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-end items-center gap-4">
        <div class="flex gap-2">
            <input type="text" placeholder="Search by name..." class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-[#2E7D32] outline-none w-64">
            <select class="bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none">
                <option>All Status</option>
                <option>Present</option>
                <option>Absent</option>
            </select>
        </div>
        <button class="bg-[#2E7D32] text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-[#1B5E20] transition">
            <i class="fas fa-download mr-2"></i> Export Log
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Student</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-center bg-green-50/30">AM In</th>
                        <th class="px-6 py-4 text-center bg-green-50/30">AM Out</th>
                        <th class="px-6 py-4 text-center bg-orange-50/30">PM In</th>
                        <th class="px-6 py-4 text-center bg-orange-50/30">PM Out</th>
                        <th class="px-6 py-4 text-center font-bold text-slate-700">Total Hours</th>
                        <th class="px-6 py-4 text-center font-bold text-[#D50000]">Missed</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-bold text-slate-700">Marcus Wright</td>
                        <td class="px-6 py-4 text-slate-500">02/23/2026</td>
                        <td class="px-6 py-4 text-center text-[#2E7D32] font-medium">08:00 AM</td>
                        <td class="px-6 py-4 text-center text-[#2E7D32] font-medium">12:00 PM</td>
                        <td class="px-6 py-4 text-center text-[#FF8C00] font-medium">01:00 PM</td>
                        <td class="px-6 py-4 text-center text-[#FF8C00] font-medium">05:00 PM</td>
                        <td class="px-6 py-4 text-center font-black text-slate-700">8.0 hrs</td>
                        <td class="px-6 py-4 text-center text-slate-400">0.0</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-green-100 text-[#2E7D32] rounded-full text-[10px] font-black uppercase tracking-tighter">Present</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-bold text-slate-700">Kevin Lee</td>
                        <td class="px-6 py-4 text-slate-500">02/23/2026</td>
                        <td class="px-6 py-4 text-center text-[#2E7D32] font-medium">08:30 AM</td>
                        <td class="px-6 py-4 text-center text-[#2E7D32] font-medium">12:00 PM</td>
                        <td class="px-6 py-4 text-center text-[#FF8C00] font-medium">01:00 PM</td>
                        <td class="px-6 py-4 text-center text-[#FF8C00] font-medium">04:30 PM</td>
                        <td class="px-6 py-4 text-center font-black text-slate-700">7.0 hrs</td>
                        <td class="px-6 py-4 text-center font-bold text-[#FF4500]">1.0 hr</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-red-100 text-[#D50000] rounded-full text-[10px] font-black uppercase tracking-tighter">Absent</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection