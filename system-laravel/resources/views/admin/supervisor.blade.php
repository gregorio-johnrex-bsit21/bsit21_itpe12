@extends('layouts.admin')

@section('title', 'Supervisor')

@section('content')
{{-- Removed d-flex and justify-content-center to let it align naturally --}}
<div class="container">
    <div class="content-wrapper">
        <div class="row">
            
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Line chart</h4>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Bar chart</h4>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Area chart</h4>
                        <canvas id="areaChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Doughnut chart</h4>
                        <div class="doughnutjs-wrapper d-flex justify-content-center">
                            <canvas id="doughnutChart" style="height: 250px !important;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- End Row --}}
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
@endpush
@endsection