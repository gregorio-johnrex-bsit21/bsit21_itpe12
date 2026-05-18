@extends('layouts.admin')

@section('title', 'Student Attendance Logs')

@section('content')

<div class="row">
    <div class="col-12">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-0">Student Attendance</h4>
                <p class="text-muted small mb-0">{{ $attendances->count() }} total records</p>
            </div>
        </div>

        <div class="card card-rounded shadow-sm border-0 mb-4">
    <div class="card-body py-3">
        <div class="row g-3 align-items-center">

            {{-- Search --}}
            <div class="col-12 col-md-5">
                <div class="input-group" style="border: 1.5px solid #e2e8f0; border-radius: 10px; overflow: hidden; background: #fff;">
                    <span class="input-group-text border-0 bg-white pe-1">
                        <i class="mdi mdi-magnify" style="color: #059669; font-size: 18px;"></i>
                    </span>
                    <input type="text" id="attendanceSearch"
                        class="form-control border-0 ps-1 shadow-none"
                        placeholder="Search student or date..."
                        style="font-size: 13px;"
                        onkeyup="applyFilters()">
                </div>
            </div>

            {{-- Company Filter --}}
            <div class="col-12 col-md-4">
                <select id="companyFilter"
                    class="form-select shadow-none"
                    style="border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #374151; background-color: #fff;"
                    onchange="applyFilters()">
                    <option value="all">All Companies</option>
                    @foreach($companies as $company)
                        <option value="{{ strtolower($company->name) }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status Filter --}}
            <div class="col-12 col-md-3">
                <select id="statusFilter"
                    class="form-select shadow-none"
                    style="border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #374151; background-color: #fff;"
                    onchange="applyFilters()">
                    <option value="all">All Status</option>
                    <option value="regular day">Regular Day</option>
                    <option value="half day">Half Day</option>
                    <option value="has missed">Has Missed</option>
                    <option value="incomplete">Incomplete</option>
                </select>
            </div>

        </div>
    </div>
</div>

        {{-- Table Card --}}
        <div class="card card-rounded shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" id="attendanceTable">
                        <thead style="background: #f8fafb;">
                            <tr>
                                <th class="px-4 py-3 text-uppercase text-muted fw-semibold border-0" style="font-size: 11px; letter-spacing: 0.05em;">Student</th>
                                <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px; letter-spacing: 0.05em;">Date</th>
                                <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px; letter-spacing: 0.05em;" colspan="2">AM Session</th>
                                <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px; letter-spacing: 0.05em;" colspan="2">PM Session</th>
                                <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center" style="font-size: 11px; letter-spacing: 0.05em;">Total</th>
                                <th class="py-3 text-uppercase text-muted fw-semibold border-0 text-center pe-4" style="font-size: 11px; letter-spacing: 0.05em;">Status</th>
                            </tr>
                            <tr style="background: #f8fafb;">
                                <th class="px-4 border-0 pb-3"></th>
                                <th class="border-0 pb-3"></th>
                                <th class="border-0 pb-3 text-center text-muted" style="font-size: 10px;">IN</th>
                                <th class="border-0 pb-3 text-center text-muted" style="font-size: 10px;">OUT</th>
                                <th class="border-0 pb-3 text-center text-muted" style="font-size: 10px;">IN</th>
                                <th class="border-0 pb-3 text-center text-muted" style="font-size: 10px;">OUT</th>
                                <th class="border-0 pb-3"></th>
                                <th class="border-0 pb-3 pe-4"></th>
                            </tr>
                        </thead>
                        <tbody id="attendanceBody">
                            @forelse($attendances as $a)
                            <tr class="attendance-row border-top"
                                data-name="{{ strtolower($a['student_name']) }}"
                                data-date="{{ strtolower($a['date']) }}"
                                data-company="{{ strtolower($a['company_name']) }}"
                                data-status="{{ strtolower($a['status']) }}"
                                style="transition: background 0.15s;">

                                {{-- Student --}}
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                             style="width:38px; height:38px; font-size:13px; background:{{ $a['avatar_bg'] }};">
                                            {{ $a['initials'] }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark" style="font-size:14px;">{{ $a['student_name'] }}</div>
                                            <div class="text-muted" style="font-size:11px; letter-spacing:0.04em;">{{ strtoupper($a['company_name']) }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td class="py-3 text-center">
                                    <span class="fw-semibold text-dark" style="font-size:13px;">{{ $a['date'] }}</span>
                                </td>

                                {{-- AM In --}}
                                <td class="py-3 text-center">
                                    @if($a['am_time_in'])
                                        <span class="fw-bold" style="color:#059669; font-size:13px;">{{ $a['am_time_in'] }}</span>
                                    @else
                                        <span class="text-muted" style="font-size:13px;">--:--</span>
                                    @endif
                                </td>

                                {{-- AM Out --}}
                                <td class="py-3 text-center">
                                    @if($a['am_time_out'])
                                        <span class="text-muted" style="font-size:13px;">{{ $a['am_time_out'] }}</span>
                                    @else
                                        <span class="text-muted" style="font-size:13px;">--:--</span>
                                    @endif
                                </td>

                                {{-- PM In --}}
                                <td class="py-3 text-center">
                                    @if($a['pm_time_in'])
                                        <span class="fw-bold" style="color:#059669; font-size:13px;">{{ $a['pm_time_in'] }}</span>
                                    @else
                                        <span class="text-muted" style="font-size:13px;">--:--</span>
                                    @endif
                                </td>

                                {{-- PM Out --}}
                                <td class="py-3 text-center">
                                    @if($a['pm_time_out'])
                                        <span class="text-muted" style="font-size:13px;">{{ $a['pm_time_out'] }}</span>
                                    @else
                                        <span class="text-muted" style="font-size:13px;">--:--</span>
                                    @endif
                                </td>

                                {{-- Total --}}
                                <td class="py-3 text-center">
                                    <span class="fw-bold {{ $a['hours_class'] }}" style="font-size:14px;">
                                        {{ $a['total_hours'] }}h
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="py-3 text-center pe-4">
                                    @php
                                        $badgeStyle = match($a['status']) {
                                            'Regular Day' => 'background:#ecfdf5; color:#059669; border:1px solid #a7f3d0;',
                                            'Half Day'    => 'background:#fff7ed; color:#ea580c; border:1px solid #fed7aa;',
                                            'Has Missed'  => 'background:#fffbeb; color:#d97706; border:1px solid #fde68a;',
                                            'Incomplete'  => 'background:#fef2f2; color:#dc2626; border:1px solid #fecaca;',
                                            default       => 'background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-pill fw-semibold"
                                          style="font-size:11px; {{ $badgeStyle }}">
                                        {{ $a['status'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="mdi mdi-calendar-blank mdi-36px d-block mb-2"></i>
                                    No attendance records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Empty state when filters return nothing --}}
                <div id="noResults" class="text-center py-5 text-muted d-none">
                    <i class="mdi mdi-filter-off mdi-36px d-block mb-2"></i>
                    <p class="mb-0">No records match your filters.</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function applyFilters() {
        const search  = document.getElementById('attendanceSearch').value.toLowerCase().trim();
        const company = document.getElementById('companyFilter').value.toLowerCase();
        const status  = document.getElementById('statusFilter').value.toLowerCase();
        const rows    = document.querySelectorAll('.attendance-row');
        let visible   = 0;

        rows.forEach(row => {
            const name        = row.getAttribute('data-name')    ?? '';
            const date        = row.getAttribute('data-date')    ?? '';
            const rowCompany  = row.getAttribute('data-company') ?? '';
            const rowStatus   = row.getAttribute('data-status')  ?? '';

            const matchSearch  = search  === '' || name.includes(search) || date.includes(search);
            const matchCompany = company === 'all' || rowCompany.includes(company);
            const matchStatus  = status  === 'all' || rowStatus === status;

            const show = matchSearch && matchCompany && matchStatus;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('noResults').classList.toggle('d-none', visible > 0);
    }
</script>
@endpush