@extends('layouts.app')

@push('styles')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Kelola File Tabel</h4>

                        <div>
                            <a href="#" class="fs-5" id="btn-refresh"><i class="mdi mdi-refresh"></i></a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Terakhir Diedit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr>
                                    @for ($i = 0; $i < 4; $i++)
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
    <script src="{{ asset('assets/js/pages/file-manager.js') }}"></script>
@endpush
