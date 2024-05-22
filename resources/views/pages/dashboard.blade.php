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
                        <div class="btn-wrapper">
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

    <script>
        const currentYear = new Date().getFullYear()
        const filterChart = $('#filterChart')
        $(() => {
            $('.yearPotensiProfit').html(`${currentYear}-${currentYear+1}`)
            $('.yearPrevProfitTotal').html(`${currentYear -1}-${currentYear}`)

            annualSummary()
            getAllMaterial()
            getAllCustomer()

            filterChart.on('change', (e) => {
                const year = filterChart.val()
                annualSummary(year)
            })
        })

        // const year = 2024
        // const month = 5
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        const getAllCustomer = () => {
            $.get('/api/customer?orderBy=price&direction=desc&limit=10', (results, status) => {
                const recentEvent = $('#customerRecent')
                const datas = results.data;

                recentEvent.html('')
                datas.forEach((data, index) => {
                    let name = `${data.service} - ${data.name}`
                    recentEvent.append(displayRecentEvent(name, data.due_date, data.price))
                });
            }, 'json');
        }

        const getAllMaterial = () => {
            $.get('/api/material?orderBy=price&direction=desc&limit=10', (results, status) => {
                const recentEvent = $('#materialRecent')
                const datas = results.data;

                recentEvent.html('')
                datas.forEach((data, index) => recentEvent.append(displayRecentEvent(data.item, data.due_date,
                    data.price)));
            }, 'json');
        }

        const annualSummary = (year) => {
            let queryParam = year ? `?year=${year}` : ''

            $.get(`/api/payment/annual-summary${queryParam}`, (results, status) => {
                const {
                    years,
                    monthly_customer_summary,
                    material_summary_current_year,
                    customer_summary_current_year,
                    total_summary_current_year,
                } = results.data
                const annualSummary = results.data.paymentSummary
                let currentTotalPriceMaterial = 0,
                    currentTotalPriceCustomer = 0,
                    currentTotalPrice = 0,
                    prevTotalPrice = 0

                if (annualSummary[0]?.year == currentYear) {
                    currentTotalPriceMaterial = parseInt(annualSummary[0]?.total_price_material)
                    currentTotalPriceCustomer = parseInt(annualSummary[0]?.total_price_customer)
                    currentTotalPrice = parseInt(annualSummary[0]?.total_price)
                }

                if (annualSummary[1]?.year == (currentYear - 1)) {
                    prevTotalPrice = parseInt(annualSummary[1].total_price)
                }

                $('#profitMaterial').html(rupiah(currentTotalPriceMaterial))
                $('#nilaiPotensiProfitMaterial').html(rupiah(material_summary_current_year))
                    .addClass(currentTotalPriceMaterial > material_summary_current_year ?
                        'text-danger' :
                        'text-success')

                $('#profitUser').html(rupiah(currentTotalPriceCustomer))
                $('#nilaiPotensiProfitUser').html(rupiah(customer_summary_current_year))
                    .addClass(currentTotalPriceCustomer > customer_summary_current_year ?
                        'text-danger' :
                        'text-success')

                $('#profitTotal').html(rupiah(currentTotalPrice))
                $('#nilaiPotensiTotal').html(rupiah(prevTotalPrice))
                    .addClass(currentTotalPrice > prevTotalPrice ? 'text-danger' :
                        'text-success')

                initChart(monthly_customer_summary)

                filterChart.html(years.map((year) => `<option val="${year}">${year}</option>`))
                if (year) filterChart.val(year)
                else filterChart.val(currentYear)
            })
        }

        const displayRecentEvent = (keterangan, due_date, price) => {
            const date = new Date(due_date);
            const month = months[date.getMonth()];
            const day = date.getDate();
            const year = date.getFullYear();

            return `<div class="list align-items-center border-bottom py-2">
                        <div class="wrapper w-100">
                            <p class="mb-2 fw-medium line-clamp-1"> ${keterangan} </p>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="mb-0 text-small text-muted"><i class="mdi mdi-calendar me-1"></i><span>${month} ${day}, ${year}</span></p>
                                <p class="mb-0 text-small text-muted"><i class="mdi mdi-cash me-1"></i><span>${rupiah(price)}</span></p>
                            </div>
                        </div>
                    </div>`
        }
    </script>

    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush
