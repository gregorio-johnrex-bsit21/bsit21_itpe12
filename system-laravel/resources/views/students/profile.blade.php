@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<style>
    html.dark .min-h-screen { background-color: var(--bg-tertiary) !important; }

    /* All white cards */
    html.dark .bg-white.rounded-3xl,
    html.dark .bg-white.rounded-2xl {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }

    /* Stat tiles inside cards */
    html.dark .bg-gray-50.rounded-xl { background-color: var(--bg-secondary) !important; border-color: var(--border-color) !important; }
    html.dark .bg-emerald-50.rounded-lg { background-color: rgba(6, 78, 59, 0.25) !important; }

    /* Partner university card */
    html.dark .bg-gradient-to-br.from-emerald-50 {
        background: var(--bg-secondary) !important;
        border-color: var(--border-color) !important;
    }

    /* Profile edit modal */
    html.dark #profileContent {
        background-color: var(--bg-card) !important;
    }
    html.dark #profileContent input,
    html.dark #profileContent textarea,
    html.dark #profileContent select {
        background-color: var(--bg-input) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }
    html.dark #profileContent .bg-gray-50.rounded-2xl {
        background-color: var(--bg-secondary) !important;
        border-color: var(--border-color) !important;
    }
    html.dark #profileContent .border-b.border-gray-100 { border-color: var(--border-color) !important; }
    html.dark #profileContent .border-t.border-gray-100 { border-color: var(--border-color) !important; }
    html.dark #profileContent .bg-gray-100.hover\:bg-gray-200 { background-color: var(--bg-secondary) !important; }

    /* Quick actions card */
    html.dark .bg-gray-50.text-gray-400.cursor-not-allowed { background-color: var(--bg-secondary) !important; }
    html.dark .bg-emerald-50.text-emerald-700 { background-color: rgba(6, 78, 59, 0.25) !important; }

    /* Active training card icons */
    html.dark .bg-emerald-50.rounded-lg.flex-shrink-0 { background-color: rgba(6, 78, 59, 0.25) !important; }

    /* Addresses card */
    html.dark .bg-blue-50.rounded-lg { background-color: rgba(7, 68, 124, 0.2) !important; }

    /* Toast */
    html.dark #successToast { background-color: #065f46 !important; }

    
</style>

@if(session('success'))
<div id="successToast" class="fixed top-4 right-4 z-[300] bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-semibold flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
<script>
    setTimeout(() => document.getElementById('successToast')?.remove(), 3000);
</script>
@endif

@php
    $student      = session('student');
    $studentModel = \App\Models\Student::with([
        'company.ojtRequirement',
        'company.supervisors.user',
    ])->find($student->id);

    $ojt            = $studentModel?->company?->ojtRequirement;
    $supervisorName = $studentModel?->company?->supervisors?->first()?->user?->name ?? 'Not assigned';
    $startDate      = $ojt?->start_date
        ? \Carbon\Carbon::parse($ojt->start_date)->format('M d, Y') : 'Not set';
    $endDate        = $ojt?->end_date
        ? \Carbon\Carbon::parse($ojt->end_date)->format('M d, Y') : 'Not set';
@endphp

{{-- Profile Page - Desktop & Mobile Responsive --}}


    {{-- Simple Header --}}
    <div class="max-w-lg lg:max-w-6xl mx-auto px-0 lg:px-8 pt-6 pb-2">
        <h2 class="text-xl font-bold text-gray-900">My Profile Info</h2>
    </div>

    {{-- Mobile Layout (max-w-lg) / Desktop Layout (max-w-6xl with grid) --}}
    <div class="max-w-lg lg:max-w-6xl mx-auto px-0 lg:px-8 pt-4 space-y-4 lg:space-y-0 lg:grid lg:grid-cols-12 lg:gap-4">

        {{-- LEFT COLUMN: Profile + Details (Mobile: full width, Desktop: 8 cols) --}}
        <div class="lg:col-span-8 space-y-4">

            {{-- Profile Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 text-center relative overflow-hidden lg:text-left lg:flex lg:items-center lg:gap-6 lg:p-8">
                {{-- Subtle emerald gradient decoration --}}
                <div class="absolute top-0 left-0 right-0 h-24 bg-gradient-to-b from-emerald-50/50 to-transparent pointer-events-none lg:hidden dark:hidden"></div>

                {{-- Avatar --}}
                <div class="relative inline-block mb-4 lg:mb-0 lg:flex-shrink-0">
                    <div class="h-24 w-24 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 p-0.5 shadow-lg">
                        <div class="h-full w-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                            @if(session('student')->avatar)
                                <img src="{{ session('student')->avatar }}" class="h-full w-full object-cover" alt="Profile">
                            @else
                                <span class="text-2xl font-bold text-emerald-600">
                                    {{ strtoupper(substr(explode(' ', session('student')->name)[0], 0, 1)) . strtoupper(substr(explode(' ', session('student')->name)[1] ?? '', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- Online indicator --}}
                    <div class="absolute bottom-1 right-1 h-5 w-5 bg-emerald-500 border-3 border-white rounded-full"></div>
                </div>

                {{-- Info --}}
                <div class="flex-1 lg:min-w-0">
                    <h2 class="text-xl font-bold text-gray-900">{{ session('student')->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ session('student')->email ?? 'student@university.edu' }}</p>
                    <p class="text-xs text-gray-400 mt-1 flex items-center justify-center lg:justify-start gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        {{ $profile?->course ?? 'N/A' }} - {{ $profile?->section ?? 'N/A' }} · OJT Trainee
                    </p>
                </div>

                {{-- Edit Button (Desktop: right side) --}}
                <button id="openProfileModal" class="mt-5 lg:mt-0 inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-full shadow-lg transition-all active:scale-95 lg:flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Profile
                </button>
            </div>

             {{-- Quick Actions Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Quick Actions</h3>
                </div>
                <div class="p-3 space-y-1">
                    @if($profile?->is_complete)
    <div class="w-full flex items-center gap-3 px-4 py-3 bg-gray-50 text-gray-400 rounded-xl text-sm font-semibold cursor-not-allowed select-none">
        <div class="p-1.5 bg-gray-100 rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <span class="flex-1 text-left">Complete Profile</span>
        <span class="text-xs bg-gray-200 text-gray-400 px-2 py-0.5 rounded-full">Done ✓</span>
    </div>
@else
    <button id="openProfileModal2" class="w-full group flex items-center gap-3 px-4 py-3 bg-emerald-50 text-emerald-700 rounded-xl text-sm font-semibold hover:bg-emerald-100 transition active:scale-[0.98]">
        <div class="p-1.5 bg-emerald-200/50 rounded-lg">
            <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <span class="flex-1 text-left">Complete Profile</span>
        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
    </button>
@endif

                    <button class="w-full group flex items-center gap-3 px-4 py-3 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-50 transition active:scale-[0.98]">
                        <div class="p-1.5 bg-gray-100 rounded-lg group-hover:bg-gray-200 transition">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        Change Password
                    </button>
                </div>
            </div>

            {{-- Student Details Card: ID & Class (top), Contact (middle), Emergency (bottom) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Student Details</h3>
                </div>
                {{-- Top Row: ID & Class --}}
                <div class="px-5 pt-4 grid grid-cols-2 gap-3">
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">Student ID</p>
                        <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ session('student')->student_id }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">Class</p>
                        <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $profile?->course ? $profile->course . ' - ' . $profile->section : 'Not set' }}</p>
                    </div>
                </div>
                {{-- Middle: Contact --}}
                <div class="px-5 pt-3">
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">Contact</p>
                        <p class="text-sm font-semibold text-gray-900 mt-0.5">+63 {{ $profile?->contact_number ?? 'Not set' }}</p>
                    </div>
                </div>
                {{-- Bottom: Emergency --}}
                <div class="px-5 py-4">
                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-500 font-medium">Emergency</p>
                        <p class="text-sm font-semibold mt-0.5 {{ $profile?->emergency_contact ? 'text-gray-900' : 'text-red-600' }}">+63 {{ $profile?->emergency_contact ?? 'Required' }}</p>
                    </div>
                </div>
            </div>

            {{-- Active Training Summary Card --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-50">
        <div class="flex items-center gap-2">
            <div class="p-1.5 bg-emerald-50 rounded-lg">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">Active Training Summary</h3>
                <p class="text-xs text-gray-500">Current OJT period details</p>
            </div>
        </div>
    </div>

    {{-- Slate Box: All schedule info in one clean container --}}
    <div class="px-5 py-4">
        <div class="bg-slate-50 rounded-2xl border border-slate-100 p-4 space-y-3">

            {{-- Row 1: Start & End Date --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Start Date</p>
                    <p class="text-sm font-bold text-slate-700">{{ $startDate }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">End Date</p>
                    <p class="text-sm font-bold text-slate-700">{{ $endDate }}</p>
                </div>
            </div>

            {{-- Divider --}}
            <div class="h-px bg-slate-200"></div>

            {{-- Row 2: AM Schedule --}}
            <div class="flex items-center gap-3">
                <div class="p-1.5 bg-amber-50 rounded-lg">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">AM Schedule</p>
                    <p class="text-sm font-bold text-slate-700">
                        {{ $ojt?->am_start_time ? \Carbon\Carbon::parse($ojt->am_start_time)->format('h:i A') : '--:--' }}
                        <span class="text-slate-300 mx-1">→</span>
                        {{ $ojt?->am_end_time ? \Carbon\Carbon::parse($ojt->am_end_time)->format('h:i A') : '--:--' }}
                    </p>
                </div>
            </div>

            {{-- Row 3: PM Schedule --}}
            <div class="flex items-center gap-3">
                <div class="p-1.5 bg-indigo-50 rounded-lg">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">PM Schedule</p>
                    <p class="text-sm font-bold text-slate-700">
                        {{ $ojt?->pm_start_time ? \Carbon\Carbon::parse($ojt->pm_start_time)->format('h:i A') : '--:--' }}
                        <span class="text-slate-300 mx-1">→</span>
                        {{ $ojt?->pm_end_time ? \Carbon\Carbon::parse($ojt->pm_end_time)->format('h:i A') : '--:--' }}
                    </p>
                </div>
            </div>

            {{-- Divider --}}
            <div class="h-px bg-slate-200"></div>

            {{-- Row 4: Supervisor --}}
            <div class="flex items-center gap-3">
                <div class="p-1.5 bg-emerald-50 rounded-lg">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Supervisor</p>
                    <p class="text-sm font-bold text-emerald-600">{{ $supervisorName }}</p>
                </div>
            </div>

        </div>
    </div>
</div>

            {{-- Addresses Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-50 rounded-lg">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900">Addresses</h3>
                    </div>
                </div>

                <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">School</p>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">{{ $profile?->school_address ?? 'Not set' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Home</p>
                        </div>
                        <p class="text-sm font-semibold text-gray-900">{{ $profile?->home_address ?? 'Not set' }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: Quick Actions + Partner (Mobile: full width, Desktop: 4 cols) --}}
        <div class="lg:col-span-4 space-y-4">

           

            {{-- Partner University Card --}}
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl border border-emerald-100 p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2 bg-white rounded-xl shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wide">Partner University</p>
                    </div>
                </div>
                <p class="text-lg font-bold text-gray-900">Carlos Hilado Memorial State University</p>
                <p class="text-xs text-gray-500 mt-1">Official OJT partner institution</p>
            </div>

        </div>

    </div>
</div>
{{-- Profile Modal --}}
<div id="profileModal" class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out">

    <div id="profileBackdrop" class="absolute inset-0 bg-black/40 sm:backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

    {{-- Mobile: Full screen (no max-width, no margin, full rounded-t only) --}}
    {{-- Desktop: Centered modal with max-width --}}
    <div id="profileContent" class="relative bg-white w-full sm:max-w-lg h-[100dvh] sm:h-auto sm:max-h-[85vh] overflow-hidden flex flex-col shadow-2xl rounded-t-2xl sm:rounded-2xl transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 ease-out">

        {{-- Modal Handle (Mobile only) --}}
        <div class="flex justify-center pt-3 pb-1 sm:hidden">
            <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
        </div>

        <!-- HEADER -->
        <div class="px-6 py-4 flex items-center justify-between shrink-0 border-b border-gray-100 sm:border-0">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Complete Profile</h3>
                <p class="text-xs text-gray-500 font-medium mt-0.5">OJT Requirement Checklist</p>
            </div>
            <button id="closeProfileBtn" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- BODY -->
        <div class="flex-1 overflow-y-auto px-6 py-2 space-y-6">
            <form id="profileForm" method="POST" action="{{ route('students.profile.save') }}" class="space-y-6">
                @csrf

                <!-- PROFILE PHOTO -->
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="h-16 w-16 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0 border-2 border-white shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                        <input type="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 cursor-pointer transition">
                    </div>
                </div>

                <!-- ACADEMIC -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-4 bg-emerald-500 rounded-full"></span>
                        Academic Info
                    </h4>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">School Name</label>
                        <input type="text" name="school_name" value="{{ old('school_name', $profile?->school_name) }}" placeholder="Enter school name"
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Course</label>
                            <input type="text" name="course" value="{{ old('course', $profile?->course) }}" placeholder="BSIT"
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Year</label>
                            <select name="year_level"
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition appearance-none">
                                <option value="3rd Year" {{ old('year_level', $profile?->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th Year" {{ old('year_level', $profile?->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Section</label>
                            <input type="text" name="section" value="{{ old('section', $profile?->section) }}" placeholder="4A"
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>

                <!-- LOCATION -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-4 bg-emerald-500 rounded-full"></span>
                        Location
                    </h4>
                    <div> <!-- disabled addresses -->
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">School Address</label>
                        <textarea disabled name="school_address" rows="2" placeholder="Enter school address"
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none">{{ old('school_address', $profile?->school_address) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Home Address</label>
                        <textarea disabled name="home_address" rows="2" placeholder="Enter home address"
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition resize-none">{{ old('home_address', $profile?->home_address) }}</textarea>
                    </div>
                </div>

                <!-- CONTACT -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-4 bg-emerald-500 rounded-full"></span>
                        Contact Information
                    </h4>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Primary Contact</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">+63</span>
                            <input type="tel" name="contact_number" value="{{ old('contact_number', $profile?->contact_number) }}" placeholder="9123456789"
                                class="w-full pl-12 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-red-600 mb-1.5">Emergency Contact <span class="text-red-400 font-normal">(Required)</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">+63</span>
                            <input type="tel" name="emergency_contact" value="{{ old('emergency_contact', $profile?->emergency_contact) }}" placeholder="9123456789"
                                class="w-full pl-12 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition">
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- FOOTER -->
        <div class="p-5 bg-white border-t border-gray-100 flex gap-3 shrink-0">
            <button id="closeProfileBtn2" class="flex-1 py-3 px-4 bg-gray-100 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-200 active:scale-95 transition">
                Cancel
            </button>
            <button type="submit" form="profileForm" class="flex-[2] py-3 px-4 bg-emerald-500 text-white rounded-xl text-sm font-semibold hover:bg-emerald-600  active:scale-95 transition">
                Save Profile
            </button>
        </div>

    </div>


@push('scripts')
<script>
    const openProfileModalBtns = document.querySelectorAll('#openProfileModal, #openProfileModal2');
    const profileModal     = document.getElementById('profileModal');
    const profileBackdrop  = document.getElementById('profileBackdrop');
    const profileContent   = document.getElementById('profileContent');
    const closeProfileBtns = document.querySelectorAll('#closeProfileBtn, #closeProfileBtn2');

    function openModal() {
        profileModal.classList.remove('opacity-0', 'pointer-events-none');
        profileModal.classList.add('opacity-100', 'pointer-events-auto');

        profileBackdrop.classList.remove('opacity-0');
        profileBackdrop.classList.add('opacity-100');

        // Mobile: slide up, Desktop: scale in
        if (window.innerWidth < 640) {
            profileContent.classList.remove('translate-y-full');
            profileContent.classList.add('translate-y-0');
        } else {
            profileContent.classList.remove('scale-95', 'opacity-0');
            profileContent.classList.add('scale-100', 'opacity-100');
        }

        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        profileModal.classList.remove('opacity-100', 'pointer-events-auto');
        profileModal.classList.add('opacity-0', 'pointer-events-none');

        profileBackdrop.classList.remove('opacity-100');
        profileBackdrop.classList.add('opacity-0');

        // Mobile: slide down, Desktop: scale out
        if (window.innerWidth < 640) {
            profileContent.classList.remove('translate-y-0');
            profileContent.classList.add('translate-y-full');
        } else {
            profileContent.classList.remove('scale-100', 'opacity-100');
            profileContent.classList.add('scale-95', 'opacity-0');
        }

        document.body.style.overflow = '';
    }

    openProfileModalBtns.forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    closeProfileBtns.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    profileModal.addEventListener('click', (e) => {
        if (e.target === profileModal || e.target === profileBackdrop) {
            closeModal();
        }
    });
</script>
@endpush

@endsection 