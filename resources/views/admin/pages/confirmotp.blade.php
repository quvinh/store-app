<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Confirm OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/3v.png') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />

</head>

<body class="loading authentication-bg"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    @include('admin.home.preloader')
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header pt-2 pb-2 text-center bg-primary">
                            <a href="">
                                <span><img src="{{ asset('assets/images/bvy.png') }}" alt="LOGO" height="60"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">
                            @if(session()->has('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                {{ session()->get('error') }}
                            </div>
                            @endif
                            <div class="text-center m-auto">
                                <img src="{{ asset('assets/images/mail_sent.svg') }}" alt="mail sent image" height="64" />
                                    <h4 class="text-dark-50 text-center mt-4 fw-bold">@lang('confirmotp.pleasecheck')</h4>
                                    <p class="text-muted mb-2">
                                        @lang('confirmotp.aemail...') <b>{{ $email }}</b>.
                                        @lang('confirmotp.pleasecheckemail...') 
                                    </p>
                            </div>

                            <form action="{{ route('confirm-otp') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    {{-- <a href="pages-recoverpw.html" class="text-muted float-end"><small>Forgot your
                                            password?</small></a> --}}
                                    {{-- <label for="otp" class="form-label">OTP Code</label> --}}
                                    <div class="input-group input-group-merge">
                                        <input type="text" id="otp" class="form-control" name="otp"
                                            placeholder="@lang('confirmotp.enterotp')" value="" autofocus>
                                    </div>
                                </div>
                                <input type="text" name="username" value="{{ $username }}" required hidden>
                                <input type="password" name="password" value="{{ $password }}" required hidden>
                                <input type="number" name="rememberme" value="{{ $rememberme ? 1 : 0 }}" required hidden>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> @lang('confirmotp.confirm') </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->

                        <div class="row">
                            <div class="col-12 text-center">
                                <p class="text-muted"><a href=""
                                        class="text-muted ms-1"><b>@lang('confirmotp.notreceive')?</b></a></p>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt">
        2022 © Dailythue - thuemienbac.vn
    </footer>

    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>

</html>
