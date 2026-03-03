@extends('layouts.app')

@section('title', 'Profile')

@section('content')



<div id="profileModal" class="fixed inset-0 bg-black/60 z-[100] flex items-center justify-center hidden backdrop-blur-sm p-4 py-10">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in-95 duration-200 flex flex-col max-h-full">
        
        <div class="p-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-black text-gray-800 leading-tight">Complete Profile</h3>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">OJT Requirement Checklist</p>
        </div>

        <div class="p-5 overflow-y-auto custom-scrollbar">
            <form id="profileForm" class="space-y-6">
                
                <div class="flex items-center gap-3 p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <div class="h-12 w-12 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-600 flex-shrink-0 border-2 border-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[9px] font-black text-emerald-800 uppercase tracking-widest leading-none">Profile Photo</label>
                        <input type="file" class="block w-full text-[10px] text-gray-500 mt-1 file:mr-2 file:py-0.5 file:px-2 file:rounded-md file:border-0 file:text-[9px] file:font-bold file:bg-emerald-600 file:text-white cursor-pointer">
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-2 mb-1 px-1">
                        <h4 class="text-[10px] font-black text-gray-800 uppercase tracking-widest">Academic Info</h4>
                    </div>
                    
                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">School Name</label>
                        <input type="text" placeholder="University Name" class="w-full mt-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 transition-all">
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Course</label>
                            <input type="text" placeholder="BSIT" class="w-full mt-1 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Year</label>
                            <select class="w-full mt-1 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                                <option>3rd</option>
                                <option>4th</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Section</label>
                            <input type="text" placeholder="A, B, C" class="w-full mt-1 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-2 mb-1 px-1">
                        <h4 class="text-[10px] font-black text-gray-800 uppercase tracking-widest">Location</h4>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">School Address</label>
                        <textarea rows="2" placeholder="Street, City..." class="w-full mt-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 resize-none"></textarea>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-1">Home Address</label>
                        <textarea rows="2" placeholder="Street, Barangay..." class="w-full mt-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 resize-none"></textarea>
                    </div>
                </div>

              <div class="space-y-4 pb-2">
    <div class="flex items-center gap-2 mb-1 px-1 border-b border-gray-100 pb-2">
        <h4 class="text-[10px] font-black text-gray-800 uppercase tracking-widest">Contact Information</h4>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <div>
            <div class="flex justify-between items-center mb-1.5 px-1">
                <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Primary Contact</label>
                <span class="text-[8px] font-bold text-gray-400 uppercase italic">Student Mobile No.</span>
            </div>
            <div class="relative">
                <input type="tel" placeholder="09** *** ****" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 transition-all pl-10">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
            </div>
        </div>

       <div class="space-y-3">
    <div>
        <div class="flex justify-between items-center mb-1.5 px-1">
            <label class="text-[9px] font-black text-red-400 uppercase tracking-widest">Emergency Contact</label>
            <span class="text-[8px] font-bold text-gray-400 uppercase italic">Parent / Guardian</span>
        </div>
        <div class="relative">
            <input type="text" placeholder="Name (Relationship)" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-red-400 transition-all pl-10">
            <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="relative">
        <input type="tel" placeholder="09** *** ****" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-red-400 transition-all pl-10">
        <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-gray-400">
           <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
             <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
        </div>
    </div>
</div>
    </div>
</div>
            </form>
        </div>

        <div class="p-5 bg-gray-50 border-t border-gray-100 flex gap-2">
            <button id="closeProfile" class="flex-1 py-2.5 px-4 bg-white border border-gray-200 text-gray-500 rounded-xl text-[11px] font-black hover:bg-gray-100 transition active:scale-95 uppercase">
                Cancel
            </button>
            <button class="flex-[2] py-2.5 px-4 bg-emerald-600 text-white rounded-xl text-[11px] font-black hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition active:scale-95 uppercase">
                Save Profile
            </button>
        </div>
    </div>
</div>



    <div class="flex flex-col md:flex-row gap-6">
        <div class="flex-1 bg-white p-8 rounded-3xl border border-gray-300 shadow-sm text-center md:text-left">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="h-24 w-24 rounded-full bg-emerald-500 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-emerald-100 border-4 border-white">
                    CK
                </div>
                <div>
                    <h2 class="text-2xl font-black text-gray-800">Charlie Kirk</h2>
                    <p class="text-sm font-bold text-emerald-600 uppercase tracking-widest mt-1">IT Trainee • RRL Tech Solutions</p>
                    <p class="text-xs text-gray-400 font-medium mt-1">charlie.kirk.@neck.edu</p>
                </div>
            </div>
            
          <div class="mt-8 space-y-3">
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-gray-50/50 p-3 rounded-2xl border border-gray-200 text-center hover:border-emerald-200 transition-colors">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none">Student ID</p>
            <p class="text-[13px] font-black text-gray-700 mt-1.5">2021-0452-A</p>
        </div>

        <div class="bg-gray-50/50 p-3 rounded-2xl border border-gray-200 text-center hover:border-emerald-200 transition-colors">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none">Class Info</p>
            <p class="text-[13px] font-black text-gray-700 mt-1.5">BSIT - 4A</p>
        </div>
    </div>

    <div class="bg-emerald-50/30 p-4 rounded-2xl border border-emerald-100 text-center group transition-all duration-300 hover:bg-emerald-50">
        <div class="flex items-center justify-center gap-2 mb-1">
            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/>
            </svg>
            <p class="text-[9px] font-black text-emerald-600/70 uppercase tracking-[0.2em] leading-none">Official University</p>
        </div>
        <p class="text-sm font-black text-gray-800 tracking-tight">Harvard University</p>
    </div>
</div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Contact Number</p>
                    <p class="text-sm font-black text-gray-800">0912 345 6789</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Emergency Contact</p>
                    <p class="text-sm font-black text-red-500 uppercase text-[10px]">Required</p>
                </div>
            </div>
        </div>

        <div class="w-full md:w-80 bg-white p-6 rounded-3xl border border-gray-300 shadow-sm">
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <button id="openProfileModal" class="w-full py-3 px-4 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition flex items-center justify-between group shadow-md shadow-emerald-100 active:scale-95">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Complete Profile
                    </div>
                    <span class="flex h-2 w-2 rounded-full bg-white animate-pulse"></span>
                </button>
                <button class="w-full py-3 px-4 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit Personal Info
                </button>
                <button class="w-full py-3 px-4 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Change Password
                </button>
            </div>
        </div>
    </div>

  <div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-gray-300 shadow-sm overflow-hidden relative">
        <div class="flex items-center gap-2 mb-6">
            <div class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Active Training Summary</h3>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 relative z-10">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Start Date</p>
                <p class="text-sm font-black text-gray-800">Jan 15, 2026</p>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">End Date</p>
                <p class="text-sm font-black text-gray-800">Apr 30, 2026</p>
            </div>
            <div class="col-span-2 md:col-span-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Supervisor</p>
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-sm font-black text-emerald-600">Sarah Miller</p>
                </div>
            </div>
        </div>
        <div class="absolute -right-12 -bottom-12 w-32 h-32 bg-emerald-50 rounded-full opacity-60"></div>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-300 shadow-sm overflow-hidden relative">
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Home and School Addresses</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">School Address</p>
                </div>
                <p class="text-xs font-bold text-gray-800 leading-relaxed">Tokyo, Japan</p>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Home Address</p>
                </div>
                <p class="text-xs font-bold text-black">Hidden Leaf Village</p>
            </div>
        </div>
    </div>
</div>

@endsection