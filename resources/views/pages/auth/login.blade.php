@extends('layouts.guest')

@section('content')
    <h4>Hello! let's get started</h4>
    <h6 class="fw-light">Sign in to continue.</h6>
    <form class="pt-3" id="loginForm">
        @csrf
        {{-- <div class="form-group">
            <input type="email" name="email" class="form-control form-control-lg" id="emailLogin" placeholder="Email...">
        </div> --}}
        <div class="form-group mb-2">
            <input type="password" name="password" class="form-control form-control-lg" id="passwordLogin"
                placeholder="Pin...">
        </div>
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn btn-submit"
                id="submitButton">
                SIGN IN
            </button>
        </div>
    </form>
@endsection


@push('scripts')
    <script>
        const loginForm = $('#loginForm')
        $(() => {
            loginForm.on('submit', (event) => {
                event.preventDefault();
                const formData = new FormData(loginForm[0]);

                $.ajax({
                    url: '/login',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => setButtonDisabled($('.btn-submit'), true),
                    complete: () => setButtonDisabled($('.btn-submit'), false),
                    success: (results, status) => {
                        toastFlashMessage(results.message, status);
                        localStorage.setItem('token-name', results.token);
                        loginForm[0].reset()
                        location.href = 'dashboard'
                    }
                });
            });
        })
    </script>
@endpush
