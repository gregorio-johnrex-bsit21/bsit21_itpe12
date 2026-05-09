@extends('layouts.supervisor')

@section('title', 'Attendance')
@section('page_title', 'Attendance')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="space-y-8" x-data="{ 
    openClockIn: false, 
    openClockOut: false,
    clockInStudentId: '',
    clockInSession: 'am',
    clockInDate: new Date().toISOString().split('T')[0],
    clockInTime: new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' }),
    clockOutStudentId: '',
    clockOutSession: 'am',
    clockOutDate: new Date().toISOString().split('T')[0],
    clockOutTime: new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' }),
    
    resetClockIn() {
        this.clockInStudentId = '';
        this.clockInDate = new Date().toISOString().split('T')[0];
        this.clockInTime = new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
        const feedback = document.getElementById('clockInFeedback');
        if (feedback) {
            feedback.classList.add('hidden');
            feedback.innerText = '';
        }
    },
    
    resetClockOut() {
        this.clockOutStudentId = '';
        this.clockOutDate = new Date().toISOString().split('T')[0];
        this.clockOutTime = new Date().toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
        const feedback = document.getElementById('clockOutFeedback');
        if (feedback) {
            feedback.classList.add('hidden');
            feedback.innerText = '';
        }
    },
    
    async submitClockIn() {
        const feedback = document.getElementById('clockInFeedback');
        try {
            const res = await fetch('{{ route('attendance.clock-in') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    student_id: this.clockInStudentId,
                    session: this.clockInSession,
                    date: this.clockInDate,
                    time: this.clockInTime
                })
            });
            const data = await res.json();
            feedback.classList.remove('hidden', 'bg-red-100', 'text-red-600', 'bg-emerald-100', 'text-emerald-600');
            if (data.success) {
                feedback.classList.add('bg-emerald-100', 'text-emerald-600');
                feedback.innerText = data.message;
                setTimeout(() => { this.openClockIn = false; this.resetClockIn(); }, 1500);
            } else {
                feedback.classList.add('bg-red-100', 'text-red-600');
                feedback.innerText = data.message;
            }
        } catch (e) {
            feedback.classList.remove('hidden');
            feedback.classList.add('bg-red-100', 'text-red-600');
            feedback.innerText = 'Network error. Please try again.';
        }
    },
    
    async submitClockOut() {
        const feedback = document.getElementById('clockOutFeedback');
        try {
            const res = await fetch('{{ route('attendance.clock-out') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    student_id: this.clockOutStudentId,
                    session: this.clockOutSession,
                    date: this.clockOutDate,
                    time: this.clockOutTime
                })
            });
            const data = await res.json();
            feedback.classList.remove('hidden', 'bg-red-100', 'text-red-600', 'bg-emerald-100', 'text-emerald-600');
            if (data.success) {
                feedback.classList.add('bg-emerald-100', 'text-emerald-600');
                feedback.innerText = data.message + (data.total_hours ? ' | Total: ' + data.total_hours + ' hrs' : '');
                setTimeout(() => { this.openClockOut = false; this.resetClockOut(); }, 1500);
            } else {
                feedback.classList.add('bg-red-100', 'text-red-600');
                feedback.innerText = data.message;
            }
        } catch (e) {
            feedback.classList.remove('hidden');
            feedback.classList.add('bg-red-100', 'text-red-600');
            feedback.innerText = 'Network error. Please try again.';
        }
    }
}">

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
            <button @click="openClockIn = true; resetClockIn()" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white px-8 py-3 rounded-xl font-black text-xs transition-all shadow-md uppercase">
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
            <button @click="openClockOut = true; resetClockOut()" class="bg-[#FF8C00] hover:bg-[#e67e00] text-white px-8 py-3 rounded-xl font-black text-xs transition-all shadow-md uppercase">
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

    @forelse($todayLogs as $attendance)

    <tr class="hover:bg-slate-50/50 transition">

        {{-- Student --}}
        <td class="px-6 py-4">
            <div class="flex flex-col">

                <span class="text-sm font-bold text-slate-700">
                    {{ $attendance->student->user->name ?? 'Unknown' }}
                </span>

                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded mt-1 w-fit uppercase tracking-tighter">
                    Student ID: {{ $attendance->student->student_id }}
                </span>

            </div>
        </td>

        {{-- AM IN --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">

                <span class="text-[#2E7D32] font-mono font-bold text-sm">
                    {{ $attendance->am_time_in
                        ? \Carbon\Carbon::parse($attendance->am_time_in)->format('h:i A')
                        : '--:--' }}
                </span>

                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                    08:00 AM
                </span>

            </div>
        </td>

        {{-- AM OUT --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">

                <span class="text-[#2E7D32] font-mono font-bold text-sm">
                    {{ $attendance->am_time_out
                        ? \Carbon\Carbon::parse($attendance->am_time_out)->format('h:i A')
                        : '--:--' }}
                </span>

                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                    12:00 PM
                </span>

            </div>
        </td>

        {{-- PM IN --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">

                <span class="text-[#1565C0] font-mono font-bold text-sm">
                    {{ $attendance->pm_time_in
                        ? \Carbon\Carbon::parse($attendance->pm_time_in)->format('h:i A')
                        : '--:--' }}
                </span>

                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                    01:00 PM
                </span>

            </div>
        </td>

        {{-- PM OUT --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">

                <span class="text-[#1565C0] font-mono font-bold text-sm">
                    {{ $attendance->pm_time_out
                        ? \Carbon\Carbon::parse($attendance->pm_time_out)->format('h:i A')
                        : '--:--' }}
                </span>

                <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                    05:00 PM
                </span>

            </div>
        </td>

        {{-- STATUS --}}
        <td class="px-6 py-4 text-center">

            @if($attendance->am_time_in && $attendance->am_time_out && $attendance->pm_time_in && $attendance->pm_time_out)

                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-tighter">
                    Completed
                </span>

            @elseif($attendance->am_time_in && $attendance->am_time_out && !$attendance->pm_time_in)

                <span class="px-3 py-1 bg-orange-100 text-[#FF8C00] rounded-full text-[10px] font-black uppercase tracking-tighter">
                    Afternoon Pending
                </span>

            @elseif($attendance->am_time_in && !$attendance->am_time_out)

                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-black uppercase tracking-tighter">
                    AM Ongoing
                </span>

            @else

                <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-tighter">
                    Pending
                </span>

            @endif

        </td>

    </tr>

    @empty
    <tr>
       <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm font-medium">
          No attendance records for today.
       </td>
    </tr>             

    @endforelse

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

    @forelse($attendanceLogs as $attendance)

    <tr class="hover:bg-slate-50/50 transition">

    {{-- Define dateStr once per row --}}
    @php $dateStr = \Carbon\Carbon::parse($attendance->date)->format('Y-m-d'); @endphp

        {{-- Date --}}
        <td class="px-6 py-4">
            <span class="font-mono font-bold text-slate-500 text-sm">
                {{ \Carbon\Carbon::parse($attendance->date)->format('m/d/Y') }}
            </span>
        </td>

        {{-- Student --}}
        <td class="px-6 py-4">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-slate-700">
                    {{ $attendance->student->user->name ?? 'Unknown' }}
                </span>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded mt-1 w-fit uppercase tracking-tighter">
                    Student ID: {{ $attendance->student->student_id }}
                </span>
            </div>
        </td>

        {{-- AM In --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                @if($attendance->am_time_in)
                    @php
                        $amInRaw   = \Carbon\Carbon::parse($dateStr . ' ' . $attendance->am_time_in);
                        $amInSched = \Carbon\Carbon::parse($dateStr . ' 08:00:00');
                        $amInIsLate = $amInRaw->gt($amInSched);
                    @endphp
                    <span class="{{ $amInIsLate ? 'text-red-500' : 'text-[#2E7D32]' }} font-mono font-bold text-sm">
                        {{ $amInIsLate ? $amInRaw->format('h:i A') : '08:00 AM' }}
                    </span>
                    <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                        Arr: {{ $amInRaw->format('h:i A') }}
                    </span>
                @else
                    <span class="text-slate-300 font-mono font-bold text-sm italic">--:--</span>
                    <span class="text-slate-300 font-mono text-[10px] italic">08:00 AM</span>
                @endif
            </div>
        </td>

        {{-- AM Out --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                @if($attendance->am_time_out)
                    @php
                        $amOutRaw   = \Carbon\Carbon::parse($dateStr . ' ' . $attendance->am_time_out);
                        $amOutSched = \Carbon\Carbon::parse($dateStr . ' 12:00:00');
                        $amOutIsEarly = $amOutRaw->lt($amOutSched);
                    @endphp
                    <span class="{{ $amOutIsEarly ? 'text-red-500' : 'text-[#2E7D32]' }} font-mono font-bold text-sm">
                        {{ $amOutIsEarly ? $amOutRaw->format('h:i A') : '12:00 PM' }}
                    </span>
                    <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                        Dep: {{ $amOutRaw->format('h:i A') }}
                    </span>
                @else
                    <span class="text-slate-300 font-mono font-bold text-sm italic">--:--</span>
                    <span class="text-slate-300 font-mono text-[10px] italic">12:00 PM</span>
                @endif
            </div>
        </td>

        {{-- PM In --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                @if($attendance->pm_time_in)
                    @php
                        $pmInRaw   = \Carbon\Carbon::parse($dateStr . ' ' . $attendance->pm_time_in);
                        $pmInSched = \Carbon\Carbon::parse($dateStr . ' 13:00:00');
                        $pmInIsLate = $pmInRaw->gt($pmInSched);
                    @endphp
                    <span class="{{ $pmInIsLate ? 'text-red-500' : 'text-[#1565C0]' }} font-mono font-bold text-sm">
                        {{ $pmInIsLate ? $pmInRaw->format('h:i A') : '01:00 PM' }}
                    </span>
                    <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                        Arr: {{ $pmInRaw->format('h:i A') }}
                    </span>
                @else
                    <span class="text-slate-300 font-mono font-bold text-sm italic">--:--</span>
                    <span class="text-slate-300 font-mono text-[10px] italic">01:00 PM</span>
                @endif
            </div>
        </td>

        {{-- PM Out --}}
        <td class="px-6 py-4 text-center">
            <div class="flex flex-col justify-center items-center">
                @if($attendance->pm_time_out)
                    @php
                        $pmOutRaw   = \Carbon\Carbon::parse($dateStr . ' ' . $attendance->pm_time_out);
                        $pmOutSched = \Carbon\Carbon::parse($dateStr . ' 17:00:00');
                        $pmOutIsEarly = $pmOutRaw->lt($pmOutSched);
                    @endphp
                    <span class="{{ $pmOutIsEarly ? 'text-red-500' : 'text-[#1565C0]' }} font-mono font-bold text-sm">
                        {{ $pmOutIsEarly ? $pmOutRaw->format('h:i A') : '05:00 PM' }}
                    </span>
                    <span class="text-slate-400 font-mono text-[10px] font-medium leading-tight">
                        Dep: {{ $pmOutRaw->format('h:i A') }}
                    </span>
                @else
                    <span class="text-slate-300 font-mono font-bold text-sm italic">--:--</span>
                    <span class="text-slate-300 font-mono text-[10px] italic">05:00 PM</span>
                @endif
            </div>
        </td>

        {{-- Total --}}
        <td class="px-6 py-4 text-center">
            <span class="font-black text-slate-800 text-sm">
                {{ $attendance->total_hours }} hrs
            </span>
        </td>

        {{-- Missed --}}
        <td class="px-6 py-4 text-center">
            @php $missed = 8 - $attendance->total_hours; @endphp
            @if($missed <= 0)
                <span class="px-3 py-1 bg-slate-100 text-slate-400 rounded-full text-[10px] font-black uppercase tracking-tighter">
                    None
                </span>
            @else
                <span class="font-black text-red-500 text-sm">
                    {{ number_format($missed, 1) }} hrs
                </span>
            @endif
        </td>

    </tr>

    @empty
    <tr>
        <td colspan="8" class="px-6 py-8 text-center text-slate-400 text-sm font-medium">
            No attendance logs found.
        </td>
    </tr>
    @endforelse

</tbody>
            </table>
        </div>
    </div>
</div>

{{-- Clock In Modal --}}
<div x-show="openClockIn" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div @click.away="openClockIn = false; resetClockIn()" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden relative z-10 border border-slate-100">
            <div class="bg-[#2E7D32] p-4 text-white text-center">
                <h2 class="text-base font-black uppercase tracking-widest">Clock In OJT</h2>
                <p class="text-green-100 text-[10px] mt-0.5">Official Attendance Registration</p>
            </div>
            <form @submit.prevent="submitClockIn" class="p-5 space-y-4">
                @csrf
                
                {{-- Student ID --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Student ID Number</label>
                    <input type="text" x-model="clockInStudentId" placeholder="Enter ID e.g. #2024-001" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#2E7D32] outline-none font-bold text-slate-700 text-sm">
                </div>

                {{-- Session --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Select Session</label>
                    <select x-model="clockInSession"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#2E7D32] outline-none font-bold text-slate-700 text-sm appearance-none cursor-pointer">
                        <option value="am">AM Session</option>
                        <option value="pm">PM Session</option>
                    </select>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Date</label>
                    <input type="date" x-model="clockInDate" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#2E7D32] outline-none font-bold text-slate-700 text-sm">
                </div>

                {{-- Time --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Time</label>
                    <input type="time" x-model="clockInTime" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#2E7D32] outline-none font-bold text-slate-700 text-sm">
                </div>

                {{-- Feedback --}}
                <div id="clockInFeedback" class="hidden text-center text-xs font-bold rounded-lg py-2"></div>

                <button type="submit" class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white py-3 rounded-xl font-black uppercase tracking-widest shadow-md transition-all transform active:scale-95 text-xs">
                    Confirm Clock In
                </button>
            </form>
        </div>
    </div>
</div>

 {{-- Clock Out Modal --}}
<div x-show="openClockOut" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div @click.away="openClockOut = false; resetClockOut()" class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden relative z-10 border border-slate-100">
            <div class="bg-[#FF8C00] p-4 text-white text-center">
                <h2 class="text-base font-black uppercase tracking-widest">Clock Out OJT</h2>
                <p class="text-orange-100 text-[10px] mt-0.5">Exit Attendance Registration</p>
            </div>
            <form @submit.prevent="submitClockOut" class="p-5 space-y-4">
                @csrf
                
                {{-- Student ID --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Student ID Number</label>
                    <input type="text" x-model="clockOutStudentId" placeholder="Enter ID e.g. #2024-001" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00] outline-none font-bold text-slate-700 text-sm">
                </div>

                {{-- Session --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Select Session</label>
                    <select x-model="clockOutSession"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00] outline-none font-bold text-slate-700 text-sm appearance-none cursor-pointer">
                        <option value="am">AM Session</option>
                        <option value="pm">PM Session</option>
                    </select>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Date</label>
                    <input type="date" x-model="clockOutDate" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00] outline-none font-bold text-slate-700 text-sm">
                </div>

                {{-- Time --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Time</label>
                    <input type="time" x-model="clockOutTime" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#FF8C00] outline-none font-bold text-slate-700 text-sm">
                </div>

                {{-- Feedback --}}
                <div id="clockOutFeedback" class="hidden text-center text-xs font-bold rounded-lg py-2"></div>

                <button type="submit" class="w-full bg-[#FF8C00] hover:bg-[#e67e00] text-white py-3 rounded-xl font-black uppercase tracking-widest shadow-md transition-all transform active:scale-95 text-xs">
                    Confirm Clock Out
                </button>
            </form>
        </div>
    </div>
</div>
@endsection