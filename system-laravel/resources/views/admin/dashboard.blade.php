@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <style>
    .stat-card {
      background: #ffffff;
      border-radius: 15px;
      padding: 20px;
      border: 1px solid #f0f0f0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
      transition: transform 0.2s;
    }
    .stat-card:hover {
      transform: translateY(-5px);
    }
    .icon-box {
      width: 45px;
      height: 45px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 15px;
    }
    .bg-light-green { background-color: rgba(46, 125, 50, 0.1); color: #2E7D32; }
    .bg-light-blue { background-color: rgba(0, 123, 255, 0.1); color: #007bff; }
    .bg-light-orange { background-color: rgba(255, 152, 0, 0.1); color: #ff9800; }
    .bg-light-purple { background-color: rgba(123, 31, 162, 0.1); color: #7B1FA2; }

    .stat-value { font-size: 1.5rem; font-weight: 700; color: #333; margin-bottom: 0; }
    .stat-label { font-size: 0.85rem; color: #6c757d; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .chart-card {
      background: #ffffff;
      border-radius: 15px;
      padding: 20px;
      border: 1px solid #f0f0f0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .chart-title {
      font-size: 1rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 15px;
    }
  </style>
@endpush

@section('content')

<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom mb-4 pb-3">
        <h2 class="welcome-text">Overview <span class="text-black fw-bold">Summary</span></h2>
      </div>

      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview">

          {{-- Stats Cards --}}
          <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-green">
                  <i class="mdi mdi-office-building mdi-24px"></i>
                </div>
                <p class="stat-label">Companies</p>
                <h3 class="stat-value">{{ $totalCompanies }}</h3>
                <p class="text-success small mt-2 mb-0">
                  <i class="mdi mdi-check-circle"></i> Active
                </p>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-blue">
                  <i class="mdi mdi-account-group mdi-24px"></i>
                </div>
                <p class="stat-label">OJT Students</p>
                <h3 class="stat-value">{{ $totalStudents }}</h3>
                <p class="text-success small mt-2 mb-0">
                  <i class="mdi mdi-menu-up"></i> Enrolled
                </p>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-orange">
                  <i class="mdi mdi-clock-outline mdi-24px"></i>
                </div>
                <p class="stat-label">Total Hours</p>
                <h3 class="stat-value">{{ number_format($totalHours, 1) }}</h3>
                <p class="text-muted small mt-2 mb-0">
                  <i class="mdi mdi-calendar"></i> All time
                </p>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-purple">
                  <i class="mdi mdi-chart-line mdi-24px"></i>
                </div>
                <p class="stat-label">Avg. Session</p>
                <h3 class="stat-value">{{ $avgTime }}</h3>
                <p class="text-muted small mt-2 mb-0">
                  <i class="mdi mdi-timer"></i> Per log
                </p>
              </div>
            </div>
          </div>

          {{-- Charts Row --}}
          <div class="row mt-2 mb-4">
            {{-- Pie Chart: Students per Company --}}
            <div class="col-lg-5 mb-4">
              <div class="chart-card h-100">
                <h5 class="chart-title">
                  <i class="mdi mdi-chart-pie text-success me-2"></i>
                  Students by Company
                </h5>
                <div style="position: relative; height: 280px;">
                  <canvas id="companyStudentChart"></canvas>
                </div>
                <p class="text-muted small mt-2 mb-0 text-center">
                  Distribution of OJT students across companies
                </p>
              </div>
            </div>

            {{-- Line Chart: Daily Hours --}}
            <div class="col-lg-7 mb-4">
              <div class="chart-card h-100">
                <h5 class="chart-title">
                  <i class="mdi mdi-chart-line text-primary me-2"></i>
                  Daily Hours Logged
                </h5>
                <div style="position: relative; height: 280px;">
                  <canvas id="hoursLineChart"></canvas>
                </div>
                <p class="text-muted small mt-2 mb-0 text-center">
                  Total hours recorded per day (last 7 days)
                </p>
              </div>
            </div>
          </div>

          {{-- Student Progress Table --}}
          <div class="row mt-2">
            <div class="col-lg-8">
              <div class="card card-rounded" style="border-radius: 15px;">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Student Progress</h4>
                    <a href="#" class="text-success fw-bold small">View All</a>
                  </div>
                  @if($studentProgress->isEmpty())
                    <div class="text-center py-5 text-muted">No student data available.</div>
                  @else
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Student</th>
                          <th>Company</th>
                          <th>Hours</th>
                          <th>Progress</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($studentProgress as $s)
                        <tr>
                          <td class="fw-bold">{{ $s['name'] }}</td>
                          <td class="text-muted small">{{ $s['company'] }}</td>
                          <td>{{ $s['hours'] }} / {{ $s['target'] }}</td>
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              <div class="progress flex-grow-1" style="height: 6px;">
                                <div class="progress-bar bg-success" style="width: {{ $s['progress'] }}%"></div>
                              </div>
                              <span class="small fw-bold" style="min-width: 40px;">{{ $s['progress'] }}%</span>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  @endif
                </div>
              </div>
            </div>

            {{-- Overall Task Completion --}}
            <div class="col-lg-4">
              <div class="card card-rounded" style="border-radius: 15px;">
                <div class="card-body text-center py-5">
                  <h4 class="card-title mb-4">Overall Task Completion</h4>
                  <div class="position-relative d-inline-block">
                    <canvas id="taskChart" width="180" height="180"></canvas>
                    <div class="position-absolute top-50 start-50 translate-middle">
                      <h2 class="fw-bold mb-0">{{ $taskCompletionRate }}%</h2>
                    </div>
                  </div>
                  <p class="text-muted small mt-3 mb-0">Of all assigned tasks</p>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // 1. Doughnut chart for overall task completion
  const ctx = document.getElementById('taskChart').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Completed', 'Pending'],
      datasets: [{
        data: [{{ $taskCompletionRate }}, {{ 100 - $taskCompletionRate }}],
        backgroundColor: ['#2E7D32', '#e9ecef'],
        borderWidth: 0,
        cutout: '75%'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: { legend: { display: false } }
    }
  });

  // 2. Pie chart: Students per company
  const companyCtx = document.getElementById('companyStudentChart').getContext('2d');
  new Chart(companyCtx, {
    type: 'pie',
    data: {
      labels: @json($companyStudentData->pluck('name')),
      datasets: [{
        data: @json($companyStudentData->pluck('count')),
        backgroundColor: ['#2E7D32', '#007bff', '#ff9800', '#7B1FA2', '#dc3545', '#17a2b8'],
        borderWidth: 2,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15 } },
        tooltip: {
          callbacks: {
            label: function(context) {
              const total = @json($companyStudentData->sum('count'));
              const pct = ((context.raw / total) * 100).toFixed(1);
              return context.label + ': ' + context.raw + ' students (' + pct + '%)';
            }
          }
        }
      }
    }
  });

  // 3. Line chart: Daily hours trend
  const hoursCtx = document.getElementById('hoursLineChart').getContext('2d');
  new Chart(hoursCtx, {
    type: 'line',
    data: {
      labels: @json($attendanceTrend['labels']),
      datasets: [{
        label: 'Hours Logged',
        data: @json($attendanceTrend['hours']),
        borderColor: '#2E7D32',
        backgroundColor: 'rgba(46, 125, 50, 0.1)',
        fill: true,
        tension: 0.4,
        pointRadius: 4,
        pointBackgroundColor: '#2E7D32',
        pointBorderColor: '#fff',
        pointBorderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
        x: { grid: { display: false } }
      },
      plugins: {
        legend: { display: false }
      }
    }
  });
</script>
@endpush
