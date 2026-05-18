{{-- ========================================== --}}
{{-- TUTORIAL ENGINE — FIXES: spacing, white nav, progress step --}}
{{-- ========================================== --}}

<div id="tutorialOverlay" class="fixed inset-0 z-[300] hidden">
    <div id="tutorialBackdrop" class="absolute inset-0 bg-black/0 transition-all duration-500"></div>
    
    <div id="tutorialSpotlight" 
         class="absolute transition-all duration-500 ease-out pointer-events-none"
         style="box-shadow: 0 0 0 9999px rgba(0,0,0,0); border-radius: 12px;">
    </div>

    <div id="tutorialTooltip" 
         class="absolute rounded-xl p-3 w-[calc(100vw-32px)] max-w-[280px] transition-all duration-500 ease-out opacity-0 z-[302]"
         style="pointer-events: auto; background: rgba(30, 41, 59, 0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.1);">
        
        <div class="flex items-center gap-2.5 mb-2">
            <div class="w-6 h-6 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 flex-shrink-0">
                <span id="tutorialStepNum" class="text-[10px] font-bold">1</span>
            </div>
            <div class="min-w-0">
                <h4 id="tutorialTitle" class="font-bold text-white/90 text-[11px] leading-tight">Title</h4>
                <span id="tutorialCounter" class="text-[8px] text-white/40 font-medium uppercase tracking-wider">Step 1 of 9</span>
            </div>
        </div>
        
        <p id="tutorialDesc" class="text-[11px] text-white/70 leading-relaxed mb-3"></p>

        <div id="tutorialDots" class="flex justify-center gap-1 mb-3"></div>

        <div class="flex items-center justify-between">
            <button id="tutorialSkip" class="text-[10px] font-medium text-white/40 hover:text-white/60 transition px-2 py-1">
                Skip
            </button>
            <div class="flex gap-2">
                <button id="tutorialPrev" class="px-2.5 py-1 rounded-lg text-[10px] font-semibold text-white/70 bg-white/10 hover:bg-white/20 transition hidden">
                    ← Back
                </button>
                <button id="tutorialNext" class="px-3 py-1 rounded-lg text-[10px] font-semibold text-white bg-emerald-500 hover:bg-emerald-600 transition shadow-sm">
                    Next →
                </button>
            </div>
        </div>
    </div>
</div>

<style>
body.tutorial-active {
    overflow: hidden !important;
    touch-action: none;
}

/* EMERALD GLOW - only on the square edges */
#tutorialSpotlight {
    /* Default: just dark overlay */
    box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6);
}
</style>

<script>
(function() {
    'use strict';

    const overlay = document.getElementById('tutorialOverlay');
    const backdrop = document.getElementById('tutorialBackdrop');
    const spotlight = document.getElementById('tutorialSpotlight');
    const tooltip = document.getElementById('tutorialTooltip');
    
    const titleEl = document.getElementById('tutorialTitle');
    const descEl = document.getElementById('tutorialDesc');
    const stepNumEl = document.getElementById('tutorialStepNum');
    const counterEl = document.getElementById('tutorialCounter');
    const dotsEl = document.getElementById('tutorialDots');
    const nextBtn = document.getElementById('tutorialNext');
    const prevBtn = document.getElementById('tutorialPrev');
    const skipBtn = document.getElementById('tutorialSkip');

    let steps = [];
    let currentStep = 0;
    let isActive = false;
    let finishCallback = null;
    let isFinishing = false;

    window.initTutorial = function(tutorialSteps, options = {}) {
        if (isActive) forceCleanup();
        
        steps = tutorialSteps || [];
        currentStep = 0;
        finishCallback = options.onFinish || null;
        isFinishing = false;
        
        if (!steps || steps.length === 0) return;
        
        isActive = true;
        document.body.classList.add('tutorial-active');
        overlay.classList.remove('hidden');
        
        requestAnimationFrame(() => {
            backdrop.style.backgroundColor = 'rgba(0,0,0,0.6)';
        });
        
        buildDots();
        setTimeout(() => renderStep(false), 100);
    };

        function forceCleanup() {
        isActive = false;
        isFinishing = false;
        document.body.classList.remove('tutorial-active');
        backdrop.style.backgroundColor = 'rgba(0,0,0,0)';
        spotlight.style.border = 'none';
        tooltip.style.opacity = '0';
        
        steps.forEach(step => {
            const target = findTarget(step.target);
            if (target) {
                target.style.position = '';
                target.style.zIndex = '';
            }
        });
        
        // Remove emerald glow
        spotlight.classList.remove('emerald-glow');
    }

    window.replayTutorial = function() {
        if (window.pageTutorialSteps && window.pageTutorialSteps.length > 0) {
            window.initTutorial(window.pageTutorialSteps, {
                onFinish: () => console.log('Tutorial replayed')
            });
        }
    };

    function buildDots() {
        dotsEl.innerHTML = '';
        steps.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.className = `w-1 h-1 rounded-full transition-all duration-300 ${i === 0 ? 'bg-emerald-400 w-3' : 'bg-white/30'}`;
            dotsEl.appendChild(dot);
        });
    }

    function updateDots() {
        Array.from(dotsEl.children).forEach((dot, i) => {
            dot.className = `w-1 h-1 rounded-full transition-all duration-300 ${i === currentStep ? 'bg-emerald-400 w-3' : 'bg-white/30'}`;
        });
    }

    function findTarget(selector) {
        if (!selector) return null;
        if (typeof selector === 'string') return document.querySelector(selector);
        for (let sel of selector) {
            const el = document.querySelector(sel);
            if (el) return el;
        }
        return null;
    }

    function renderStep(isAfterScroll = false) {
        if (!isActive) return;
        
        const step = steps[currentStep];
        const target = findTarget(step.target);
        
        if (!target) {
            console.warn('Target not found:', step.target);
            if (currentStep < steps.length - 1) {
                currentStep++;
                renderStep(false);
            } else {
                finishTutorial();
            }
            return;
        }

        const rect = target.getBoundingClientRect();
        const viewportH = window.innerHeight;
        const padding = step.padding || 12;
        
        // Check if we need to scroll
        const isNotFullyVisible = rect.top < 80 || rect.bottom > viewportH - 100;
        const needsScroll = step.scrollFirst === true && isNotFullyVisible && !isAfterScroll;
        
        if (needsScroll) {
            tooltip.style.opacity = '0';
            spotlight.style.boxShadow = '0 0 0 9999px rgba(0,0,0,0)';
            
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            setTimeout(() => renderStep(true), 500);
            return;
        }

        // Update content
        titleEl.textContent = step.title || '';
        descEl.textContent = step.desc || '';
        stepNumEl.textContent = currentStep + 1;
        counterEl.textContent = `Step ${currentStep + 1} of ${steps.length}`;
        
        prevBtn.classList.toggle('hidden', currentStep === 0);
        nextBtn.textContent = currentStep === steps.length - 1 ? 'Finish ✓' : 'Next →';
        updateDots();

                // ==========================================
        // SPOTLIGHT — Emerald glow on square edges only
        // ==========================================
        
        // Clear any old styles
        spotlight.style.border = '';
        spotlight.style.boxShadow = '';
        
        // Apply emerald border + dark overlay directly (no classes)
        spotlight.style.border = '3px solid rgb(16, 185, 129)';
        spotlight.style.boxShadow = '0 0 0 9999px rgba(0, 0, 0, 0.6), 0 0 15px rgb(16, 185, 129)';
        
        
        const sWidth = rect.width + (padding * 2);
        const sHeight = rect.height + (padding * 2);
        const sLeft = rect.left - padding;
        const sTop = rect.top - padding;
        
        const computedStyle = window.getComputedStyle(target);
        const targetRadius = computedStyle.borderRadius;
        spotlight.style.borderRadius = targetRadius !== '0px' ? targetRadius : (step.borderRadius || '16px');
        
        spotlight.style.width = `${sWidth}px`;
        spotlight.style.height = `${sHeight}px`;
        spotlight.style.left = `${sLeft}px`;
        spotlight.style.top = `${sTop}px`;

        // ==========================================
        // TOOLTIP POSITION
        // ==========================================
        
        const viewportW = window.innerWidth;
        const margin = 16;
        const bottomNavH = 75;
        const topOffset = 60;
        
        let tooltipPos = step.tooltipPos || 'auto';
        
        if (tooltipPos === 'auto') {
            const targetCenterY = rect.top + rect.height / 2;
            if (targetCenterY < viewportH / 2.5) {
                tooltipPos = 'below';
            } else {
                tooltipPos = 'above';
            }
        }
        
        // Reset to measure
        tooltip.style.opacity = '0';
        tooltip.style.left = `${margin}px`;
        tooltip.style.top = `${topOffset}px`;
        
        const tooltipRect = tooltip.getBoundingClientRect();
        const tooltipH = tooltipRect.height;
        
        let finalTop, finalLeft = margin;
        const gap = 20; // BIGGER gap for remaining/missed
        
        if (tooltipPos === 'below') {
            // Tooltip BELOW target — with bigger gap
            finalTop = rect.bottom + gap;
            
            // If would go off bottom, put above instead
            if (finalTop + tooltipH > viewportH - bottomNavH - margin) {
                finalTop = rect.top - tooltipH - gap;
            }
        } else {
            // Tooltip ABOVE — at top
            finalTop = topOffset;
            
            // If target is very top, put below target
            if (rect.top < topOffset + tooltipH + gap) {
                finalTop = rect.bottom + gap;
            }
        }
        
        // Safety clamps
        finalTop = Math.max(margin, Math.min(finalTop, viewportH - bottomNavH - tooltipH - margin));
        
        tooltip.style.width = `${Math.min(280, viewportW - 32)}px`;
        tooltip.style.left = `${finalLeft}px`;
        tooltip.style.top = `${finalTop}px`;
        tooltip.style.zIndex = '302';
        tooltip.style.opacity = '1';
        tooltip.style.transform = 'translateY(0)';

        // Bring target above overlay
        target.style.position = 'relative';
        target.style.zIndex = '301';
    }

    function nextStep() {
        if (isFinishing) return;
        cleanupCurrentStep();
        currentStep++;
        if (currentStep >= steps.length) finishTutorial();
        else renderStep(false);
    }

    function prevStep() {
        if (isFinishing) return;
        cleanupCurrentStep();
        currentStep--;
        renderStep(false);
    }

        function cleanupCurrentStep() {
        if (currentStep >= 0 && currentStep < steps.length) {
            const target = findTarget(steps[currentStep].target);
            if (target) {
                target.style.position = '';
                target.style.zIndex = '';
            }
        }
        // Remove glow when moving to next step
        spotlight.style.border = 'none';
    }

        function finishTutorial() {
        if (isFinishing) return;
        isFinishing = true;
        isActive = false;
        
        cleanupCurrentStep();
        document.body.classList.remove('tutorial-active');
        
        backdrop.style.backgroundColor = 'rgba(0,0,0,0)';
        spotlight.style.boxShadow = '0 0 0 9999px rgba(0,0,0,0)';
        spotlight.style.border = 'none';
        tooltip.style.opacity = '0';
        
        setTimeout(() => {
            overlay.classList.add('hidden');
            if (finishCallback) {
                try { finishCallback(); } catch (e) { console.error(e); }
            }
        }, 500);
    }

    nextBtn.addEventListener('click', nextStep);
    prevBtn.addEventListener('click', prevStep);
    skipBtn.addEventListener('click', finishTutorial);
    
    document.addEventListener('keydown', (e) => {
        if (!isActive) return;
        if (e.key === 'Escape') finishTutorial();
        if (e.key === 'ArrowRight') nextStep();
        if (e.key === 'ArrowLeft') prevStep();
    });

})();
</script>