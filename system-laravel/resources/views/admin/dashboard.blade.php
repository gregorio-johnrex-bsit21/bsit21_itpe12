@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <style>
    /* Custom Green Theme for Dashboard Cards */
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
    
    .stat-value { font-size: 1.5rem; font-weight: 700; color: #333; margin-bottom: 0; }
    .stat-label { font-size: 0.85rem; color: #6c757d; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
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
          
          {{-- Modern Statistics Cards --}}
          <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-green">
                  <i class="mdi mdi-office-building mdi-24px"></i>
                </div>
                <p class="stat-label">Companies</p>
                <h3 class="stat-value">3</h3>
                <p class="text-danger small mt-2 mb-0"><i class="mdi mdi-menu-down"></i> -0.5%</p>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-blue">
                  <i class="mdi mdi-account-group mdi-24px"></i>
                </div>
                <p class="stat-label">OJT Students</p>
                <h3 class="stat-value">3</h3>
                <p class="text-success small mt-2 mb-0"><i class="mdi mdi-menu-up"></i> +0.1%</p>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-orange">
                  <i class="mdi mdi-clock-outline mdi-24px"></i>
                </div>
                <p class="stat-label">Total Sessions</p>
                <h3 class="stat-value">68.8</h3>
                <p class="text-danger small mt-2 mb-0"><i class="mdi mdi-menu-down"></i> 68.8%</p>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-4">
              <div class="stat-card">
                <div class="icon-box bg-light-green">
                  <i class="mdi mdi-chart-line mdi-24px"></i>
                </div>
                <p class="stat-label">Avg. Time</p>
                <h3 class="stat-value">2m:35s</h3>
                <p class="text-success small mt-2 mb-0"><i class="mdi mdi-menu-up"></i> +0.8%</p>
              </div>
            </div>
          </div>

          {{-- Main Content Section (Where charts usually go) --}}
          <div class="row mt-3">
            <div class="col-lg-12 d-flex flex-column">
               <div class="card card-rounded" style="border-radius: 15px;">
                 <div class="card-body">
                   <h4 class="card-title">Overall Performance</h4>
                   <canvas id="performanceLine"></canvas>
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