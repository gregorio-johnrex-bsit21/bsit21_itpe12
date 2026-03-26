@extends('layouts.supervisor')

@section('title', 'Attendance')
@section('page_title', 'Attendance')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="space-y-8" x-data="{ openClockIn: false, openClockOut: false }">

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="relative w-full md:w-1/2">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" placeholder="Search by student name, ID, or department..." 
                   class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-[#2E7D32] focus:bg-white outline-none transition-all">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 flex items-center justify-between transition-transform hover:scale-[1.01]">
            <div class="flex items-center gap-4">
                <div class="bg-green-50 p-4 rounded-2xl text-[#2E7D32]">
                    <i class="fas fa-sign-in-alt text-2xl"></i>
                </div>
                <div>
    
                    <p class="text-xl font-bold text-slate-800">Time In</p>
                </div>
            </div>
            <button @click="openClockIn = true" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white px-8 py-3 rounded-xl font-black text-xs transition-all shadow-md uppercase">
                Clock In
            </button>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-b-4 flex items-center justify-between transition-transform hover:scale-[1.01]">
            <div class="flex items-center gap-4">
                <div class="bg-orange-50 p-4 rounded-2xl text-[#FF8C00]">
                    <i class="fas fa-sign-out-alt text-2xl"></i>
                </div>
                <div>
                    
                    <p class="text-xl font-bold text-slate-800">Time Out</p>
                </div>
            </div>
            <button @click="openClockOut = true" class="bg-[#FF8C00] hover:bg-[#e67e00] text-white px-8 py-3 rounded-xl font-black text-xs transition-all shadow-md uppercase">
                Clock Out
            </button>
        </div>
    </div>

    <div>
        <div class="flex items-center gap-2 mb-4 px-2">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Today's Attendance</h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase tracking-[0.15em] font-black">
                        <tr>
                            <th class="px-6 py-4">Student Details</th>
                            <th class="px-6 py-4 text-center bg-green-50/30">AM In</th>
                            <th class="px-6 py-4 text-center bg-green-50/30">AM Out</th>
                            <th class="px-6 py-4 text-center bg-orange-50/30">PM In</th>
                            <th class="px-6 py-4 text-center bg-orange-50/30">PM Out</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
<tbody class="divide-y divide-slate-100">
    <tr class="hover:bg-slate-50/50 transition">
        <td class="px-6 py-4">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-slate-700">Marcus Wright</span>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded mt-1 w-fit uppercase tracking-tighter">
                    Log ID: #ATT-99283
                </span>
            </div>
        </td>

        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                <span class="text-[#2E7D32] font-mono font-bold text-sm">08:00 AM</span>
                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">08:10 AM</span>
            </div>
        </td>

        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                <span class="text-[#2E7D32] font-mono font-bold text-sm">12:00 PM</span>
                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">12:05 PM</span>
            </div>
        </td>

        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                <span class="text-slate-400 font-mono font-bold text-sm italic opacity-50">01:00 PM</span>
                <span class="text-slate-300 font-mono text-[10px] italic">--:--</span>
            </div>
        </td>

        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                <span class="text-slate-400 font-mono font-bold text-sm italic opacity-50">05:00 PM</span>
                <span class="text-slate-300 font-mono text-[10px] italic">--:--</span>
            </div>
        </td>

        <td class="px-6 py-4 text-center">
            <span class="px-3 py-1 bg-orange-100 text-[#FF8C00] rounded-full text-[10px] font-black uppercase tracking-tighter">
                Afternoon Pending
            </span>
        </td>
    </tr>
</tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="pt-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 px-2 gap-4">
            <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Overall Students Logs</h2>
            <div class="flex items-center gap-2 bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                <select class="bg-slate-50 border-none rounded-lg px-4 py-1.5 text-xs font-bold text-[#2E7D32] outline-none focus:ring-0">
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                <button class="bg-slate-800 text-white p-1.5 rounded-lg hover:bg-black transition">
                    <i class="fas fa-download text-[10px]"></i>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden opacity-90">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-800 text-slate-200 text-[10px] uppercase tracking-[0.15em] font-black">
                        <tr>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Student</th>
                            <th class="px-6 py-4 text-center">Total Hours</th>
                            <th class="px-6 py-4 text-center">Credits</th>
                            <th class="px-6 py-4 text-center">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-mono text-slate-500">02/22/2026</td>
                            <td class="px-6 py-4 font-bold text-slate-700">Kevin Lee</td>
                            <td class="px-6 py-4 text-center font-black text-slate-800">8.0 hrs</td>
                            <td class="px-6 py-4 text-center"><span class="text-[#2E7D32]">+1.0</span></td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Completed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="openClockIn" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click.away="openClockIn = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden relative z-10 border border-slate-100">
                <div class="bg-[#2E7D32] p-6 text-white text-center">
                    <h2 class="text-xl font-black uppercase tracking-widest">Clock In OJT</h2>
                    <p class="text-green-100 text-[10px] mt-1">Official Attendance Registration</p>
                </div>
                <form action="#" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Student ID Number</label>
                        <input type="text" name="student_id" placeholder="Enter ID e.g. #2024-001" required
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#2E7D32] outline-none font-bold text-slate-700">
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-clock text-slate-400"></i>
                                <span class="text-[10px] font-black text-slate-400 uppercase">Arrival Day</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-red-100 text-red-600 text-[9px] font-black rounded uppercase">Late</span>
                                <span class="text-xl font-black text-[#2E7D32] font-mono">08:10 AM</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-building text-[#2E7D32]"></i>
                                <span class="text-[10px] font-black text-[#2E7D32] uppercase tracking-wider">Company Time In</span>
                            </div>
                            <span class="text-xl font-black text-[#2E7D32] font-mono">08:00 AM</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg transition-all transform active:scale-95">
                        Confirm Clock In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openClockOut" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div @click.away="openClockOut = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden relative z-10 border border-slate-100">
                <div class="bg-[#FF8C00] p-6 text-white text-center">
                    <h2 class="text-xl font-black uppercase tracking-widest">Clock Out OJT</h2>
                    <p class="text-orange-100 text-[10px] mt-1">Exit Attendance Registration</p>
                </div>
                <form action="#" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Student ID Number</label>
                        <input type="text" name="student_id" placeholder="Enter ID e.g. #2024-001" required
                               class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#FF8C00] outline-none font-bold text-slate-700">
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-walking text-slate-400"></i>
                                <span class="text-[10px] font-black text-slate-400 uppercase">Arrival Day</span>
                            </div>
                            <div class="flex items-center gap-2">

                                <span class="text-xl font-black text-[#FF8C00] font-mono">05:00 PM</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-door-open text-[#FF8C00]"></i>
                                <span class="text-[10px] font-black text-[#FF8C00] uppercase tracking-wider">Company Time Out</span>
                            </div>
                            <span class="text-xl font-black text-[#FF8C00] font-mono">05:00 PM</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#FF8C00] hover:bg-[#e67e00] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg transition-all transform active:scale-95">
                        Confirm Clock Out
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection