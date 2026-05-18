@extends('layouts.supervisor')

@section('title', 'Evaluation')
@section('page_title', 'Evaluation')

@section('content')
<div class="space-y-6" x-data="{ evalFilter: 'all' }">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-100 pb-6">
        <div>
            <h3 class="font-black text-2xl text-slate-800 tracking-tight">Student Performance</h3>
            <p class="text-sm text-slate-500 mt-1">Overview of OJT hour completion and earned milestones.</p>
        </div>
        <div class="flex gap-1 bg-slate-100 p-1 rounded-xl">
            <button @click="evalFilter = 'all'"
                :class="evalFilter === 'all' ? 'bg-white shadow-sm text-emerald-700' : 'text-slate-500 hover:text-slate-700'"
                class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                All Students
            </button>
            <button @click="evalFilter = 'behind'"
                :class="evalFilter === 'behind' ? 'bg-white shadow-sm text-red-600' : 'text-slate-500 hover:text-slate-700'"
                class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                Attention Needed
            </button>
        </div>
    </div>

    @if($studentData->isEmpty())
        <div class="text-center py-20">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p class="text-slate-400 text-sm font-medium">No students enrolled yet.</p>
        </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        @foreach($studentData as $s)
        @php
            $isBehind   = in_array($s['status'], ['behind', 'at_risk', 'incomplete']);
            $color      = $isBehind ? '#D50000' : '#2E7D32';
            $bgBadge    = $isBehind ? 'bg-red-50 text-red-600 border-red-100' : 'bg-emerald-50 text-emerald-700 border-emerald-100';
            $label      = $isBehind ? 'Behind Schedule' : 'On Track';
            $barColor   = $isBehind ? 'bg-red-600' : 'bg-emerald-700';
            $missedBg   = $s['missed'] > 0 ? 'bg-red-50 border-red-100' : 'bg-slate-50 border-slate-100';
            $missedText = $s['missed'] > 0 ? 'text-red-600' : 'text-slate-700';
            $missedLabel = $s['missed'] > 0 ? 'text-red-400' : 'text-slate-400';
            $avatarBg   = $isBehind ? 'D50000' : '2E7D32';
        @endphp

        <div
            x-show="evalFilter === 'all' || (evalFilter === 'behind' && {{ $isBehind ? 'true' : 'false' }})"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">

            {{-- Card Header with subtle accent --}}
            <div class="px-6 pt-6 pb-4">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($s['name']) }}&background={{ $avatarBg }}&color=fff"
                         class="w-12 h-12 rounded-xl shadow-sm">
                    <div class="min-w-0">
                        <h2 class="font-bold text-slate-800 text-base truncate">{{ $s['name'] }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $bgBadge }}">
                            {{ $label }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Progress Section --}}
            <div class="px-6 pb-6 space-y-5">

                {{-- Hours Row --}}
                <div class="flex justify-between items-baseline">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">{{ $s['required'] }} hrs required</span>
                    <div class="text-right">
                        <span class="text-2xl font-black" style="color: {{ $color }};">{{ $s['accumulated'] }}</span>
                        <span class="text-xs font-medium text-slate-400 ml-0.5">hrs</span>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="space-y-1.5">
                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $barColor }} transition-all duration-500" style="width: {{ $s['progress'] }}%"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-semibold text-slate-400 uppercase">Completion</span>
                        <span class="text-sm font-bold" style="color: {{ $color }};">{{ $s['progress'] }}%</span>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 rounded-xl border {{ $missedBg }}">
                        <p class="text-[10px] font-bold uppercase {{ $missedLabel }} mb-1">Missed</p>
                        <p class="text-lg font-black {{ $missedText }}">{{ $s['missed'] }}</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Remaining</p>
                        <p class="text-lg font-black" style="color: {{ $color }};">{{ $s['remaining'] }}</p>
                    </div>
                </div>

            </div>
        </div>
        @endforeach

    </div>
    @endif

</div>
@endsection