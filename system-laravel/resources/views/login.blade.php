<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emerald Portal – Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background: #f0fdf4;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(16,185,129,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(5,150,105,0.06) 0%, transparent 50%);
            min-height: 100vh;
        }

        @keyframes boxSlideUp {
            0%   { opacity: 0; transform: translateY(28px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes boxSlideOut {
            0%   { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-28px); }
        }

        .box-animate-in  { animation: boxSlideUp  0.55s cubic-bezier(.22,.68,0,1.2) forwards; }
        .box-animate-out { animation: boxSlideOut 0.35s ease-in-out forwards; }

        /* Floating label */
        .input-group { position: relative; }
        .floating-label {
            position: absolute;
            left: 2.75rem;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.2s ease-in-out;
            pointer-events: none;
            color: #9ca3af;
            font-size: 0.875rem;
        }
        .floating-input:focus ~ .floating-label,
        .floating-input:not(:placeholder-shown) ~ .floating-label {
            top: 0;
            font-size: 0.62rem;
            font-weight: 700;
            color: #10b981;
            transform: translateY(0.4rem);
        }
        .floating-input { padding-top: 1.25rem; padding-bottom: 0.5rem; }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 0.8rem;
            transition: color 0.15s;
        }
        .pw-toggle:hover { color: #10b981; }

        /* Spinner on button */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner {
            display: inline-block;
            width: 1rem; height: 1rem;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 0.4rem;
        }
        #user-id { text-transform: uppercase; }
    </style>
</head>
<body class="min-h-screen bg-white sm:flex sm:items-center sm:justify-center sm:p-6">

    {{-- ───── MAIN LOGIN / REGISTER BOX ───── --}}
    <div id="main-box" 
         class="opacity-0 w-full min-h-screen sm:min-h-0 bg-white sm:rounded-3xl sm:shadow-2xl sm:max-w-[390px] overflow-hidden">

        <div class="px-6 pt-16 pb-8 sm:p-8 md:p-10 flex flex-col sm:block min-h-screen sm:min-h-0">

            {{-- Logo --}}
            <div class="text-center font-bold mb-10 sm:mb-7 flex flex-col items-center gap-3">
                <img src="/images/logo.png" class="w-20 h-20 object-contain">
                <div>
                    <span class="text-emerald-500 text-xl tracking-tight">OJT Manager</span>
                    <span class="text-gray-700 text-xl tracking-tight">Portal</span>
                </div>

                {{-- Mobile subtitle --}}
                <p class="text-gray-400 text-sm sm:hidden">
                    Log in to your account
                </p>
            </div>

            {{-- Alerts --}}
            <div id="error-msg" class="hidden bg-red-50 border border-red-200 text-red-500 text-xs rounded-2xl px-4 py-3 mb-4 text-center"></div>
            <div id="success-msg" class="hidden bg-emerald-50 border border-emerald-200 text-emerald-600 text-xs rounded-2xl px-4 py-3 mb-4 text-center"></div>

            {{-- Title (hidden on mobile only) --}}
            <h2 id="form-title" class="hidden sm:block text-2xl font-bold text-gray-800 mb-1">Welcome Back</h2>
            <p id="form-subtitle" class="hidden sm:block text-gray-400 text-sm mb-6">Enter your credentials to continue.</p>

            <form id="auth-form" class="flex flex-col space-y-4" onsubmit="handleSubmit(event)" autocomplete="off">
                @csrf

                {{-- Full Name --}}
                <div id="name-field" class="hidden input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                    <i class="fa fa-user text-gray-400 ml-4 mt-2 w-4"></i>
                    <input type="text" id="name" name="name" placeholder=" "
                           class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                    <label class="floating-label">Full Name</label>
                </div>

                {{-- User ID --}}
                <div class="input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                  <i class="fa fa-id-card text-gray-400 ml-4 mt-2 w-4"></i>
                    <input type="text" id="user-id" name="user_id" placeholder=" "
                        class="floating-input bg-transparent px-3 outline-none text-sm w-full uppercase" oninput="this.value = this.value.toUpperCase()" autocomplete="off">
                  <label id="id-label" class="floating-label">User ID</label>
                </div>

                {{-- Company --}}
                <div id="company-field" class="hidden input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                    <i class="fa fa-building text-gray-400 ml-4 mt-2 w-4"></i>
                    <input type="text" id="company-id" name="company_id" placeholder=" "
                           class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                    <label class="floating-label">Company ID</label>
                </div>

                {{-- Password --}}
                <div class="input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                    <i class="fa fa-lock text-gray-400 ml-4 mt-2 w-4"></i>
                    <input type="password" id="password" name="password" placeholder=" "
                           class="floating-input bg-transparent px-3 outline-none text-sm w-full pr-10">
                    <label class="floating-label">Password</label>
                    <span class="pw-toggle" onclick="togglePw('password', this)">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </div>

                {{-- Confirm --}}
                <div id="confirm-field" class="hidden input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                    <i class="fa fa-shield-halved text-gray-400 ml-4 mt-2 w-4"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder=" "
                           class="floating-input bg-transparent px-3 outline-none text-sm w-full pr-10">
                    <label class="floating-label">Confirm Password</label>
                    <span class="pw-toggle" onclick="togglePw('password_confirmation', this)">
                        <i class="fa fa-eye-slash"></i>
                    </span>
                </div>

                <input type="hidden" id="approved-id" value="">

                <button type="submit" id="main-btn"
                        class="w-full bg-emerald-500 text-white rounded-2xl py-4 font-bold mt-4 sm:mt-2 sm:shadow-lg sm:shadow-emerald-100 active:scale-95 flex items-center justify-center gap-2">
                    Login
                </button>
            </form>

            {{-- Toggle --}}
            <div class="text-center mt-6">
                <p class="text-gray-400 text-sm">
                    <span id="prompt-text">Don't have an account?</span>
                    <button id="toggle-btn" class="text-emerald-500 font-bold ml-1 hover:text-emerald-600 transition-colors">
                        Sign Up
                    </button>
                </p>
            </div>

        </div>
    </div>

    {{-- ───── PENDING / APPROVED STATUS BOX (WRAPPED IN OVERLAY) ───── --}}
    <div id="pendingWrapper" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-white/80 sm:bg-transparent backdrop-blur-sm sm:backdrop-blur-none">
        <div id="pendingModal" class="bg-white rounded-3xl shadow-2xl w-full max-w-[390px] overflow-hidden box-animate-in">
            <div class="p-8 md:p-10 text-center">

                <div class="text-center font-bold mb-7">
                    <span class="text-emerald-500 text-xl tracking-tight">Emerald</span><span class="text-gray-700 text-xl tracking-tight">Portal</span>
                </div>

                {{-- Pending icon --}}
                <div id="pendingIcon" class="flex items-center justify-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-emerald-50 flex items-center justify-center">
                        <svg class="w-12 h-12 text-emerald-500 animate-spin" style="animation-duration:3s"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Approved icon --}}
                <div id="approvedIcon" class="hidden flex items-center justify-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-emerald-50 flex items-center justify-center">
                        <svg class="w-12 h-12 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <h2 id="statusTitle"   class="text-2xl font-bold text-gray-800 mb-2">Pending Approval</h2>
                <p  id="statusMessage" class="text-gray-400 text-sm mb-8">
                    Your registration is being reviewed by your supervisor. Please wait.
                </p>

                <button id="loginNowBtn"
                        class="hidden w-full bg-emerald-500 text-white rounded-2xl py-4 font-bold hover:bg-emerald-600 transition-all shadow-lg active:scale-95"
                        onclick="showLoginForm(false)">
                    Login Now
                </button>

            </div>
        </div>
    </div>

   <script>
    // ── DOM refs ──────────────────────────────────────────────────────────
    const mainBox        = document.getElementById('main-box');
    const pendingWrapper = document.getElementById('pendingWrapper');
    const formTitle      = document.getElementById('form-title');
    const formSubtitle   = document.getElementById('form-subtitle');
    const mainBtn        = document.getElementById('main-btn');
    const promptText     = document.getElementById('prompt-text');
    const toggleBtn      = document.getElementById('toggle-btn');
    const idLabel        = document.getElementById('id-label');
    const errorMsg       = document.getElementById('error-msg');
    const successMsg     = document.getElementById('success-msg');

    const registerFields = {
        name:    document.getElementById('name-field'),
        company: document.getElementById('company-field'),
        confirm: document.getElementById('confirm-field'),
    };

    // ── State ─────────────────────────────────────────────────────────────
    const urlParams = new URLSearchParams(window.location.search);
    let isLogin = urlParams.get('mode') !== 'register';
    let statusPollInterval = null;

    // ── Boot ──────────────────────────────────────────────────────────────
    applyMode();
    mainBox.classList.remove('opacity-0');
    mainBox.classList.add('box-animate-in');

    // ── Helpers ───────────────────────────────────────────────────────────
    function applyMode() {
        if (isLogin) {
            formTitle.innerText    = 'Welcome Back';
            formSubtitle.innerText = 'Enter your credentials to continue.';
            mainBtn.innerText      = 'Login';
            promptText.innerText   = "Don't have an account?";
            toggleBtn.innerText    = 'Sign Up';
            idLabel.innerText      = 'User ID';
            Object.values(registerFields).forEach(f => f.classList.add('hidden'));
        } else {
            formTitle.innerText    = 'Create Account';
            formSubtitle.innerText = 'Register for your student account.';
            mainBtn.innerText      = 'Register';
            promptText.innerText   = 'Already a member?';
            toggleBtn.innerText    = 'Sign In';
            idLabel.innerText      = 'Student ID';
            Object.values(registerFields).forEach(f => f.classList.remove('hidden'));
        }
    }

    function showError(msg) {
        errorMsg.innerText = msg;
        errorMsg.classList.remove('hidden');
        successMsg.classList.add('hidden');
    }

    function showSuccess(msg) {
        successMsg.innerText = msg;
        successMsg.classList.remove('hidden');
        errorMsg.classList.add('hidden');
    }

    function clearAlerts() {
        errorMsg.classList.add('hidden');
        successMsg.classList.add('hidden');
    }

    function setLoading(loading) {
        if (loading) {
            mainBtn.disabled = true;
            mainBtn.innerHTML = '<span class="spinner"></span> Please wait…';
        } else {
            mainBtn.disabled = false;
            mainBtn.innerText = isLogin ? 'Login' : 'Register';
        }
    }

    function togglePw(inputId, icon) {
        const input = document.getElementById(inputId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.innerHTML = isHidden
            ? '<i class="fa fa-eye"></i>'
            : '<i class="fa fa-eye-slash"></i>';
    }

    // ── Toggle login ↔ register ───────────────────────────────────────────
    toggleBtn.addEventListener('click', () => {
        clearAlerts();
        mainBox.classList.remove('box-animate-in');
        mainBox.classList.add('box-animate-out');

        setTimeout(() => {
            isLogin = !isLogin;
            applyMode();
            mainBox.classList.remove('box-animate-out');
            void mainBox.offsetWidth;
            mainBox.classList.add('box-animate-in');
        }, 350);
    });

    // ── Submit ────────────────────────────────────────────────────────────
    async function handleSubmit(event) {
        event.preventDefault();
        clearAlerts();

        const userId   = document.getElementById('user-id').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!userId || !password) {
            showError('Please fill in all required fields.');
            return;
        }

        setLoading(true);

        try {
            if (isLogin) {
                const res = await fetch("{{ route('login.post') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ user_id: userId, password })
                });

                const data = await res.json();

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    showError(data.message);
                }

            } else {
                const name            = document.getElementById('name').value.trim();
                const companyId       = document.getElementById('company-id').value.trim();
                const passwordConfirm = document.getElementById('password_confirmation').value.trim();

                const res = await fetch("{{ route('students.register') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name,
                        student_id: userId,
                        company_id: companyId,
                        password,
                        password_confirmation: passwordConfirm
                    })
                });

                const data = await res.json();

                if (data.success) {
                    clearInterval(statusPollInterval);
                    mainBox.classList.add('hidden');
                    pendingWrapper.classList.remove('hidden');
                    startPollingStatus(userId);
                } else {
                    showError(data.message ?? 'Something went wrong.');
                }
            }
        } catch (e) {
            showError('Network error. Please try again.');
        } finally {
            setLoading(false);
        }
    }

    // ── Pending status polling ────────────────────────────────────────────
    function startPollingStatus(studentId) {
        clearInterval(statusPollInterval);

        statusPollInterval = setInterval(() => {
            fetch(`/validation/status?student_id=${studentId}`)
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'Active') {
                    clearInterval(statusPollInterval);
                    document.getElementById('approved-id').value = studentId;
                    showApproved();
                    } else if (data.status === 'Rejected') {
                        clearInterval(statusPollInterval);
                        showRejected();
                    }
                    // 'Inactive' = still pending, keep polling
                })
                .catch(() => {
                    clearInterval(statusPollInterval);
                    showRejected();
                });
        }, 5000);
    }

    function showApproved() {
        document.getElementById('pendingIcon').classList.add('hidden');
        document.getElementById('approvedIcon').classList.remove('hidden');
        document.getElementById('statusTitle').innerText   = 'Request Approved!';
        document.getElementById('statusMessage').innerText = 'Your registration has been approved. You can now login!';

        const loginBtn = document.getElementById('loginNowBtn');
        loginBtn.innerText = 'Login Now';
        loginBtn.style.background = '';
        loginBtn.style.boxShadow  = '';
        loginBtn.classList.remove('hidden');
        loginBtn.onclick = () => showLoginForm(true);
    }

    function showRejected() {
        document.getElementById('pendingIcon').classList.add('hidden');
        document.getElementById('approvedIcon').classList.add('hidden');

        // Avoid duplicate rejected icons
        if (!document.querySelector('.rejected-icon')) {
            const rejectedIcon = document.createElement('div');
            rejectedIcon.className = 'rejected-icon flex items-center justify-center mb-6';
            rejectedIcon.innerHTML = `
                <div class="w-24 h-24 rounded-full bg-red-50 flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>`;
            document.getElementById('statusTitle').parentNode.insertBefore(
                rejectedIcon,
                document.getElementById('statusTitle')
            );
        }

        document.getElementById('statusTitle').innerText   = 'Request Rejected';
        document.getElementById('statusMessage').innerText = 'Your registration has been rejected. Please contact your supervisor.';

        const loginBtn = document.getElementById('loginNowBtn');
        loginBtn.innerText = 'Register Again';
        loginBtn.classList.remove('hidden');
        loginBtn.style.background = '#ef4444';
        loginBtn.style.boxShadow  = '0 4px 14px rgba(239,68,68,0.3)';
    }

    function showLoginForm(fromApproval = false) {
        clearInterval(statusPollInterval);

        // Clean up rejected icon so it doesn't duplicate
        const rejectedIcon = document.querySelector('.rejected-icon');
        if (rejectedIcon) rejectedIcon.remove();

        // Reset pending modal back to original state
        document.getElementById('pendingIcon').classList.remove('hidden');
        document.getElementById('approvedIcon').classList.add('hidden');
        document.getElementById('statusTitle').innerText   = 'Pending Approval';
        document.getElementById('statusMessage').innerText = 'Your registration is being reviewed by your supervisor. Please wait.';

        const loginBtn = document.getElementById('loginNowBtn');
        loginBtn.classList.add('hidden');
        loginBtn.style.background = '';
        loginBtn.style.boxShadow  = '';

        pendingWrapper.classList.add('hidden');
        mainBox.classList.remove('hidden');
        mainBox.classList.add('box-animate-in');

        // Clear all fields
        document.getElementById('name').value                  = '';
        document.getElementById('user-id').value               = '';
        document.getElementById('company-id').value            = '';
        document.getElementById('password').value              = '';
        document.getElementById('password_confirmation').value = '';
        clearAlerts();

        // Always go to register after rejection
    if (fromApproval) {
    isLogin = true;
    applyMode();
    const approvedId = document.getElementById('approved-id').value;
    if (approvedId) {
        document.getElementById('user-id').value = approvedId;
        setTimeout(() => document.getElementById('password').focus(), 400);
    }
    } else {
    isLogin = false;
    applyMode();
    }
           }
</script>
</body>
</html>