@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between align-items-start gap-1">
                        <h4 class="card-title col-12 col-lg-2 col-sm-5 mb-2">Material Tabel</h4>

                        <div class="col-lg-5 col-12 col-sm-6 d-flex justify-content-end">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" data-filter="all"
                                    class="filterButton btn btn-sm btn-outline-primary">All</button>
                                <button type="button" data-filter="hosting"
                                    class="filterButton btn btn-sm btn-outline-primary">Hosting</button>
                                <button type="button" data-filter="domain"
                                    class="filterButton btn btn-sm btn-outline-primary">Domain</button>
                                <button type="button" data-filter="ssl"
                                    class="filterButton btn btn-sm btn-outline-primary">Ssl</button>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12 d-flex justify-content-end">
                            <button class="btn btn-sm btn-primary text-white mb-0 me-0" type="button"data-bs-toggle="modal"
                                data-bs-target="#addMaterialModal">
                                <i class="mdi mdi-plus-box-outline"></i> Material
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Batas Waktu</th>
                                    <th>Item</th>
                                    <th>Material</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyMaterial">
                                <tr>
                                    @for ($i = 0; $i < 4; $i++)
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
    <x-modal title="Tambah Data" idModal="addMaterialModal">
        <form action="#" method="POST" id="addForm">
            @csrf
            <div class="modal-body">
                <div class="form-group row">
                    <label for="inputItem" class="col-sm-3 col-form-label">Item <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="item" id="inputItem" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPrice" class="col-sm-3 col-form-label">Harga <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="price" id="inputPrice" class="form-control" step="0.01" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputBillingCycle" class="col-sm-3 col-form-label">Siklus Tagihan <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="billing_cycle" id="inputBillingCycle" class="form-control"
                            placeholder="per 1 tahun..." required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDueDate" class="col-sm-3 col-form-label">Batas Waktu <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="due_date" id="inputDueDate" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="inputMaterial" class="col-sm-3 col-form-label">Material <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="material" id="inputMaterial" class="form-select text-dark"
                            onchange="ifTrueDisabled(this, '#inputMultiple', 'domain')" required>
                            <option selected value="">-- Pilih --</option>
                            <option value="hosting">Hosting</option>
                            <option value="domain">Domain</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-check-label">
                        <input type="checkbox" name="is_multiple" id="inputMultiple" class="form-check-input"
                            value="yes" disabled> Tidak sekali pilih<i class="input-helper"></i>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
            </div>
        </form>
    </x-modal>

    {{-- Edit Modal --}}
    <x-modal title="Edit Data" idModal="editMaterialModal">
        <form action="#" method="POST" id="updateForm">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="hidden" id="inputIdEdit">
                <div class="form-group row">
                    <label for="inputItemEdit" class="col-sm-3 col-form-label">Item <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="item" id="inputItemEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPaymentAmountEdit" class="col-sm-3 col-form-label">Nilai Bayar
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="price" id="inputPaymentAmountEdit" class="form-control"
                            step="0.01" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputBillingCycleEdit" class="col-sm-3 col-form-label">Siklus Tagihan <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="billing_cycle" id="inputBillingCycleEdit" class="form-control"
                            placeholder="per 1 tahun..." required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDueDatePaymentEdit" class="col-sm-3 col-form-label">Batas Waktu
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="due_date" id="inputDueDatePaymentEdit" class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label for="inputMaterialEdit" class="col-sm-3 col-form-label">Material <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="material" id="inputMaterialEdit" class="form-select text-dark"
                            onchange="ifTrueDisabled(this, '#inputMultipleEdit', 'domain')" required>
                            <option selected value="">-- Pilih --</option>
                            <option value="hosting">Hosting</option>
                            <option value="domain">Domain</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-check-label">
                        <input type="checkbox" name="is_multiple" id="inputMultipleEdit" class="form-check-input"
                            value="yes" disabled> Tidak sekali pilih<i class="input-helper"></i>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
            </div>
        </form>
    </x-modal>

    {{-- Bayar Modal --}}
    <x-modal title="Bayar Data" idModal="bayarMaterialModal">
        <form action="#" method="POST" id="paymentForm">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="material_id" id="inputIdPayment">
                <div class="form-group row">
                    <label for="inputMaterialNamePayment" class="col-sm-3 col-form-label">Nama Material</label>
                    <div class="col-sm-9">
                        <input type="text" id="inputMaterialNamePayment" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDatePayment" class="col-sm-3 col-form-label">Tanggal
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="date" id="inputDatePayment" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDueDatePayment" class="col-sm-3 col-form-label">Batas Waktu
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="due_date" id="inputDueDatePayment" class="form-control" required />
                        <p class="text-muted my-0">Ubah untuk data bayar berikutnya.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPricePayment" class="col-sm-3 col-form-label">Harga
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="price" id="inputPricePayment" class="form-control" step="0.01"
                            required />
                        <p class="text-muted my-0">Ubah untuk data bayar berikutnya.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPaymentAmount" class="col-sm-3 col-form-label">Nilai Bayar
                        <span class="text-danger">*</span></label>
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

    <script>
        const tbody = $('#tbodyMaterial');
        const addForm = $('#addForm');
        const updateForm = $('#updateForm');
        const paymentForm = $('#paymentForm');
        const currentYear = new Date().getFullYear();
        const nextYear = currentYear + 1;

        // tfoot table
        let tfootTotalHargaText = $('#tfootTotalHargaText')
        let tfootPotentialProfitThisYearText = $('#tfootPotentialProfitThisYearText')
        let tfootPotentialProfitNextYearText = $('#tfootPotentialProfitNextYearText')
        $('#tfootPotentialProfitThisYear').html(`Potensi Profit ${currentYear}`)
        $('#tfootPotentialProfitNextYear').html(`Potensi Profit ${nextYear}`)

        // filter material
        const filterMaterial = localStorage.getItem('filter-material') ?? 'all'
        $(`.filterButton[data-filter=${filterMaterial}]`).addClass('btn-primary').removeClass('btn-outline-primary')

        $(() => {
            // Muat data material saat halaman pertama kali dimuat
            getAllMaterial(filterMaterial);

            $('.filterButton').on('click', (event) => {
                const clickedVal = event.target.getAttribute('data-filter')
                getAllMaterial(clickedVal);

                localStorage.setItem('filter-material', clickedVal)
                $('.filterButton').addClass('btn-outline-primary').removeClass('btn-primary')
                $(event.target).addClass('btn-primary').removeClass(
                    'btn-outline-primary')
            })

            // Event delegation untuk form submit
            addForm.submit((event) => {
                event.preventDefault()
                handleFormSubmit(addForm, '/api/material', 'POST')
            })

            updateForm.submit((event) => {
                event.preventDefault()
                const materialId = $('#inputIdEdit').val();
                handleFormSubmit(updateForm, `/api/material/${materialId}`, 'POST')
            })

            paymentForm.submit((event) => {
                event.preventDefault()
                handleFormSubmit(paymentForm, `/api/material/bayar`, 'POST')
            })

            // Event delegation untuk tombol klik di dalam tbodyMaterial
            tbody.on('click', '.btn-hapus', (event) => {
                const idEl = $(event.target).closest('tr').data('id');
                handleShowConfirmDelete(idEl)
            });

            tbody.on('click', '.btn-edit', (event) => {
                const idEl = $(event.target).closest('tr').data('id');
                handleEditButtonClick(idEl)
            });

            tbody.on('click', '.btn-bayar', (event) => {
                const idEl = $(event.target).closest('tr').data('id');
                handleBayarButtonClick(idEl);
            });
        });

        // Fungsi untuk mendapatkan semua data material
        const getAllMaterial = (filter) => {
            const addQueryParam = filter ? `?material=${filter}` : ''

            resetDataTable('.table')
            $.get(`/api/material${addQueryParam}`, (result, status) => {
                const results = result.data
                let totalHarga = 0,
                    potentialProfitThisYear = 0,
                    potentialProfitNextYear = 0

                tbody.html('');
                results.forEach(data => {
                    let year = new Date(data.due_date).getFullYear()
                    let price = parseFloat(data.price)

                    totalHarga += price
                    if (currentYear === year) potentialProfitThisYear += price
                    if (nextYear === year) potentialProfitNextYear += price

                    tbody.append(displayTbody(data))
                });

                if (results.length === 0) tbody.append(
                    '<tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>')

                if (results.length > 0) {
                    tfootTotalHargaText.html(rupiah(totalHarga))
                    tfootPotentialProfitThisYearText.html(rupiah(potentialProfitThisYear))
                    tfootPotentialProfitNextYearText.html(rupiah(potentialProfitNextYear))

                    loadDataTable('.table')
                }
            }, 'json');
        };

        // Fungsi untuk membangun HTML untuk menampilkan data material
        const displayTbody = (data) => {
            const {
                id,
                item,
                price,
                billing_cycle,
                due_date,
                material
            } = data;
            const reminderDueDate = diffInDay(due_date)

            return `<tr data-id="${id}">
                <td>${due_date} <span class="badge badge-${badgeClassReminder(reminderDueDate)}">${reminderDueDate}</span></td>
                <td>${item}</td>
                <td>${material}</td>
                <td>${rupiah(price)} <small class="d-block text-muted">${billing_cycle}</small></td>
                <td>
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
                url: `/api/material/${idEl}`,
                type: "GET",
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (result, status) => {
                    const {
                        id,
                        item,
                        price,
                        billing_cycle,
                        due_date,
                        material,
                        is_multiple
                    } = result.data

                    // Isi nilai form dengan data material yang akan diupdate
                    $('#inputIdEdit').val(id);
                    $('#inputItemEdit').val(item);
                    $('#inputPaymentAmountEdit').val(price);
                    $('#inputDueDatePaymentEdit').val(due_date);
                    $('#inputBillingCycleEdit').val(billing_cycle);
                    $('#inputMaterialEdit').val(material);
                    $('#inputMultipleEdit').prop('checked', is_multiple)
                        .prop('disabled', material !== 'domain' ?? false);

                    // Tampilkan modal edit
                    $('#editMaterialModal').modal('show');
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
                url: `/api/material/${idEl}`,
                type: "GET",
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (result, status) => {
                    const {
                        id,
                        item,
                        price,
                        due_date,
                    } = result.data

                    // Isi nilai form dengan data material yang akan diupdate
                    $('#inputIdPayment').val(id);
                    $('#inputMaterialNamePayment').val(item);
                    $('#inputDueDatePayment').val(due_date);
                    $('#inputPricePayment').val(price);

                    $('#inputDatePayment').val(getCurrentDate());
                    $('#inputPaymentAmount').val('');

                    // Tampilkan modal edit
                    $('#bayarMaterialModal').modal('show');
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON
                            .errors) :
                        'Terjadi kesalahan saat memuat data.';
                    flashMessage("Error", errorMessage, status);
                }
            })
        };

        // Fungsi untun mengangi klik konfirmasi tombol hapus
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
                url: `/api/material/${idEl}`,
                type: "DELETE",
                cache: false,
                beforeSend: () => setButtonDisabled($('.btn-action'), true),
                complete: () => setButtonDisabled($('.btn-action'), false),
                success: (response, status) => {
                    getAllMaterial()
                    toastFlashMessage(response.message, status);
                },
                error: (xhr, status, error) => {
                    const errorMessage = xhr.responseJSON ? displayError(xhr.responseJSON.errors) :
                        'Terjadi kesalahan saat memuat data.';
                    flashMessage("Error", errorMessage, status);
                }
            });
        };

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
                    getAllMaterial()
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
