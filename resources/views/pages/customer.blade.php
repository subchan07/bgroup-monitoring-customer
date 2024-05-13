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
                        <h4 class="card-title">Customer Tabel</h4>

                        <button class="btn btn-sm btn-primary text-white mb-0 me-0" type="button"data-bs-toggle="modal"
                            data-bs-target="#addCustomerModal">
                            <i class="mdi mdi-plus-box-outline"></i> Customer
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Domain</th>
                                    <th>Domain Material</th>
                                    <th>Hosting Material</th>
                                    <th>SSL Material</th>
                                    <th>Batas Waktu</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyCustomer">
                                <tr>
                                    @for ($i = 0; $i < 7; $i++)
                                        <td class="placeholder-glow">
                                            <span class="placeholder col-12"></span>
                                        </td>
                                    @endfor
                                    <td class="placeholder-glow">
                                        <span class="placeholder col-4"></span>
                                        <span class="placeholder col-4"></span>
                                        <span class="placeholder col-4"></span>
                                    </td>
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
    {{-- Add Modal --}}
    <x-modal title="Tambah Data" idModal="addCustomerModal">
        <form action="#" method="POST" id="addForm">
            @csrf
            <div class="modal-body">
                <div class="form-group row">
                    <label for="inputName" class="col-sm-3 col-form-label">Nama <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="name" id="inputName" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDomain" class="col-sm-3 col-form-label">Nama Domain <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="domain" id="inputDomain" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDueDate" class="col-sm-3 col-form-label">Batas Waktu <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="due_date" id="inputDueDate" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPrice" class="col-sm-3 col-form-label">Harga <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="price" id="inputPrice" step="0.01" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDomainMaterial" class="col-sm-3 col-form-label">Domain</label>
                    <div class="col-sm-9">
                        <select name="domain_material_id" id="inputDomainMaterial"
                            class="select-domain js-example-basic-single w-100">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputHostingMaterial" class="col-sm-3 col-form-label">Hosting</label>
                    <div class="col-sm-9">
                        <select name="hosting_material_id" id="inputHostingMaterial"
                            class="select-hosting js-example-basic-single w-100">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputSslMaterial" class="col-sm-3 col-form-label">Ssl</label>
                    <div class="col-sm-9">
                        <select name="ssl_material_id" id="inputSslMaterial"
                            class="select-ssl js-example-basic-single w-100">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
            </div>
        </form>
    </x-modal>

    {{-- Edit Modal --}}
    <x-modal title="Edit Data" idModal="editCustomerModal">
        <form action="#" method="POST" id="updateForm">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="hidden" id="inputIdEdit">
                <div class="form-group row">
                    <label for="inputNameEdit" class="col-sm-3 col-form-label">Nama <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="name" id="inputNameEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDomainEdit" class="col-sm-3 col-form-label">Nama Domain <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="domain" id="inputDomainEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDomainMaterialEdit" class="col-sm-3 col-form-label">Domain </label>
                    <div class="col-sm-9">
                        <select name="domain_material_id" id="inputDomainMaterialEdit"
                            class="select-domain js-example-basic-single w-100">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputHostingMaterialEdit" class="col-sm-3 col-form-label">Hosting</label>
                    <div class="col-sm-9">
                        <select name="hosting_material_id" id="inputHostingMaterialEdit"
                            class="select-hosting js-example-basic-single w-100">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputSslMaterialEdit" class="col-sm-3 col-form-label">Ssl</label>
                    <div class="col-sm-9">
                        <select name="ssl_material_id" id="inputSslMaterialEdit"
                            class="select-ssl js-example-basic-single w-100">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
            </div>
        </form>
    </x-modal>

    {{-- Bayar Modal --}}
    <x-modal title="Bayar Data" idModal="bayarCustomerModal">
        <form action="#" method="POST" id="paymentForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="customer_id" id="inputIdPayment">
                <div class="form-group row">
                    <label for="inputCustomerNamePayment" class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" id="inputCustomerNamePayment" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDatePayment" class="col-sm-3 col-form-label">Tanggal <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="date" id="inputDatePayment" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDueDatePayment" class="col-sm-3 col-form-label">Batas Waktu <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="due_date" id="inputDueDatePayment" class="form-control" required />
                        <p class="text-muted my-0">Ubah untuk data bayar berikutnya.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPricePayment" class="col-sm-3 col-form-label">Harga <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="price" id="inputPricePayment" class="form-control" step="0.01"
                            required />
                        <p class="text-muted my-0">Ubah untuk data bayar berikutnya.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPaymentAmount" class="col-sm-3 col-form-label">Nilai Bayar <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="payment_amount" id="inputPaymentAmount" class="form-control"
                            step="0.01" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
            </div>
        </form>
    </x-modal>

    {{-- custom js for this page --}}
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <script>
        const tbody = $('#tbodyCustomer'),
            addForm = $('#addForm'),
            updateForm = $('#updateForm'),
            paymentForm = $('#paymentForm'),
            selectDomain = $('.select-domain'),
            selectHosting = $('.select-hosting'),
            selectSsl = $('.select-ssl')

        $(() => {
            // Muat data customer saat halaman pertama kali dimuat
            getAllCustomer();
            getAllMaterial();

            // Menangani submit form tambah
            addForm.on('submit', (event) => {
                event.preventDefault();
                const formData = new FormData(addForm[0]);

                $.ajax({
                    url: '/api/customer',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => setButtonDisabled($('.btn-submit'), true),
                    complete: () => setButtonDisabled($('.btn-submit'), false),
                    success: (results, status) => {
                        getAllCustomer()
                        toastFlashMessage(results.message, status);
                        addForm[0].reset()
                        $('.modal').modal('hide')
                    },
                    error: (xhr, status, error) => {
                        const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                                .errors) :
                            'Terjadi kesalahan saat memuat data.';
                        flashMessage("Error", errorMessage, status);
                    }
                });
            });

            // Menangani submit form update
            updateForm.on('submit', (event) => {
                event.preventDefault();
                const dataForm = new FormData(updateForm[0]);
                const customerId = $('#inputIdEdit').val();

                $.ajax({
                    url: `/api/customer/${customerId}`,
                    type: 'POST',
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    beforeSend: () => setButtonDisabled($('.btn-submit'), true),
                    complete: () => setButtonDisabled($('.btn-submit'), false),
                    success: (results, status) => {
                        getAllCustomer()
                        toastFlashMessage(results.message, status)
                        updateForm[0].reset()
                        $('.modal').modal('hide')
                    },
                    error: (xhr, status, error) => {
                        const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                                .errors) :
                            'Terjadi kesalahan saat memuat data.';
                        flashMessage("Error", errorMessage, status);
                    }
                });
            });

            paymentForm.on('submit', (event) => {
                event.preventDefault();
                const dataForm = new FormData(paymentForm[0]);
                const customerId = $('#inputIdPayment').val();

                $.ajax({
                    url: `/api/customer/bayar`,
                    type: 'POST',
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    beforeSend: () => setButtonDisabled($('.btn-submit'), true),
                    complete: () => setButtonDisabled($('.btn-submit'), false),
                    success: (results, status) => {
                        getAllCustomer()
                        toastFlashMessage(results.message, status)
                        paymentForm[0].reset()
                        $('.modal').modal('hide')
                    },
                    error: (xhr, status, error) => {
                        const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                                .errors) :
                            'Terjadi kesalahan saat memuat data.';
                        flashMessage("Error", errorMessage, status);
                    }
                });
            });

            $('#tbodyCustomer').on('click', '.btn-hapus', (event) => {
                const clickedEl = $(event.target)
                const id = clickedEl.closest('tr').data('id');

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Data ini tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        handleHapusButtonClick(id)
                    }
                });
            });
        });

        // Event delegation untuk tombol klik di dalam tbodyCustomer
        $('#tbodyCustomer').on('click', '.btn-edit', (event) => {
            const clickedEl = $(event.target)
            const idEl = clickedEl.closest('tr').data('id');

            $.ajax({
                url: `/api/customer/${idEl}`,
                type: "GET",
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (result, status) => {
                    const {
                        id,
                        name,
                        domain,
                        due_date,
                        price,
                        domain_material_id,
                        hosting_material_id,
                        ssl_material_id
                    } = result.data

                    // Isi nilai form dengan data customer yang akan diupdate
                    $('#inputIdEdit').val(id);
                    $('#inputNameEdit').val(name);
                    $('#inputDomainEdit').val(domain);
                    $('#inputDueDateEdit').val(due_date);
                    $('#inputPriceEdit').val(price);
                    $('#inputDomainMaterialEdit').val(domain_material_id);
                    $('#inputHostingMaterialEdit').val(hosting_material_id);
                    $('#inputSslMaterialEdit').val(ssl_material_id);

                    // Tampilkan modal edit
                    $('#editCustomerModal').modal('show');
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                            .errors) :
                        'Terjadi kesalahan saat memuat data.';
                    flashMessage("Error", errorMessage, status);
                }
            })
        });

        $('#tbodyCustomer').on('click', '.btn-bayar', (event) => {
            const clickedEl = $(event.target)
            const idEl = clickedEl.closest('tr').data('id');
            handleBayarButtonClick(idEl);
        });


        // HANDLE FUNCTION

        // Fungsi untuk menangani klik tombol Bayar
        const handleBayarButtonClick = (idEl) => {
            $.ajax({
                url: `/api/customer/${idEl}`,
                type: "GET",
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (result, status) => {
                    const {
                        id,
                        name,
                        due_date,
                        price,
                    } = result.data

                    // Isi nilai form dengan data customer yang akan diupdate
                    $('#inputIdPayment').val(id);
                    $('#inputCustomerNamePayment').val(name);
                    $('#inputDueDatePayment').val(due_date);
                    $('#inputPricePayment').val(price);

                    $('#inputDatePayment').val(getCurrentDate());
                    $('#inputPaymentAmount').val('')

                    // Tampilkan modal edit
                    $('#bayarCustomerModal').modal('show');
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                            .errors) :
                        'Terjadi kesalahan saat memuat data.';
                    flashMessage("Error", errorMessage, status);
                }
            })
        };

        // Fungsi untuk menangani klik tombol Hapus
        const handleHapusButtonClick = (id) => {
            $.ajax({
                url: `/api/customer/${id}`,
                type: "DELETE",
                cache: false,
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (response, status) => {
                    getAllCustomer()
                    toastFlashMessage(response.message, status);
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON.errors) :
                        'Terjadi kesalahan saat memuat data.';
                    flashMessage("Error", errorMessage, status);
                }
            });
        };


        const getAllMaterial = () => {
            $.get('/api/material', (result, status) => {
                const results = result.data;

                let optionDomain = '<option selected value="">-- Pilih --</option>',
                    optionHosting = '<option selected value="">-- Pilih --</option>',
                    optionSsl = '<option selected value="">-- Pilih --</option>'

                results.forEach(data => {
                    if (data.material === 'hosting') optionHosting +=
                        `<option value="${data.id}">${data.item}</option>`

                    if (data.material == 'domain') optionDomain +=
                        `<option value="${data.id}">${data.item}</option>`

                    if (data.material == 'ssl') optionSsl +=
                        `<option value="${data.id}">${data.item}</option>`
                });

                selectDomain.html(optionDomain)
                selectHosting.html(optionHosting)
                selectSsl.html(optionSsl)
            }, 'json');
        }

        // Fungsi untuk mendapatkan semua data customer
        const getAllCustomer = () => {
            resetDataTable('.table')
            $.get('/api/customer', (result, status) => {
                const results = result.data;

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

        // Fungsi untuk membangun HTML untuk menampilkan data customer
        const displayTbody = (data) => {
            const domainMaterial = data.domainMaterial
            const hostingMaterial = data.hostingMaterial
            const sslMaterial = data.sslMaterial
            const {
                id,
                name,
                domain,
                due_date,
                price,
            } = data;

            return `<tr data-id="${id}">
                        <td>${name}</td>
                        <td>${domain}</td>
                        <td>${domainMaterial === null ? '-' : domainMaterial.item}</td>
                        <td>${hostingMaterial === null ? '-' : hostingMaterial.item}</td>
                        <td>${sslMaterial === null ? '-' : sslMaterial.item}</td>
                        <td>${due_date}</td>
                        <td>${rupiah(price)}</td>
                        <td>
                            <button class="btn-bayar btn btn-sm btn-info btn-action">Bayar</button>
                            <button class="btn-edit btn btn-sm btn-warning btn-action">Edit</button>
                            <button class="btn-hapus btn btn-sm btn-danger btn-action">Hapus</button>
                        </td>
                    </tr>`;
        };
    </script>
@endpush
