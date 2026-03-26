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
                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">08:00 AM</span>
            </div>
        </td>

        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                <span class="text-[#2E7D32] font-mono font-bold text-sm">12:00 PM</span>
                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">12:00 PM</span>
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
        <option value="week">This Week</option>
        <option value="month">This Month</option>
    </select>
    <button class="flex items-center gap-2 bg-[#2E7D32] hover:bg-[#1B5E20] text-white px-4 py-1.5 rounded-lg transition">
        <i class="fas fa-file-export text-[10px]"></i>
        <span class="text-[10px] font-black uppercase tracking-wider">Export Log</span>
    </button>
</div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-500 text-[10px] uppercase tracking-[0.15em] font-black">
                    <tr>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Student Details</th>
                        <th class="px-6 py-4 text-center bg-green-50/30">AM In</th>
                        <th class="px-6 py-4 text-center bg-green-50/30">AM Out</th>
                        <th class="px-6 py-4 text-center bg-blue-50/30">PM In</th>
                        <th class="px-6 py-4 text-center bg-blue-50/30">PM Out</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Missed</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50/50 transition">

                        {{-- Date --}}
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-slate-500 text-sm">02/22/2026</span>
                        </td>

                        {{-- Student --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">Kevin Lee</span>
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded mt-1 w-fit uppercase tracking-tighter">
                                    Log ID: #ATT-99283
                                </span>
                            </div>
                        </td>

                        {{-- AM In --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-[#2E7D32] font-mono font-bold text-sm">08:00 AM</span>
                                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">08:00 AM</span>
                            </div>
                        </td>

                        {{-- AM Out --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-[#2E7D32] font-mono font-bold text-sm">12:00 PM</span>
                                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">12:00 PM</span>
                            </div>
                        </td>

                        {{-- PM In --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-[#1565C0] font-mono font-bold text-sm">01:00 PM</span>
                                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">01:03 PM</span>
                            </div>
                        </td>

                        {{-- PM Out --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-[#1565C0] font-mono font-bold text-sm">05:00 PM</span>
                                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">05:00 PM</span>
                            </div>
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-4 text-center">
                            <span class="font-black text-slate-800 text-sm">8.0 hrs</span>
                        </td>

                        {{-- Missed --}}
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black uppercase tracking-tighter">
                                None
                            </span>
                        </td>

                    </tr>

                    {{-- Example row with missed session --}}
                    <tr class="hover:bg-slate-50/50 transition">

                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-slate-500 text-sm">02/23/2026</span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">Marcus Wright</span>
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded mt-1 w-fit uppercase tracking-tighter">
                                    Log ID: #ATT-99284
                                </span>
                            </div>
                        </td>

                        {{-- AM In --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-[#2E7D32] font-mono font-bold text-sm">08:00 AM</span>
                                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">08:00 AM</span>
                            </div>
                        </td>

                        {{-- AM Out --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-[#2E7D32] font-mono font-bold text-sm">12:00 PM</span>
                                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">12:00 PM</span>
                            </div>
                        </td>

                        {{-- PM In - Missed --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-slate-300 font-mono font-bold text-sm italic">--:--</span>
                                <span class="text-slate-300 font-mono text-[10px] italic">--:--</span>
                            </div>
                        </td>

                        {{-- PM Out - Missed --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col justify-center items-center">
                                <span class="text-slate-300 font-mono font-bold text-sm italic">--:--</span>
                                <span class="text-slate-300 font-mono text-[10px] italic">--:--</span>
                            </div>
                        </td>

                        {{-- Total --}}
                         <td class="px-6 py-4 text-center">
                            <span class="font-black text-slate-800 text-sm">4.0 hrs</span>
                        </td>

                        {{-- Missed --}}
                        <td class="px-6 py-4 text-center">
                            <span class="font-black text-slate-800 text-sm">4.0 hrs</span>
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
        <div @click.away="openClockIn = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden relative z-10 border border-slate-100">
            <div class="bg-[#2E7D32] p-4 text-white text-center">
                <h2 class="text-base font-black uppercase tracking-widest">Clock In OJT</h2>
                <p class="text-green-100 text-[10px] mt-0.5">Official Attendance Registration</p>
            </div>
            <form action="#" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Student ID Number</label>
                    <input type="text" name="student_id" placeholder="Enter ID e.g. #2024-001" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#2E7D32] outline-none font-bold text-slate-700 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Select Session</label>
                    <select name="session" x-model="selectedSession"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#2E7D32] outline-none font-bold text-slate-700 text-sm appearance-none cursor-pointer">
                        <option value="am">AM Session</option>
                        <option value="pm">PM Session</option>
                    </select>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Arrival Time</span>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-red-100 text-red-600 text-[9px] font-black rounded uppercase">Late</span>
                            <span class="text-base font-black text-red-600 font-mono">08:10 AM</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                        <span class="text-[10px] font-black uppercase tracking-wider">Time In</span>
                        <span class="text-base font-black font-mono">08:10 AM</span>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white py-3 rounded-xl font-black uppercase tracking-widest shadow-md transition-all transform active:scale-95 text-xs">
                    Confirm Clock In
                </button>
            </form>
        </div>
    </div>
</div>

    <div x-show="openClockOut" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div @click.away="openClockOut = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden relative z-10 border border-slate-100">
            <div class="bg-[#FF8C00] p-4 text-white text-center">
                <h2 class="text-base font-black uppercase tracking-widest">Clock Out OJT</h2>
                <p class="text-orange-100 text-[10px] mt-0.5">Exit Attendance Registration</p>
            </div>
            <form action="#" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Student ID Number</label>
                    <input type="text" name="student_id" placeholder="Enter ID e.g. #2024-001" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00] outline-none font-bold text-slate-700 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Select Session</label>
                    <select name="session" x-model="selectedSession"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00] outline-none font-bold text-slate-700 text-sm appearance-none cursor-pointer">
                        <option value="am">AM Session</option>
                        <option value="pm">PM Session</option>
                    </select>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-400 uppercase">Departure Time</span>
                        <span class="text-base font-black text-[#FF8C00] font-mono">05:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                        <span class="text-[10px] font-black uppercase tracking-wider">Time Out</span>
                        <span class="text-base font-black font-mono">05:00 PM</span>
                    </div>
                </div>
                <button type="submit" class="w-full bg-[#FF8C00] hover:bg-[#e67e00] text-white py-3 rounded-xl font-black uppercase tracking-widest shadow-md transition-all transform active:scale-95 text-xs">
                    Confirm Clock Out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection