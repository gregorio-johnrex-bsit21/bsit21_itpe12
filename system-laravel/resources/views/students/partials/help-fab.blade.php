{{-- ========================================== --}}
{{-- FLOATING HELP FAB — REPLAY TUTORIAL        --}}
{{-- ========================================== --}}

<button id="helpFab" 
    class="fixed right-4 bottom-20 z-[45] w-11 h-11 rounded-full bg-emerald-500 text-white flex items-center justify-center hover:bg-emerald-600 active:scale-90 transition-all duration-200 group"
    aria-label="Replay tutorial">
    
    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
    </svg>
    
    {{-- Tooltip on hover --}}
    <span class="absolute right-full mr-3 px-2 py-1 bg-gray-900 text-white text-[10px] font-medium rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
        Replay tutorial
    </span>
</button>

<script>
(function() {
    const fab = document.getElementById('helpFab');
    if (!fab) return;
    
    fab.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Check if tutorial engine is loaded
        if (typeof window.initTutorial !== 'function') {
            console.error('Tutorial engine not loaded');
            return;
        }
        
        // Check if page has tutorial steps defined
        if (window.pageTutorialSteps && Array.isArray(window.pageTutorialSteps) && window.pageTutorialSteps.length > 0) {
            window.initTutorial(window.pageTutorialSteps, {
                onFinish: function() {
                    console.log('Tutorial replayed');
                }
            });
        } else {
            console.warn('No pageTutorialSteps defined. Make sure the page includes its tutorial partial.');
        }
    });
})();
</script>