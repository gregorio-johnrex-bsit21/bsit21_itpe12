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
            <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight drop-shadow-lg">
                {{ session('student')->name }}
            </h1>
        </div>

        <div class="flex flex-col items-center">
            <div id="header-weather-icon" class="text-white/90 drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                <svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M3 12h2.25m.386-6.364l1.591 1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                </svg>
            </div>
            
            <span class="text-[11px] md:text-sm font-black uppercase tracking-[0.2em] mt-3 text-white drop-shadow-md bg-black/20 px-3 py-1 rounded-full backdrop-blur-sm">
                28°C • Sunny
            </span>
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
  /* Updated Stat Card - Sleek Landscape Bar */
  .stat-card {
    background: #ffffff;
    /* Reduced vertical padding, kept horizontal wide */
    padding: 1rem 1.25rem; 
    border-radius: 16px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: 2px solid #e2e8f0; 
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    
    display: flex;
    flex-direction: column;
    justify-content: center;
    /* Reduced min-height to make it look "longer" and less square */
    min-height: 90px; 
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  }

  /* Colors */
  .text-slate { color: #334155; }
  .card-slate:hover { border-color: #64748b; }

  .text-emerald { color: #059669; }
  .card-emerald:hover { border-color: #10b981; }

  .text-orange { color: #d97706; }
  .card-orange:hover { border-color: #f59e0b; }

  .text-rose { color: #dc2626; }
  .card-rose:hover { border-color: #ef4444; }

  /* Elements */
  .card-label {
    font-size: 10px; /* Slightly smaller for better fit */
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .card-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
  }

  .card-number {
    font-size: 24px;
    font-weight: 900;
    color: #000000;
    line-height: 1;
  }

  .card-unit {
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    margin-left: 2px;
  }
</style>

<div class="grid grid-cols-2 gap-3 mb-8">
  
  <div class="stat-card card-slate">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
      <span class="card-label text-slate">Required</span>
      <div class="card-icon-wrap">
        <svg fill="none" stroke="currentColor" class="text-slate" viewBox="0 0 24 24" width="16" height="16">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
    </div>
    <div style="display:flex; align-items:baseline;">
      <span class="card-number">500</span><span class="card-unit">h</span>
    </div>
  </div>

  <div class="stat-card card-emerald">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
      <span class="card-label text-emerald">Accumulated</span>
      <div class="card-icon-wrap">
        <svg fill="none" stroke="currentColor" class="text-emerald" viewBox="0 0 24 24" width="16" height="16">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
      </div>
    </div>
    <div style="display:flex; align-items:baseline;">
      <span class="card-number">124</span><span class="card-unit">h</span>
    </div>
  </div>

  <div class="stat-card card-orange">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
      <span class="card-label text-orange">Remaining</span>
      <div class="card-icon-wrap">
        <svg fill="none" stroke="currentColor" class="text-orange" viewBox="0 0 24 24" width="16" height="16">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
        </svg>
      </div>
    </div>
    <div style="display:flex; align-items:baseline;">
      <span class="card-number">376</span><span class="card-unit">h</span>
    </div>
  </div>

  <div class="stat-card card-rose">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
      <span class="card-label text-rose">Missed</span>
      <div class="card-icon-wrap">
        <svg fill="none" stroke="currentColor" class="text-rose" viewBox="0 0 24 24" width="16" height="16">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
    </div>
    <div style="display:flex; align-items:baseline;">
      <span class="card-number">24</span><span class="card-unit">h</span>
    </div>
  </div>

</div>


<div class="w-full bg-white p-6 md:p-8 rounded-2xl border-2 border-slate-200 shadow-lg ring-1 ring-black/5">
    
    <div class="flex items-center gap-2 mb-2">
        <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 13h2v7H3zm5-6h2v13H8zm5 5h2v8h-2zm5-8h2v16h-2z"/>
        </svg>
        <h3 class="text-xl md:text-xl font-bold text-slate-900 tracking-tight">Total Progress</h3>
    </div>
    
    <p class="text-slate-500 text-sm mb-6 md:mb-4">Overall OJT completion status</p>

    <div class="flex flex-col items-center py-6">
        <div class="relative flex items-center justify-center">
            <div class="absolute inset-0 rounded-full bg-emerald-400/20 blur-xl"></div>
            
            <svg class="w-44 h-44 md:w-48 md:h-48 transform -rotate-90 relative z-10">
                <circle
                    cx="50%"
                    cy="50%"
                    r="42%"
                    stroke-width="12"
                    stroke="currentColor"
                    fill="transparent"
                    class="text-slate-100"
                />
                <circle
                    cx="50%"
                    cy="50%"
                    r="42%"
                    stroke-width="12"
                    stroke-dasharray="264" 
                    stroke-dashoffset="66"
                    stroke-linecap="round"
                    stroke="currentColor"
                    fill="transparent"
                    class="text-emerald-500 transition-all duration-1000 drop-shadow-[0_0_8px_rgba(16,185,129,0.6)]"
                />
            </svg>
            
            <div class="absolute text-center z-20 bg-white rounded-full w-28 h-28 flex flex-col items-center justify-center shadow-inner">
                <div class="text-4xl md:text-4xl font-black text-slate-900 leading-none">75%</div>
                <div class="text-emerald-600 text-[10px] font-bold uppercase tracking-widest mt-1">Achieved</div>
            </div>
        </div>

        <div class="mt-8 text-center max-w-[250px]">
           <p class="text-slate-600 text-sm leading-relaxed">
                You’ve reached <span class="font-bold text-emerald-600">75%</span> of your goal. <br>
                <span class="text-xs text-slate-400 font-medium">Only 25% left to reach the peak!</span>
           </p>
        </div>
    </div>
</div>



                    




        


@endsection