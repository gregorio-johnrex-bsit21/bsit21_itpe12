@extends('layouts.admin')

@section('title', 'Company Management')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
           {{-- Top Header Section with Add Button --}}
<div class="d-sm-flex align-items-center justify-content-between border-bottom mb-3">
    <h2 class="text-dark fw-bold mb-0" style="font-size: 1.5rem;">Company Management</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-lg text-white mb-0 shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#addSupervisorModal">
            <i class="mdi mdi-account-plus-outline"></i> Add Supervisor
        </button>
        <button class="btn btn-primary btn-lg text-white mb-0 shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
            <i class="mdi mdi-plus-circle-outline"></i> Add New Company
        </button>
    </div>
</div>

            <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    
                    <div class="row">
                        {{-- Left Side: Company Management --}}
                        <div class="col-lg-8 d-flex flex-column">
                            <div class="card card-rounded shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title card-title-dash mb-0">Company Management</h4>
                                        
                                        {{-- Modern Search --}}
                                        <div id="searchWrapper" class="d-flex align-items-center" style="position: relative;">
                                            <div id="searchContainer" class="d-flex align-items-center" 
                                                 style="transition: all 0.4s; background: transparent; border-radius: 12px; padding: 4px 8px; width: 40px; height: 40px; justify-content: flex-end;">
                                                <input type="text" id="searchInput" class="form-control form-control-sm border-0 bg-transparent p-0 shadow-none" 
                                                       placeholder="Search students..." onkeyup="filterTable(this)"
                                                       style="width: 0; opacity: 0; transition: all 0.3s; font-size: 0.85rem; font-weight: 500; color: #1F283E;">
                                                <button class="btn btn-link text-dark p-0 shadow-none d-flex align-items-center justify-content-center" 
                                                        onclick="toggleSearch()" style="width: 24px; height: 24px;">
                                                    <i class="mdi mdi-magnify" id="searchIcon" style="font-size: 1.4rem;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-small mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">PARTNER COMPANY</p>
                                       <select class="form-select form-select-sm shadow-none border-1" id="companyDropdown" onchange="updateDashboard()"
                                         style="width: 220px; height: 40px; font-size: 0.85rem; border-radius: 8px; color: #000; border-color: #000; background-color: #fff;">
                                         <option value="" selected disabled>Select Company</option>
                                         @foreach($companies as $company)
                                         <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                                         @endforeach
                                       </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Side Corner: Performance Spotlight --}}
                        <div class="col-lg-4 d-flex flex-column">
                            <div class="card card-rounded bg-primary shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h4 class="card-title card-title-dash text-white">Performance Spotlight</h4>
                                        <i class="mdi mdi-account-star text-white fs-4"></i>
                                    </div>
                                    <div class="d-flex align-items-center mt-3">
                                        <div class="ms-0">
                                            <h3 id="topName" class="mb-0 text-white fw-bold">---</h3>
                                            <p id="topCourse" class="text-white opacity-75 small mb-0">N/A</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 text-white text-center">
                                        <div>
                                            <p class="opacity-75 mb-0 small">Hours</p>
                                            <h4 id="topHours" class="mb-0 fw-bold">0</h4>
                                        </div>
                                        <div>
                                            <p class="opacity-75 mb-0 small">Rating</p>
                                            <h4 id="topRating" class="mb-0 fw-bold">0.0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Section: Full Width Table --}}
                    <div id="dashboardContent" class="row mt-4" style="display: none;">
                        <div class="col-lg-12">
                            <div class="card card-rounded shadow-sm border-0">
                                <div class="card-body">
                                    <h4 class="card-title card-title-dash mb-4">Active OJT Assignments</h4>
                                    <div class="table-responsive">
                                        <table class="table select-table" id="studentTable">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Course</th>
                                                    <th>OJT Progress</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="studentTableBody"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Supervisor List Table --}}
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title card-title-dash mb-4">Supervisor List</h4>
                <div class="table-responsive">
                    <table class="table select-table">
                        <thead>
                            <tr>
                                <th>Supervisor Name</th>
                                <th>Supervisor ID</th>
                                <th>Company</th>
                                <th>Company ID</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supervisors as $supervisor)
<tr>
    <td><h6 class="fw-bold mb-0">{{ $supervisor->user->name ?? 'N/A' }}</h6></td>
    <td><p class="text-muted mb-0">{{ $supervisor->supervisor_id }}</p></td>
    <td><p class="text-muted mb-0">{{ $supervisor->company->name ?? 'N/A' }}</p></td>
    <td><p class="text-muted mb-0">{{ $supervisor->company->company_id ?? 'N/A' }}</p></td>
    <td>
        <button onclick="resetPassword('{{ $supervisor->supervisor_id }}')" 
            class="btn btn-warning btn-sm text-white">
            <i class="mdi mdi-lock-reset"></i> Reset Password
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center py-4 text-muted">No supervisors yet.</td>
</tr>
@endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Reset Password Modal --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Are you sure you want to reset this supervisor's password?</p>
                <div id="newCredentials" class="mt-3 p-3 text-center" style="display: none; background: #f8f9fa; border-radius: 10px;">
                    <p class="text-muted mb-2 small fw-bold">NEW CREDENTIALS:</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Supervisor ID:</span>
                        <h5 id="resetSupervisorId" class="text-primary fw-bold mb-0" style="letter-spacing: 2px;"></h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">New Password:</span>
                        <h5 id="resetSupervisorPassword" class="text-primary fw-bold mb-0" style="letter-spacing: 2px;"></h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning text-white px-4" id="confirmResetBtn">Confirm Reset</button>
            </div>
        </div>
    </div>
</div>

{{-- Add Company Modal --}}
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="addCompanyModalLabel">Register New Company</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="mb-2 text-muted fw-bold small">COMPANY NAME</label>
                    <input type="text" id="newCompanyName" class="form-control" placeholder="e.g. Nexus Tech Bacolod" style="height: 45px; border-radius: 8px;">
                </div>
                <div id="idDisplay" class="mt-4 p-3 text-center" style="display: none; background: #f8f9fa; border-radius: 10px;">
                    <p class="text-muted mb-1 small">SHARE THIS CODE WITH STUDENTS:</p>
                    <h3 id="generatedId" class="text-primary fw-bold mb-0" style="letter-spacing: 2px;"></h3>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary text-white px-4" id="generateBtn" onclick="addCompany()">Generate ID</button>
            </div>
        </div>
    </div>
</div>


{{-- Add Supervisor Modal --}}
<div class="modal fade" id="addSupervisorModal" tabindex="-1" aria-labelledby="addSupervisorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="addSupervisorModalLabel">Add Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="mb-2 text-muted fw-bold small">SUPERVISOR NAME</label>
                    <input type="text" id="supervisorName" class="form-control" placeholder="e.g. Juan Dela Cruz" style="height: 45px; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label class="mb-2 text-muted fw-bold small">ASSIGN TO COMPANY</label>
                    <select id="supervisorCompany" class="form-select" style="height: 45px; border-radius: 8px; color: #000; border-color: #000; background-color: #fff;">
                        <option value="" selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Credentials Display --}}
                <div id="supervisorCredentials" class="mt-4 p-3" style="display: none; background: #f8f9fa; border-radius: 10px;">
                    <p class="text-muted mb-2 small fw-bold text-center">SHARE THESE CREDENTIALS WITH SUPERVISOR:</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Supervisor ID:</span>
                        <h5 id="generatedSupervisorId" class="text-primary fw-bold mb-0" style="letter-spacing: 2px;"></h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Password:</span>
                        <h5 id="generatedSupervisorPassword" class="text-primary fw-bold mb-0" style="letter-spacing: 2px;"></h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary text-white px-4" id="addSupervisorBtn" onclick="addSupervisor()">Add Supervisor</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const companyData = {
        technova: {
            students: [
                { name: "John Doe", course: "BSIT", hours: 320, status: "Ongoing", rating: 4.8 },
                { name: "Jane Smith", course: "BSCS", hours: 480, status: "Completed", rating: 4.9 }
            ],
            topIndex: 1
        },
        globalit: {
            students: [
                { name: "Maria Clara", course: "BSIT", hours: 400, status: "Ongoing", rating: 4.5 },
                { name: "Juan Dela Cruz", course: "BSIS", hours: 480, status: "Completed", rating: 4.7 }
            ],
            topIndex: 1
        }
    };

    const TOTAL_OJT_HOURS = 480;

   function addCompany() {
    const nameInput = document.getElementById('newCompanyName');
    const idDisplay = document.getElementById('idDisplay');
    const generatedIdSpan = document.getElementById('generatedId');
    const generateBtn = document.getElementById('generateBtn'); // add this

    if (generateBtn.disabled) {
        alert("Company ID has already been generated!");
        return;
    }

    if (nameInput.value.trim() === "") {
        alert("Please enter a company name.");
        return;
    }

    fetch("{{ route('company.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ name: nameInput.value.trim() })
    })
    .then(res => res.json())
    .then(data => {
    if (data.success) {
        generatedIdSpan.innerText = data.company_id;
        idDisplay.style.display = 'block';

        // Add new company to dropdown instantly
        const dropdown = document.getElementById('companyDropdown');
        const option = document.createElement('option');
        option.value = data.company_id;
        option.text = nameInput.value.trim();
        dropdown.add(option);

        // Disable button
        generateBtn.disabled = true;
        generateBtn.innerText = "ID Generated ✓";
        generateBtn.classList.remove('btn-primary');
        generateBtn.classList.add('btn-success');
    }
})
    .catch(err => console.error(err));
}



//add supervisor 
function addSupervisor() {
    const nameInput = document.getElementById('supervisorName');
    const companyInput = document.getElementById('supervisorCompany');
    const credentials = document.getElementById('supervisorCredentials');
    const supervisorIdSpan = document.getElementById('generatedSupervisorId');
    const supervisorPasswordSpan = document.getElementById('generatedSupervisorPassword');
    const addBtn = document.getElementById('addSupervisorBtn');

    if (addBtn.disabled) {
        alert("Supervisor has already been added!");
        return;
    }

    if (nameInput.value.trim() === "") {
        alert("Please enter a supervisor name.");
        return;
    }

    if (companyInput.value === "") {
        alert("Please select a company.");
        return;
    }

    fetch("{{ route('supervisor.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            name: nameInput.value.trim(),
            company_id: companyInput.value
        })
    })
    .then(res => res.json())
    .then(data => {
    if (data.success) {
        supervisorIdSpan.innerText = data.supervisor_id;
        supervisorPasswordSpan.innerText = data.password;
        credentials.style.display = 'block';

        // Disable button
        addBtn.disabled = true;
        addBtn.innerText = "Supervisor Added ✓";
        addBtn.classList.remove('btn-secondary');
        addBtn.classList.add('btn-success');
    } else {
        alert(data.message);
    }
})
    .catch(err => console.error(err));
}

// Reset supervisor modal on close
document.getElementById('addSupervisorModal').addEventListener('hidden.bs.modal', function () {
    const addBtn = document.getElementById('addSupervisorBtn');
    addBtn.disabled = false;
    addBtn.innerText = "Add Supervisor";
    addBtn.classList.remove('btn-success');
    addBtn.classList.add('btn-primary');
    document.getElementById('supervisorName').value = '';
    document.getElementById('supervisorCompany').value = '';
    document.getElementById('supervisorCredentials').style.display = 'none';
});



//add company lock when already generated
document.getElementById('addCompanyModal').addEventListener('hidden.bs.modal', function () {
    const generateBtn = document.getElementById('generateBtn');
    generateBtn.disabled = false;
    generateBtn.innerText = "Generate ID";
    generateBtn.classList.remove('btn-success');
    generateBtn.classList.add('btn-primary');
    document.getElementById('newCompanyName').value = '';
    document.getElementById('idDisplay').style.display = 'none';
});








    function updateDashboard() {
        const companyKey = document.getElementById('companyDropdown').value;
        const data = companyData[companyKey];
        if (!data) return;

        document.getElementById('dashboardContent').style.display = 'flex';

        document.getElementById('studentTableBody').innerHTML = data.students.length > 0 ? 
            data.students.map(s => {
                const perc = Math.round((s.hours / TOTAL_OJT_HOURS) * 100);
                return `
                    <tr>
                        <td><h6 class="fw-bold mb-0">${s.name}</h6></td>
                        <td><p class="text-muted mb-0">${s.course}</p></td>
                        <td class="pe-5" style="min-width: 250px;">
                            <div class="d-flex justify-content-between mb-1"><small class="text-muted">${perc}%</small></div>
                            <div class="progress progress-md"><div class="progress-bar bg-primary" style="width: ${perc}%"></div></div>
                        </td>
                        <td><div class="badge badge-opacity-${s.status === 'Completed' ? 'success' : 'primary'}">${s.status}</div></td>
                    </tr>
                `;
            }).join('') : '<tr><td colspan="4" class="text-center py-4 text-muted">No students registered yet.</td></tr>';

        const top = data.students[data.topIndex] || { name: "---", course: "N/A", hours: 0, rating: 0.0 };
        document.getElementById('topName').innerText = top.name;
        document.getElementById('topCourse').innerText = top.course;
        document.getElementById('topHours').innerText = top.hours;
        document.getElementById('topRating').innerText = top.rating;
    }

    function toggleSearch() {
        const container = document.getElementById('searchContainer');
        const input = document.getElementById('searchInput');
        if (input.style.width === '0px' || input.style.width === '0') {
            container.style.width = '240px';
            container.style.backgroundColor = '#f3f6f9'; 
            setTimeout(() => { input.style.width = '100%'; input.style.opacity = '1'; input.style.paddingLeft = '10px'; input.focus(); }, 100);
        } else {
            input.style.width = '0'; input.style.opacity = '0'; container.style.width = '40px'; container.style.backgroundColor = 'transparent';
        }
    }

    function filterTable(input) {
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#studentTableBody tr');
        rows.forEach(row => { row.style.display = row.cells[0]?.innerText.toLowerCase().includes(filter) ? '' : 'none'; });
    }


    let resetSupervisorId = null;

function resetPassword(supervisorId) {
    resetSupervisorId = supervisorId;
    document.getElementById('newCredentials').style.display = 'none';
    document.getElementById('confirmResetBtn').disabled = false;
    document.getElementById('confirmResetBtn').innerText = 'Confirm Reset';
    document.getElementById('confirmResetBtn').classList.remove('btn-success');
    document.getElementById('confirmResetBtn').classList.add('btn-warning');
    new bootstrap.Modal(document.getElementById('resetPasswordModal')).show();
}

document.getElementById('confirmResetBtn').addEventListener('click', function() {
    fetch("{{ route('supervisor.reset.password') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ supervisor_id: resetSupervisorId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('resetSupervisorId').innerText = data.supervisor_id;
            document.getElementById('resetSupervisorPassword').innerText = data.password;
            document.getElementById('newCredentials').style.display = 'block';

            // Disable button
            this.disabled = true;
            this.innerText = 'Password Reset ✓';
            this.classList.remove('btn-warning');
            this.classList.add('btn-success');
        }
    })
    .catch(err => console.error(err));
});

</script>
@endpush
