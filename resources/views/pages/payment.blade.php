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
                        <table class="table table-hover" id="datatable">
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
    {{-- Detail Customer --}}
    <x-modal title="Detail Customer" idModal="detailCustomerModal">
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <tbody id="tbodyDetailModal">
                    </tbody>
                </table>
            </div>
        </div>
    </x-modal>

    <script>
        const tbody = $('#tbodyPayment');

        $(() => {
            // Muat data payment saat halaman pertama kali dimuat
            getAllPayment();

            tbody.on('click', '.btn-detail-customer', (event) => {
                const idEl = $(event.target).data('customer')
                handleDetailCustomerButtonCLick(idEl)
            })
        });


        // Fungsi untuk mendapatkan semua data payment
        const getAllPayment = () => {
            $.get('/api/payment', (result, status) => {
                const results = result.data

                tbody.html('')
                results.forEach(data => {
                    tbody.append(displayTbody(data));
                });

                if (results.length === 0) tbody.append(
                    '<tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>')

                if (results.length > 0) loadDataTable('#datatable')
            }, 'json');
        };

        // Fungsi untuk membangun HTML untuk menampilkan data payment
        const displayTbody = (data) => {
            const material = data.material
            const customer = data.customer
            const hostingCustomer = customer === null ? null : customer.hostingMaterial
            const domainCustomer = customer === null ? null : customer.domainMaterials
            const sslCustomer = customer === null ? null : customer.sslMaterial

            const {
                id,
                date,
                due_date,
                price,
                payment_amount
            } = data;
            // "  <a href='#' class='btn-detail-customer text-muted' data-customer="+customer.id+">lihat detail...</a>"
            return `<tr data-id="${id}">
                        <td>${material !== null ? 'material' : 'customer'}</td>
                        <td>
                            ${material === null ? '' : material.item}
                            ${customer === null ? '' : customer.name}
                        </td>
                        <td>${date}</td>
                        <td>${due_date}</td>
                        <td>${rupiah(price)}</td>
                        <td>${rupiah(payment_amount)}</td>
                    </tr>`;
        };

        // Detail data customer
        const handleDetailCustomerButtonCLick = (idEl) => {
            $.ajax({
                url: `/api/customer/${idEl}?withMaterial=true`,
                type: "GET",
                cache: false,
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (result, status) => {
                    const {
                        sslMaterial,
                        domainMaterials,
                        hostingMaterial
                    } = result.data

                    let html = ''
                    domainMaterials.forEach((data, i) => html += displayDetailCustomer(`Domain ${i+1}`,
                        data))
                    html += displayDetailCustomer('Hosting', hostingMaterial)
                    html += displayDetailCustomer('SSL', sslMaterial)

                    $('#tbodyDetailModal').html(html)
                    $('#detailCustomerModal').modal('show')
                }
            })
        }

        const displayDetailCustomer = (title, object) => {
            if (object) {
                return `<tr>
                            <td><span class="fw-bold">${title}</span></td>
                            <td><span class="fw-bold">Item:</span> ${object.item}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><span class="fw-bold">Harga:</span> ${rupiah(object.price)}</td>
                        </tr><tr><td colspan="2" class="border-0">&nbsp;</td></tr>`
            }
        }
    </script>
@endpush
