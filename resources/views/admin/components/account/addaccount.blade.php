@extends('admin.home.master')

@section('title')
    Add account
@endsection

@section('css')
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route) }}
        <!-- end page title -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session()->get('success') }}
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="{{ route('account.store') }}" method="post"
                        enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-sm-8">
                                    <div class="text-sm-start">
                                        <a href="{{ route('account.index') }}" class="btn btn-primary mb-2 me-1"><i
                                                class="mdi mdi-backburger"></i> Back to list</a>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-sm-end">
                                        <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i>
                                            Save</button>
                                    </div>
                                </div>
                                <!-- end col-->
                            </div>
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Họ và tên</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter full name" value="" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            Mời nhập họ và tên!
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Enter Email" value="" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            Mời nhập địa chỉ email!
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Tên đăng nhập</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Enter username" value="" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            Mời nhập tên đăng nhập!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="birthday" class="form-label">Birthday</label>
                                            <input type="date" class="form-control" id="birthday" name="birthday"
                                                placeholder="Enter birthday" value="">
                                        </div>
                                    </div>
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Enter new password" value="" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            Mời nhập mật khẩu!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">New Avatar</label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                value="">
                                        </div>
                                    </div> <!-- end col -->
                                    <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-1">
                                        <label for="">Gender</label>
                                        <div class="form-check form-checkbox-success mb-3">
                                            <br>
                                            <input type="checkbox" class="form-check-input" id="male"
                                                name="male" value="1">
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-checkbox-success mb-3">
                                            <br><br>
                                            <input type="checkbox" class="form-check-input" id="female"
                                                name="female" value="0">
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div> <!-- end row -->



                                <div class="text-end">

                                </div>
                            </div> <!-- end tab-content-->
                        </form>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('input[type="checkbox"]').click(function() {
                $('input[type="checkbox"]').not(this).prop("checked", false);
            });
        });
    </script>
@endsection
