@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    $student      = session('student');
    $studentModel = \App\Models\Student::with([
        'company.ojtRequirement',
    ])->find($student->id);

    $ojt           = $studentModel?->company?->ojtRequirement;
    $requiredHours = $ojt?->required_hours ?? 0;

    // Accumulated hours from attendance
    $accumulated = \App\Models\Attendance::where('student_id', $student->id)->sum('total_hours');
    $accumulated = round($accumulated, 2);

    // Remaining & missed
    $remaining     = max(0, $requiredHours - $accumulated);
    $missedMinutes = \App\Models\Attendance::where('student_id', $student->id)->get()
        ->sum(function ($record) {
            $missed  = 0;
            $dateStr = \Carbon\Carbon::parse($record->date)->format('Y-m-d');
            if ($record->am_time_in) {
                $scheduledIn = \Carbon\Carbon::parse($dateStr . ' 08:00:00');
                $actualIn    = \Carbon\Carbon::parse($dateStr . ' ' . $record->am_time_in);
                if ($actualIn->gt($scheduledIn)) $missed += $scheduledIn->diffInMinutes($actualIn);
            }
            if ($record->am_time_out) {
                $scheduledOut = \Carbon\Carbon::parse($dateStr . ' 12:00:00');
                $actualOut    = \Carbon\Carbon::parse($dateStr . ' ' . $record->am_time_out);
                if ($actualOut->lt($scheduledOut)) $missed += $actualOut->diffInMinutes($scheduledOut);
            }
            if ($record->pm_time_in) {
                $scheduledIn = \Carbon\Carbon::parse($dateStr . ' 13:00:00');
                $actualIn    = \Carbon\Carbon::parse($dateStr . ' ' . $record->pm_time_in);
                if ($actualIn->gt($scheduledIn)) $missed += $scheduledIn->diffInMinutes($actualIn);
            }
            if ($record->pm_time_out) {
                $scheduledOut = \Carbon\Carbon::parse($dateStr . ' 17:00:00');
                $actualOut    = \Carbon\Carbon::parse($dateStr . ' ' . $record->pm_time_out);
                if ($actualOut->lt($scheduledOut)) $missed += $actualOut->diffInMinutes($scheduledOut);
            }
            return $missed;
        });
    $missedHours = round($missedMinutes / 60, 2);

    // Progress percentage
    $progressPct   = $requiredHours > 0 ? min(100, round(($accumulated / $requiredHours) * 100, 1)) : 0;
    $circumference = 264;
    $strokeOffset  = $circumference - ($progressPct / 100 * $circumference);
    $remainingPct  = $requiredHours > 0 ? round(($remaining / $requiredHours) * 100, 1) : 0;
    $missedPct     = $requiredHours > 0 ? round(($missedHours / $requiredHours) * 100, 1) : 0;

    // === ADD THESE FOR THE CIRCLE ===
    $radius = 70;
    $circumference = 2 * M_PI * $radius;
    $strokeOffsetStart = $circumference;
    $strokeOffsetEnd = $circumference - ($progressPct / 100) * $circumference; // <-- was $percentage, now $progressPct
    
    // Color & status based on progress (same as supervisor)
    $color = match(true) {
        $progressPct >= 90  => '#2E7D32',   // Green
        $progressPct >= 75  => '#185FA5',   // Blue
        $progressPct >= 50  => '#FF8C00',   // Orange
        $progressPct >= 25  => '#FF4500',   // Red-Orange
        default            => '#D50000',   // Red
    };

    $status = match(true) {
        $progressPct >= 100 => 'Completed',
        $progressPct >= 75  => 'Advanced',
        $progressPct >= 50  => 'Midway',
        $progressPct >= 25  => 'Progressing',
        default            => 'Starting',
    };
@endphp

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
                <span id="user-location">Locating...</span>
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
            <span id="weather-temp" class="text-3xl md:text-4xl font-bold text-white tracking-tight">--°C</span>
            <span id="weather-desc" class="text-[11px] font-semibold text-white/80 tracking-wide">Loading...</span>
        </div>
    </div>
</div>

    <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-emerald-400/20 rounded-full blur-[80px] z-0"></div>
</div>

<script>
    function updateHeaderWeather() {
        const iconContainer = document.getElementById('header-weather-icon');
        const hours = new Date().getHours();
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
    box-shadow: 0 14px 30px rgba(0,0,0,0.08), 0 4px 10px rgba(0,0,0,0.05);
}
.scard-blue:hover, .scard-emerald:hover, .scard-orange:hover, .scard-rose:hover {
    border-color: #eef2f7;
}
.scard-pip {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    margin-bottom: 12px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 6px 14px rgba(0,0,0,0.12);
}
.scard-label {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}
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
.scard-foot {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid #e5e7eb;
}
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
        <span class="scard-num">{{ $requiredHours }}</span>
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
        <span class="scard-num">{{ $accumulated }}</span>
        <span class="scard-unit">hrs</span>
      </div>
    </div>
    <div class="scard-foot">
      <span class="scard-sub">{{ $progressPct }}% complete</span>
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
        <span class="scard-num">{{ $remaining }}</span>
        <span class="scard-unit">hrs</span>
      </div>
    </div>
    <div class="scard-foot">
      <span class="scard-sub">{{ $remainingPct }}% left</span>
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
        <span class="scard-num">{{ $missedHours }}</span>
        <span class="scard-unit">hrs</span>
      </div>
    </div>
    <div class="scard-foot">
      <span class="scard-sub">{{ $missedPct }}% of target</span>
    </div>
  </div>

</div>

{{-- Small header outside the card --}}
<div class="flex items-center gap-2 mb-3">
    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"/>
        <polyline points="12 6 12 12 16 14"/>
    </svg>
    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">OJT Progress</span>
</div>

{{-- White card with circle --}}
<div class="w-full bg-white p-5 rounded-2xl border border-slate-200 progress-card" 
     style="box-shadow: 0 2px 8px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);">

    <div class="flex flex-col items-center">
        <div class="relative flex items-center justify-center">
            <svg class="w-40 h-40 transform -rotate-90" viewBox="0 0 160 160">
                {{-- Track --}}
                <circle cx="80" cy="80" r="{{ $radius }}" 
                    stroke-width="12"
                    stroke="#f1f5f9" 
                    fill="transparent"/>
                
                {{-- Progress --}}
                <circle id="ojtProgressCircle" 
                    cx="80" cy="80" r="{{ $radius }}"
                    stroke-width="12"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ $strokeOffsetStart }}"
                    stroke-linecap="round"
                    stroke="{{ $color }}"
                    fill="transparent"
                    class="transition-all duration-[1500ms] ease-out"/>
            </svg>

            {{-- Center label --}}
            <div class="absolute text-center flex flex-col items-center justify-center">
                <div id="ojtPercentText" class="text-3xl font-black leading-none" style="color: {{ $color }}">0%</div>
                <div class="text-[10px] font-bold uppercase tracking-widest mt-1 text-black">Achieved</div>
                <div class="text-[11px] text-slate-400 mt-1 font-medium">
                    {{ number_format($accumulated, 1) }} / {{ $requiredHours }} hrs
                </div>
            </div>
        </div>

        {{-- Status badge --}}
        <div class="mt-3 text-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white"
                  style="background-color: {{ $color }}">
                {{ $status }} • {{ number_format($remaining, 1) }} hrs remaining
            </span>
        </div>
    </div>

    <script>
        (function() {
            const circle = document.getElementById('ojtProgressCircle');
            const percentEl = document.getElementById('ojtPercentText');
            const circumference = {{ $circumference }};
            const targetPercent = {{ $progressPct }};
            const targetOffset = {{ $strokeOffsetEnd }};
            const duration = 1500;
            const startTime = performance.now();

            setTimeout(() => {
                circle.style.strokeDashoffset = targetOffset;
            }, 100);

            function tick(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 4);
                const current = targetPercent * ease;
                
                percentEl.textContent = (Math.round(current * 10) / 10) + '%';
                
                if (progress < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        })();
    </script>
</div>

<script>
    (function() {
        const circle = document.getElementById('ojtProgressCircle');
        const percentEl = document.getElementById('ojtPercentText');
        const circumference = {{ $circumference }};
        const targetPercent = {{ $progressPct }};  // <-- was $percentage
        const targetOffset = {{ $strokeOffsetEnd }};
        const duration = 1500;
        const startTime = performance.now();

        setTimeout(() => {
            circle.style.strokeDashoffset = targetOffset;
        }, 100);

        function tick(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const ease = 1 - Math.pow(1 - progress, 4);
            const current = targetPercent * ease;
            
            percentEl.textContent = (Math.round(current * 10) / 10) + '%';
            
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    })();



const LAT_DEFAULT = 7.2047;
const LON_DEFAULT = 124.2310;

const weatherCodes = {
    0: 'Clear Sky', 1: 'Mostly Clear', 2: 'Partly Cloudy', 3: 'Overcast',
    45: 'Foggy', 48: 'Icy Fog',
    51: 'Light Drizzle', 53: 'Drizzle', 55: 'Heavy Drizzle',
    61: 'Light Rain', 63: 'Rain', 65: 'Heavy Rain',
    71: 'Light Snow', 73: 'Snow', 75: 'Heavy Snow',
    80: 'Rain Showers', 81: 'Rain Showers', 82: 'Heavy Showers',
    95: 'Thunderstorm', 96: 'Thunderstorm', 99: 'Thunderstorm',
};

function sunSvg() {
    return `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M3 12h2.25m.386-6.364l1.591 1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
    </svg>`;
}
function cloudSvg() {
    return `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/>
    </svg>`;
}
function rainSvg() {
    return `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 19.5l-.75 1.5M12 19.5l-.75 1.5M15.75 19.5l-.75 1.5"/>
    </svg>`;
}
function snowSvg() {
    return `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 19.5l.75 1.5-.75 1.5M12 19.5v3M15.75 19.5l-.75 1.5.75 1.5"/>
    </svg>`;
}
function stormSvg() {
    return `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16.5l-2 3h3l-2 3"/>
    </svg>`;
}
function moonSvg() {
    return `<svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
    </svg>`;
}

const weatherIcons = {
    0: sunSvg, 1: sunSvg, 2: cloudSvg, 3: cloudSvg,
    45: cloudSvg, 48: cloudSvg,
    51: rainSvg, 53: rainSvg, 55: rainSvg,
    61: rainSvg, 63: rainSvg, 65: rainSvg,
    71: snowSvg, 73: snowSvg, 75: snowSvg,
    80: rainSvg, 81: rainSvg, 82: rainSvg,
    95: stormSvg, 96: stormSvg, 99: stormSvg,
};

async function fetchWeatherAt(lat, lon) {
    try {
        const url  = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code&timezone=Asia%2FManila`;
        const res  = await fetch(url);
        const data = await res.json();

        const temp = Math.round(data.current.temperature_2m);
        const code = data.current.weather_code;
        const desc = weatherCodes[code] ?? 'Unknown';

        const tempEl = document.getElementById('weather-temp');
        const descEl = document.getElementById('weather-desc');
        if (tempEl) tempEl.textContent = `${temp}°C`;
        if (descEl) descEl.textContent = desc;

        const iconEl = document.getElementById('header-weather-icon');
        if (iconEl) {
            const hours   = new Date().getHours();
            const isNight = hours < 6 || hours >= 18;
            const iconFn  = isNight ? moonSvg : (weatherIcons[code] ?? sunSvg);
            iconEl.innerHTML = iconFn();
        }
    } catch (e) {
        const tempEl = document.getElementById('weather-temp');
        const descEl = document.getElementById('weather-desc');
        if (tempEl) tempEl.textContent = '--°C';
        if (descEl) descEl.textContent = 'Unavailable';
    }
}

async function fetchLocation(lat, lon) {
    try {
        const res  = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`);
        const data = await res.json();
        const city = data.address?.city
                  ?? data.address?.town
                  ?? data.address?.municipality
                  ?? data.address?.county
                  ?? 'Unknown';
        const country = data.address?.country_code?.toUpperCase() ?? '';
        const locEl = document.getElementById('user-location');
        if (locEl) locEl.textContent = `${city}, ${country}`;
    } catch (e) {
        const locEl = document.getElementById('user-location');
        if (locEl) locEl.textContent = 'Location unavailable';
    }
}

// Main init — try real location first, fall back to default
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        function (pos) {
            const { latitude, longitude } = pos.coords;
            fetchWeatherAt(latitude, longitude);
            fetchLocation(latitude, longitude);
            setInterval(() => fetchWeatherAt(latitude, longitude), 10 * 60 * 1000);
        },
        function () {
            // Permission denied or timeout — use default coords
            fetchWeatherAt(LAT_DEFAULT, LON_DEFAULT);
            fetchLocation(LAT_DEFAULT, LON_DEFAULT);
            setInterval(() => fetchWeatherAt(LAT_DEFAULT, LON_DEFAULT), 10 * 60 * 1000);
        },
        { timeout: 8000, maximumAge: 300000 }
    );
} else {
    fetchWeatherAt(LAT_DEFAULT, LON_DEFAULT);
    fetchLocation(LAT_DEFAULT, LON_DEFAULT);
}
</script>
</div>

@if(!session('profile_complete'))
<div id="profileWarningModal" class="fixed inset-0 z-[200] flex items-center justify-center px-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 animate-bounce-in">
        
        {{-- Icon --}}
        <div class="flex justify-center mb-4">
            <div class="p-3 bg-amber-400 rounded-full">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
        </div>

        <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Complete Your Profile</h3>
        <p class="text-sm text-gray-500 text-center leading-relaxed mb-6">
            Your profile is incomplete. You must fill out your details before using the dashboard.
        </p>

        {{-- Single CTA — forced to complete --}}
        <a href="{{ route('students.profile') }}"
            class="block w-full py-3 px-4 bg-emerald-500 text-white rounded-xl text-sm font-semibold text-center hover:bg-emerald-600 shadow-lg shadow-emerald-200 transition active:scale-95">
            Complete Profile →
        </a>
    </div>
</div>

<style>
@keyframes bounce-in {
    0% { opacity: 0; transform: scale(0.9) translateY(20px); }
    60% { transform: scale(1.02) translateY(-5px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-bounce-in {
    animation: bounce-in 0.5s ease-out;
}
</style>
@endif

@include('students.partials.tutorial-dashboard')
@include('students.partials.help-fab')

@endsection