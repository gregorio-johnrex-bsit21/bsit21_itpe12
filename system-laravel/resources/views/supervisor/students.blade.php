@extends('layouts.supervisor')

@section('title', 'Student Directory')
@section('page_title', 'Student Directory')

@section('content')
<div class="space-y-10 pb-10">

    {{-- Active Interns --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
            <div class="flex items-center gap-3">
                <h4 class="font-bold text-slate-800 tracking-tight">Active Interns</h4>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total: {{ $active->count() }}</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-slate-500 text-[11px] uppercase font-black tracking-[0.1em]">
                    <tr>
                        <th class="px-8 py-4">Full Name</th>
                        <th class="px-8 py-4 text-center">Student ID</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($active as $student)
                    <tr class="group hover:bg-slate-50/30 transition-all">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[#2E7D32] text-white flex items-center justify-center font-bold shadow-sm shadow-green-100">
                                    {{ strtoupper(substr($student->user->name ?? $student->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700 text-sm">{{ $student->user->name ?? $student->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Joined {{ $student->created_at->format('M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center font-mono text-xs text-slate-500">{{ $student->student_id }}</td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center gap-1.5 text-[#2E7D32] text-[10px] font-black uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 bg-[#2E7D32] rounded-full animate-pulse"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button onclick="viewStudentDetails('{{ $student->student_id }}')" 
                                class="h-9 px-5 bg-slate-100 hover:bg-[#2E7D32] hover:text-white text-slate-600 text-xs font-bold rounded-xl transition-all active:scale-95">
                                <i class="fas fa-eye mr-1.5"></i>View Details
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-6 text-center text-slate-400 text-sm">No active interns yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Student Requests --}}
    <div class="bg-white rounded-3xl border-2 border-orange-50 shadow-xl shadow-orange-50/20 overflow-hidden">
        <div class="px-8 py-6 bg-orange-50/30 border-b border-orange-100 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-clock text-sm"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 tracking-tight">Student Requests</h3>
                    <p class="text-[11px] text-orange-600/70 font-bold uppercase tracking-widest">Waiting for review</p>
                </div>
            </div>
            <span class="bg-orange-500 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-sm shadow-orange-200">{{ $pending->count() }} NEW</span>
        </div>

        <div class="overflow-x-auto p-2">
            <table class="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">
                        <th class="px-6 py-2">Full Name</th>
                        <th class="px-6 py-2">Student ID</th>
                        <th class="px-6 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="pending-tbody">
                    @forelse($pending as $student)
                    <tr id="row-{{ $student->student_id }}" class="group bg-white border border-slate-100 shadow-sm hover:shadow-md transition-all">
                        <td class="px-6 py-4 rounded-l-2xl border-y border-l border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-slate-50 border-2 border-white shadow-inner flex items-center justify-center font-bold text-orange-500">
                                    {{ strtoupper(substr($student->user->name ?? $student->name, 0, 2)) }}
                                </div>
                                <span class="font-bold text-slate-700">{{ $student->user->name ?? $student->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 border-y border-slate-100">
                            <span class="px-3 py-1 bg-slate-50 text-slate-500 text-xs font-bold rounded-lg border border-slate-100">{{ $student->student_id }}</span>
                        </td>
                        <td class="px-6 py-4 rounded-r-2xl border-y border-r border-slate-100 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="handleStudent('{{ $student->student_id }}', 'accept')" class="h-10 px-6 bg-[#2E7D32] hover:bg-[#256629] text-white text-xs font-bold rounded-xl shadow-lg shadow-green-100 transition-all active:scale-95">
                                    Accept
                                </button>
                                <button onclick="handleStudent('{{ $student->student_id }}', 'reject')" class="h-10 px-6 bg-white border border-red-100 text-red-500 hover:bg-red-50 text-xs font-bold rounded-xl transition-all active:scale-95">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="empty-row">
                        <td colspan="3" class="px-6 py-6 text-center text-slate-400 text-sm">No pending requests.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Student Details Modal --}}
<div id="studentDetailsModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeStudentDetails()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative z-10">
            {{-- Header --}}
            <div class="bg-[#2E7D32] p-5 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-black uppercase tracking-wider" id="modalStudentName">Student Name</h3>
                        <p class="text-green-100 text-xs mt-1 font-mono" id="modalStudentId">ID: --</p>
                    </div>
                    <button onclick="closeStudentDetails()" class="text-white/80 hover:text-white">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            {{-- Body --}}
            <div class="p-5 space-y-4 max-h-[70vh] overflow-y-auto">
                {{-- Avatar + Basic Info --}}
                <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-xl bg-[#2E7D32] text-white flex items-center justify-center text-xl font-bold shadow-lg" id="modalAvatar">
                        --
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Carlos Hilado Memorial State University</p>
                        <p class="text-sm text-slate-600 mt-1" id="modalCourse">--</p>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="space-y-3">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Contact Information</h4>
                    
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Phone Number</p>
                        <p class="text-sm font-semibold text-slate-700 mt-1" id="modalPhone">--</p>
                    </div>
                    
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Emergency Contact</p>
                        <p class="text-sm font-semibold text-slate-700 mt-1" id="modalEmergency">--</p>
                    </div>
                </div>

                {{-- Addresses --}}
                <div class="space-y-3">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Addresses</h4>
                    
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Home Address</p>
                        <p class="text-sm font-semibold text-slate-700 mt-1" id="modalHomeAddress">--</p>
                    </div>
                    
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">School Address</p>
                        <p class="text-sm font-semibold text-slate-700 mt-1" id="modalSchoolAddress">--</p>
                    </div>
                </div>

                {{-- OJT Period --}}
                <div class="space-y-3">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">OJT Period</h4>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                            <p class="text-[10px] text-emerald-600 font-bold uppercase">Start Date</p>
                            <p class="text-sm font-bold text-emerald-700 mt-1" id="modalStartDate">--</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                            <p class="text-[10px] text-emerald-600 font-bold uppercase">End Date</p>
                            <p class="text-sm font-bold text-emerald-700 mt-1" id="modalEndDate">--</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Store student data from PHP
const studentData = {
    @foreach($active as $s)
    @php
        $profile = $s->profile;
        $course = $profile?->course ?? 'Not set';
        $section = $profile?->section ?? '';
        $year = $profile?->year_level ?? '';
        $phone = $profile?->contact_number ? '+63 ' . $profile->contact_number : 'Not set';
        $emergency = $profile?->emergency_contact ? '+63 ' . $profile->emergency_contact : 'Not set';
        $home = $profile?->home_address ?? 'Not set';
        $school = $profile?->school_address ?? 'Not set';
        $start = $s->company?->ojtRequirement?->start_date ?? 'Not set';
        $end = $s->company?->ojtRequirement?->end_date ?? 'Not set';
    @endphp
    '{{ $s->student_id }}': {
        name: '{{ $s->user->name ?? $s->name }}',
        student_id: '{{ $s->student_id }}',
        course: '{{ $course }} - {{ $section }} {{ $year }}',
        phone: '{{ $phone }}',
        emergency: '{{ $emergency }}',
        home_address: '{{ $home }}',
        school_address: '{{ $school }}',
        start_date: '{{ $start }}',
        end_date: '{{ $end }}',
    },
    @endforeach
};

function viewStudentDetails(studentId) {
    const data = studentData[studentId];
    if (!data) return;

    document.getElementById('modalStudentName').innerText = data.name;
    document.getElementById('modalStudentId').innerText = 'ID: ' + data.student_id;
    document.getElementById('modalAvatar').innerText = data.name.substring(0, 2).toUpperCase();
    document.getElementById('modalCourse').innerText = data.course;
    document.getElementById('modalPhone').innerText = data.phone;
    document.getElementById('modalEmergency').innerText = data.emergency;
    document.getElementById('modalHomeAddress').innerText = data.home_address;
    document.getElementById('modalSchoolAddress').innerText = data.school_address;
    document.getElementById('modalStartDate').innerText = data.start_date;
    document.getElementById('modalEndDate').innerText = data.end_date;

    document.getElementById('studentDetailsModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeStudentDetails() {
    document.getElementById('studentDetailsModal').classList.add('hidden');
    document.body.style.overflow = '';
}

async function handleStudent(studentId, action) {
    const route = action === 'accept' 
        ? "{{ route('supervisor.accept') }}" 
        : "{{ route('supervisor.reject') }}";

    const res = await fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ student_id: studentId })
    });

    const data = await res.json();

    if (data.success) {
        document.getElementById('row-' + studentId).remove();
        window.location.reload();
    }
}
</script>
@endpush

@endsection