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
        <form action="#" method="POST" id="paymentForm" enctype="multipart/form-data">
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
                    <label for="inputPricePayment" class="col-sm-3 col-form-label">Harga</label>
                    <div class="col-sm-9">
                        <input type="number" id="inputPricePayment" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPaymentAmount" class="col-sm-3 col-form-label">Nilai Bayar
                        <span class="text-danger">*</span></label>
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


    {{-- custom js for this page --}}
    <script src="{{ asset('assets/js/pages/material.js') }}"></script>
@endpush
