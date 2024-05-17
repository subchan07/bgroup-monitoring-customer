@extends('layouts.app')

@push('styles')
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
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab"
                                aria-selected="false">Audiences</a>
                        </li> --}}
                    </ul>
                    <div>
                        <div class="btn-wrapper">
                            {{-- <a href="#" class="btn btn-otline-dark align-items-center"><i class="icon-share"></i>
                                Share</a> --}}
                            <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                            <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i>
                                Export</a>
                        </div>
                    </div>
                </div>
                <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="statistics-details d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="statistics-title">Kewajiban</p>
                                        <h3 class="rate-percentage">0</h3>
                                        <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>0</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Pembayaran</p>
                                        <h3 class="rate-percentage">0</h3>
                                        <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>0</span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="statistics-title">Profit</p>
                                        <h3 class="rate-percentage">0</h3>
                                        <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>0</span>
                                        </p>
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
                                                                class="fw-bold text-primary">Show all <i
                                                                    class="mdi mdi-arrow-right ms-2"></i></a>
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

    <script>
        const filterChart = $('#filterChart')
        $(() => {
            summaryByMonth()
            getAllCustomer()
            getAllMaterial()

            filterChart.on('change', (e) => {
                const year = filterChart.val()
                summaryByMonth(year)
            })
        })

        // const year = 2024
        // const month = 5
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const getAllCustomer = () => {
            $.get('/api/customer', (results, status) => {
                const datas = results.data;

                let recentEvent = ''
                datas.forEach((data, index) => {
                    if (index < 5) recentEvent += displayRecentEvent(data.name, data.due_date)
                });
                $('#customerRecent').html(recentEvent)
            }, 'json');
        }

        const getAllMaterial = () => {
            $.get('/api/material', (results, status) => {
                const datas = results.data;

                let recentEvent = ''
                datas.forEach((data, index) => {
                    if (index < 5) recentEvent += displayRecentEvent(data.item, data.due_date)
                });
                $('#materialRecent').html(recentEvent)
            }, 'json');
        }

        const getAllPayment = () => {
            $.get('/api/payment', (results, status) => {
                const datas = results.data
                // console.log(datas);
            })
        }

        const summaryByMonth = (year) => {
            let queryParam = year ? `?year=${year}` : ''

            $.get(`/api/material/summaryByMonth${queryParam}`, (results, status) => {
                const {
                    data,
                    years
                } = results
                initChart(data)

                filterChart.html(years.map((year) => `<option val="${year}">${year}</option>`))
                if (year) filterChart.val(year)
            })
        }

        const displayRecentEvent = (keterangan, due_date) => {
            const date = new Date(due_date);
            const month = months[date.getMonth()];
            const day = date.getDate();
            const year = date.getFullYear();

            return `<div class="list align-items-center border-bottom py-2">
                        <div class="wrapper w-100">
                            <p class="mb-2 fw-medium"> ${keterangan} </p>
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-calendar text-muted me-1"></i>
                                <p class="mb-0 text-small text-muted">${month} ${day}, ${year}</p>
                            </div>
                        </div>
                    </div>`
        }
    </script>

    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush
