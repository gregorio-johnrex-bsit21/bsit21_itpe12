@extends('layouts.supervisor')

@section('title', 'Tasks & Grading')
@section('page_title', 'Tasks & Grading')

@section('content')
{{-- x-data moved here to wrap ALL content including teleported modals --}}
<div x-data="{
    showTaskModal: false,
    showEditModal: false,
    showDeleteModal: false,
    showViewModal: false,
    selectedTask: null,
    editTask: null, 

    openView(task) { this.selectedTask = task; this.showViewModal = true; },
    openEdit(task) { this.editTask = { ...task }; this.showEditModal = true; },
    openDelete(id) { window.deleteTaskId = id; this.showDeleteModal = true; },
}">

    <div class="space-y-6">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="font-bold text-2xl text-slate-800 tracking-tight">Project Delegation</h3>
                <p class="text-sm text-slate-500">Assign tasks and evaluate intern performance</p>
            </div>
            <button @click="showTaskModal = true"
                class="bg-[#2E7D32] text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-green-100 hover:bg-[#1B5E20] hover:-translate-y-1 transition-all flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Create New Task
            </button>
        </div>

        {{-- Task Cards --}}
        @if($tasks->isEmpty())
            <div class="text-center py-16 text-slate-400 text-sm">No tasks assigned yet. Click "Create New Task" to get started.</div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($tasks as $task)
            @php
                $statusColor = match($task['status']) {
                    'completed' => 'bg-emerald-50 text-[#2E7D32] border-emerald-100',
                    'ongoing'   => 'bg-amber-50 text-[#FF8C00] border-amber-100',
                    default     => 'bg-slate-50 text-slate-500 border-slate-100',
                };
                $barColor = match($task['status']) {
                    'completed' => '#2E7D32',
                    'ongoing'   => '#FF8C00',
                    default     => '#94a3b8',
                };
            @endphp
            <div class="bg-white rounded-[1.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 flex flex-col group">
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 text-[10px] font-black uppercase rounded-lg border {{ $statusColor }}">
                            {{ ucfirst($task['status']) }}
                        </span>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Deadline</p>
                            <p class="text-xs font-bold text-slate-700">{{ $task['deadline'] ?? 'No deadline' }}</p>
                        </div>
                    </div>

                    <h4 class="font-black text-slate-800 text-lg leading-tight group-hover:text-[#2E7D32] transition-colors">
                        {{ $task['task_title'] }}
                    </h4>
                    <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ $task['description'] }}</p>

                    {{-- Progress --}}
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Progress</span>
                            <span class="text-[10px] font-black text-slate-600">{{ $task['approved'] }}/{{ $task['total_steps'] }} steps</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500"
                                 style="width: {{ $task['progress'] }}%; background-color: {{ $barColor }};"></div>
                        </div>
                    </div>

                    @if($task['guidelines'])
                    <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Guidelines</p>
                        <p class="text-xs text-slate-600 italic line-clamp-2">"{{ $task['guidelines'] }}"</p>
                    </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-slate-50/50 rounded-b-[2rem] border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($task['student_name']) }}&background=2E7D32&color=fff"
                             class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                        <span class="text-xs font-bold text-slate-700">
                            {{ explode(' ', $task['student_name'])[0] }}. {{ substr(explode(' ', $task['student_name'])[1] ?? '', 0, 1) }}.
                        </span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button @click="openView({{ json_encode($task) }})"
                                class="p-2 text-slate-400 hover:text-[#2E7D32] hover:bg-white rounded-xl transition-all">
                            <i class="fa-solid fa-eye text-sm"></i>
                        </button>
                        <button @click="openEdit({{ json_encode($task) }})"
                                class="p-2 text-slate-400 hover:text-blue-500 hover:bg-white rounded-xl transition-all">
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                        </button>
                        <button @click="openDelete({{ $task['id'] }})"
                                class="p-2 text-slate-400 hover:text-[#D50000] hover:bg-white rounded-xl transition-all">
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div> {{-- end .space-y-6 --}}

    {{-- ========================================== --}}
    {{-- MODALS TELEPORTED TO BODY (fixes backdrop) --}}
    {{-- ========================================== --}}

    {{-- CREATE TASK MODAL --}}
    <template x-teleport="body">
        <div x-show="showTaskModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
             x-cloak>
            <div @click.away="showTaskModal = false" class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-slate-800">Assign New Task</h3>
                        <button @click="showTaskModal = false" class="text-slate-400 hover:text-slate-600">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                    <form id="createTaskForm" class="space-y-3">
                        @csrf
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Task Title</label>
                            <input type="text" name="task_title" placeholder="e.g. Front-end Refactoring"
                                class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Assigned Student</label>
                                <select name="student_id"
                                    class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32] appearance-none">
                                    <option value="">Select Intern...</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->user->name ?? 'Unknown' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Deadline</label>
                                <input type="date" name="deadline"
                                    class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                            </div>
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Total Steps Required</label>
                            <input type="number" name="total_steps" value="1" min="1" max="20"
                                class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Description</label>
                            <textarea name="description" placeholder="Briefly explain the goal..."
                                class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm h-16 outline-none focus:ring-2 focus:ring-[#2E7D32] resize-none"></textarea>
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Supervisor Guidelines</label>
                            <textarea name="guidelines" placeholder="Special instructions..."
                                class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm h-16 outline-none focus:ring-2 focus:ring-[#2E7D32] resize-none"></textarea>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="showTaskModal = false"
                                class="flex-1 px-4 py-3 border border-slate-100 rounded-xl font-bold text-sm text-slate-400 hover:bg-slate-50">Cancel</button>
                            <button type="button" onclick="createTask()"
                                class="flex-1 px-4 py-3 bg-[#2E7D32] text-white rounded-xl font-bold text-sm shadow-md shadow-green-100 hover:bg-[#1B5E20]">
                                Save Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    {{-- VIEW MODAL --}}
    <template x-teleport="body">
        <div x-show="showViewModal" x-cloak
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showViewModal = false"
                 class="bg-white w-full max-w-lg rounded-[2rem] shadow-2xl overflow-hidden max-h-[85vh] flex flex-col">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center shrink-0">
                    <h3 class="text-xl font-black text-slate-800">Task Details</h3>
                    <button @click="showViewModal = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <div class="overflow-y-auto p-6 space-y-4" x-show="selectedTask">
                    <div class="flex justify-between items-start">
                        <h4 class="font-black text-slate-800 text-lg" x-text="selectedTask?.task_title"></h4>
                        <span class="px-3 py-1 text-[10px] font-black uppercase rounded-lg border bg-slate-50 text-slate-500"
                              x-text="selectedTask?.status"></span>
                    </div>
                    <p class="text-sm text-slate-500" x-text="selectedTask?.description"></p>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100" x-show="selectedTask?.guidelines">
                        <p class="text-[10px] font-black text-emerald-600 uppercase mb-1">Guidelines</p>
                        <p class="text-sm text-slate-600 italic" x-text="selectedTask?.guidelines"></p>
                    </div>

                    {{-- Progress --}}
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-[10px] font-black text-slate-400 uppercase">Progress</span>
                            <span class="text-[10px] font-black text-slate-600"
                                  x-text="(selectedTask?.approved ?? 0) + '/' + (selectedTask?.total_steps ?? 0) + ' steps'"></span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#2E7D32] rounded-full"
                                 :style="`width: ${selectedTask?.progress ?? 0}%`"></div>
                        </div>
                    </div>

                    {{-- Submissions --}}
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase mb-3">Submissions</p>
                        <template x-if="selectedTask?.submissions?.length === 0">
                            <p class="text-sm text-slate-400 text-center py-4">No submissions yet.</p>
                        </template>
                        <div class="space-y-3">
                            <template x-for="sub in selectedTask?.submissions" :key="sub.id">
                                <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <a :href="sub.proof_url" target="_blank">
                                        <img :src="sub.proof_url" class="w-16 h-16 rounded-lg object-cover border border-slate-200">
                                    </a>
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-slate-700">Step <span x-text="sub.step_number"></span></p>
                                        <p class="text-[10px] text-slate-400" x-text="sub.created_at"></p>
                                        <p class="text-[10px] text-slate-500 mt-1" x-show="sub.notes" x-text="'Note: ' + sub.notes"></p>
                                    </div>
                                    <div class="flex flex-col gap-1" x-show="sub.status === 'pending'">
                                        <button @click="reviewSubmission(sub.id, 'approved')"
                                            class="px-3 py-1 bg-emerald-600 text-white rounded-lg text-[10px] font-black hover:bg-emerald-700">
                                            Approve
                                        </button>
                                        <button @click="reviewSubmission(sub.id, 'rejected')"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg text-[10px] font-black hover:bg-red-600">
                                            Reject
                                        </button>
                                    </div>
                                    <span x-show="sub.status !== 'pending'"
                                          class="px-2 py-1 rounded-lg text-[10px] font-black"
                                          :class="sub.status === 'approved' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600'"
                                          x-text="sub.status"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t border-slate-100 shrink-0">
                    <button @click="showViewModal = false"
                        class="w-full py-3 bg-slate-100 text-slate-600 rounded-xl font-bold">Close</button>
                </div>
            </div>
        </div>
    </template>

    {{-- EDIT MODAL --}}
    <template x-teleport="body">
        <div x-show="showEditModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
             x-cloak>
            <div @click.away="showEditModal = false" class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-slate-800">Edit Task</h3>
                        <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Task Title</label>
                            <input type="text" x-model="editTask.task_title"
                                class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Status</label>
                                <select x-model="editTask.status"
                                    class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32] appearance-none">
                                    <option value="pending">Pending</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Total Steps</label>
                                <input type="number" x-model="editTask.total_steps" min="1" max="20"
                                    class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-[#2E7D32]">
                            </div>
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 tracking-widest">Guidelines</label>
                            <textarea x-model="editTask.guidelines"
                                class="w-full mt-1 bg-slate-50 border-none rounded-xl px-4 py-2 text-sm h-20 outline-none focus:ring-2 focus:ring-[#2E7D32] resize-none"></textarea>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button @click="showEditModal = false"
                                class="flex-1 px-4 py-3 border border-slate-100 rounded-xl font-bold text-sm text-slate-400 hover:bg-slate-50">Cancel</button>
                            <button @click="updateTask()"
                                class="flex-1 px-4 py-3 bg-[#2E7D32] text-white rounded-xl font-bold text-sm shadow-md shadow-green-100 hover:bg-[#1B5E20]">
                                Update Task
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    {{-- DELETE MODAL --}}
    <template x-teleport="body">
        <div x-show="showDeleteModal" x-cloak
             class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showDeleteModal = false"
                 class="bg-white w-full max-w-sm rounded-[2rem] p-8 text-center shadow-2xl">
                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-trash-can text-2xl"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800">Delete Task?</h3>
                <p class="text-sm text-slate-500 mt-2">Are you sure? This cannot be undone.</p>
                <div class="flex gap-3 mt-6">
                    <button @click="showDeleteModal = false"
                        class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold">Cancel</button>
                    <button @click="deleteTask()"
                        class="flex-1 py-3 bg-red-500 text-white rounded-xl font-bold">Delete</button>
                </div>
            </div>
        </div>
    </template>

</div> {{-- end x-data wrapper --}}

@push('scripts')
<script>
    function createTask() {
        const form = document.getElementById('createTaskForm');
        const data = Object.fromEntries(new FormData(form));
        fetch("{{ route('supervisor.tasks.store') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        }).then(r => r.json()).then(d => {
            if (d.success) { alert(d.message); location.reload(); }
            else alert(d.message ?? 'Error creating task.');
        });
    }

    function updateTask() {
        const comp = Alpine.$data(document.querySelector('[x-data]'));
        const task = comp.editTask;
        fetch(`/supervisor/tasks/${task.id}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(task)
        }).then(r => r.json()).then(d => {
            if (d.success) { alert(d.message); location.reload(); }
            else alert(d.message ?? 'Error updating task.');
        });
    }

    function deleteTask() {
        const id = window.deleteTaskId;
        if (!id) {
            alert('No task selected.');
            return;
        }
        
        fetch(`/supervisor/tasks/${id}`, {
            method: 'DELETE',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
        })
        .then(r => {
            if (!r.ok) {
                return r.text().then(text => { throw new Error(text) });
            }
            return r.json();
        })
        .then(d => {
            if (d.success) { 
                alert(d.message); 
                location.reload(); 
            } else {
                alert(d.message ?? 'Error.');
            }
        })
        .catch(err => {
            console.error('Delete error:', err);
            alert('Failed: ' + err.message);
        });
    }

    function reviewSubmission(submissionId, status) {
        const notes = status === 'rejected' ? prompt('Rejection reason (optional):') : null;
        fetch(`/supervisor/submissions/${submissionId}/review`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ status, notes })
        }).then(r => r.json()).then(d => {
            if (d.success) { alert(d.message); location.reload(); }
            else alert(d.message ?? 'Error reviewing submission.');
        });
    }
</script>
@endpush
@endsection