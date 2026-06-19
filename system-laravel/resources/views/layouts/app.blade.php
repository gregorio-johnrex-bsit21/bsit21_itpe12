<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OJT Manager')</title>
    
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        window.ChatConfig = {
            conversation: "{{ str_replace(' ', '_', session('student') ? session('student')->name : '') }}"
        };
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9935CS56VF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-9935CS56VF');
</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

   <style>
    [x-cloak] { display: none !important; }
    body { font-family: 'Inter', sans-serif; }



/* ── Modal Animations ─────────────────────────── */

/* Mobile: Bottom sheet slide-up */
.modal-enter {
    opacity: 0;
    transform: translateY(100%);
}
.modal-enter-active {
    opacity: 1;
    transform: translateY(0);
    transition: transform 0.35s cubic-bezier(0.32, 0.72, 0, 1), opacity 0.3s ease-out;
}

.modal-exit {
    opacity: 1;
    transform: translateY(0);
}
.modal-exit-active {
    opacity: 0;
    transform: translateY(100%);
    transition: transform 0.28s cubic-bezier(0.32, 0.72, 0, 1), opacity 0.2s ease-in;
}

/* Desktop: Pop up (scale + fade) */
@media (min-width: 640px) {
    .modal-enter {
        opacity: 0;
        transform: scale(0.95);
    }
    .modal-enter-active {
        opacity: 1;
        transform: scale(1);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease-out;
    }

    .modal-exit {
        opacity: 1;
        transform: scale(1);
    }
    .modal-exit-active {
        opacity: 0;
        transform: scale(0.95);
        transition: transform 0.2s ease-in, opacity 0.2s ease-in;
    }
}

/* Backdrop — same both */
.backdrop-enter {
    opacity: 0;
}
.backdrop-enter-active {
    opacity: 1;
    transition: opacity 0.35s ease-out;
}
.backdrop-exit {
    opacity: 1;
}
.backdrop-exit-active {
    opacity: 0;
    transition: opacity 0.25s ease-in;
} 

</style>

<script>
    (function() {
        const saved = localStorage.getItem('theme') || 'light';
        document.documentElement.classList.remove('light', 'dark');
        document.documentElement.classList.add(saved);
    })();
</script>

<style>
    /* ── Dark Mode Variables ─────────────────────────── */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f9fafb;
        --bg-tertiary: #f3f4f6;
        --bg-card: #ffffff;
        --bg-input: #ffffff;

        --text-primary: #111827;
        --text-secondary: #374151;
        --text-tertiary: #6b7280;
        --text-muted: #9ca3af;

        --border-color: #e5e7eb;
        --border-light: #f3f4f6;

        --brand: #059669;
        --brand-light: #ecfdf5;
        --brand-dark: #047857;

        --sidebar-bg: #ffffff;
        --header-bg: #ffffff;
        --header-border: #d1d5db;

        --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.10);
    }

    html.dark {
        --bg-primary: #0c0e12;
        --bg-secondary: #151821;
        --bg-tertiary: #0c0e12;
        --bg-card: #151821;
        --bg-input: #1e212e;

        --text-primary: #e2e4e9;
        --text-secondary: #9ca0b0;
        --text-tertiary: #6b7080;
        --text-muted: #4a4f5c;

        --border-color: #252a38;
        --border-light: #1a1e2a;

        --btn-primary: #2d4a52;
        --btn-primary-hover: #3d5a62;
        --btn-text: #8ab4c0;

        --sidebar-bg: #151821;
        --header-bg: #151821;
        --header-border: #252a38;

        --shadow-sm: 0 1px 3px rgba(0,0,0,0.4);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.5);
    }

    /* ── Clean Modern Forest Green (dark mode only) ───── */
    /* Not neon, not swamp — crisp muted green with good contrast */
    html.dark {
        --accent-green: #4ade80;       /* clean bright green — modern, not neon */
        --accent-green-soft: #6ee7b7;  /* soft mint for hover */
        --accent-green-dim: #34d399;   /* slightly dimmed */
        --accent-green-bg: #064e3b;    /* deep forest for backgrounds */
        --accent-green-deep: #065f46;  /* deep emerald */
    }

    html.dark .text-emerald-600 { color: var(--accent-green-dim) !important; }
    html.dark .text-emerald-500 { color: var(--accent-green) !important; }
    html.dark .text-emerald-400 { color: var(--accent-green-soft) !important; }
    html.dark .text-emerald-700 { color: var(--accent-green-bg) !important; }
    html.dark .text-emerald-300 { color: var(--accent-green-soft) !important; }

    html.dark .bg-emerald-600 { background-color: var(--accent-green-deep) !important; }
    html.dark .bg-emerald-500 { background-color: var(--accent-green-bg) !important; }
    html.dark .bg-emerald-100 { background-color: rgba(6, 78, 59, 0.35) !important; }
    html.dark .bg-emerald-50  { background-color: rgba(6, 78, 59, 0.2) !important; }

    html.dark .from-emerald-400 { --tw-gradient-from: var(--accent-green-bg) !important; }
    html.dark .to-emerald-600   { --tw-gradient-to: #022c22 !important; }
    html.dark .from-emerald-50  { --tw-gradient-from: rgba(6, 78, 59, 0.25) !important; }
    html.dark .to-teal-50       { --tw-gradient-to: rgba(6, 95, 70, 0.12) !important; }

    html.dark .border-emerald-500 { border-color: var(--accent-green-bg) !important; }
    html.dark .border-emerald-100 { border-color: rgba(6, 78, 59, 0.3) !important; }
    html.dark .ring-emerald-500   { --tw-ring-color: var(--accent-green-bg) !important; }

    html.dark .shadow-emerald-200 { --tw-shadow-color: rgba(6, 78, 59, 0.4) !important; }
    html.dark .shadow-emerald-100 { --tw-shadow-color: rgba(6, 78, 59, 0.2) !important; }

    html.dark .hover\:bg-emerald-600:hover { background-color: #047857 !important; }
    html.dark .hover\:bg-emerald-100:hover { background-color: rgba(6, 78, 59, 0.45) !important; }
    html.dark .hover\:bg-emerald-50:hover  { background-color: rgba(6, 78, 59, 0.3) !important; }

    html.dark .hover\:text-emerald-600:hover { color: var(--accent-green-soft) !important; }
    html.dark .hover\:text-emerald-700:hover { color: var(--accent-green-dim) !important; }

    html.dark .active\:bg-emerald-100:active { background-color: rgba(6, 78, 59, 0.5) !important; }

    /* ── BOTTOM NAV: original emerald green ───────────── */
    /* Active nav text — bright emerald */
    html.dark nav.fixed.bottom-0 .text-emerald-500,
    html.dark nav.fixed.bottom-0 .text-emerald-600,
    html.dark nav.fixed.bottom-0 [class*="text-emerald"] {
        color: #10b981 !important;
    }
    html.dark nav.fixed.bottom-0 .text-green-500,
    html.dark nav.fixed.bottom-0 .text-green-600,
    html.dark nav.fixed.bottom-0 [class*="text-green-"] {
        color: #10b981 !important;
    }
    /* Inactive nav items — gray */
    html.dark nav.fixed.bottom-0 .text-gray-400,
    html.dark nav.fixed.bottom-0 .text-gray-500 {
        color: #6b7280 !important;
    }
    /* Active highlight bar — bright emerald, NO GLOW */
    html.dark nav.fixed.bottom-0 .bg-emerald-500,
    html.dark nav.fixed.bottom-0 .bg-green-500,
    html.dark nav.fixed.bottom-0 [class*="bg-emerald"],
    html.dark nav.fixed.bottom-0 [class*="bg-green-"] {
        background-color: #10b981 !important;
        box-shadow: none !important;
    }

    /* ── HEADER ICONS: chat & notification SVGs — lighter stroke only ── */
    html.dark header svg,
    html.dark header [class*="icon"] svg,
    html.dark header button svg {
        color: #9ca0b0 !important;
        stroke: #9ca0b0 !important;
        fill: none !important;
    }
    html.dark header svg:hover,
    html.dark header button:hover svg,
    html.dark header [class*="icon"]:hover svg {
        color: var(--accent-green-soft) !important;
        stroke: var(--accent-green-soft) !important;
        fill: none !important;
    }

    /* ── ADD NOTE FAB: .diaryBtn + icon + text ────────── */
    /* The circular button background — original emerald, NO GLOW */
    html.dark nav.fixed.bottom-0 .diaryBtn,
    html.dark nav.fixed.bottom-0 .diaryBtn.bg-emerald-600,
    html.dark nav.fixed.bottom-0 .diaryBtn[class*="bg-emerald"] {
        background-color: #059669 !important;  /* Tailwind emerald-600 */
        background: #059669 !important;
        border-color: #10b981 !important;
        box-shadow: none !important;
    }
    /* The + icon — white */
    html.dark nav.fixed.bottom-0 .diaryBtn svg,
    html.dark nav.fixed.bottom-0 .diaryBtn svg line,
    html.dark nav.fixed.bottom-0 .diaryBtn svg [stroke] {
        stroke: #ffffff !important;
        color: #ffffff !important;
    }
    /* The "Add Note" label — bright emerald */
    html.dark nav.fixed.bottom-0 .flex:has(.diaryBtn) span,
    html.dark nav.fixed.bottom-0 .diaryBtn + span,
    html.dark nav.fixed.bottom-0 span.text-emerald-600,
    html.dark nav.fixed.bottom-0 [class*="text-emerald-600"] {
        color: #10b981 !important;  /* Tailwind emerald-500 */
    }
    /* Hover: slightly lighter */
    html.dark nav.fixed.bottom-0 .diaryBtn:hover,
    html.dark nav.fixed.bottom-0 .diaryBtn:active {
        background-color: #047857 !important;
        background: #047857 !important;
    }
    html.dark nav.fixed.bottom-0 .diaryBtn:hover svg,
    html.dark nav.fixed.bottom-0 .diaryBtn:hover svg line {
        stroke: #ffffff !important;
        color: #ffffff !important;
    }
    html.dark nav.fixed.bottom-0 .diaryBtn:hover + span,
    html.dark nav.fixed.bottom-0 .flex:has(.diaryBtn):hover span {
        color: #34d399 !important;  /* lighter emerald */
    }

        /* ── HEADER AVATAR: emerald, NO GLOW ──────────────── */
    html.dark header button[class*="bg-emerald"],
    html.dark header .bg-emerald-500,
    html.dark header .bg-emerald-600 {
        background-color: #059669 !important;
        box-shadow: none !important;
    }

        /* ── Apply variables globally ─────────────────────── */
    body {
        background-color: var(--bg-tertiary) !important;
        color: var(--text-primary) !important;
        transition: background-color 0.25s ease, color 0.25s ease;
    }

    /* Cards & surfaces */
    .bg-white { background-color: var(--bg-card) !important; }
    .bg-gray-50 { background-color: var(--bg-secondary) !important; }
    .bg-gray-100 { background-color: var(--bg-tertiary) !important; }

    /* Text — LIGHT MODE (default) */
    .text-gray-900, .text-slate-900 { color: #111827 !important; }
    .text-gray-800, .text-slate-800 { color: #1f2937 !important; }
    .text-gray-700, .text-slate-700 { color: #374151 !important; }
    .text-gray-600, .text-slate-600 { color: #4b5563 !important; }
    .text-gray-500, .text-slate-500 { color: #6b7280 !important; }
    .text-gray-400, .text-slate-400 { color: #9ca3af !important; }

    /* Text — DARK MODE */
    html.dark .text-gray-900,
    html.dark .text-slate-900 { color: #f9fafb !important; }
    html.dark .text-gray-800,
    html.dark .text-slate-800 { color: #e2e4e9 !important; }
    html.dark .text-gray-700,
    html.dark .text-slate-700 { color: #9ca0b0 !important; }
    html.dark .text-gray-600,
    html.dark .text-slate-600 { color: #6b7080 !important; }
    html.dark .text-gray-500,
    html.dark .text-slate-500 { color: #4a4f5c !important; }
    html.dark .text-gray-400,
    html.dark .text-slate-400 { color: #4a4f5c !important; }

    /* Borders */
    .border-gray-100, .border-gray-200, .border-slate-100, .border-slate-200 {
        border-color: var(--border-color) !important;
    }
    .border-gray-50, .border-slate-50 { border-color: var(--border-light) !important; }

    /* Inputs */
    input, textarea, select {
        background-color: var(--bg-input) !important;
        color: var(--text-primary) !important;
        border-color: var(--border-color) !important;
    }
    input::placeholder, textarea::placeholder { color: var(--text-muted) !important; }

    /* Sidebar & header */
    aside { background-color: var(--sidebar-bg) !important; border-color: var(--border-color) !important; }
    header { background-color: var(--header-bg) !important; border-color: var(--header-border) !important; }
    /* Force header bg to stay dark even if other rules try to override */
    html.dark header { background-color: #151821 !important; }

    /* Bottom nav */
    nav.fixed.bottom-0 {
        background-color: var(--header-bg) !important;
        border-color: var(--header-border) !important;
    }

    /* Modals */
    #inboxModal > div,
    #composeModal > div,
    #msgModal,
    #notifModal,
    #chatBox,
    #mediaPreviewModal > div { background-color: var(--bg-card) !important; border-color: var(--border-color) !important; }

    /* Hover states — LIGHT MODE */
    .hover\:bg-gray-50:hover,
    .hover\:bg-slate-50:hover { background-color: #f9fafb !important; }
    .hover\:bg-gray-100:hover { background-color: #f3f4f6 !important; }

    /* Hover states — DARK MODE */
    html.dark .hover\:bg-gray-50:hover,
    html.dark .hover\:bg-slate-50:hover { background-color: #151821 !important; }
    html.dark .hover\:bg-gray-100:hover { background-color: #0c0e12 !important; }

    /* Slate-50 used as card backgrounds */
    .bg-slate-50 { background-color: var(--bg-secondary) !important; }

    /* Dividers */
    .divide-gray-100 > * + *, .divide-gray-200 > * + * { border-color: var(--border-color) !important; }

    /* Dropdown menus */
    html.dark [x-show] { border-color: var(--border-color) !important; }

    /* Transition everything smoothly */
    *, *::before, *::after {
        transition-property: background-color, border-color, color;
        transition-duration: 0.2s;
        transition-timing-function: ease;
    }

    /* ── OJT PROGRESS CIRCLE: dark mode overrides ─────── */
    /* EMPTY TRACK (background arc) — dark blue */
    html.dark .progress-card svg circle[stroke="#f1f5f9"],
    html.dark .progress-card svg circle:first-child,
    html.dark .progress-card svg circle:not([stroke-linecap="round"]) {
        stroke: #1e3a5f !important;  /* dark navy blue for empty portion */
    }
    /* FILLED PROGRESS stroke — keep it visible, light gray/white */
    html.dark #ojtProgressCircle,
    html.dark .progress-card circle[id*="Progress"],
    html.dark .progress-card svg circle[stroke-linecap="round"] {
        stroke: #e2e4e9 !important;  /* light gray/white for filled portion */
    }
    /* "ACHIEVED" text — white/light gray */
    html.dark .progress-card .text-black,
    html.dark .progress-card [class*="Achieved"],
    html.dark #ojtPercentText + div,
    html.dark #ojtPercentText ~ div,
    html.dark .progress-card .absolute div[class*="text-"] {
        color: #e2e4e9 !important;
    }
    /* Percentage number */
    html.dark #ojtPercentText,
    html.dark .progress-card .text-3xl {
        color: #f9fafb !important;
    }
    /* Hours text below */
    html.dark .progress-card .text-slate-400,
    html.dark .progress-card .text-\[11px\] {
        color: #9ca0b0 !important;
    }
    /* Status badge */
    html.dark .progress-card span[class*="rounded-full"],
    html.dark .progress-card .inline-flex {
        background-color: #1e3a5f !important;
        color: #e2e4e9 !important;
    }

        /* ── CHAT MODAL: dark mode fixes ──────────────────── */
    /* Chat modal background — match dark card bg, NOT black */
    html.dark #chatBox,
    html.dark #msgModal,
    html.dark .chat-modal,
    html.dark .message-modal,
    html.dark [id*="chat"] > div,
    html.dark [id*="msg"] > div {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }
    /* Chat header — dark */
    html.dark #chatBox header,
    html.dark #msgModal header,
    html.dark .chat-modal header {
        background-color: var(--header-bg) !important;
        border-color: var(--header-border) !important;
    }
    /* Chat header text */
    html.dark #chatBox header h3,
    html.dark #chatBox header p,
    html.dark #msgModal header h3,
    html.dark #msgModal header p,
    html.dark .chat-modal header h3,
    html.dark .chat-modal header p {
        color: var(--text-primary) !important;
    }
    /* "ACTIVE NOW" status dot — bright emerald */
    html.dark #chatBox header .text-green-500,
    html.dark #chatBox header [class*="text-green"],
    html.dark #chatBox header .bg-green-500,
    html.dark #chatBox header [class*="bg-green"],
    html.dark #msgModal header .text-green-500,
    html.dark #msgModal header .bg-green-500,
    html.dark .chat-modal header .text-green-500,
    html.dark .chat-modal header .bg-green-500 {
        color: #10b981 !important;
        background-color: #10b981 !important;
    }
    /* Close button (X) — light gray */
    html.dark #chatBox header button,
    html.dark #msgModal header button,
    html.dark .chat-modal header button {
        color: var(--text-secondary) !important;
    }
    /* Message bubbles — RECEIVED (left side, dark gray) */
    html.dark #chatBox .bg-gray-100,
    html.dark #chatBox .bg-gray-200,
    html.dark #chatBox .bg-slate-100,
    html.dark #chatBox .bg-slate-200,
    html.dark #msgModal .bg-gray-100,
    html.dark #msgModal .bg-gray-200,
    html.dark .chat-modal .bg-gray-100,
    html.dark .chat-modal .bg-gray-200 {
        background-color: #1e212e !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color) !important;
    }
    /* Message bubbles — SENT (right side, original emerald, white text, NO GLOW) */
    html.dark #chatBox .bg-emerald-500,
    html.dark #chatBox .bg-green-500,
    html.dark #chatBox .bg-emerald-600,
    html.dark #chatBox .bg-green-600,
    html.dark #msgModal .bg-emerald-500,
    html.dark #msgModal .bg-green-500,
    html.dark .chat-modal .bg-emerald-500,
    html.dark .chat-modal .bg-green-500 {
        background-color: #059669 !important;  /* Tailwind emerald-600 */
        color: #ffffff !important;  /* WHITE text */
        border: 1px solid #047857 !important;
        box-shadow: none !important;
    }
    /* Chat input area — dark */
    html.dark #chatBox input,
    html.dark #chatBox textarea,
    html.dark #msgModal input,
    html.dark #msgModal textarea,
    html.dark .chat-modal input,
    html.dark .chat-modal textarea {
        background-color: var(--bg-input) !important;
        color: var(--text-primary) !important;
        border-color: var(--border-color) !important;
    }
    /* Chat input placeholder */
    html.dark #chatBox input::placeholder,
    html.dark #msgModal input::placeholder,
    html.dark .chat-modal input::placeholder {
        color: var(--text-muted) !important;
    }
    /* Send button — green */
    html.dark #chatBox button[type="submit"],
    html.dark #chatBox .send-btn,
    html.dark #msgModal button[type="submit"],
    html.dark .chat-modal button[type="submit"] {
        color: var(--accent-green) !important;
    }
    /* Scrollbar area — match card bg */
    html.dark #chatBox .overflow-y-auto,
    html.dark #msgModal .overflow-y-auto,
    html.dark .chat-modal .overflow-y-auto {
        background-color: var(--bg-card) !important;
    }
    /* Image preview in chat — dark border */
    html.dark #chatBox img,
    html.dark #msgModal img,
    html.dark .chat-modal img {
        border-color: var(--border-color) !important;
    }

    /* ── NOTIFICATION MODAL: match dark bg ───────────── */
    html.dark #notifModal,
    html.dark .notif-modal,
    html.dark [id*="notif"] > div {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }
    /* Notification "Close" button — match dark bg, not gray */
    html.dark #notifModal button,
    html.dark .notif-modal button,
    html.dark #notifModal [onclick*="close"],
    html.dark .notif-modal [onclick*="close"],
    html.dark #notifModal .close-btn,
    html.dark .notif-modal .close-btn {
        background-color: var(--bg-input) !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color) !important;
    }
    html.dark #notifModal button:hover,
    html.dark .notif-modal button:hover {
        background-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }
    /* Notification items */
    html.dark #notifModal .bg-white,
    html.dark .notif-modal .bg-white,
    html.dark #notifModal [class*="bg-white"] {
        background-color: var(--bg-card) !important;
    }
    html.dark #notifModal .text-gray-800,
    html.dark .notif-modal .text-gray-800,
    html.dark #notifModal .text-gray-900,
    html.dark .notif-modal .text-gray-900 {
        color: var(--text-primary) !important;
    }
    html.dark #notifModal .text-gray-500,
    html.dark .notif-modal .text-gray-500,
    html.dark #notifModal .text-gray-400,
    html.dark .notif-modal .text-gray-400 {
        color: var(--text-secondary) !important;
    }

        /* ── ALL EMERALD/GREEN BUTTONS: flat, no glow ───── */
    /* Catch-all for any button with emerald/green bg */
    html.dark button[class*="bg-emerald"],
    html.dark button[class*="bg-green"],
    html.dark a[class*="bg-emerald"],
    html.dark a[class*="bg-green"],
    html.dark .btn-emerald,
    html.dark .btn-green,
    html.dark [class*="btn"][class*="emerald"],
    html.dark [class*="btn"][class*="green"],
    html.dark input[type="submit"][class*="bg-emerald"],
    html.dark input[type="submit"][class*="bg-green"] {
        background-color: #059669 !important;
        background: #059669 !important;
        color: #ffffff !important;
        border-color: #047857 !important;
        box-shadow: none !important;
    }
    html.dark button[class*="bg-emerald"]:hover,
    html.dark button[class*="bg-green"]:hover,
    html.dark a[class*="bg-emerald"]:hover,
    html.dark a[class*="bg-green"]:hover {
        background-color: #047857 !important;
        background: #047857 !important;
    }
    /* Floating help button (?) — if it has specific classes */
    html.dark .help-btn,
    html.dark .fab-help,
    html.dark [class*="help"][class*="btn"],
    html.dark [class*="fab"][class*="help"],
    html.dark button[title*="help"],
    html.dark button[aria-label*="help"] {
        background-color: #059669 !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }
    /* Form submit buttons that might use different patterns */
    html.dark form button[type="submit"],
    html.dark form input[type="submit"],
    html.dark .form-btn,
    html.dark .submit-btn {
        background-color: #059669 !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }
    /* Profile action buttons (Save, Edit, Update, etc) */
    html.dark [class*="save"][class*="btn"],
    html.dark [class*="edit"][class*="btn"],
    html.dark [class*="update"][class*="btn"],
    html.dark [class*="profile"][class*="btn"],
    html.dark button[class*="save"],
    html.dark button[class*="edit"],
    html.dark button[class*="update"] {
        background-color: #059669 !important;
        color: #ffffff !important;
        box-shadow: none !important;
    }

        /* ── ONLINE STATUS DOT: bright emerald, PRECISE ───── */
    /* Only target small dots positioned on avatars/profile pics */
    html.dark .online-dot,
    html.dark .status-dot,
    html.dark .avatar-dot,
    html.dark .profile-dot {
        background-color: #10b981 !important;
        border: 2px solid var(--bg-card) !important;
        box-shadow: none !important;
    }
    /* Target small circular elements positioned absolute on rounded images */
    html.dark img.rounded-full ~ .absolute,
    html.dark .rounded-full ~ .absolute,
    html.dark .avatar ~ .absolute,
    html.dark .profile-pic ~ .absolute,
    html.dark [class*="avatar"] > .absolute:last-child,
    html.dark [class*="profile"] > .absolute:last-child,
    html.dark div[class*="relative"] > img + div[class*="absolute"] {
        background-color: #10b981 !important;
        border: 2px solid var(--bg-card) !important;
        box-shadow: none !important;
    }

        /* ── GREETING SECTION: ocean theme in dark mode ───── */
    /* Hide the forest image completely in dark mode */
    html.dark .bg-emerald-900 img,
    html.dark div[class*="bg-emerald-900"] img,
    html.dark div[class*="rounded-2xl"] > div > img {
        display: none !important;
    }
    /* Set ocean background on the container */
    html.dark .bg-emerald-900,
    html.dark div[class*="bg-emerald-900"] {
        background-color: #0a1628 !important;
        background-image: url('https://images.unsplash.com/photo-1531366936337-7c912a4589a7?auto=format&fit=crop&q=80&w=2000') !important;
        background-size: cover !important;
        background-position: center !important;
    }
    /* The overlay div that holds the gradient — force blue gradient */
    html.dark .bg-emerald-900 > div[class*="absolute"],
    html.dark div[class*="bg-emerald-900"] > div[class*="absolute"],
    html.dark .bg-emerald-900 .bg-gradient-to-br,
    html.dark div[class*="bg-emerald-900"] [class*="bg-gradient"] {
    }
    /* Decorative blur circle — reduced/subtle or removed */
    html.dark .bg-emerald-900 [class*="bg-emerald-400"],
    html.dark div[class*="bg-emerald-900"] [class*="bg-emerald-400"] {
        background-color: rgba(59, 130, 246, 0.08) !important;  /* much more subtle */
        /* OR to completely remove: display: none !important; */
    }
    /* Text readability */
    html.dark .bg-emerald-900 h1,
    html.dark .bg-emerald-900 h2,
    html.dark [class*="bg-emerald-900"] h1,
    html.dark [class*="bg-emerald-900"] h2 {
        color: #ffffff !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4) !important;
    }
    html.dark .bg-emerald-900 .text-white\/80,
    html.dark .bg-emerald-900 .text-white\/90,
    html.dark [class*="bg-emerald-900"] [class*="text-white"] {
        color: rgba(255, 255, 255, 0.9) !important;
    }
    /* Weather icon — light blue */
    html.dark .bg-emerald-900 svg,
    html.dark [class*="bg-emerald-900"] svg {
        color: #ffffff !important;
    }

        /* ── SIDEBAR DRAWER: header background in dark mode */
    /* The mobile drawer background — dark card color */
    html.dark #mobileDrawer,
    html.dark .mobile-drawer,
    html.dark [id*="drawer"] {
        background-color: var(--bg-card) !important;
    }
    /* The drawer HEADER specifically — the green nature header section */
    html.dark #mobileDrawer div[style*="background-image"],
    html.dark #drawerMain div[style*="background-image"],
    html.dark #mobileDrawer div[class*="bg-emerald-900\/50"],
    html.dark #drawerMain div[class*="bg-emerald-900"],
    html.dark #mobileDrawer div[class*="overflow-hidden"]:not([id]):not([class*="flex-1"]),
    html.dark #drawerMain > div:first-child > div:first-child {
        background-image: url('https://images.unsplash.com/photo-1742023299694-0b81944dca5a?q=80&w=1331&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') !important;
        background-size: cover !important;
        background-position: center !important;
    }
    /* Hide the original forest image inside the header */
    html.dark #mobileDrawer div[style*="background-image"] > div[style*="background-image"],
    html.dark #drawerMain div[style*="background-image"] > div[style*="background-image"] {
        display: none !important;
    }
    /* The overlay on the drawer header */
    html.dark #mobileDrawer div[class*="bg-emerald-900\/50"],
    html.dark #drawerMain div[class*="bg-emerald-900\/50"] {
        background: linear-gradient(to bottom, rgba(10, 15, 30, 0.6), rgba(15, 25, 50, 0.4)) !important;
    }

        /* ── Dark mode toggle switch ─────────────────────── */
    .dark-toggle {
        position: relative;
        display: inline-flex;
        align-items: center;
        width: 44px;
        height: 24px;
        background: var(--border-color);
        border-radius: 9999px;
        cursor: pointer;
        transition: background 0.25s;
        flex-shrink: 0;
    }
    .dark-toggle.active { background: var(--brand); }
    .dark-toggle::after {
        content: '';
        position: absolute;
        left: 3px;
        width: 18px;
        height: 18px;
        background: white;
        border-radius: 50%;
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .dark-toggle.active::after { transform: translateX(20px); }
</style>

<body class="bg-gray-50" x-data="{ activeTab: 'dashboard', taskModal: false }">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Header --}}
        @include('partials.header')

        {{-- Main Content --}}
        <main class="lg:ml-64 pb-20 lg:pb-0 flex-1 overflow-y-auto p-4 lg:p-6">
            <div class="space-y-6">
                @yield('content')
            </div>
        </main>

    </div>

</div>

{{-- ============================================================
     MODALS — all here so scripts below can find them
     ============================================================ --}}

{{-- Notes Inbox Modal --}}
<div id="inboxModal" class="fixed inset-0 bg-black/50 z-[60] flex items-end sm:items-center justify-center hidden">
    <div id="inboxInner" class="bg-white w-full h-full sm:h-auto sm:max-w-sm sm:mx-4 sm:rounded-xl shadow-2xl overflow-hidden flex flex-col">
        
        <div class="p-4 border-b flex justify-between items-center bg-gray-50">
            <h3 class="font-bold text-gray-700">My Notes</h3>
            <button id="closeInbox" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-2 pb-24 sm:pb-6">
             {{-- Your list items stay exactly in this container --}}
        </div>

        <div class="p-4 border-t bg-white sm:bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" id="noteSearch" 
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-100 sm:bg-white border border-transparent sm:border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" 
                        placeholder="Search notes...">
                </div>

                <button id="addNewBtn" class="bg-emerald-600 text-white p-3 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-100 active:scale-95 transition-all flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>


{{-- Compose Note Modal --}}
<div id="composeModal" class="fixed inset-0 bg-black/60 z-[70] flex items-end sm:items-center justify-center hidden">
    <div id="composeInner" class="bg-white w-full h-full sm:h-auto sm:max-w-md sm:mx-4 sm:rounded-xl shadow-2xl overflow-hidden flex flex-col">
        
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">New Note</h3>
            <button id="closeCompose" class="text-gray-400 hover:text-gray-600 text-3xl leading-none px-2">&times;</button>
        </div>
        
        <div class="p-4 flex-1 flex flex-col">
            <input type="text" placeholder="Title..." class="w-full mb-3 p-2 border-b font-semibold focus:outline-none focus:border-blue-500">
            
            <textarea class="w-full flex-1 p-2 text-gray-600 outline-none resize-none" placeholder="Start writing..."></textarea>
        </div>
        
        <div class="p-4 bg-gray-50 flex justify-end">
            <button id="saveNote" class="w-full sm:w-auto px-6 py-3 sm:py-2 bg-emerald-600 text-white rounded-lg font-medium shadow-md hover:bg-emerald-700 transition-colors">
                Save Note
            </button>
        </div>
    </div>
</div>



{{-- Messages Dropdown --}}
<div id="msgModal" class="hidden fixed top-16 right-4 w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[999] overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-white">
        <h3 class="text-sm font-black text-gray-800 uppercase tracking-tighter">Messages</h3>
        <span id="studentNewLabel" class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full hidden"></span>
    </div>
    <div class="max-h-[300px] overflow-y-auto">
       <div onclick="openChat()" class="p-4 flex items-center gap-3 hover:bg-gray-50 cursor-pointer transition-colors active:bg-gray-100">
    <div class="relative flex-shrink-0">
       <img src="https://ui-avatars.com/api/?name=Sarah+Miller&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full supervisor-avatar">
        <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
    </div>
    <div class="flex-1 min-w-0">
    <p id="supervisorName" class="text-sm font-bold text-gray-900 truncate transition-colors supervisor-name">Sarah Miller</p>
    <div class="flex items-center gap-1">
        <p id="studentMsgPreview" class="text-xs text-gray-500 truncate font-medium transition-colors">No messages yet</p>
        <span id="studentMsgTime" class="text-[11px] text-gray-400 font-medium shrink-0 before:content-['·'] before:mr-1"></span>
    </div>
</div>
</div>
    </div>
    <div class="flex border-t border-gray-100 bg-gray-50/50">
        <button onclick="closeAll()" class="flex-1 p-3 text-xs font-bold text-gray-400 hover:text-gray-600">Close</button>
    </div>
</div>

{{-- Notifications Dropdown --}}
<div id="notifModal" class="hidden fixed top-16 right-4 w-80 bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-gray-100 z-[999] overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-white">
        <h3 class="text-sm font-black text-gray-800 uppercase tracking-tighter">Notifications</h3>
        <button onclick="markAllNotifsRead()" class="text-[10px] font-semibold text-emerald-600 hover:text-emerald-700">Mark all read</button>
    </div>
    <div id="notifList" class="max-h-[300px] overflow-y-auto">
        {{-- Notifications loaded here --}}
        <div class="p-4 text-center text-xs text-gray-400">Loading...</div>
    </div>
    <div class="flex border-t border-gray-100 bg-gray-50/50">
        <button onclick="closeAll()" class="flex-1 p-3 text-xs font-bold text-gray-400 hover:text-gray-600">Close</button>
    </div>
</div>

{{-- Profile Edit Modal --}}
<div id="profileModal" class="hidden fixed inset-0 bg-black/50 z-[80] flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Edit Profile</h3>
            <button id="closeProfile" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Full Name</label>
                <input type="text" value="Charlie Kirk" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest">Email</label>
                <input type="email" value="charlie.kirk@neck.edu" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
            </div>
        </div>
        <div class="p-4 bg-gray-50 flex justify-end gap-2">
            <button id="cancelProfile" class="px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button>
            <button class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-medium text-sm hover:bg-emerald-700">Save</button>
        </div>
    </div>
</div>

{{-- Chat Window --}}
<div id="chatBox" class="hidden fixed inset-0 sm:inset-auto sm:bottom-6 sm:right-4 sm:w-80 sm:h-[500px] bg-white sm:rounded-2xl shadow-2xl border-gray-200 z-[9999] flex flex-col overflow-hidden animate-in slide-in-from-bottom-full duration-300">
    <div class="p-4 bg-white border-b border-gray-100 flex items-center justify-between shrink-0 h-16 sm:h-auto">
        <div class="flex items-center gap-3">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name=Sarah+Miller&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full supervisor-avatar">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
            <div>
                <p class="text-sm font-black text-gray-900 leading-none supervisor-name">Sarah Miller</p>  
                <p class="text-[10px] text-green-500 font-bold uppercase mt-1">Active Now</p>
            </div>
        </div>
        <button onclick="closeChat()" class="p-2 hover:bg-gray-100 rounded-full text-gray-400 transition-colors">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
    </div>
    <div id="messageList" class="flex-1 overflow-y-auto p-4 flex flex-col gap-4 bg-gray-50/50"></div>
    <div class="p-4 border-t border-gray-100 bg-white pb-8 sm:pb-4 shrink-0">
    <div class="flex items-center gap-2">
        <input id="msgInput" type="text" placeholder="Type a message..." class="flex-1 min-w-0 bg-gray-100 border-none rounded-full px-4 py-3 text-sm focus:ring-1 focus:ring-blue-500 outline-none"> 
        
        <button id="imageBtn" class="text-gray-500 hover:text-emerald-500 p-1 active:scale-90 transition-transform shrink-0">
            <input type="file" id="mediaInput" accept="image/jpeg,image/png,image/gif,video/mp4,video/webm,video/ogg" class="hidden">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        </button>

        <button id="sendBtn" class="text-emerald-600 p-1 active:scale-90 transition-transform shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
        </button>
    </div>
</div>
</div>


<div id="mediaPreviewModal" class="fixed inset-0 bg-black/70 z-[999] flex items-center justify-center hidden"
     style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999;">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Send Media</h3>
            <button id="closeMediaPreview" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div class="p-4 flex items-center justify-center bg-gray-50 min-h-48">
            <img id="imagePreview" class="max-h-64 max-w-full rounded-lg object-contain hidden" />
            <video id="videoPreview" class="max-h-64 max-w-full rounded-lg object-contain hidden" controls></video>
        </div>
        <div class="p-4 flex justify-between items-center gap-2">
            <button id="cancelMediaBtn" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">Cancel</button>
            <button id="sendMediaBtn" class="px-6 py-2 bg-emerald-600 text-white rounded-lg font-medium shadow-md hover:bg-emerald-700 transition-colors">Send</button>
        </div>
    </div>
</div>


{{-- ============================================================
     SCRIPTS — loads after ALL html above
     ============================================================ --}}
{{-- ChatConfig FIRST --}}
<script>
    fetch('/student/supervisor')
        .then(r => r.json())
        .then(supervisor => {
            if (!supervisor) return;

            const name = supervisor.name || 'Unknown';
            
            const nameEls = document.querySelectorAll('#supervisorName, .supervisor-name');
            nameEls.forEach(el => el.textContent = name);

            const avatarEls = document.querySelectorAll('.supervisor-avatar');
            avatarEls.forEach(el => el.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=0ea5e9&color=fff`);
        })
        .catch(err => console.error('Failed to load supervisor:', err));
</script>


@stack('scripts')
<script src="{{ asset('js/student-header.js') }}"></script>

</body>
</html>