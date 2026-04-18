<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvard OJT Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        .parallax { background-attachment: fixed; }
        
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <section class="relative h-screen w-full flex flex-col items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0 parallax bg-cover bg-center" 
             style="background-image: url('images/landing_bg.jpg');"> <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]"></div>
        </div>

        <div class="relative z-10 text-center px-6">
            <div class="mb-6 flex justify-center">
                <img src="images/logo_2.0.png" alt="Harvard Logo" class="w-32 h-32 md:w-32 md:h-32 object-contain drop-shadow-2xl">
            </div>

            <h1 class="text-white text-4xl md:text-6xl font-black tracking-tighter mb-4">
                WELCOME TO <span class="text-emerald-400">OJT MANAGER</span>
            </h1>
            <p class="text-slate-200 text-lg md:text-xl max-w-2xl mx-auto mb-10 opacity-90">
                The world-class internship management system for Harvard students and industry partners.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center w-full max-w-md mx-auto">
    <a href="/login?mode=login"
       class="w-full sm:w-48 bg-emerald-600 hover:bg-emerald-500 text-white text-center font-bold py-4 rounded-2xl transition-all transform hover:scale-105 shadow-xl shadow-emerald-900/20">
        Login
    </a>

    <a href="/login?mode=register"
       class="w-full sm:w-48 bg-white/10 hover:bg-white/20 backdrop-blur-md text-white text-center border border-white/30 font-bold py-4 rounded-2xl transition-all transform hover:scale-105">
        Register
    </a>
</div>
        </div>

      
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2  opacity-50">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <section class="relative z-20 bg-white py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="text-emerald-600 font-bold tracking-[0.3em] uppercase text-xs">About the System</span>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 mt-4 mb-6 leading-tight">
                        Bridging Excellence <br>With Opportunity.
                    </h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-8">
                        The Harvard OJT Manager provides a seamless interface for students to document their journey at top-tier companies. Whether you are at Microsoft or a local startup, we ensure your professional growth is tracked, verified, and celebrated.
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <h4 class="font-bold text-slate-900">Secure Logs</h4>
                            <p class="text-sm text-slate-500">Encrypted daily attendance.</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <h4 class="font-bold text-slate-900">Verified</h4>
                            <p class="text-sm text-slate-500">Official Harvard stamp.</p>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="aspect-video bg-emerald-700 rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="absolute inset-0 flex items-center justify-center text-white p-12 text-center">
                            <p class="text-2xl font-italic opacity-80 italic">"The best way to predict the future is to create it."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-50 border-t border-slate-200 py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                <div class="max-w-xs">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="images/logo.png" class="w-8 h-8 object-contain">
                        <span class="text-xl font-black tracking-tighter">CHMSU OJT</span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Official internship management platform for the Faculty of Engineering and Applied Sciences.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12 w-full md:w-auto">
                    <div>
                        <h4 class="font-bold text-slate-900 mb-4">Contact Us</h4>
                        <ul class="text-sm text-slate-500 space-y-3">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">E:</span> support@harvard.edu
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-600 font-bold">P:</span> +1 (617) 495-1000
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-4">Locations</h4>
                        <ul class="text-sm text-slate-500 space-y-3">
                            <li>Cambridge, Massachusetts</li>
                            <li>Redmond, Washington (HQ)</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-4">Follow Us</h4>
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-slate-200"></div>
                            <div class="w-8 h-8 rounded-full bg-slate-200"></div>
                            <div class="w-8 h-8 rounded-full bg-slate-200"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-16 pt-8 border-t border-slate-200 text-center">
                <p class="text-xs text-slate-400 font-medium">© 2026 Harvard OJT Manager System. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>