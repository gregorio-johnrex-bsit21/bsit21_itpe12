<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap');
        body { font-family: 'Montserrat', sans-serif; background: #f8fafc; }

        @keyframes boxSlideUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .box-animate-in { animation: boxSlideUp 0.6s ease-in-out forwards; }

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
            color: #3b82f6;
            transform: translateY(0.4rem);
        }
        .floating-input { padding-top: 1.25rem; padding-bottom: 0.5rem; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div id="main-box" class="opacity-0 bg-white rounded-3xl shadow-2xl w-full max-w-[380px] overflow-hidden">
        <div class="p-8 md:p-10">

            <div class="text-center font-bold mb-8">
                <span class="text-blue-500 text-xl tracking-tight">Supervisor</span><span class="text-gray-700 text-xl tracking-tight">Portal</span>
            </div>

            <!-- Error Message -->
            <div id="error-msg" class="hidden bg-red-50 border border-red-200 text-red-500 text-sm rounded-2xl px-4 py-3 mb-4 text-center"></div>

            <h2 class="text-2xl font-bold text-gray-800 mb-1">Welcome Back</h2>
            <p class="text-gray-400 text-sm mb-8">Enter your credentials to login.</p>

            <form id="login-form" class="flex flex-col space-y-4" onsubmit="handleSubmit(event)">
                @csrf

                <div class="input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-blue-500 transition-colors">
                    <i class="fa fa-id-badge text-gray-400 ml-4 mt-2 w-4"></i>
                    <input type="text" id="supervisor-id" name="supervisor_id" placeholder=" " class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                    <label class="floating-label">Supervisor ID</label>
                </div>

                <div class="input-group bg-gray-50 flex items-center rounded-2xl border border-gray-100 focus-within:border-blue-500 transition-colors">
                    <i class="fa fa-lock text-gray-400 ml-4 mt-2 w-4"></i>
                    <input type="password" id="password" name="password" placeholder=" " class="floating-input bg-transparent px-3 outline-none text-sm w-full">
                    <label class="floating-label">Password</label>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white rounded-2xl py-4 font-bold hover:bg-blue-600 transition-all shadow-lg mt-4 active:scale-95">
                    Login
                </button>
            </form>

        </div>
    </div>

    <script>
        document.getElementById('main-box').classList.remove('opacity-0');
        document.getElementById('main-box').classList.add('box-animate-in');

        async function handleSubmit(event) {
            event.preventDefault();
            const errorMsg = document.getElementById('error-msg');
            errorMsg.classList.add('hidden');

            const supervisorId = document.getElementById('supervisor-id').value.trim();
            const password = document.getElementById('password').value.trim();

            const res = await fetch("{{ route('supervisor.login.post') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ supervisor_id: supervisorId, password: password })
            });

            const data = await res.json();

            if (data.success) {
                window.location.href = data.redirect;
            } else {
                errorMsg.innerText = data.message;
                errorMsg.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>