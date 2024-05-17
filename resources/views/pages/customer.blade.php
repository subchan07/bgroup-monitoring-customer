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
                        <table class="table table-hover" id="datatable">
                            <thead>
                                <tr>
                                    <th>Batas Waktu</th>
                                    <th>Customer</th>
                                    <th>Domain</th>
                                    <th>Domain M</th>
                                    <th>Hosting M</th>
                                    <th>SSL M</th>
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
                            <tfoot>
                                <tr>
                                    <td>Total Harga</td>
                                    <td id="tfootTotalHargaText">-</td>
                                </tr>
                                <tr>
                                    <td id="tfootPotentialProfitThisYear">Potensi Profit</td>
                                    <td id="tfootPotentialProfitThisYearText">-</td>
                                </tr>
                                <tr>
                                    <td id="tfootPotentialProfitNextYear">Potensi Profit</td>
                                    <td id="tfootPotentialProfitNextYearText">-</td>
                                </tr>
                            </tfoot>
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
                    <label for="inputName" class="col-sm-3 col-form-label">Customer <span
                            class="text-danger">*</span></label>
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
                        <select name="domain_material_ids[]" id="inputDomainMaterial" multiple
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
                    <label for="inputNameEdit" class="col-sm-3 col-form-label">Customer <span
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
                    <label for="inputDueDateEdit" class="col-sm-3 col-form-label">Batas Waktu <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="due_date" id="inputDueDateEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPriceEdit" class="col-sm-3 col-form-label">Harga <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="price" id="inputPriceEdit" step="0.01" class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDomainMaterialEdit" class="col-sm-3 col-form-label">Domain </label>
                    <div class="col-sm-9">
                        <select name="domain_material_ids[]" id="inputDomainMaterialEdit" multiple
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
                    <label for="inputCustomerNamePayment" class="col-sm-3 col-form-label">Customer</label>
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

    {{-- Detail  --}}
    <x-modal title="Detail Customer" idModal="detailCustomerModal">
        <div class="modal-body">
            <table class="table table-sm">
                <tbody id="tbodyDetailModal">
                </tbody>
            </table>
        </div>
    </x-modal>

    {{-- custom js for this page --}}
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>

    <script>
        const minusIcon = '<i class="mdi mdi-minus text-danger"></i>'
        const checkIcon = '<i class="mdi mdi-check text-success"></i>'
        const tbody = $('#tbodyCustomer')
        const addForm = $('#addForm')
        const updateForm = $('#updateForm')
        const paymentForm = $('#paymentForm')
        const selectDomain = $('.select-domain')
        const selectHosting = $('.select-hosting')
        const selectSsl = $('.select-ssl')

        const currentYear = new Date().getFullYear();
        const nextYear = currentYear + 1;

        // Tfoot table
        let tfootTotalHargaText = $('#tfootTotalHargaText')
        let tfootPotentialProfitThisYearText = $('#tfootPotentialProfitThisYearText')
        let tfootPotentialProfitNextYearText = $('#tfootPotentialProfitNextYearText')
        $('#tfootPotentialProfitThisYear').html(`Potensi Profit ${currentYear}`)
        $('#tfootPotentialProfitNextYear').html(`Potensi Profit ${nextYear}`)

        $(() => {
            // Muat data customer saat halaman pertama kali dimuat
            getAllCustomer();

            // Event delegation untuk form submit
            addForm.submit((event) => {
                event.preventDefault()
                handleFormSubmit(addForm, '/api/customer', 'POST')
            })

            updateForm.submit((event) => {
                event.preventDefault()
                const customerId = $('#inputIdEdit').val();
                handleFormSubmit(updateForm, `/api/customer/${customerId}`, 'POST')
            })

            paymentForm.submit((event) => {
                event.preventDefault()
                handleFormSubmit(paymentForm, `/api/customer/bayar`, 'POST')
            })

            // Event delegation untuk tombol klik di dalam tbodyMaterial
            tbody.on('click', '.btn-hapus', (event) => {
                const id = $(event.target).closest('tr').data('id')
                handleShowConfirmDelete(id)
            });

            tbody.on('click', '.btn-edit', (event) => {
                const idEl = $(event.target).closest('tr').data('id');
                handleEditButtonClick(idEl)
            });

            tbody.on('click', '.btn-bayar', (event) => {
                const idEl = $(event.target).closest('tr').data('id');
                handleBayarButtonClick(idEl);
            });

            tbody.on('click', '.btn-detail', (event) => {
                const idEl = $(event.target).closest('tr').data('id')
                handleDetailButtonCLick(idEl)
            })
        });

        // Fungsi untuk mendapatkan semua data material
        const getAllMaterial = () => {
            $.get('/api/material?unused_by_customers=true', (result, status) => {
                const results = result.data;

                selectDomain.html('<option disabled value="">-- Pilih --</option>')
                selectHosting.html('<option selected disabled value="">-- Pilih --</option>')
                selectSsl.html('<option selected disabled value="">-- Pilih --</option>')

                results.forEach(data => {
                    if (data.material === 'hosting')
                        selectHosting.append(`<option value="${data.id}">${data.item}</option>`)
                    if (data.material == 'domain')
                        selectDomain.append(`<option value="${data.id}">${data.item}</option>`)
                    if (data.material == 'ssl')
                        selectSsl.append(`<option value="${data.id}">${data.item}</option>`)
                });
            }, 'json');
        }

        // Fungsi untuk mendapatkan semua data customer
        const getAllCustomer = () => {
            resetDataTable('.table');
            $.get('/api/customer', (result, status) => {
                const results = result.data;
                let totalHarga = 0,
                    potentialProfitThisYear = 0,
                    potentialProfitNextYear = 0

                tbody.html('')
                results.forEach(data => {
                    const year = new Date(data.due_date).getFullYear();
                    const price = parseFloat(data.price);

                    totalHarga += price;
                    if (currentYear === year) potentialProfitThisYear += price;
                    if (nextYear === year) potentialProfitNextYear += price;

                    tbody.append(displayTbody(data))
                });

                if (results.length === 0) tbody.append(
                    '<tr><td colspan="8" class="text-center">Data tidak ditemukan.</td></tr>')

                if (results.length > 0) {
                    tfootTotalHargaText.html(rupiah(totalHarga));
                    tfootPotentialProfitThisYearText.html(rupiah(potentialProfitThisYear));
                    tfootPotentialProfitNextYearText.html(rupiah(potentialProfitNextYear));

                    loadDataTable('#datatable');
                }

                getAllMaterial();
            }, 'json');
        };

        // Fungsi untuk membangun HTML untuk menampilkan data customer
        const displayTbody = (data) => {
            const {
                id,
                name,
                domain,
                due_date,
                price,
                domainMaterials,
                hostingMaterial,
                sslMaterial,
            } = data;
            const reminderDueDate = diffInDay(due_date)

            return `<tr data-id="${id}">
                        <td>${due_date} <span class="badge badge-${badgeClassReminder(reminderDueDate)}">${reminderDueDate}</span></td>
                        <td>${name}</td>
                        <td>${domain}</td>
                        <td class="text-center">${domainMaterials && domainMaterials.length === 0 ? minusIcon : checkIcon}</td>
                        <td class="text-center">${hostingMaterial === null ? minusIcon : checkIcon}</td>
                        <td class="text-center">${sslMaterial === null ? minusIcon : checkIcon}</td>
                        <td>${rupiah(price)}</td>
                        <td>
                            <button class="btn-detail btn btn-sm btn-success btn-action">Detail</button>
                            <button class="btn-bayar btn btn-sm btn-info btn-action">Bayar</button>
                            <button class="btn-edit btn btn-sm btn-warning btn-action">Edit</button>
                            <button class="btn-hapus btn btn-sm btn-danger btn-action">Hapus</button>
                        </td>
                    </tr>`;
        };

        // HANDLE FUNCTION

        // Fungsi untuk menangani klik tombol edit
        const handleEditButtonClick = (idEl) => {
            $.ajax({
                url: `/api/customer/${idEl}?withMaterial=true`,
                type: "GET",
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (result, status) => {
                    const selectDomainEdit = $('#inputDomainMaterialEdit')
                    const selectSslEdit = $('#inputSslMaterialEdit')

                    const {
                        id,
                        name,
                        domain,
                        due_date,
                        price,
                        domain_material_ids,
                        hosting_material_id,
                        ssl_material_id,
                        sslMaterial,
                        domainMaterials
                    } = result.data

                    // hapus elemen select option old-material
                    $('.old-material').remove()

                    // tambahkan select option edit
                    if (domainMaterials && domainMaterials.length >= 0) {
                        domainMaterials.forEach((data, index) => selectDomainEdit.append(
                            `<option class="old-material" value="${data.id}">${data.item}</option>`
                        ))
                    }

                    if (sslMaterial) selectSslEdit.append(
                        `<option class="old-material" value="${sslMaterial.id}">${sslMaterial.item}</option>`
                    )

                    $('#inputIdEdit').val(id);
                    $('#inputNameEdit').val(name);
                    $('#inputDomainEdit').val(domain);
                    $('#inputDueDateEdit').val(due_date);
                    $('#inputPriceEdit').val(price);
                    $('#inputHostingMaterialEdit').val(hosting_material_id);
                    selectDomainEdit.val(domain_material_ids)
                    selectSslEdit.val(ssl_material_id);

                    $('#editCustomerModal').modal('show')
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                            .errors) :
                        'Terjadi kesalahan saat memuat data.';
                    flashMessage("Error", errorMessage, status);
                }
            })
        }

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

        // Fungsi untuk menangani klik konfirmasi tombol Hapus
        const handleShowConfirmDelete = (idEl) => {
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
                    handleHapusButtonClick(idEl)
                }
            });
        }

        // Fungsi untuk menangani klik tombol Hapus
        const handleHapusButtonClick = (idEl) => {
            $.ajax({
                url: `/api/customer/${idEl}`,
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

        // fungsi untuk detail data
        const handleDetailButtonCLick = (idEl) => {
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
                    domainMaterials.forEach((data, i) => html += displayDetailCustomer(`Domain ${i+1}`, data))
                    html += displayDetailCustomer('Hosting', hostingMaterial)
                    html += displayDetailCustomer('SSL', sslMaterial)

                    $('#tbodyDetailModal').html(html)
                    $('#detailCustomerModal').modal('show')
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON.errors) :
                        'Terjadi kesalahan saat memuat data.'
                    flashMessage('Error', errorMessage, status)
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

        // fungsi untuk form submit
        const handleFormSubmit = (form, url, method) => {
            const dataForm = new FormData(form[0]);

            $.ajax({
                url: url,
                type: method,
                data: dataForm,
                processData: false,
                contentType: false,
                beforeSend: () => setButtonDisabled($('.btn-submit'), true),
                complete: () => setButtonDisabled($('.btn-submit'), false),
                success: (results, status) => {
                    getAllCustomer()
                    toastFlashMessage(results.message, status)
                    form[0].reset()
                    $('.modal').modal('hide')
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                            .errors) :
                        'Terjadi kesalahan saat memuat data.';
                    flashMessage("Error", errorMessage, status);
                }
            });
        }
    </script>
@endpush
