<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? env('APP_NAME') }} </title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather') }}.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min') }}.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons') }}.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min') }}.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons') }}.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons') }}.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base') }}.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min') }}.css">
    <!-- endinject -->

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                            </div>
                            @yield('content')
                        </div>

                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>

    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/myScript.js') }}"></script>

    @stack('scripts')
</body>

</html>
