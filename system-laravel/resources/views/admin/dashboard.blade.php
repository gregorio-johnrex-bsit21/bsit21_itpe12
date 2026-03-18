@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
@endpush

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="home-tab">
      <div class="d-sm-flex align-items-center justify-content-between border-bottom">


      <div class="tab-content tab-content-basic">
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">

          {{-- Statistics Row --}}
          <div class="row">
            <div class="col-sm-12">
              <div class="statistics-details d-flex align-items-center justify-content-between">
                <div>
                  <p class="statistics-title">Comany</p>
                  <h3 class="rate-percentage">3</h3>
                  <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>-0.5%</span></p>
                </div>
                <div>
                  <p class="statistics-title">OJT Student</p>
                  <h3 class="rate-percentage">3</h3>
                  <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>+0.1%</span></p>
                </div>
                <div>
                  <p class="statistics-title">Total Sessions</p>
                  <h3 class="rate-percentage">68.8</h3>
                  <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                </div>
                <div class="d-none d-md-block">
                  <p class="statistics-title">Avg. Time on Site</p>
                  <h3 class="rate-percentage">2m:35s</h3>
                  <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                </div>
                <div class="d-none d-md-block">
                  <p class="statistics-title">Avg. Time on Site</p>
                  <h3 class="rate-percentage">2m:35s</h3>
                  <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                </div>
              </div>
            </div>
          </div>

          <div class="row gx-4">
            {{-- Left Column --}}
            <div class="col-lg-6 d-flex flex-row">

              {{-- student Overview Chart --}}
              <div class="row flex-grow">
                <div class="col-11.5 gd-flex flex-column">
                  <div class="card card-rounded">
                    <div class="card-body">
                      <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                          <h4 class="card-title card-title-dash">Student Overview</h4>
                          <p class="card-subtitle card-subtitle-dash">Track student overall performance</p>
                        </div>
                        <div class="d-flex align-items-center">
                          <h2 class="me-2 fw-bold">3</h2>
                          <h4 class="text-success">(+1.37%)</h4>
                        </div>
                        <div class="me-3">
                          <div id="marketingOverview-legend"></div>
                        </div>
                      </div>
                      <div class="chartjs-bar-wrapper mt-3">
                        <canvas id="marketingOverview"></canvas>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              
            {{-- End Left Column --}}

            {{-- Right Column --}}
            <div class="col-lg-12 d-flex flex-column">


              {{-- Student Report Chart --}}
              <div class="row flex-grow">
                <div class="col-12 grid-margin">
                  <div class="card card-rounded">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                              <h4 class="card-title card-title-dash">Student Report</h4>
                            </div>
                            <div>
                              <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Month Wise</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                  <h6 class="dropdown-header">Week Wise</h6>
                                  <a class="dropdown-item" href="#">Year Wise</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="mt-3">
                            <canvas id="leaveReport"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            {{-- End Right Column --}}

          </div>
        </div>
        {{-- End Overview Tab --}}

      </div>
      {{-- End tab-content --}}

    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush
