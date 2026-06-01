@extends('layouts.admin')

@section('title', 'OJT Performance Report')

@section('content')
<style>
    .text-forest  { color: #059669 !important; }
    .bg-forest    { background-color: #059669 !important; }
    .btn-forest   { background-color: #059669; color: #fff; border: none; }
    .btn-forest:hover { background-color: #047857; color: #fff; }
    .btn-outline-forest { border: 1.5px solid #059669; color: #059669; background: transparent; }
    .btn-outline-forest:hover { background: #059669; color: #fff; }
    .stat-card { border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 18px 20px; background: #fff; }
    .initials-circle-lg {
        width: 64px; height: 64px; border-radius: 50%;
        background: #ecfdf5; color: #059669;
        font-weight: 700; font-size: 1.3rem;
        display: flex; align-items: center; justify-content: center;
    }
    @media print {
    .no-print { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    
    /* Hide sidebar and header, show only content */
    .sidebar,
    aside,
    nav,
    header,
    .navbar,
    .topbar,
    .app-header,
    .main-header,
    .page-header,
    .breadcrumb,
    .footer,
    .app-footer { 
        display: none !important; 
    }
    
    /* Expand content to full width */
    .main-panel,
    .content-wrapper,
    .page-content,
    main,
    .container-fluid,
    .content { 
        width: 100% !important; 
        margin: 0 !important; 
        padding: 0 !important; 
        max-width: 100% !important;
    }
    
    /* Remove any left margin that was for sidebar */
    body {
        padding-left: 0 !important;
        margin-left: 0 !important;
    }
}
</style>

<div class="row">
    <div class="col-12">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4 no-print">
            <div>
                <h4 class="fw-bold mb-0">OJT Performance <span class="text-forest">Report</span></h4>
                <p class="text-muted small mb-0">Select a company and student to generate report</p>
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- Company --}}
                <select id="companySelect"
                    class="form-select form-select-sm shadow-none"
                    style="border: 1.5px solid #e2e8f0; border-radius: 10px; width: 200px; font-size: 13px;"
                    onchange="loadStudents()">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->company_id }}">{{ $company->name }}</option>
                    @endforeach
                </select>

                {{-- Student --}}
                <select id="studentSelect"
                    class="form-select form-select-sm shadow-none"
                    style="border: 1.5px solid #e2e8f0; border-radius: 10px; width: 200px; font-size: 13px;"
                    onchange="loadReport()" disabled>
                    <option value="">Select Student</option>
                </select>

                {{-- Print --}}
                <button class="btn btn-outline-forest btn-sm" onclick="window.print()">
                    <i class="mdi mdi-printer me-1"></i> Print
                </button>

                {{-- Export CSV --}}
                <button class="btn btn-forest btn-sm" id="exportBtn" onclick="exportCsv()" disabled>
                    <i class="mdi mdi-file-export me-1"></i> Export CSV
                </button>
            </div>
        </div>

        {{-- Empty State --}}
        <div id="emptyState" class="text-center py-5 text-muted">
            <i class="mdi mdi-file-chart mdi-48px d-block mb-3" style="color: #cbd5e1;"></i>
            <p class="fw-semibold mb-1">No Report Selected</p>
            <p class="small">Choose a company and student above to generate their OJT report.</p>
        </div>

        {{-- Loading --}}
        <div id="loadingState" class="text-center py-5 d-none">
            <div class="spinner-border text-success" role="status"></div>
            <p class="text-muted small mt-2">Loading report...</p>
        </div>

        {{-- Report Content --}}
        <div id="reportContent" class="d-none">

            {{-- Top: Profile + Stats --}}
            <div class="row g-3 mb-4">

                {{-- Profile Card --}}
                <div class="col-md-4">
                    <div class="card card-rounded shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="initials-circle-lg" id="rInitials">--</div>
                            </div>
                            <h5 class="fw-bold mb-0" id="rName">--</h5>
                            <p class="text-muted small mb-1" id="rStudentId">--</p>
                            <p class="text-forest fw-semibold small mb-3" id="rCompany">--</p>

                            <div class="border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Hours Completed</span>
                                    <span class="fw-bold text-dark" id="rHours">--</span>
                                </div>
                                <div class="progress mb-1" style="height: 8px; border-radius: 99px;">
                                    <div id="rProgressBar" class="progress-bar bg-forest" style="width: 0%; border-radius: 99px;"></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted" style="font-size: 11px;">Progress</span>
                                    <span class="text-forest fw-bold" style="font-size: 11px;" id="rProgressPct">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="col-md-8">
                    <div class="row g-3 h-100">
                        <div class="col-6">
                            <div class="stat-card h-100">
                                <p class="text-muted small mb-1">Attendance Rate</p>
                                <h3 class="fw-bold text-forest mb-0" id="rAttRate">--%</h3>
                                <p class="text-muted mb-0 mt-1" style="font-size: 11px;" id="rAttDays">-- / -- days complete</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card h-100">
                                <p class="text-muted small mb-1">Days with Deductions</p>
                                <h3 class="fw-bold mb-0" id="rLateDays">--</h3>
                                <p class="text-muted mb-0 mt-1" style="font-size: 11px;">days with late/early out</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card h-100">
                                <p class="text-muted small mb-1">Total Missed Hours</p>
                                <h3 class="fw-bold text-danger mb-0" id="rMissed">-- h</h3>
                                <p class="text-muted mb-0 mt-1" style="font-size: 11px;">from late/early deductions</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card h-100">
                                <p class="text-muted small mb-1">Total Days Logged</p>
                                <h3 class="fw-bold mb-0" id="rTotalDays">--</h3>
                                <p class="text-muted mb-0 mt-1" style="font-size: 11px;">attendance records</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- DTR Table --}}
            <div class="card card-rounded shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Daily Time Record History</h6>
                        <span class="text-muted small" id="rRecordCount">-- records</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" style="font-size: 13px;">
                            <thead style="background: #f8fafb;">
                                <tr>
                                    <th class="py-3 text-uppercase text-muted fw-semibold border-0" style="font-size: 11px;">Date</th>
                                    <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px;" colspan="2">AM Session</th>
                                    <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px;" colspan="2">PM Session</th>
                                    <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px;">Total</th>
                                    <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px;">Missed</th>
                                    <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px;">Status</th>
                                </tr>
                                <tr style="background: #f8fafb;">
                                    <th class="border-0 pb-2"></th>
                                    <th class="border-0 pb-2 text-center text-muted" style="font-size: 10px;">IN</th>
                                    <th class="border-0 pb-2 text-center text-muted" style="font-size: 10px;">OUT</th>
                                    <th class="border-0 pb-2 text-center text-muted" style="font-size: 10px;">IN</th>
                                    <th class="border-0 pb-2 text-center text-muted" style="font-size: 10px;">OUT</th>
                                    <th class="border-0 pb-2"></th>
                                    <th class="border-0 pb-2"></th>
                                    <th class="border-0 pb-2"></th>
                                </tr>
                            </thead>
                            <tbody id="rLogsBody">
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No records</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let currentStudentId = null;

    async function loadStudents() {
        const companyId = document.getElementById('companySelect').value;
        const studentSelect = document.getElementById('studentSelect');

        studentSelect.innerHTML = '<option value="">Select Student</option>';
        studentSelect.disabled = true;
        document.getElementById('exportBtn').disabled = true;
        showEmpty();

        if (!companyId) return;

        const res  = await fetch(`/admin/report/students?company_id=${companyId}`);
        const data = await res.json();

        data.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id;
            opt.text  = s.name;
            studentSelect.appendChild(opt);
        });

        studentSelect.disabled = false;
    }

    async function loadReport() {
        const studentId = document.getElementById('studentSelect').value;
        if (!studentId) { showEmpty(); return; }

        currentStudentId = studentId;
        showLoading();

        const res  = await fetch(`/admin/report/data?student_id=${studentId}`);
        const data = await res.json();

        renderReport(data);
        document.getElementById('exportBtn').disabled = false;
    }

    function renderReport(data) {
        const s = data.student;

        // Profile
        document.getElementById('rInitials').textContent    = s.initials;
        document.getElementById('rName').textContent        = s.name;
        document.getElementById('rStudentId').textContent   = 'ID: ' + s.student_id;
        document.getElementById('rCompany').textContent     = s.company;
        document.getElementById('rHours').textContent       = s.total_hours + ' / ' + s.required_hours + ' hrs';
        document.getElementById('rProgressBar').style.width = s.progress_pct + '%';
        document.getElementById('rProgressPct').textContent = s.progress_pct + '%';

        // Stats
        document.getElementById('rAttRate').textContent   = s.attendance_rate + '%';
        document.getElementById('rAttDays').textContent   = s.complete_days + ' / ' + s.total_days + ' days complete';
        document.getElementById('rLateDays').textContent  = s.late_days;
        document.getElementById('rMissed').textContent    = s.total_missed_h + ' h';
        document.getElementById('rTotalDays').textContent = s.total_days;
        document.getElementById('rRecordCount').textContent = data.logs.length + ' records';

        // DTR Table
        const tbody = document.getElementById('rLogsBody');
        if (data.logs.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-4">No attendance records found.</td></tr>`;
        } else {
            tbody.innerHTML = data.logs.map(log => {
                const statusStyle = {
                    'Complete':   'background:#ecfdf5; color:#059669; border:1px solid #a7f3d0;',
                    'Half Day':   'background:#fff7ed; color:#ea580c; border:1px solid #fed7aa;',
                    'Has Missed': 'background:#fffbeb; color:#d97706; border:1px solid #fde68a;',
                    'Incomplete': 'background:#fef2f2; color:#dc2626; border:1px solid #fecaca;',
                }[log.status] ?? 'background:#f1f5f9; color:#64748b;';

                const fmt = t => t
                    ? `<span style="color:#059669; font-weight:600;">${t}</span>`
                    : `<span class="text-muted">--:--</span>`;

                return `<tr class="border-top">
                    <td class="py-2 fw-semibold">${log.date}</td>
                    <td class="py-2 text-center">${fmt(log.am_time_in)}</td>
                    <td class="py-2 text-center">${log.am_time_out ? `<span class="text-muted">${log.am_time_out}</span>` : '<span class="text-muted">--:--</span>'}</td>
                    <td class="py-2 text-center">${fmt(log.pm_time_in)}</td>
                    <td class="py-2 text-center">${log.pm_time_out ? `<span class="text-muted">${log.pm_time_out}</span>` : '<span class="text-muted">--:--</span>'}</td>
                    <td class="py-2 text-center fw-bold">${log.total_hours}h</td>
                    <td class="py-2 text-center">${log.missed_mins > 0 ? `<span class="text-danger fw-semibold">${log.missed_mins}m</span>` : '<span class="text-muted">0m</span>'}</td>
                    <td class="py-2 text-center">
                        <span class="px-2 py-1 rounded-pill fw-semibold" style="font-size:11px; ${statusStyle}">${log.status}</span>
                    </td>
                </tr>`;
            }).join('');
        }

        showReport();
    }

    function exportCsv() {
        if (!currentStudentId) return;
        window.location.href = `/admin/report/export?student_id=${currentStudentId}`;
    }

    function showEmpty()   {
        document.getElementById('emptyState').classList.remove('d-none');
        document.getElementById('loadingState').classList.add('d-none');
        document.getElementById('reportContent').classList.add('d-none');
    }
    function showLoading() {
        document.getElementById('emptyState').classList.add('d-none');
        document.getElementById('loadingState').classList.remove('d-none');
        document.getElementById('reportContent').classList.add('d-none');
    }
    function showReport()  {
        document.getElementById('emptyState').classList.add('d-none');
        document.getElementById('loadingState').classList.add('d-none');
        document.getElementById('reportContent').classList.remove('d-none');
    }
</script>
@endpush