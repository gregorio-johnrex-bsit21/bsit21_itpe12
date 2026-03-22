        <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 px-4 md:px-8 py-4 flex justify-between items-center">

            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 hover:bg-slate-100 rounded-lg text-slate-500 transition-colors">
                    <i class="fas fa-bars-staggered"></i>
                </button>
                <div class="hidden sm:block">
                    <p class="text-lg font-bold text-slate-800">@yield('page_title')</p>
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-4">

                {{-- Messages --}}
                <div class="relative">
                   <button @click="msgOpen = !msgOpen; notifOpen = false; profileOpen = false"
                    class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 relative transition-all">
                    <i class="far fa-comment-alt text-xl"></i>
                     <span id="totalUnreadBadge" class="absolute top-2 right-2 w-4 h-4 bg-[#2E7D32] border-2 border-white rounded-full text-[10px] text-white font-bold items-center justify-center hidden"></span>
                  </button>

                    <div x-show="msgOpen" @click.away="msgOpen = false" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-3 w-80 bg-white rounded-[1.5rem] shadow-xl border border-slate-100 overflow-hidden z-50">

                        <div class="p-4 border-b border-slate-50 bg-slate-50/50 flex justify-between items-center">
                            <span class="font-black text-slate-800 text-xs uppercase tracking-widest">Messages</span>
                            <i class="fas fa-edit text-slate-400 hover:text-[#2E7D32] cursor-pointer text-sm"></i>
                        </div>

                        <div class="max-h-80 overflow-y-auto custom-scrollbar">
   <div class="max-h-80 overflow-y-auto custom-scrollbar" id="conversationList">
    <p class="text-center text-xs text-slate-400 p-4">Loading...</p>
   </div>
</div>
                    </div>
                </div>

                {{-- Notifications --}}
                <div class="relative">
                    <button @click="notifOpen = !notifOpen; msgOpen = false; profileOpen = false"
                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 relative transition-all">
                        <i class="far fa-bell text-xl"></i>
                        <span class="absolute top-2 right-2 w-4 h-4 bg-[#D50000] border-2 border-white rounded-full text-[10px] text-white font-bold flex items-center justify-center">3</span>
                    </button>

                    <div x-show="notifOpen" @click.away="notifOpen = false" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-3 w-80 bg-white rounded-[1.5rem] shadow-xl border border-slate-100 overflow-hidden">
                        <div class="p-4 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                            <span class="font-black text-slate-800 text-xs uppercase tracking-widest">Notifications</span>
                            <span class="text-[10px] text-[#2E7D32] font-bold cursor-pointer">Mark all read</span>
                        </div>
                        <div class="max-h-72 overflow-y-auto custom-scrollbar">
                            <template x-for="i in 3">
                                <div class="p-4 hover:bg-slate-50 border-b border-slate-50 cursor-pointer transition-colors">
                                    <p class="text-sm font-bold text-slate-800">New Log Submission</p>
                                    <p class="text-xs text-slate-500 line-clamp-1">Marcus Wright submitted 8 hours for Feb 22.</p>
                                    <p class="text-[10px] text-slate-400 mt-1 uppercase font-medium">2 mins ago</p>
                                </div>
                            </template>
                        </div>
                        <div class="p-3 text-center border-t border-slate-50">
                            <button class="text-xs font-bold text-slate-400 hover:text-[#2E7D32] transition-colors">View All Notifications</button>
                        </div>
                    </div>
                </div>

                {{-- Profile --}}
                <div class="relative flex items-center pl-4 border-l border-slate-200 ml-2">
                    <button @click="profileOpen = !profileOpen; notifOpen = false; msgOpen = false"
                            class="flex items-center gap-3 group focus:outline-none">
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen; view = 'main'" class="flex items-center justify-center h-10 w-10 rounded-full bg-emerald-500 text-white text-sm font-bold hover:bg-emerald-600 transition-all shadow-sm focus:outline-none">
                {{ strtoupper(substr(explode(' ', session('supervisor')->name)[0], 0, 1)) . strtoupper(substr(explode(' ', session('supervisor')->name)[1] ?? '', 0, 1)) }}
            </button>
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                    </button>

                    <div x-show="profileOpen" @click.away="profileOpen = false" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="absolute right-0 top-full mt-3 w-64 bg-white rounded-[1.5rem] shadow-xl border border-slate-100 py-2">

                        <div class="px-4 py-3 border-b border-slate-50 mb-1">
                            <p class="text-[15px] font-black text-slate-400 uppercase tracking-widest">ACCOUNT</p>
                            <p class="text-[12px] font-bold text-slate-400 truncate">{{ session('supervisor')->name }}</p>
                            
                        </div>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-green-50 hover:text-[#2E7D32] transition-all">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-[#2E7D32]">
                                <i class="far fa-user text-sm"></i>
                            </div>
                            Profile Settings
                        </a>
                        <a href="#" onclick="document.getElementById('changePasswordModal').classList.remove('hidden')" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <i class="fas fa-cog text-sm"></i>
                            </div>
                            Account Security
                        </a>
                        <hr class="my-2 border-slate-50">
                        <a href="#" onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-[#D50000] hover:bg-red-50 transition-all">
                           <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-[#D50000]">
                           <i class="fas fa-sign-out-alt text-sm"></i>
                           </div>
                          Logout
                        </a>
                    </div>
                </div>

                {{-- Change Password Modal --}}
<div id="changePasswordModal" class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-sm mx-4">
        
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-black text-slate-800">Change Password</h3>
            <button onclick="document.getElementById('changePasswordModal').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Success/Error Message --}}
        <div id="changePwMsg" class="hidden rounded-2xl px-4 py-3 mb-4 text-sm text-center font-bold"></div>

        <div class="space-y-4">
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 block">Current Password</label>
                <input type="password" id="currentPassword" 
                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-[#2E7D32] text-sm transition-colors"
                    placeholder="Enter current password">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 block">New Password</label>
                <input type="password" id="newPassword"
                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-[#2E7D32] text-sm transition-colors"
                    placeholder="Enter new password">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1 block">Confirm New Password</label>
                <input type="password" id="confirmNewPassword"
                    class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:outline-none focus:border-[#2E7D32] text-sm transition-colors"
                    placeholder="Confirm new password">
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('changePasswordModal').classList.add('hidden')"
                class="flex-1 py-3 rounded-2xl border border-slate-200 text-slate-600 text-sm font-bold hover:bg-slate-50 transition-all">
                Cancel
            </button>
            <button onclick="changePassword()"
                class="flex-1 py-3 rounded-2xl bg-[#2E7D32] text-white text-sm font-bold hover:bg-[#256629] transition-all">
                Update Password
            </button>
        </div>
    </div>
</div>

</div>


            


            
<script>
function logoutSupervisor() {
    fetch("{{ route('supervisor.logout') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        }
    });
}

function changePassword() {
    const current = document.getElementById('currentPassword').value.trim();
    const newPass = document.getElementById('newPassword').value.trim();
    const confirm = document.getElementById('confirmNewPassword').value.trim();
    const msg = document.getElementById('changePwMsg');

    if (!current || !newPass || !confirm) {
        msg.className = 'rounded-2xl px-4 py-3 mb-4 text-sm text-center font-bold bg-red-50 text-red-500';
        msg.innerText = 'Please fill in all fields.';
        msg.classList.remove('hidden');
        return;
    }

    if (newPass !== confirm) {
        msg.className = 'rounded-2xl px-4 py-3 mb-4 text-sm text-center font-bold bg-red-50 text-red-500';
        msg.innerText = 'New passwords do not match.';
        msg.classList.remove('hidden');
        return;
    }

    if (newPass.length < 6) {
        msg.className = 'rounded-2xl px-4 py-3 mb-4 text-sm text-center font-bold bg-red-50 text-red-500';
        msg.innerText = 'Password must be at least 6 characters.';
        msg.classList.remove('hidden');
        return;
    }

    fetch("{{ route('supervisor.change.password') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            current_password: current,
            new_password: newPass
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            msg.className = 'rounded-2xl px-4 py-3 mb-4 text-sm text-center font-bold bg-emerald-50 text-emerald-600';
            msg.innerText = 'Password updated successfully!';
            msg.classList.remove('hidden');
            // Clear fields
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmNewPassword').value = '';
        } else {
            msg.className = 'rounded-2xl px-4 py-3 mb-4 text-sm text-center font-bold bg-red-50 text-red-500';
            msg.innerText = data.message;
            msg.classList.remove('hidden');
        }
    });
}
</script>
        </header>