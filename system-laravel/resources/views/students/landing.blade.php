<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvard OJT Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; -webkit-font-smoothing: antialiased; }
        .parallax { background-attachment: fixed; }
        @media (max-width: 768px) { .parallax { background-attachment: scroll; } }
        
        .fade-in { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.8s ease-out forwards; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body class="bg-white text-slate-900">

    <!-- Hero -->
    <section class="relative min-h-[100dvh] md:min-h-screen w-full flex flex-col items-center justify-center overflow-hidden">
    
    {{-- Background --}}
    <div class="absolute inset-0 z-0 parallax bg-cover bg-center" 
         style="background-image: url('images/landing_bg.jpg');">
        <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-[2px]"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 text-center px-5 sm:px-6 max-w-4xl mx-auto fade-in pt-20 pb-24 md:pt-0 md:pb-0">

        {{-- Logo + School Name --}}
        <div class="mb-8 md:mb-10 flex flex-col items-center gap-4">
            
            {{-- Logo --}}
            <div class="relative">
                <div class="absolute inset-0 bg-emerald-500/20 rounded-full blur-2xl scale-110"></div>
                <img src="images/logo_2.0.png" 
                     alt="CHMSU Logo" 
                     class="relative w-28 h-28 sm:w-32 sm:h-32 md:w-40 md:h-40 object-contain drop-shadow-2xl">
            </div>

            {{-- School Name --}}
            <div class="flex flex-col items-center gap-1">
                <p class="text-white/90 text-xs sm:text-sm font-bold tracking-[0.25em] uppercase">
                    Carlos Hilado Memorial State University
                </p>
                <div class="h-px w-16 bg-emerald-400/50"></div>
                <p class="text-emerald-400 text-[10px] sm:text-xs font-semibold tracking-[0.2em] uppercase">
                    College of Computer Studies
                </p>
            </div>
        </div>

        {{-- Title --}}
        <h1 class="text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black tracking-tight mb-4 md:mb-5 leading-[1.1]">
            OJT Manager
        </h1>

        {{-- Subtitle --}}
        <p class="text-slate-300 text-sm sm:text-base md:text-lg max-w-lg md:max-w-xl mx-auto mb-3 md:mb-4 leading-relaxed font-light px-2 sm:px-0">
            Your official on-the-job training companion. Track hours, complete tasks, log attendance, and stay connected with your supervisor — all in one place.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center items-center w-full max-w-xs sm:max-w-sm md:max-w-md mx-auto px-4 sm:px-0">
            <a href="/login?mode=login"
               class="w-full sm:w-auto sm:flex-1 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold text-center py-3.5 md:py-4 px-6 md:px-8 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-emerald-900/30 active:scale-95">
                Sign In
            </a>
            <a href="/login?mode=register"
               class="w-full sm:w-auto sm:flex-1 bg-white/10 hover:bg-white/15 text-white text-sm font-semibold text-center border border-white/20 hover:border-white/30 py-3.5 md:py-4 px-6 md:px-8 rounded-xl transition-all duration-200 backdrop-blur-sm active:scale-95">
                Get Started
            </a>
        </div>

    </div>

</section>

    <!-- Features -->
    <section class="relative z-20 bg-white py-16 sm:py-20 md:py-28 px-5 sm:px-6">
        <div class="max-w-5xl mx-auto">
    <div class="text-center mb-12 md:mb-16 fade-in px-2">
        <span class="text-emerald-600 font-bold tracking-[0.2em] uppercase text-[10px] sm:text-[11px]">About the System</span>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 md:mt-3 mb-3 md:mb-4 tracking-tight">
            Built for CHMSU<br class="hidden sm:block"> OJT Students
        </h2>
        <p class="text-slate-500 text-sm sm:text-base md:text-lg max-w-xl md:max-w-2xl mx-auto leading-relaxed">
            The CHMSU OJT Manager is your official platform for on-the-job training. Designed to make the entire OJT experience — from enrollment to completion — simple, transparent, and stress-free for students, supervisors, and coordinators alike.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-10 lg:gap-16 items-center">
        <div class="space-y-3 sm:space-y-4 md:space-y-6 fade-in delay-100">

            <div class="flex gap-3 sm:gap-4 p-4 sm:p-5 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 hover:border-emerald-100 hover:shadow-md transition-all duration-200">
                <div class="shrink-0 w-9 h-9 sm:w-10 sm:h-10 bg-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-0.5 sm:mb-1">For Students</h4>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Log your hours, receive tasks, and communicate with your supervisor all in one place.</p>
                </div>
            </div>

            <div class="flex gap-3 sm:gap-4 p-4 sm:p-5 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 hover:border-emerald-100 hover:shadow-md transition-all duration-200">
                <div class="shrink-0 w-9 h-9 sm:w-10 sm:h-10 bg-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-0.5 sm:mb-1">For Supervisors</h4>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">Monitor attendance, assign tasks, and stay connected with your OJT trainees effortlessly.</p>
                </div>
            </div>

            <div class="flex gap-3 sm:gap-4 p-4 sm:p-5 bg-slate-50 rounded-xl sm:rounded-2xl border border-slate-100 hover:border-emerald-100 hover:shadow-md transition-all duration-200">
                <div class="shrink-0 w-9 h-9 sm:w-10 sm:h-10 bg-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-0.5 sm:mb-1">Official & Verified</h4>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">All records are tied to your CHMSU account — making your OJT completion official and verifiable.</p>
                </div>
            </div>

        </div>
                
               <div class="relative fade-in delay-200 mt-4 lg:mt-0">
   {{-- Feature Tour --}}
<div class="space-y-0">

    {{-- Hero --}}
    <div class="text-center py-8 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Everything you need for OJT, in one place</h2>
        <p class="text-sm text-gray-500 max-w-md mx-auto leading-relaxed">Track your hours, complete tasks, log attendance, and stay connected with your supervisor — all from a single dashboard.</p>
    </div>

    {{-- Feature 1: Dashboard --}}
    <div class="flex flex-col sm:flex-row items-center gap-8 py-10 border-b border-gray-100">
        <div class="w-full sm:w-48 h-40 bg-emerald-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg width="120" height="120" viewBox="0 0 140 140" fill="none">
                <circle cx="70" cy="70" r="54" stroke="#9FE1CB" stroke-width="12"/>
                <circle cx="70" cy="70" r="54" stroke="#1D9E75" stroke-width="12" stroke-dasharray="339" stroke-dashoffset="85" stroke-linecap="round" transform="rotate(-90 70 70)"/>
                <text x="70" y="66" text-anchor="middle" font-size="22" font-weight="500" fill="#0F6E56">75%</text>
                <text x="70" y="83" text-anchor="middle" font-size="11" fill="#1D9E75">complete</text>
            </svg>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">01 — Dashboard</p>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Your OJT progress at a glance</h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-3">See your target hours, accumulated hours, remaining hours, and missed time all on one screen. A visual progress ring shows exactly where you stand.</p>
            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Target hours</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Progress ring</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Remaining hours</span>
            </div>
        </div>
    </div>

    {{-- Feature 2: Tasks --}}
    <div class="flex flex-col sm:flex-row-reverse items-center gap-8 py-10 border-b border-gray-100">
        <div class="w-full sm:w-48 h-40 bg-blue-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg width="120" height="120" viewBox="0 0 140 140" fill="none">
                <rect x="20" y="20" width="100" height="100" rx="10" fill="white" stroke="#B5D4F4" stroke-width="1.5"/>
                <rect x="32" y="34" width="55" height="7" rx="3.5" fill="#B5D4F4"/>
                <rect x="32" y="47" width="36" height="5" rx="2.5" fill="#E6F1FB"/>
                <rect x="20" y="62" width="100" height="1" fill="#E6F1FB"/>
                <rect x="32" y="74" width="76" height="8" rx="4" fill="#E6F1FB"/>
                <rect x="32" y="74" width="50" height="8" rx="4" fill="#378ADD"/>
                <text x="57" y="81" text-anchor="middle" font-size="9" fill="white" font-weight="500">67%</text>
                <rect x="32" y="90" width="55" height="5" rx="2.5" fill="#B5D4F4"/>
                <rect x="32" y="102" width="40" height="5" rx="2.5" fill="#E6F1FB"/>
            </svg>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">02 — Tasks</p>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Stay on top of assigned work</h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-3">Your company supervisor assigns tasks directly through the system. Track progress, view due dates, and mark tasks complete in a clean, organized list.</p>
            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Assigned by supervisor</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Progress tracking</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Due dates</span>
            </div>
        </div>
    </div>

    {{-- Feature 3: Logs --}}
    <div class="flex flex-col sm:flex-row items-center gap-8 py-10 border-b border-gray-100">
        <div class="w-full sm:w-48 h-40 bg-amber-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg width="130" height="120" viewBox="0 0 160 140" fill="none">
                <rect x="16" y="20" width="128" height="24" rx="6" fill="#FAC775"/>
                <text x="80" y="36" text-anchor="middle" font-size="10" fill="#633806" font-weight="500">MAY 08, 2026</text>
                <rect x="16" y="52" width="58" height="36" rx="6" fill="white" stroke="#FAC775" stroke-width="1"/>
                <text x="45" y="64" text-anchor="middle" font-size="8" fill="#854F0B">AM SHIFT</text>
                <text x="45" y="76" text-anchor="middle" font-size="9" fill="#633806" font-weight="500">08:00 AM</text>
                <text x="45" y="86" text-anchor="middle" font-size="7" fill="#BA7517">12:00 PM</text>
                <rect x="86" y="52" width="58" height="36" rx="6" fill="white" stroke="#FAC775" stroke-width="1"/>
                <text x="115" y="64" text-anchor="middle" font-size="8" fill="#854F0B">PM SHIFT</text>
                <text x="115" y="76" text-anchor="middle" font-size="9" fill="#633806" font-weight="500">01:00 PM</text>
                <text x="115" y="86" text-anchor="middle" font-size="7" fill="#BA7517">05:00 PM</text>
                <rect x="16" y="96" width="128" height="26" rx="6" fill="white" stroke="#FAC775" stroke-width="1"/>
                <text x="55" y="113" text-anchor="middle" font-size="8" fill="#854F0B">Total</text>
                <text x="110" y="113" text-anchor="middle" font-size="10" fill="#633806" font-weight="500">8h 00m</text>
            </svg>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">03 — Attendance Logs</p>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Your daily time record, always accurate</h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-3">View your full DTR with AM and PM shifts. The system shows your actual arrival and departure times alongside scheduled times so you can see any missed minutes.</p>
            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">AM & PM shifts</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Actual vs scheduled</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Daily total hours</span>
            </div>
        </div>
    </div>

    {{-- Feature 4: Messaging --}}
    <div class="flex flex-col sm:flex-row-reverse items-center gap-8 py-10 border-b border-gray-100">
        <div class="w-full sm:w-48 h-40 bg-purple-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg width="120" height="120" viewBox="0 0 160 140" fill="none">
                <rect x="24" y="20" width="112" height="30" rx="8" fill="white" stroke="#CECBF6" stroke-width="1"/>
                <circle cx="40" cy="35" r="8" fill="#7F77DD"/>
                <text x="40" y="39" text-anchor="middle" font-size="8" fill="white" font-weight="500">S</text>
                <rect x="54" y="29" width="72" height="6" rx="3" fill="#CECBF6"/>
                <rect x="24" y="58" width="112" height="30" rx="8" fill="#7F77DD"/>
                <text x="124" y="78" text-anchor="end" font-size="9" fill="white" font-weight="500">Hello! 👋</text>
                <rect x="24" y="96" width="112" height="30" rx="8" fill="white" stroke="#CECBF6" stroke-width="1"/>
                <circle cx="40" cy="111" r="8" fill="#7F77DD"/>
                <text x="40" y="115" text-anchor="middle" font-size="8" fill="white" font-weight="500">S</text>
                <rect x="54" y="105" width="60" height="6" rx="3" fill="#CECBF6"/>
            </svg>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">04 — Messaging</p>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Direct line to your supervisor</h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-3">Send and receive messages with your company supervisor. Get notified of new messages instantly so you never miss an important update or instruction.</p>
            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Real-time chat</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Unread badges</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Media sharing</span>
            </div>
        </div>
    </div>

    {{-- Feature 5: Notes --}}
    <div class="flex flex-col sm:flex-row items-center gap-8 py-10 border-b border-gray-100">
        <div class="w-full sm:w-48 h-40 bg-green-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg width="120" height="120" viewBox="0 0 160 140" fill="none">
                <rect x="24" y="18" width="112" height="104" rx="10" fill="white" stroke="#C0DD97" stroke-width="1"/>
                <rect x="36" y="30" width="48" height="6" rx="3" fill="#C0DD97"/>
                <rect x="36" y="42" width="88" height="4" rx="2" fill="#EAF3DE"/>
                <rect x="36" y="50" width="72" height="4" rx="2" fill="#EAF3DE"/>
                <rect x="36" y="64" width="88" height="1" fill="#EAF3DE"/>
                <rect x="36" y="72" width="48" height="6" rx="3" fill="#C0DD97"/>
                <rect x="36" y="84" width="88" height="4" rx="2" fill="#EAF3DE"/>
                <rect x="36" y="92" width="60" height="4" rx="2" fill="#EAF3DE"/>
                <circle cx="124" cy="112" r="10" fill="#639922"/>
                <text x="124" y="116" text-anchor="middle" font-size="14" fill="white" font-weight="500">+</text>
            </svg>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">05 — Notes</p>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Your personal journal, always private</h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-3">Jot down reflections, reminders, or ideas during your OJT. Notes are stored locally on your device — private, searchable, and always available.</p>
            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Private & local</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Searchable</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Edit anytime</span>
            </div>
        </div>
    </div>

    {{-- Feature 6: Profile --}}
    <div class="flex flex-col sm:flex-row-reverse items-center gap-8 py-10">
        <div class="w-full sm:w-48 h-40 bg-red-50 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg width="120" height="120" viewBox="0 0 160 140" fill="none">
                <circle cx="80" cy="52" r="22" fill="#F5C4B3"/>
                <circle cx="80" cy="52" r="14" fill="#D85A30"/>
                <text x="80" y="57" text-anchor="middle" font-size="12" fill="white" font-weight="500">WW</text>
                <rect x="36" y="82" width="88" height="8" rx="4" fill="#F5C4B3"/>
                <rect x="48" y="94" width="64" height="6" rx="3" fill="#FAECE7"/>
                <rect x="36" y="108" width="40" height="18" rx="6" fill="#D85A30"/>
                <text x="56" y="120" text-anchor="middle" font-size="8" fill="white" font-weight="500">Edit</text>
                <rect x="84" y="108" width="40" height="18" rx="6" fill="white" stroke="#F5C4B3" stroke-width="1"/>
                <text x="104" y="120" text-anchor="middle" font-size="8" fill="#993C1D" font-weight="500">Password</text>
            </svg>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">06 — Profile</p>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Your identity in the system</h3>
            <p class="text-sm text-gray-500 leading-relaxed mb-3">View and update your personal details, set a profile picture, and manage your password securely. Your profile is what your supervisor sees when reviewing your records.</p>
            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Edit details</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Profile photo</span>
                <span class="text-[11px] font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Change password</span>
            </div>
        </div>
    </div>

</div>
    </div>
    <div class="absolute -z-10 -bottom-3 -right-3 sm:-bottom-4 sm:-right-4 w-full h-full bg-emerald-100 rounded-xl sm:rounded-2xl hidden lg:block"></div>
</div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 sm:py-20 md:py-28 px-5 sm:px-6 bg-slate-50">
        <div class="max-w-2xl mx-auto text-center fade-in px-2">
            <h2 class="text-xl sm:text-2xl md:text-4xl font-extrabold text-slate-900 mb-3 md:mb-4 tracking-tight">
                Ready to start your journey?
            </h2>
            <p class="text-slate-500 mb-6 md:mb-8 text-sm sm:text-base md:text-lg">
                Join hundreds of students already tracking their professional growth.
            </p>
            <a href="/login?mode=register"
               class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-semibold py-3.5 px-6 sm:px-8 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-emerald-900/20 active:scale-95 w-full sm:w-auto">
                Get Started Free
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-12 sm:py-14 md:py-16 px-5 sm:px-6">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start gap-10 md:gap-16">
                <div class="max-w-xs">
                    <div class="flex items-center gap-2.5 mb-4">
                        <img src="images/logo.png" class="w-7 h-7 object-contain">
                        <span class="text-lg font-bold tracking-tight text-slate-900">CHMSU OJT</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Official internship management platform for the Faculty of Engineering and Applied Sciences.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-8 md:gap-12 w-full md:w-auto">
                    <div>
                        <h4 class="font-semibold text-slate-900 text-sm mb-3">Contact</h4>
                        <ul class="text-sm text-slate-400 space-y-2.5">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold text-xs">E</span>
                                <span class="break-all">support@harvard.edu</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold text-xs">P</span>
                                +1 (617) 495-1000
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900 text-sm mb-3">Locations</h4>
                        <ul class="text-sm text-slate-400 space-y-2.5">
                            <li>Cambridge, MA</li>
                            <li>Redmond, WA</li>
                        </ul>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <h4 class="font-semibold text-slate-900 text-sm mb-3">Follow</h4>
                        <div class="flex gap-3">
                            <a href="#" class="w-9 h-9 rounded-lg bg-slate-100 hover:bg-emerald-50 flex items-center justify-center transition-colors group">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="w-9 h-9 rounded-lg bg-slate-100 hover:bg-emerald-50 flex items-center justify-center transition-colors group">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <a href="#" class="w-9 h-9 rounded-lg bg-slate-100 hover:bg-emerald-50 flex items-center justify-center transition-colors group">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-10 sm:mt-12 pt-6 sm:pt-8 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-400 font-medium text-center sm:text-left">© 2026 CHMSU OJT Manager. All rights reserved.</p>
                <div class="flex gap-6 text-xs text-slate-400 font-medium">
                    <a href="#" class="hover:text-slate-600 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-slate-600 transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>