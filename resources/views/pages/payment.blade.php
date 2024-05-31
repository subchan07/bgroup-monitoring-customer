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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyPayment">
                                <tr>
                                    @for ($i = 0; $i < 7; $i++)
                                        <td class="placeholder-glow">
                                            <span class="placeholder col-12"></span>
                                        </td>
                                    @endfor
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total Harga</td>
                                    <td id="tfootTotalHarga">-</td>
                                </tr>
                                <tr>
                                    <td>Total Bayar</td>
                                    <td id="tfootTotalBayar">-</td>
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
    {{-- Edit Modal --}}
    <x-modal title="Edit Data" idModal="editPaymentModal">
        <form action="#" method="POST" id="updateForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="hidden" id="inputIdEdit">
                <div class="form-group row">
                    <label for="inputDateEdit" class="col-sm-3 col-form-label">Tanggal
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="date" id="inputDateEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDueDateEdit" class="col-sm-3 col-form-label">Batas Waktu
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="due_date" id="inputDueDateEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPriceEdit" class="col-sm-3 col-form-label">Harga</label>
                    <div class="col-sm-9">
                        <input type="number" id="inputPriceEdit" step="0.01" class="form-control" readonly />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPaymentAmountEdit" class="col-sm-3 col-form-label">Nilai Bayar
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" name="payment_amount" id="inputPaymentAmountEdit" step="0.01"
                            class="form-control" required />
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

    {{-- Bukti Bayar --}}
    <x-modal title="Bukti Bayar" idModal="showImgModal">
        <div class="modal-body">
        </div>
    </x-modal>


    {{-- custom js for this page --}}
    <script src="{{ asset('assets/js/pages/payment.js') }}"></script>
@endpush
