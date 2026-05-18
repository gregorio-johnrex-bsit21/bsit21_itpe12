{{-- ========================================== --}}
{{-- DASHBOARD TUTORIAL STEPS                   --}}
{{-- ========================================== --}}

@include('students.partials.tutorial-engine')

<script>
(function() {
    // Define steps globally so replay works
   window.pageTutorialSteps = [
    {
        target: '.w-full.p-8', // Header
        title: 'Your Dashboard',
        desc: 'This is your main hub. See your OJT status, weather, and date at a glance.',
        tooltipPos: 'below'
    },
    {
        target: '.scard-blue', // Required
        title: 'Required Hours',
        desc: 'Total OJT hours you need to complete.',
        tooltipPos: 'above'
    },
    {
        target: '.scard-emerald', // Accumulated
        title: 'Accumulated Hours',
        desc: 'Hours you have already completed.',
        tooltipPos: 'above'
    },
    {
        target: '.scard-orange', // Remaining
        title: 'Remaining Hours',
        desc: 'Hours left before you finish.',
        scrollFirst: true,
        tooltipPos: 'below'
    },
    {
        target: '.scard-rose', // Missed
        title: 'Missed Hours',
        desc: 'Hours missed due to late time-ins.',
        scrollFirst: true,
        tooltipPos: 'below'
    },
    {
        target: '.progress-card', // Progress — MAKE SURE THIS CLASS EXISTS
        title: 'Progress Tracker',
        desc: 'Your overall completion percentage. The ring fills up as you log more hours.',
        scrollFirst: true,
        tooltipPos: 'above',
        padding: 16,
        borderRadius: '16px'
    },
    {
        target: '[data-tutorial="tasks"]',
        title: 'Tasks',
        desc: 'Submit your daily tasks here.',
        tooltipPos: 'above',
        navHighlight: true
    },
    {
        target: '[data-tutorial="logs"]',
        title: 'Logs',
        desc: 'View your attendance history.',
        tooltipPos: 'above',
        navHighlight: true
    },
    {
        target: '[data-tutorial="profile"]',
        title: 'Profile',
        desc: 'Manage your personal info.',
        tooltipPos: 'above',
        navHighlight: true
    }
];

    // Only auto-start if profile is complete AND tutorial not seen
    @if(session('profile_complete') && !session('has_seen_tutorial'))
    
    setTimeout(() => {
        window.initTutorial(window.pageTutorialSteps, {
            onFinish: function() {
                fetch('{{ route("students.tutorial.seen") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(r => {
                    if (!r.ok) throw new Error('Network response was not ok');
                    return r.json();
                })
                .then(data => {
                    console.log('Tutorial marked as seen');
                })
                .catch(err => {
                    console.error('Failed to mark tutorial seen:', err);
                });
            }
        });
    }, 800);

    @endif
})();
</script>