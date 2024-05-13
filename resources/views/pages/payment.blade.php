@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Pembayaran Tabel</h4>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="tableContent">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Nama Item</th>
                                    <th>Tanggal</th>
                                    <th>Batas Waktu</th>
                                    <th>Harga</th>
                                    <th>Bayar</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPayment">
                                <tr>
                                    @for ($i = 0; $i < 6; $i++)
                                        <td class="placeholder-glow">
                                            <span class="placeholder col-12"></span>
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const tbody = $('#tbodyPayment');

        $(() => {
            // Muat data payment saat halaman pertama kali dimuat
            getAllPayment();
        });


        // Fungsi untuk mendapatkan semua data payment
        const getAllPayment = () => {
            $.get('/api/payment', (result, status) => {
                const results = result.data

                let htmlContent = '';
                results.forEach(data => {
                    htmlContent += displayTbody(data);
                });

                if (results.length === 0) htmlContent +=
                    '<tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>'

                tbody.html(htmlContent);
                if (results.length > 0) loadDataTable('.table')
            }, 'json');
        };

        // Fungsi untuk membangun HTML untuk menampilkan data payment
        const displayTbody = (data) => {
            const material = data.material
            const customer = data.customer
            const hostingCustomer = customer === null ? null : customer.hostingMaterial
            const domainCustomer = customer === null ? null : customer.domainMaterial
            const sslCustomer = customer === null ? null : customer.sslMaterial

            const {
                id,
                date,
                due_date,
                price,
                payment_amount
            } = data;

            return `<tr data-id="${id}">
                        <td>${material === null ? 'material' : 'customer'}</td>
                        <td>
                            ${material === null ? '' : material.item}
                            ${customer === null ? '' : customer.name+ '<br>'}
                            ${hostingCustomer === null ? '' : '<strong>hosting:</strong> '+ hostingCustomer.item + '<br>'}
                            ${domainCustomer === null ? '' : '<strong>domain:</strong> '+ domainCustomer.item + '<br>'}
                            ${sslCustomer === null ? '' : '<strong>ssl:</strong> '+ sslCustomer.item + '<br>'}
                        </td>
                        <td>${date}</td>
                        <td>${due_date}</td>
                        <td>${rupiah(price)}</td>
                        <td>${rupiah(payment_amount)}</td>
                    </tr>`;
        };
    </script>
@endpush
