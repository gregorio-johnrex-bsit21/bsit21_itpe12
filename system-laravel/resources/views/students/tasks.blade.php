
@extends('layouts.app')

@section('title', 'Tasks')

@section('content')

<style>
    html.dark [data-log-card] {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }
    html.dark [data-log-card] p.text-white { color: #ffffff !important; }
    html.dark .bg-slate-50\/80 { background-color: var(--bg-secondary) !important; }
    html.dark .bg-slate-50 { background-color: var(--bg-secondary) !important; }
    html.dark .border-slate-200 { border-color: var(--border-color) !important; }
    html.dark .text-slate-700, html.dark .text-slate-800 { color: var(--text-secondary) !important; }
    html.dark .text-slate-400, html.dark .text-slate-500 { color: var(--text-muted) !important; }

    /* Clock widget */
    html.dark .bg-white.border-slate-200\/60 {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }
    html.dark .bg-slate-50.rounded-xl { background-color: var(--bg-secondary) !important; }
    html.dark .bg-emerald-50 { background-color: rgba(6, 78, 59, 0.3) !important; }

    /* Missed hours modals */
    html.dark .bg-white.rounded-2xl,
    html.dark .bg-white.rounded-t-3xl {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }
    html.dark .bg-slate-50.rounded-xl.border { background-color: var(--bg-secondary) !important; border-color: var(--border-color) !important; }
</style>

<style>
    :root {
        --color-brand: #059669;
        --color-brand-light: #ecfdf5;
    }
</style>

<div x-data="{
    filter: 'all',
    taskModal: false,
    selectedTask: null,
    openTask(task) { this.selectedTask = task; this.taskModal = true; }
}">

    {{-- Header + Search --}}
    <div class="flex items-center gap-2 mb-6">
        <h2 class="text-xl font-bold text-gray-900 flex-1" id="tasks-heading">Assigned Tasks</h2>

        <div id="search-wrapper" class="hidden flex-1 min-w-0">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
                </svg>
                <input
                    type="text"
                    id="task-search"
                    placeholder="Search tasks..."
                    autocomplete="off"
                    class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition shadow-sm">
            </div>
        </div>

        <button id="search-toggle" class="flex-shrink-0 p-2 rounded-xl bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-500 transition">
            <svg id="search-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 105 11a6 6 0 0012 0z"/>
            </svg>
            <svg id="close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Filter Tabs --}}
    <div class="mt-2 mb-6">
        <div class="grid grid-cols-4 gap-1">
            <button @click="filter = 'all'"
                :class="filter === 'all' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 bg-white border border-slate-200 hover:bg-slate-50'"
                class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold whitespace-nowrap text-center transition">
                ALL
            </button>
            <button @click="filter = 'pending'"
                :class="filter === 'pending' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 bg-white border border-slate-200 hover:bg-slate-50'"
                class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold whitespace-nowrap text-center transition">
                NEW
            </button>
            <button @click="filter = 'ongoing'"
                :class="filter === 'ongoing' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 bg-white border border-slate-200 hover:bg-slate-50'"
                class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold whitespace-nowrap text-center transition">
                ONGOING
            </button>
            <button @click="filter = 'completed'"
                :class="filter === 'completed' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 bg-white border border-slate-200 hover:bg-slate-50'"
                class="w-full px-2 py-2 rounded-xl text-[10px] font-semibold whitespace-nowrap text-center transition">
                DONE
            </button>
        </div>
    </div>

    {{-- Task Cards --}}
    @if($tasks->isEmpty())
        <div class="text-center py-16 text-slate-400 text-sm">No tasks assigned yet.</div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($tasks as $task)
        @php
            $statusColor = match($task['status']) {
                'completed' => 'bg-emerald-600 text-white',
                'ongoing'   => 'bg-orange-500 text-white',
                default     => 'bg-slate-200 text-slate-600',
            };
            $barColor = match($task['status']) {
                'completed' => '#059669',
                'ongoing'   => '#ea580c',
                default     => '#94a3b8',
            };
        @endphp
        <div
            x-show="filter === 'all' || filter === '{{ $task['status'] }}'"
            data-task-card
            data-title="{{ strtolower($task['task_title']) }}"
            data-desc="{{ strtolower($task['description']) }}"
            data-status="{{ $task['status'] }}"
            class="bg-white p-5 rounded-2xl border border-slate-200 hover:shadow-md transition-all duration-200 cursor-pointer group">

            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2 flex-1 max-w-[200px]">
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full transition-all duration-500"
                             style="width: {{ $task['progress'] }}%; background-color: {{ $barColor }};"></div>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-500">{{ $task['progress'] }}%</span>
                </div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase">
                    {{ $task['deadline'] ?? 'No deadline' }}
                </p>
            </div>

            <h4 class="font-semibold text-slate-800 mb-1 text-base group-hover:text-emerald-600 transition">
                {{ $task['task_title'] }}
            </h4>
            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2">
                {{ $task['description'] }}
            </p>

            <div class="mt-2 text-[10px] text-slate-400 font-medium">
                Step {{ $task['approved'] }} of {{ $task['total_steps'] }} approved
            </div>

            <div class="mt-5 pt-4 border-t border-slate-100 flex justify-between items-center">
                <button @click="openTask({{ json_encode($task) }}); document.getElementById('currentTaskId').value = '{{ $task['id'] }}'"
                    class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    View Details →
                </button>
                <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold uppercase tracking-widest {{ $statusColor }}">
                    {{ ucfirst($task['status']) }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- TASK DETAIL + SUBMIT MODAL --}}
    <div x-show="taskModal" x-cloak class="fixed inset-0 z-[10001] flex items-center justify-center p-4">
        <div @click="taskModal = false"
             x-show="taskModal"
             x-transition
             class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

        <div x-show="taskModal"
             x-transition
             class="relative w-full max-w-sm bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden z-10 max-h-[85vh] flex flex-col">

            <div class="p-6 overflow-y-auto flex-1">
                <input type="hidden" id="currentTaskId" value="">

                {{-- Status + Close --}}
                <div class="flex justify-between items-center mb-4">
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold uppercase"
                          :class="{
                              'bg-emerald-600 text-white': selectedTask?.status === 'completed',
                              'bg-orange-500 text-white': selectedTask?.status === 'ongoing',
                              'bg-slate-200 text-slate-600': selectedTask?.status === 'pending',
                          }"
                          x-text="selectedTask?.status"></span>
                    <button @click="taskModal = false" class="text-gray-400 hover:bg-gray-100 p-1 rounded-lg transition">✕</button>
                </div>

                <h3 class="text-lg font-semibold text-slate-900 mb-1" x-text="selectedTask?.task_title"></h3>
                <p class="text-[11px] text-slate-400 uppercase mb-5" x-text="selectedTask?.deadline ? 'Due ' + selectedTask.deadline : 'No deadline'"></p>

                {{-- Description --}}
                <div class="bg-slate-50 rounded-xl p-4 mb-4 border border-slate-100" x-show="selectedTask?.description">
                    <h4 class="text-[10px] font-semibold text-emerald-600 uppercase mb-2 tracking-widest">Description</h4>
                    <p class="text-sm text-slate-600" x-text="selectedTask?.description"></p>
                </div>

                {{-- Guidelines --}}
                <div class="bg-slate-50 rounded-xl p-4 mb-4 border border-slate-100" x-show="selectedTask?.guidelines">
                    <h4 class="text-[10px] font-semibold text-emerald-600 uppercase mb-2 tracking-widest">Guidelines</h4>
                    <p class="text-sm text-slate-600 italic" x-text="selectedTask?.guidelines"></p>
                </div>

                {{-- Progress --}}
                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Progress</span>
                        <span class="text-[10px] font-black text-slate-600"
                              x-text="(selectedTask?.approved ?? 0) + '/' + (selectedTask?.total_steps ?? 0) + ' steps approved'"></span>
                    </div>
                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-600 rounded-full transition-all duration-500"
                             :style="`width: ${selectedTask?.progress ?? 0}%`"></div>
                    </div>
                </div>

                {{-- Submissions History --}}
                <div class="mb-4" x-show="selectedTask?.submissions?.length > 0">
                    <h4 class="text-[10px] font-semibold text-slate-400 uppercase mb-2 tracking-widest">Submission History</h4>
                    <div class="space-y-2">
                        <template x-for="sub in selectedTask?.submissions" :key="sub.id">
                            <div class="flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-100">
                                <a :href="sub.proof_url" target="_blank">
                                    <img :src="sub.proof_url" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                </a>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-slate-700">Step <span x-text="sub.step_number"></span></p>
                                    <p class="text-[10px] text-slate-400" x-text="sub.created_at"></p>
                                    <p class="text-[10px] text-orange-500" x-show="sub.notes" x-text="sub.notes"></p>
                                </div>
                                <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase"
                                      :class="{
                                          'bg-emerald-50 text-emerald-700': sub.status === 'approved',
                                          'bg-red-50 text-red-600': sub.status === 'rejected',
                                          'bg-amber-50 text-amber-600': sub.status === 'pending',
                                      }"
                                      x-text="sub.status"></span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Upload Proof --}}
                <div x-show="selectedTask?.can_submit && selectedTask?.status !== 'completed'">
                    <div class="border border-dashed border-slate-200 rounded-xl p-4 text-center hover:bg-slate-50 cursor-pointer"
                         onclick="document.getElementById('proofInput').click()">
                        <p class="text-sm font-semibold text-emerald-600">+ Upload Proof Photo</p>
                        <p class="text-xs text-slate-400" x-text="'Step ' + (selectedTask?.next_step ?? 1) + ' of ' + (selectedTask?.total_steps ?? 1)"></p>
                    </div>
                    <input type="file" id="proofInput" accept="image/jpeg,image/png,image/jpg,application/pdf"
                           class="hidden" onchange="previewProof(this)">
                    <div id="proofPreviewContainer" class="hidden mt-3">
                        <img id="proofPreview" class="w-full max-h-40 object-cover rounded-xl border border-slate-200">
                        <p id="proofFileName" class="text-xs text-slate-400 mt-1 text-center"></p>
                    </div>
                </div>

                <div x-show="!selectedTask?.can_submit && selectedTask?.status !== 'completed'"
                     class="p-3 bg-amber-50 rounded-xl border border-amber-100 text-center">
                    <p class="text-xs font-semibold text-amber-600">Waiting for supervisor to review your submission...</p>
                </div>

                <div x-show="selectedTask?.status === 'completed'"
                     class="p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-center">
                    <p class="text-xs font-semibold text-emerald-600">🎉 All steps completed!</p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="p-4 border-t border-slate-100 flex gap-2 shrink-0">
                <button @click="taskModal = false"
                    class="flex-1 py-2 text-sm text-slate-400 hover:text-slate-600 border border-slate-200 rounded-xl">
                    Close
                </button>
                <button x-show="selectedTask?.can_submit && selectedTask?.status !== 'completed'"
                    onclick="submitProof()"
                    class="flex-1 py-2 text-sm text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 font-semibold">
                    Submit Proof
                </button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    let selectedFile = null;

    function previewProof(input) {
        const file = input.files[0];
        if (!file) return;
        selectedFile = file;

        const container = document.getElementById('proofPreviewContainer');
        const preview   = document.getElementById('proofPreview');
        const name      = document.getElementById('proofFileName');

        if (file.type.startsWith('image/')) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
        name.textContent = file.name;
        container.classList.remove('hidden');
    }

    function submitProof() {
        if (!selectedFile) {
            alert('Please select a proof photo first.');
            return;
        }

        const taskIdInput = document.getElementById('currentTaskId');
        const taskId      = taskIdInput ? taskIdInput.value : '';

        if (!taskId) {
            alert('Please reopen the task and try again.');
            return;
        }

        const formData = new FormData();
        formData.append('task_id', taskId);
        formData.append('proof', selectedFile);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        fetch("{{ route('students.tasks.submit') }}", {
            method: 'POST',
            body: formData
        })
        .then(r => {
            if (!r.ok) {
                return r.text().then(text => {
                    throw new Error('Server returned ' + r.status);
                });
            }
            return r.json();
        })
        .then(d => {
            if (d.success) {
                alert(d.message);
                location.reload();
            } else {
                alert(d.message || 'Submission failed.');
            }
        })
        .catch(err => {
            alert('Failed: ' + err.message);
        });
    }

    // ── Search ────────────────────────────────────────────────────
    const searchToggle = document.getElementById('search-toggle');
    const searchWrapper = document.getElementById('search-wrapper');
    const searchInput   = document.getElementById('task-search');
    const searchIcon    = document.getElementById('search-icon');
    const closeIcon     = document.getElementById('close-icon');
    const tasksHeading  = document.getElementById('tasks-heading');
    let searchOpen      = false;

    searchToggle.addEventListener('click', () => {
        searchOpen = !searchOpen;

        if (searchOpen) {
            tasksHeading.classList.add('hidden');
            searchWrapper.classList.remove('hidden');
            searchIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            searchInput.focus();
        } else {
            tasksHeading.classList.remove('hidden');
            searchWrapper.classList.add('hidden');
            searchIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            searchInput.value = '';
            filterBySearch('');
        }
    });

    searchInput.addEventListener('input', () => {
        filterBySearch(searchInput.value.trim().toLowerCase());
    });

    function filterBySearch(query) {
        const cards = document.querySelectorAll('[data-task-card]');

        // No query — reset inline styles and let Alpine x-show handle filtering
        if (query === '') {
            cards.forEach(card => card.style.display = '');
            return;
        }

        // Has query — get current Alpine filter tab value
        const alpineData   = document.querySelector('[x-data]')?._x_dataStack?.[0];
        const activeFilter = alpineData?.filter ?? 'all';

        cards.forEach(card => {
            const title       = card.getAttribute('data-title')  ?? '';
            const desc        = card.getAttribute('data-desc')   ?? '';
            const status      = card.getAttribute('data-status') ?? '';
            const matchSearch = title.includes(query) || desc.includes(query);
            const matchFilter = activeFilter === 'all' || status === activeFilter;
            card.style.display = (matchSearch && matchFilter) ? '' : 'none';
        });
    }
</script>
@endpush

@endsection
