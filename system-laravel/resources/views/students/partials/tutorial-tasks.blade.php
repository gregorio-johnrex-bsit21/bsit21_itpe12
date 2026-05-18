{{-- ========================================== --}}
{{-- TASKS PAGE TUTORIAL STEPS                  --}}
{{-- ========================================== --}}

@include('students.partials.tutorial-engine')

<script>
(function() {
    // Define steps globally so replay works on Tasks page
    window.pageTutorialSteps = [
        {
            target: '.task-list, [data-tutorial="task-list"], .tasks-container',
            title: 'Your Tasks',
            desc: 'Here you see all tasks assigned by your supervisor. Check deadlines and status.',
            position: 'bottom'
        },
        {
            target: '.task-submit-btn, [data-tutorial="submit"], button[type="submit"]',
            title: 'Submit Task',
            desc: 'Click here to upload your completed work and mark tasks as done.',
            position: 'top'
        },
        {
            target: '[data-tutorial="tasks"]',
            title: 'Tasks Tab',
            desc: 'You are currently on the Tasks page. Use the bottom nav to switch pages.',
            position: 'top'
        }
    ];
})();
</script>