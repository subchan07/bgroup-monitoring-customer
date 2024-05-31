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
                                    <th>Layanan</th>
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
                <div class="form-group row justify-content-end">
                    <label for="inputName" class="col-sm-3 col-form-label">Customer <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="name" id="inputName" class="form-select text-dark select-customer js-example-basic-single"
                            data-target_id="#inputOtherName" required>
                            <option value="">-- pilih --</option>
                        </select>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" name="other_name" id="inputOtherName" class="form-control d-none" placeholder="customer..." />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputService" class="col-sm-3 col-form-label">Layanan <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="service" id="inputService" class="form-select text-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="website">Website</option>
                            <option value="laporanusaha">Laporan Usaha</option>
                        </select>
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
                <div class="form-group row justify-content-end">
                    <label for="inputNameEdit" class="col-sm-3 col-form-label">Customer <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="name" id="inputNameEdit" class="form-select text-dark select-customer js-example-basic-single"
                            data-target_id="#inputOtherNameEdit" required>
                            <option value="">-- pilih --</option>
                        </select>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" name="other_name" id="inputOtherNameEdit" class="form-control d-none" placeholder="customer..." />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputServiceEdit" class="col-sm-3 col-form-label">Layanan <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="service" id="inputServiceEdit" class="form-select text-dark" required>
                            <option value="">-- Pilih --</option>
                            <option value="website">Website</option>
                            <option value="laporanusaha">Laporan Usaha</option>
                        </select>
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
        <form action="#" method="POST" id="paymentForm" enctype="multipart/form-data">
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
                    <label for="inputPricePayment" class="col-sm-3 col-form-label">Harga</label>
                    <div class="col-sm-9">
                        <input type="number" id="inputPricePayment" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPaymentAmount" class="col-sm-3 col-form-label">Nilai Bayar <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="payment_amount" id="inputPaymentAmount" class="form-control"
                            step="0.01" required />
                        <p class="text-muted my-0">Ubah untuk data bayar berikutnya.</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputFilePayment" class="col-sm-3 col-form-label">Upload File</label>
                    <div class="col-sm-9">
                        <input type="file" id="inputFilePayment" name="file" class="form-control" />
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
            <div class="table-responsive">
                <table class="table table-sm">
                    <tbody id="tbodyDetailModal">
                    </tbody>
                </table>
            </div>
        </div>
    </x-modal>


    {{-- custom js for this page --}}
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/js/pages/customer.js') }}"></script>
@endpush
