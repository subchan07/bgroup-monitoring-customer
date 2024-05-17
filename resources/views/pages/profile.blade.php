@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Profile</h4>
                    <form class="forms-sample" id="updateProfileUser">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" id="inputName" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                                <small class="text-muted">isi ini jika ingin merubah password.</small>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-2 btn-submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        const formUpdateProfile = $('#updateProfileUser')

        $(() => {
            userCurrent()

            formUpdateProfile.on('submit', function(event) {
                event.preventDefault();
                const dataForm = new FormData(formUpdateProfile[0])

                $.ajax({
                    url: '/api/user/profile',
                    type: 'POST',
                    data: dataForm,
                    processData: false,
                    contentType: false,
                    beforeSend: () => setButtonDisabled($('.btn-submit'), true),
                    complete: () => setButtonDisabled($('.btn-submit'), false),
                    success: (results, status) => {
                        toastFlashMessage(results.message, status)
                        $('#inputPassword').val('')
                    },
                })
            })
        })

        const userCurrent = () => {
            $.get('/api/user/current', function(result, status) {
                const {
                    name
                } = result.data
                $('#inputName').val(name)
            })
        }
    </script>
@endpush
