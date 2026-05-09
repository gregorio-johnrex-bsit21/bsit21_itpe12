@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="w-full p-8 md:p-20 rounded-2xl shadow-xl mb-8 relative overflow-hidden bg-emerald-900">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?auto=format&fit=crop&q=80&w=2000" 
             alt="Forest background" 
             class="w-full h-full object-cover opacity-80">
        
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-950/80 via-emerald-900/40 to-transparent"></div>
    </div>

   <div class="flex justify-between items-center relative z-10">
    <div class="flex flex-col gap-1">
        <h2 class="text-emerald-100/90 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] drop-shadow-sm">
            Good day,
        </h2>
        <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">
            {{ session('student')->name }}
        </h1>

        {{-- ✅ Added: Date and Location just like the pic --}}
        <div class="flex flex-col gap-1 mt-2">
            <div class="flex items-center gap-1.5 text-white/80 text-xs font-medium">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <span>{{ now()->format('F d, Y') }}</span>
            </div>
            <div class="flex items-center gap-1.5 text-white/80 text-xs font-medium">
                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                <span>Cotabato City, PH</span>
            </div>
        </div>

    </div>

    <div class="flex flex-col items-center">
        <div id="header-weather-icon" class="text-white/90 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
            <svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M3 12h2.25m.386-6.364l1.591 1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
        </div>

        <div class="flex flex-col items-center mt-3">
            <span class="text-3xl md:text-4xl font-bold text-white tracking-tight">28°C</span>
            <span class="text-[11px] font-semibold text-white/80 tracking-wide">Sunny</span>
        </div>
    </div>
</div>

    <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-emerald-400/20 rounded-full blur-[80px] z-0"></div>
</div>

<script>
    function updateHeaderWeather() {
        const iconContainer = document.getElementById('header-weather-icon');
        
        // Slightly thicker stroke (1.5) makes it much more visible
        const sunSvg = `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M3 12h2.25m.386-6.364l1.591 1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>`;
        
        const moonSvg = `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>`;

        iconContainer.innerHTML = (hours >= 6 && hours < 18) ? sunSvg : moonSvg;
    }

    updateHeaderWeather();
</script>

<style>
.scard {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #eef2f7;
    padding: 15px;
    position: relative;
    cursor: pointer;
    transition: all 200ms ease;
    
}

.scard:hover {
    transform: translateY(-3px);
    box-shadow:
        0 14px 30px rgba(0,0,0,0.08),
        0 4px 10px rgba(0,0,0,0.05);
}

/* Remove strong colored borders */
.scard-blue:hover,
.scard-emerald:hover,
.scard-orange:hover,
.scard-rose:hover {
    border-color: #eef2f7;
}

/* ICON BOX (top-left like screenshot) */
.scard-pip {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    margin-bottom: 12px;

    /* soft neumorphic feel */
    box-shadow:
        inset 0 1px 0 rgba(255,255,255,0.4),
        0 6px 14px rgba(0,0,0,0.12);
}

/* LABEL beside icon */
.scard-label {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}

/* NUMBER */
.scard-num {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
}

.scard-unit {
    font-size: 11px;
    color: #94a3b8;
    margin-left: 4px;
}

/* Divider (like screenshot) */
.scard-foot {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid #e5e7eb;
}

/* Subtext */
.scard-sub {
    font-size: 12px;
    color: #6b7280;
}

</style>

<div class="grid grid-cols-2 gap-2 mb-8">

  {{-- REQUIRED --}}
  <div class="scard scard-blue">
    <div class="scard-label" style="color:#185FA5; margin-bottom: 18px;">REQUIRED</div>
    
    <div class="flex items-center gap-3">
      <div class="scard-pip" style="background:#185FA5; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0; flex-shrink: 0;">
        <svg width="18" height="18" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="9"/>
          <polyline points="12 7 12 12 15 15"/>
        </svg>
      </div>

      <div>
        <span class="scard-num">500</span>
        <span class="scard-unit">hrs</span>
      </div>
    </div>

    <div class="scard-foot">
      <span class="scard-sub">Total OJT hours</span>
    </div>
  </div>

  {{-- ACCUMULATED --}}
  <div class="scard scard-emerald">
    <div class="scard-label" style="color:#059669; margin-bottom: 18px;">ACCUMULATED</div>
    
    <div class="flex items-center gap-3">
      <div class="scard-pip" style="background:#059669; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0; flex-shrink: 0;">
        <svg width="18" height="18" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
          <polyline points="16 7 22 7 22 13"/>
        </svg>
      </div>

      <div>
        <span class="scard-num">124</span>
        <span class="scard-unit">hrs</span>
      </div>
    </div>

    <div class="scard-foot">
      <span class="scard-sub">24.8% complete</span>
    </div>
  </div>

  {{-- REMAINING --}}
  <div class="scard scard-orange">
    <div class="scard-label" style="color:#ea580c; margin-bottom: 18px;">REMAINING</div>
    
    <div class="flex items-center gap-3">
      <div class="scard-pip" style="background:#ea580c; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0; flex-shrink: 0;">
        <svg width="18" height="18" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="9"/>
          <polyline points="12 8 12 12 15 15"/>
        </svg>
      </div>

      <div>
        <span class="scard-num">376</span>
        <span class="scard-unit">hrs</span>
      </div>
    </div>

    <div class="scard-foot">
      <span class="scard-sub">75.2% left</span>
    </div>
  </div>

  {{-- MISSED --}}
  <div class="scard scard-rose">
    <div class="scard-label" style="color:#e11d48; margin-bottom: 18px;">MISSED</div>
    
    <div class="flex items-center gap-3">
      <div class="scard-pip" style="background:#e11d48; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; padding: 0; flex-shrink: 0;">
        <svg width="18" height="18" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </div>

      <div>
        <span class="scard-num">24</span>
        <span class="scard-unit">hrs</span>
      </div>
    </div>

    <div class="scard-foot">
      <span class="scard-sub">4.8% of target</span>
    </div>
  </div>

</div>

<div class="w-full bg-white p-5 rounded-2xl border border-slate-200" 
     style="box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-1">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 13h2v7H3zm5-6h2v13H8zm5 5h2v8h-2zm5-8h2v16h-2z"/>
                </svg>
            </div>
            <h3 class="text-sm font-700 text-slate-800 tracking-tight">Total Progress</h3>
        </div>
        <span class="text-[11px] font-600 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700">
            On track
        </span>
    </div>
    <p class="text-[11px] text-slate-400 font-500 uppercase tracking-widest mb-5 ml-9">Overall OJT completion</p>

    {{-- Ring --}}
    <div class="flex flex-col items-center py-4">
        <div class="relative flex items-center justify-center">

            <svg class="w-40 h-40 transform -rotate-90">
                {{-- Track --}}
                <circle cx="50%" cy="50%" r="42%" stroke-width="10"
                    stroke="#f1f5f9" fill="transparent"/>
                {{-- Progress --}}
                <circle cx="50%" cy="50%" r="42%"
                    stroke-width="10"
                    stroke-dasharray="264"
                    stroke-dashoffset="66"
                    stroke-linecap="round"
                    stroke="#059669"
                    fill="transparent"
                    class="transition-all duration-1000"/>
            </svg>

            {{-- Center label --}}
            <div class="absolute text-center flex flex-col items-center justify-center">
                <div class="text-3xl font-black text-slate-900 leading-none">75%</div>
                <div class="text-[10px] font-700 text-emerald-600 uppercase tracking-widest mt-1">Achieved</div>
            </div>
        </div>

        {{-- Footer stats --}}
        <div class="w-full mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
    
    <div class="text-center flex-1">
        <div class="text-[11px] text-slate-400 uppercase tracking-widest mb-1">Completed</div>
        <div class="text-base font-bold text-slate-800">124 <span class="text-xs text-slate-400 font-medium">hrs</span></div>
    </div>

    <div style="width:1px; height:32px; background:#e2e8f0;"></div>

    <div class="text-center flex-1">
        <div class="text-[11px] text-slate-400 uppercase tracking-widest mb-1">Remaining</div>
        <div class="text-base font-bold text-slate-800">376 <span class="text-xs text-slate-400 font-medium">hrs</span></div>
    </div>

    <div style="width:1px; height:32px; background:#e2e8f0;"></div>

    <div class="text-center flex-1">
        <div class="text-[11px] text-slate-400 uppercase tracking-widest mb-1">Target</div>
        <div class="text-base font-bold text-slate-800">500 <span class="text-xs text-slate-400 font-medium">hrs</span></div>
    </div>

</div>
    </div>
</div>


                    




        


@endsection