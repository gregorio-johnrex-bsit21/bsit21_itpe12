@extends('layouts.admin')

@section('title', 'Company Management')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            {{-- Top Header Section --}}
            <div class="d-sm-flex align-items-center justify-content-between border-bottom mb-3 pb-3">
                <h2 class="text-dark fw-bold mb-0" style="font-size: 1.5rem;">Company Management</h2>
                <div class="d-flex gap-2">
                    <button class="btn btn-lg text-white mb-0 shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#addSupervisorModal" style="background-color: #2E7D32; border-color: #2E7D32;">
                        <i class="mdi mdi-account-plus-outline"></i> Add Supervisor
                    </button>
                    <button class="btn btn-lg text-white mb-0 shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#addCompanyModal" style="background-color: #2E7D32; border-color: #2E7D32;">
                        <i class="mdi mdi-plus-circle-outline"></i> Add New Company
                    </button>
                </div>
                {{-- Updated Button: Now Green (#2E7D32) --}}
<button class="btn btn-lg text-white mb-0 shadow-sm" type="button" data-bs-toggle="modal" data-bs-target="#setHoursModal" style="background-color: #2E7D32; border-color: #2E7D32;">
    <i class="mdi mdi-clock-outline"></i> OJT Requirements
</button>

{{-- Modal remains the same, but the Save button is now Orange (#ff9800) --}}
<div class="modal fade" id="setHoursModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 px-4 pt-4">
                <h4 class="modal-title fw-bold" style="color: #2E7D32; margin: 0;">OJT Requirements</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body px-4">
                {{-- Company Dropdown --}}
                <div class="form-group mb-3">
                    <label class="mb-2 text-muted fw-bold small">PARTNER COMPANY</label>
                    <select id="ojtCompany" class="form-select shadow-none" style="height: 45px; border-radius: 10px; border: 1.5px solid #eee; font-size: 14px;">
                        <option value="" selected disabled>Select Company...</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->name }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Shift Schedule Section --}}
                <div class="p-3 mb-3" style="background-color: #f8f9fa; border-radius: 15px; border: 1px solid #f1f1f1;">
                    <label class="mb-3 text-dark fw-bold small text-uppercase d-block" style="letter-spacing: 0.5px;">
                        <i class="mdi mdi-calendar-clock me-1"></i> Shift Schedule
                    </label>
                    
                    <div class="row g-2">
                        {{-- AM Session --}}
                        <div class="col-md-6">
                            <label class="mb-1 text-muted fw-bold" style="font-size: 10px; display: block;">AM SESSION</label>
                            <div class="d-flex align-items-center justify-content-between">
                                <input type="time" id="amStartTime" class="form-control form-control-sm shadow-none" 
                                    style="width: 43%; height: 38px; padding: 5px 8px; font-size: 12px; border-radius: 8px; border: 1.5px solid #eee;">
                                
                                <span style="font-size: 11px; color: #6c757d; font-weight: bold;">to</span>
                                
                                <input type="time" id="amEndTime" class="form-control form-control-sm shadow-none" 
                                    style="width: 43%; height: 38px; padding: 5px 8px; font-size: 12px; border-radius: 8px; border: 1.5px solid #eee;">
                            </div>
                        </div>

                        {{-- PM Session --}}
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="mb-1 text-muted fw-bold" style="font-size: 10px; display: block;">PM SESSION</label>
                            <div class="d-flex align-items-center justify-content-between">
                                <input type="time" id="pmStartTime" class="form-control form-control-sm shadow-none" 
                                    style="width: 43%; height: 38px; padding: 5px 8px; font-size: 12px; border-radius: 8px; border: 1.5px solid #eee;">
                                
                                <span style="font-size: 11px; color: #6c757d; font-weight: bold;">to</span>
                                
                                <input type="time" id="pmEndTime" class="form-control form-control-sm shadow-none" 
                                    style="width: 43%; height: 38px; padding: 5px 8px; font-size: 12px; border-radius: 8px; border: 1.5px solid #eee;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Hours --}}
                <div class="form-group mb-3">
                    <label class="mb-2 text-muted fw-bold small">REQUIRED TOTAL HOURS</label>
                    <input type="number" id="requiredHours" class="form-control shadow-none" placeholder="e.g. 480" style="height: 45px; border-radius: 10px; border: 1.5px solid #eee; font-size: 14px;">
                </div>

                {{-- Dates --}}
                <div class="row g-3">
                    <div class="col-6">
                        <label class="mb-2 text-muted fw-bold small">START DATE</label>
                        <input type="date" id="startDate" class="form-control shadow-none" style="height: 45px; border-radius: 10px; border: 1.5px solid #eee; font-size: 13px;">
                    </div>
                    <div class="col-6">
                        <label class="mb-2 text-muted fw-bold small">END DATE</label>
                        <input type="date" id="endDate" class="form-control shadow-none" style="height: 45px; border-radius: 10px; border: 1.5px solid #eee; font-size: 13px;">
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pb-4 mt-2 justify-content-center">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 25px; font-size: 14px;">Cancel</button>
                <button type="button" class="btn text-white fw-bold shadow-sm" onclick="saveOjtRequirements()" style="background-color: #ff9800; border: none; border-radius: 10px; padding: 10px 25px; font-size: 14px;">
                    Save Requirements
                </button>
            </div>
        </div>
    </div>
</div>
            </div>
            

            <div class="tab-content tab-content-basic">
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row">
                        {{-- Partner Selection Card --}}
                        <div class="col-lg-12 d-flex flex-column">
                            <div class="card card-rounded shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title card-title-dash mb-0">Partner Selection</h4>
                                        
                                        {{-- Modern Search --}}
                                        <div id="searchWrapper" class="d-flex align-items-center" style="position: relative;">
                                            <div id="searchContainer" class="d-flex align-items-center" 
                                                 style="transition: all 0.4s; background: transparent; border-radius: 12px; padding: 4px 8px; width: 40px; height: 40px; justify-content: flex-end;">
                                                <input type="text" id="searchInput" class="form-control form-control-sm border-0 bg-transparent p-0 shadow-none" 
                                                       placeholder="Search supervisors..." onkeyup="filterTable(this)"
                                                       style="width: 0; opacity: 0; transition: all 0.3s; font-size: 0.85rem; font-weight: 500; color: #1F283E;">
                                                <button class="btn btn-link text-dark p-0 shadow-none d-flex align-items-center justify-content-center" 
                                                        onclick="toggleSearch()" style="width: 24px; height: 24px;">
                                                    <i class="mdi mdi-magnify" id="searchIcon" style="font-size: 1.4rem;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-small mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">FILTER BY COMPANY</p>
                                        <select class="form-select form-select-sm shadow-none" id="companyDropdown" onchange="filterByCompany()"
                                                style="width: 240px; height: 45px; font-size: 0.85rem; border-radius: 8px; color: #000; border: 1.5px solid #2E7D32; background-color: #fff;">
                                            <option value="all" selected>All Companies</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->name }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
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

{{-- Supervisor List --}}
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title card-title-dash mb-4">Supervisor List</h4>
                <div class="table-responsive">
                    <table class="table select-table" id="supervisorTable">
                        <thead>
                            <tr>
                                <th>Supervisor Name</th>
                                <th>Supervisor ID</th>
                                <th>Company</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="supervisorTableBody">
                            @forelse($supervisors as $supervisor)
                            <tr data-company="{{ $supervisor->company->name ?? 'N/A' }}">
                                <td><h6 class="fw-bold mb-0">{{ $supervisor->name }}</h6></td>
                                <td><p class="text-muted mb-0">{{ $supervisor->supervisor_id }}</p></td>
                                <td><p class="text-muted mb-0">{{ $supervisor->company->name ?? 'N/A' }}</p></td>
                                <td>
                                    <button onclick="resetPassword('{{ $supervisor->supervisor_id }}')" 
                                        class="btn btn-warning btn-sm text-white">
                                        <i class="mdi mdi-lock-reset"></i> Reset
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No supervisors registered.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0"><h5 class="modal-title fw-bold">Reset Password</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <p class="text-muted">Reset supervisor password?</p>
                <div id="newCredentials" class="mt-3 p-3 text-center" style="display: none; background: #f8f9fa; border-radius: 10px;">
                    <div class="d-flex justify-content-between align-items-center mb-2"><span class="text-muted small">ID:</span><h5 id="resetSupervisorId" class="fw-bold mb-0" style="color: #2E7D32;"></h5></div>
                    <div class="d-flex justify-content-between align-items-center"><span class="text-muted small">Pass:</span><h5 id="resetSupervisorPassword" class="fw-bold mb-0" style="color: #2E7D32;"></h5></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning text-white px-4" id="confirmResetBtn">Confirm Reset</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0"><h5 class="modal-title fw-bold">Register Company</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="form-group"><label class="mb-2 text-muted fw-bold small">COMPANY NAME</label><input type="text" id="newCompanyName" class="form-control" style="height: 45px; border-radius: 8px;"></div>
                <div id="idDisplay" class="mt-4 p-3 text-center" style="display: none; background: #f8f9fa; border-radius: 10px;"><h3 id="generatedId" class="fw-bold mb-0" style="color: #2E7D32;"></h3></div>
            </div>
            <div class="modal-footer border-0"><button type="button" class="btn text-white px-4" onclick="addCompany()" style="background-color: #2E7D32;">Generate ID</button></div>
        </div>
    </div>
</div>


<div class="modal fade" id="addSupervisorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Add Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="mb-2 text-muted fw-bold small">SUPERVISOR NAME</label>
                    <input type="text" id="supervisorName" class="form-control" style="height: 45px; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label class="mb-2 text-muted fw-bold small">ASSIGN TO COMPANY</label>
                    <select id="supervisorCompany" class="form-select" style="height: 45px; border-radius: 8px; border: 1px solid #2E7D32;">
                        <option value="" selected disabled>Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="supervisorCredentials" class="mt-4 p-3" style="display: none; background: #f8f9fa; border-radius: 10px;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">ID:</span>
                        <h5 id="genSupId" class="fw-bold mb-0" style="color: #2E7D32;"></h5>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Temporary Password:</span>
                        <h5 id="genSupPass" class="fw-bold mb-0" style="color: #2E7D32;"></h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn text-white px-4" id="addSupBtn" onclick="addSupervisor()" style="background-color: #2E7D32;">Add Supervisor</button>
            </div>
        </div>
    </div>
    
</div>

@endsection

@push('scripts')
<script>
    let currentResetId = null;

    function toggleSearch() {
        const container = document.getElementById('searchContainer');
        const input = document.getElementById('searchInput');
        if (input.style.width === '0px' || !input.style.width || input.style.width === '0') {
            container.style.width = '240px'; container.style.backgroundColor = '#f3f6f9'; 
            setTimeout(() => { input.style.width = '100%'; input.style.opacity = '1'; input.focus(); }, 100);
        } else {
            input.style.width = '0'; input.style.opacity = '0'; container.style.width = '40px'; container.style.backgroundColor = 'transparent';
        }
    }

    function filterTable(input) {
        const val = input.value.toLowerCase();
        const rows = document.querySelectorAll('#supervisorTableBody tr');
        rows.forEach(r => { r.style.display = r.innerText.toLowerCase().includes(val) ? '' : 'none'; });
    }

    function filterByCompany() {
        const selected = document.getElementById('companyDropdown').value;
        const rows = document.querySelectorAll('#supervisorTableBody tr');
        rows.forEach(r => {
            if (selected === "all" || r.getAttribute('data-company') === selected) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }

    function resetPassword(id) {
        currentResetId = id;
        document.getElementById('newCredentials').style.display = 'none';
        new bootstrap.Modal(document.getElementById('resetPasswordModal')).show();
    }

    document.getElementById('confirmResetBtn').addEventListener('click', function() {
        fetch("{{ route('supervisor.reset.password') }}", {
            method: "POST", headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ supervisor_id: currentResetId })
        }).then(res => res.json()).then(data => {
            if (data.success) {
                document.getElementById('resetSupervisorId').innerText = data.supervisor_id;
                document.getElementById('resetSupervisorPassword').innerText = data.password;
                document.getElementById('newCredentials').style.display = 'block';
                this.disabled = true; this.innerText = 'Done ✓';
            }
        });
    });

    function addCompany() {
        const name = document.getElementById('newCompanyName').value;
        if(!name) return alert("Please enter a name");
        fetch("{{ route('company.store') }}", {
            method: "POST", headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ name: name })
        }).then(res => res.json()).then(data => {
            if(data.success) {
                document.getElementById('generatedId').innerText = data.company_id;
                document.getElementById('idDisplay').style.display = 'block';
            }
        });
    }

    function addSupervisor() {
        const name = document.getElementById('supervisorName').value;
        const cid = document.getElementById('supervisorCompany').value;
        const btn = document.getElementById('addSupBtn');

        if(!name || !cid) return alert("Please fill in all fields.");

        fetch("{{ route('supervisor.store') }}", {
            method: "POST", 
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ name: name, company_id: cid })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.getElementById('genSupId').innerText = data.supervisor_id;
                document.getElementById('genSupPass').innerText = data.password;
                document.getElementById('supervisorCredentials').style.display = 'block';
                btn.disabled = true;
                btn.innerText = "Added Successfully";
            } else {
                alert("Error adding supervisor. Please check the data.");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Something went wrong. Please try again.");
        });
    }
</script>
@endpush