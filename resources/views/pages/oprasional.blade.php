@extends('layouts.app')

@push('styles')
    <style>
        .w-full {
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between align-items-start gap-1">
                        <h4 class="card-title col-12 col-lg-2 col-sm-5 mb-2">Oprasional Tabel</h4>

                        <div class="col-lg-4 col-12 d-flex justify-content-end">
                            <button class="btn btn-sm btn-primary text-white mb-0 me-0" type="button" data-bs-toggle="modal"
                                data-bs-target="#addOprasionalModal">
                                <i class="mdi mdi-plus-box-outline"></i> Oprasional
                            </button>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Kebutuhan</th>
                                    <th>Detail</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    @for ($i = 0; $i < 5; $i++)
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
    {{-- Tambah Modal --}}
    <x-modal title="Tambah Data" idModal="addOprasionalModal">
        <form action="#" method="POST" id="addForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row">
                    <label for="inputDate" class="col-sm-3 col-form-label">Tanggal
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="date" id="inputDate" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputNeeds" class="col-sm-3 col-form-label">Kebutuhan
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="needs" id="inputNeeds" class="form-select text-dark" required>
                            <option value="konsumsi">Konsumsi</option>
                            <option value="gaji">Gaji</option>
                            <option value="perlengkapan">Perlengkapan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDetail" class="col-sm-3 col-form-label">Detail
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="detail" id="inputDetail" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPrice" class="col-sm-3 col-form-label">Harga
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number"name="price" id="inputPrice" step="0.01" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputNote" class="col-sm-3 col-form-label">Note</label>
                    <div class="col-sm-9">
                        <textarea name="note" id="inputNote" rows="3" class="w-full"></textarea>
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
    <x-modal title="Edit Data" idModal="editOprasionalModal">
        <form action="#" method="POST" id="updateForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" id="inputIdEdit">
            <div class="modal-body">
                <div class="form-group row">
                    <label for="inputDateEdit" class="col-sm-3 col-form-label">Tanggal
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="date" name="date" id="inputDateEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputNeedsEdit" class="col-sm-3 col-form-label">Kebutuhan
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="needs" id="inputNeedsEdit" class="form-select text-dark" required>
                            <option value="konsumsi">Konsumsi</option>
                            <option value="gaji">Gaji</option>
                            <option value="perlengkapan">Perlengkapan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputDetailEdit" class="col-sm-3 col-form-label">Detail
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" name="detail" id="inputDetailEdit" class="form-control" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPriceEdit" class="col-sm-3 col-form-label">Harga
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number"name="price" id="inputPriceEdit" step="0.01" class="form-control"
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputNoteEdit" class="col-sm-3 col-form-label">Note</label>
                    <div class="col-sm-9">
                        <textarea name="note" id="inputNoteEdit" rows="3" class="w-full"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
            </div>
        </form>
    </x-modal>

    <script src="{{ asset('assets/js/pages/oprasional.js') }}"></script>
@endpush
