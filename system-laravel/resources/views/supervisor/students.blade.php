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
                                    {{ strtoupper(substr($student->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-700 text-sm">{{ $student->name }}</p>
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
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-all">
                                <i class="fas fa-ellipsis-v text-xs"></i>
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
                                    {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                </div>
                                <span class="font-bold text-slate-700">{{ $student->user->name }}</span>
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

@push('scripts')
<script>
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
        // Remove row from pending table
        document.getElementById('row-' + studentId).remove();

        // Reload page to reflect changes
        window.location.reload();
    }
}
</script>
@endpush

@endsection