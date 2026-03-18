@extends('layouts.admin') {{-- This matches your provided layout name --}}

@section('title', 'Student Attendance Logs')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            {{-- Modernized Header: Matches the "with-welcome-text" body class --}}
            <div class="d-sm-flex align-items-center justify-content-between border-bottom mb-3">
                <div class="py-3">
                    <h2 class="welcome-text text-black fw-bold">Daily Time <span class="text-black fw-bold">Records</span></h2>
                </div>
                
                {{-- Integrated Search Bar --}}
                <div class="search-wrapper" style="width: 300px;">
                    <div class="input-group bg-white p-1 shadow-sm card-rounded">
                        <span class="input-group-text border-0 bg-transparent">
                            <i class="icon-magnifier text-primary"></i>
                        </span>
                        <input type="text" id="attendanceSearch" class="form-control border-0 ps-0 text-small" 
                               placeholder="Search name, date, or company..." onkeyup="filterAttendance(this)">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded shadow-sm">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h4 class="card-title card-title-dash">Attendance Logs</h4>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table select-table" id="attendanceTable">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="align-middle">Student & Company</th>
                                            <th rowspan="2" class="align-middle text-center">Date</th>
                                            <th colspan="2" class="text-center bg-light card-rounded-0" style="border-bottom: 1px solid #eee;">AM Session</th>
                                            <th colspan="2" class="text-center bg-light card-rounded-0" style="border-bottom: 1px solid #eee;">PM Session</th>
                                            <th rowspan="2" class="align-middle text-center">Total Rendered</th>
                                            <th rowspan="2" class="align-middle text-center">Status</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center py-2">In</th>
                                            <th class="text-center py-2">Out</th>
                                            <th class="text-center py-2">In</th>
                                            <th class="text-center py-2">Out</th>
                                        </tr>
                                    </thead>
                                    <tbody id="attendanceBody">
                                        {{-- Row 1: Full Day Example --}}
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white d-flex align-items-center justify-content-center fw-bold me-3 card-rounded" 
                                                         style="width: 40px; height: 40px; font-size: 0.8rem;">JD</div>
                                                    <div>
                                                        <h6 class="fw-bold mb-0">John Doe</h6>
                                                        <p class="text-muted mb-0 small text-uppercase">Nexus Tech Bacolod</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fw-bold">Mar 14, 2026</p>
                                            </td>
                                            {{-- AM Logs --}}
                                            <td class="text-center"><span class="text-success fw-bold">08:00 AM</span></td>
                                            <td class="text-center"><span class="text-muted">12:00 PM</span></td>
                                            {{-- PM Logs --}}
                                            <td class="text-center"><span class="text-success fw-bold">01:00 PM</span></td>
                                            <td class="text-center"><span class="text-danger fw-bold">05:00 PM</span></td>
                                            
                                            <td class="text-center">
                                                <h6 class="fw-bold text-dark mb-0">8.0 hrs</h6>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-opacity-success">Regular Day</div>
                                            </td>
                                        </tr>

                                        {{-- Row 2: Incomplete Example --}}
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-warning text-white d-flex align-items-center justify-content-center fw-bold me-3 card-rounded" 
                                                         style="width: 40px; height: 40px; font-size: 0.8rem;">JS</div>
                                                    <div>
                                                        <h6 class="fw-bold mb-0">Jane Smith</h6>
                                                        <p class="text-muted mb-0 small text-uppercase">Global IT Hub</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p class="mb-0 fw-bold">Mar 14, 2026</p>
                                            </td>
                                            {{-- AM Logs --}}
                                            <td class="text-center"><span class="text-success fw-bold">08:15 AM</span></td>
                                            <td class="text-center"><span class="text-muted">12:00 PM</span></td>
                                            {{-- PM Logs --}}
                                            <td class="text-center text-muted">--:--</td>
                                            <td class="text-center text-muted">--:--</td>
                                            
                                            <td class="text-center">
                                                <h6 class="fw-bold text-warning mb-0">3.7 hrs</h6>
                                            </td>
                                            <td class="text-center">
                                                <div class="badge badge-opacity-warning">Half Day</div>
                                            </td>
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
@endsection

@push('scripts')
<script>
    /**
     * Modern Search Functionality
     */
    function filterAttendance(input) {
        const filter = input.value.toLowerCase();
        const rows = document.querySelectorAll('#attendanceBody tr');

        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase();
            row.style.display = rowText.includes(filter) ? "" : "none";
        });
    }
</script>
@endpush