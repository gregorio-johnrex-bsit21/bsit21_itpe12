@extends('layouts.supervisor')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Interns</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-black text-slate-800">{{ $totalStudents }}</h3>
                <span class="text-green-500 text-xs font-bold">Enrolled</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hours Rendered</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-black text-slate-800">{{ $totalHours }}</h3>
                <span class="text-blue-500 text-xs font-bold">Total</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Tasks</p>
            <div class="flex items-end justify-between mt-2">
                <h3 class="text-3xl font-black text-slate-800">{{ $pendingTasks }}</h3>
                <span class="text-amber-500 text-xs font-bold">Active</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Task Completion</p>
            <div class="flex items-end justify-between mt-2">
               <h3 class="text-3xl font-black text-slate-800">{{ $successRate }}%</h3>
               <span class="text-emerald-600 text-xs font-bold">{{ $completedTasks }}/{{ $totalTasks }}</span>
            </div>
        </div>

    </div>

    {{-- Student Completion Progress --}}
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h4 class="font-bold text-slate-800 text-lg">Student Completion Progress</h4>
            <a href="{{ route('supervisor.students') }}" class="text-sm text-[#2E7D32] font-semibold hover:underline">View All Students</a>
        </div>

        @if($studentProgress->isEmpty())
            <div class="text-center py-10 text-slate-400 text-sm">No students enrolled yet.</div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
            @foreach($studentProgress as $s)
            @php
                $colors = ['#2E7D32', '#FF8C00', '#FF4500', '#D50000', '#185FA5', '#7B1FA2'];
                $color  = $colors[$loop->index % count($colors)];
            @endphp
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/50 border border-transparent hover:border-slate-200 transition-all">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($s['name']) }}&background={{ ltrim($color, '#') }}&color=fff"
                     class="w-12 h-12 rounded-xl shadow-sm">
                <div class="flex-1">
                    <h5 class="font-bold text-slate-800 leading-tight">{{ $s['name'] }}</h5>
                    <p class="text-xs text-slate-500 mt-1 mb-3">
                        {{ $s['tasks_done'] }} of {{ $s['tasks_total'] }} tasks completed
                        &nbsp;·&nbsp; {{ $s['hours'] }} hrs
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="h-2 flex-1 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-700"
                                 style="width: {{ $s['progress'] }}%; background-color: {{ $color }};"></div>
                        </div>
                        <span class="text-xs font-black" style="color: {{ $color }};">{{ $s['progress'] }}%</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>
@endsection