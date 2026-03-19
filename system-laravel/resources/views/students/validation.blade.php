<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emerald Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap');
        
        body { 
            font-family: 'Montserrat', sans-serif; 
            background: #f8fafc;
        }

        @keyframes boxSlideUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes boxSlideOut {
            0% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-30px); }
        }

        .box-animate-in { animation: boxSlideUp 0.6s ease-in-out forwards; }
        .box-animate-out { animation: boxSlideOut 0.4s ease-in-out forwards; }

        .input-group { position: relative; }

        .floating-label {
            position: absolute;
            left: 2.75rem;
            top: 50%;
            transform: translateY(-50%);
            background-color: transparent;
            transition: all 0.2s ease-in-out;
            pointer-events: none;
            color: #9ca3af; 
            font-size: 0.875rem;
        }

        .floating-input:focus ~ .floating-label,
        .floating-input:not(:placeholder-shown) ~ .floating-label {
            top: 0;
            left: 2.75rem;
            font-size: 0.65rem;
            font-weight: 700;
            color: #10b981; 
            transform: translateY(0.4rem);
        }

        .floating-input {
            padding-top: 1.25rem;
            padding-bottom: 0.5rem;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div id="main-box" class="opacity-0 bg-white rounded-3xl shadow-2xl w-full max-w-[380px] overflow-hidden">
        <div class="p-8 md:p-10">
            
            <div class="text-center font-bold mb-8">
                <span class="text-emerald-500 text-xl tracking-tight">Student</span><span class="text-gray-700 text-xl tracking-tight">Portal</span>
            </div>

            <!-- Message Box -->
            <div id="error-msg" class="hidden bg-red-50 border border-red-200 text-red-500 text-sm rounded-2xl px-4 py-3 mb-4 text-center"></div>
            <div id="success-msg" class="hidden bg-emerald-50 border border-emerald-200 text-emerald-500 text-sm rounded-2xl px-4 py-3 mb-4 text-center"></div>

            <div id="form-container">
                <h2 id="form-title" class="text-2xl font-bold text-gray-800 mb-1">Welcome Back</h2>
                <p id="form-subtitle" class="text-gray-400 text-sm mb-8">Enter your credentials to login.</p>

                <form id="login-form" class="flex flex-col space-y-4" onsubmit="handleSubmit(event)">
                    @csrf

                    {{-- Name Field (register only) --}}
                    <div id="name-field" class="hidden input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                        <i class="fa fa-user text-gray-400 ml-4 mt-2 w-4"></i>
                        <input type="text" id="name" name="name" placeholder=" " class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                        <label class="floating-label">Full Name</label>
                    </div>

                    {{-- Student ID --}}
                    <div class="input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                        <i class="fa fa-id-card text-gray-400 ml-4 mt-2 w-4"></i>
                        <input type="text" id="student-id" name="student_id" placeholder=" " class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                        <label class="floating-label">Student ID</label>
                    </div>

                    {{-- Company ID (register only) --}}
                    <div id="company-field" class="hidden input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                        <i class="fa fa-building text-gray-400 ml-4 mt-2 w-4"></i>
                        <input type="text" id="company-id" name="company_id" placeholder=" " class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                        <label class="floating-label">Company ID</label>
                    </div>

                    {{-- Password --}}
                    <div class="input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                        <i class="fa fa-lock text-gray-400 ml-4 mt-2 w-4"></i>
                        <input type="password" id="password" name="password" placeholder=" " class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                        <label class="floating-label">Password</label>
                    </div>

                    {{-- Confirm Password (register only) --}}
                    <div id="confirm-field" class="hidden input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-emerald-500 transition-colors">
                        <i class="fa fa-shield-halved text-gray-400 ml-4 mt-2 w-4"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder=" " class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                        <label class="floating-label">Confirm Password</label>
                    </div>

                    <button type="submit" id="main-btn" class="w-full bg-emerald-500 text-white rounded-2xl py-4 font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-50/50 mt-4 active:scale-95">
                        Login
                    </button>
                </form>

                <div class="text-center mt-8">
                    <p class="text-gray-400 text-sm">
                        <span id="prompt-text">Don't have an account?</span>
                        <button id="toggle-btn" class="text-emerald-500 font-bold ml-1 hover:text-emerald-600 transition-colors">Sign Up</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-btn');
        const mainBox = document.getElementById('main-box');
        const formTitle = document.getElementById('form-title');
        const formSubtitle = document.getElementById('form-subtitle');
        const mainBtn = document.getElementById('main-btn');
        const promptText = document.getElementById('prompt-text');
        const errorMsg = document.getElementById('error-msg');
        const successMsg = document.getElementById('success-msg');

        const fields = {
            name: document.getElementById('name-field'),
            company: document.getElementById('company-field'),
            confirm: document.getElementById('confirm-field')
        };

        const urlParams = new URLSearchParams(window.location.search);
        const mode = urlParams.get('mode');
        let isLogin = mode !== 'register';

        if (!isLogin) {
            formTitle.innerText = "Create Account";
            formSubtitle.innerText = "Register for your student account.";
            mainBtn.innerText = "Register";
            promptText.innerText = "Already a member?";
            toggleBtn.innerText = "Sign In";
            Object.values(fields).forEach(field => field.classList.remove('hidden'));
        }

        mainBox.classList.remove('opacity-0');
        mainBox.classList.add('box-animate-in');

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

        async function handleSubmit(event) {
            event.preventDefault();
            errorMsg.classList.add('hidden');
            successMsg.classList.add('hidden');

            const studentId = document.getElementById('student-id').value.trim();
            const password = document.getElementById('password').value.trim();

            if (isLogin) {
                // LOGIN
                const res = await fetch("{{ route('students.login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ student_id: studentId, password: password })
                });

                const data = await res.json();

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    showError(data.message);
                }

            } else {
                // REGISTER
                const name = document.getElementById('name').value.trim();
                const companyId = document.getElementById('company-id').value.trim();
                const passwordConfirmation = document.getElementById('password_confirmation').value.trim();

                const res = await fetch("{{ route('students.register') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: name,
                        student_id: studentId,
                        company_id: companyId,
                        password: password,
                        password_confirmation: passwordConfirmation
                    })
                });

                const data = await res.json();

                if (data.success) {
                    showSuccess(data.message);
                    // Reset form
                    document.getElementById('login-form').reset();
                } else {
                    showError(data.message ?? 'Something went wrong.');
                }
            }
        }

        toggleBtn.addEventListener('click', () => {
            errorMsg.classList.add('hidden');
            successMsg.classList.add('hidden');
            mainBox.classList.remove('box-animate-in');
            mainBox.classList.add('box-animate-out');

            setTimeout(() => {
                isLogin = !isLogin;
                formTitle.innerText = isLogin ? "Welcome Back" : "Create Account";
                formSubtitle.innerText = isLogin ? "Enter your credentials to login." : "Register for your student account.";
                mainBtn.innerText = isLogin ? "Login" : "Register";
                promptText.innerText = isLogin ? "Don't have an account?" : "Already a member?";
                toggleBtn.innerText = isLogin ? "Sign Up" : "Sign In";

                Object.values(fields).forEach(field => {
                    field.classList.toggle('hidden', isLogin);
                });

                mainBox.classList.remove('box-animate-out');
                void mainBox.offsetWidth;
                mainBox.classList.add('box-animate-in');
            }, 400);
        });
    </script>
</body>
</html>