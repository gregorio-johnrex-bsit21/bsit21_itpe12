@extends('layouts.admin')

@section('title', 'Student OJT Report')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            {{-- Header with Dependent Dropdowns and Print Actions --}}
            <div class="d-sm-flex align-items-center justify-content-between border-bottom mb-4 pb-3">
                <div class="py-3">
                    <h2 class="welcome-text">OJT <span class="text-black fw-bold">Performance Report</span></h2>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    {{-- Company Dropdown --}}
                    <div class="form-group mb-0">
                        <select class="form-select form-select-sm card-rounded border shadow-sm" id="companySelect" style="height: 40px; width: 180px;" onchange="updateStudentList()">
                            <option value="">Select Company</option>
                            <option value="technova">TechNova Solutions</option>
                            <option value="nexus">Nexus Tech Bacolod</option>
                        </select>
                    </div>

                    {{-- Student Dropdown (Filtered by Company) --}}
                    <div class="form-group mb-0">
                        <select class="form-select form-select-sm card-rounded border shadow-sm text-primary fw-bold" id="studentSelect" style="height: 40px; width: 180px;" onchange="filterReport()">
                            <option value="">Select Student</option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <button type="button" class="btn btn-outline-primary btn-sm me-2 mb-0" onclick="window.print()">
                        <i class="icon-printer"></i> Print
                    </button>
                    <button type="button" class="btn btn-primary btn-sm text-white mb-0">
                        <i class="icon-share-alt"></i> Export
                    </button>
                </div>
            </div>

            <div class="row" id="reportContent">
                {{-- Left: Student Profile Summary --}}
                <div class="col-md-4 grid-margin stretch-card filter-item" data-name="maria clara" data-company="technova">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="text-center pb-3 border-bottom">
                                <div class="badge badge-opacity-primary p-4 mb-3" style="width: 60px; height: 60px; border-radius: 50%; font-size: 1.2rem;">MC</div>
                                <h4 class="fw-bold mb-1">Maria Clara</h4>
                                <p class="text-muted small">BSIT Student</p>
                                <div class="badge badge-opacity-success mt-2">Active Assignment</div>
                            </div>
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left text-muted small">Company</span>
                                    <span class="float-right fw-bold text-primary">TechNova Solutions</span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left text-muted small">Hours Completed</span>
                                    <span class="float-right text-dark fw-bold">400 / 480 hrs</span>
                                </p>
                                <div class="progress progress-md mt-2">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 83%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Performance Analytics --}}
                <div class="col-md-8 grid-margin stretch-card filter-item" data-name="maria clara" data-company="technova">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h4 class="card-title card-title-dash">Overall Competency</h4>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded mb-3">
                                        <p class="text-muted mb-1 small">Attendance Rate</p>
                                        <h3 class="fw-bold">98.5%</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded mb-3">
                                        <p class="text-muted mb-1 small">Late Frequency</p>
                                        <h3 class="fw-bold">2 Days</h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <h6 class="fw-bold small mb-2">Evaluator Remarks:</h6>
                                        <p class="text-muted italic" style="font-size: 0.85rem;">"Demonstrates strong technical aptitude in web development."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DTR Table --}}
                <div class="col-lg-12 grid-margin stretch-card printable-area filter-item" data-name="maria clara" data-company="technova">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h4 class="card-title card-title-dash">Daily Time Record History</h4>
                            <div class="table-responsive">
                                <table class="table select-table">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>Date</th>
                                            <th class="text-center">AM Session</th>
                                            <th class="text-center">PM Session</th>
                                            <th class="text-center">Total Hours</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mar 10, 2026</td>
                                            <td class="text-center">08:00 AM - 12:00 PM</td>
                                            <td class="text-center">01:00 PM - 05:00 PM</td>
                                            <td class="text-center fw-bold">8.0 hrs</td>
                                            <td class="text-center"><div class="badge badge-opacity-success">Complete</div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Printing Styles --}}
<style type="text/css" media="print">
    @page { size: auto; margin: 20mm; }
    body * { visibility: hidden; }
    .printable-area, .printable-area * { visibility: visible; }
    .printable-area { position: absolute; left: 0; top: 0; width: 100%; }
    .btn, .welcome-text, .navbar, .sidebar, .form-group { display: none !important; }
</style>
@endsection

@push('scripts')
<script>
    // Sample Data Mapping (In Laravel, you would pass this from the Controller)
    const dataMap = {
        "technova": ["Maria Clara", "Juan Dela Cruz"],
        "nexus": ["Jose Rizal", "Andres Bonifacio"]
    };

    function updateStudentList() {
        const company = document.getElementById('companySelect').value;
        const studentDropdown = document.getElementById('studentSelect');
        
        // Reset Student Dropdown
        studentDropdown.innerHTML = '<option value="">Select Student</option>';
        
        if (company && dataMap[company]) {
            dataMap[company].forEach(student => {
                let option = document.createElement('option');
                option.value = student.toLowerCase();
                option.text = student;
                studentDropdown.appendChild(option);
            });
        }
        filterReport(); // Run filter to show/hide cards based on company
    }

    function filterReport() {
        const selectedCompany = document.getElementById('companySelect').value;
        const selectedStudent = document.getElementById('studentSelect').value.toLowerCase();
        const items = document.querySelectorAll('.filter-item');

        items.forEach(item => {
            const itemName = item.getAttribute('data-name').toLowerCase();
            const itemCompany = item.getAttribute('data-company');

            const matchesCompany = !selectedCompany || itemCompany === selectedCompany;
            const matchesStudent = !selectedStudent || itemName === selectedStudent;

            if (matchesCompany && matchesStudent) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    }
</script>
@endpush