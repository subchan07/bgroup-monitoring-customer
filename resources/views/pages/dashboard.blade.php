@extends('layouts.app')

@push('styles')
    <style>
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab"
                                aria-controls="overview" aria-selected="true">Overview</a>
                        </li>
                    </ul>
                    <div>
                        {{-- <div class="btn-wrapper">
                            <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i>
                                Export</a>
                        </div> --}}
                    </div>
                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="statistics-details d-flex align-items-start justify-content-between">
                                    <div>
                                        <p class="statistics-title">Material</p>
                                        <h3 class="rate-percentage" id="profitMaterial">0</h3>
                                        <div class="text-muted">
                                            <p class="mb-0 yearPotensiProfit">year</p>
                                            <p class="fw-semibold mb-0" id="nilaiPotensiProfitMaterial">Rp. 0</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="statistics-title">User</p>
                                        <h3 class="rate-percentage" id="profitUser">0</h3>
                                        <div class="text-muted">
                                            <p class="mb-0 yearPotensiProfit">year</p>
                                            <p class="fw-semibold mb-0" id="nilaiPotensiProfitUser">Rp. 0</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Profit</p>
                                        <h3 class="rate-percentage" id="profitTotal" title="(user - material)">0</h3>
                                        <div class="text-muted">
                                            <p class="mb-0 yearPrevProfitTotal">year</p>
                                            <p class="fw-semibold mb-0" id="nilaiPotensiTotal">Rp. 0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body">
                                                <div class="d-sm-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h4 class="card-title card-title-dash">Material Chart
                                                        </h4>
                                                    </div>
                                                    <div id="performanceLine-legend">
                                                        <select id="filterChart" class="form-select text-dark">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="chartjs-wrapper mt-4">
                                                    <canvas id="performanceLine" width=""></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 d-flex flex-column">
                                <div class="row flex-grow">
                                    <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body card-rounded">
                                                <h4 class="card-title  card-title-dash">Material</h4>
                                                <div id="materialRecent">
                                                    <div class="placeholder-glow list border-bottom py-2">
                                                        <span class="placeholder col-12"></span>
                                                        <span class="placeholder col-1"></span>
                                                        <span class="placeholder col-6"></span>
                                                    </div>
                                                    <div class="placeholder-glow list border-bottom py-2">
                                                        <span class="placeholder col-12"></span>
                                                        <span class="placeholder col-1"></span>
                                                        <span class="placeholder col-6"></span>
                                                    </div>
                                                </div>
                                                <div class="list align-items-center pt-3">
                                                    <div class="wrapper w-100">
                                                        <p class="mb-0">
                                                            <a href="{{ route('material') }}"
                                                                class="fw-bold text-primary">Show all <i
                                                                    class="mdi mdi-arrow-right ms-2"></i></a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 grid-margin stretch-card">
                                        <div class="card card-rounded">
                                            <div class="card-body card-rounded">
                                                <h4 class="card-title card-title-dash">Customer</h4>
                                                <div id="customerRecent">
                                                    <div class="placeholder-glow list border-bottom py-2">
                                                        <span class="placeholder col-12"></span>
                                                        <span class="placeholder col-1"></span>
                                                        <span class="placeholder col-6"></span>
                                                    </div>
                                                    <div class="placeholder-glow list border-bottom py-2">
                                                        <span class="placeholder col-12"></span>
                                                        <span class="placeholder col-1"></span>
                                                        <span class="placeholder col-6"></span>
                                                    </div>
                                                </div>
                                                <div class="list align-items-center pt-3">
                                                    <div class="wrapper w-100">
                                                        <p class="mb-0">
                                                            <a href="{{ route('customer') }}"
                                                                class="fw-bold text-primary">Show all
                                                                <i class="mdi mdi-arrow-right ms-2"></i>
                                                            </a>
                                                        </p>
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush
