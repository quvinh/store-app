@extends('admin.home.master')

@section('title')
    Add Supplier
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Thêm mới nhà cung cấp</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Thêm mới nhà cung cấp</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate action="{{ route('supplier.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <div class="col s12 m6 l6">
                                    <div class="row mb-2">
                                        <div class="col s6">
                                            <label class="form-label" for="supplier_code">Mã nhà cung cấp:</label>
                                            <input type="text" class="form-control" id="supplier_code"
                                                placeholder="Mã nhà cung cấp" required="" name="supplier_code" value="{{$supplier->supplier_code}}">
                                            <div class="invalid-feedback">
                                                Vui lòng nhập mã nhà cung cấp.
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <label class="form-label" for="supplier_name">Tên nhà cung cấp:</label>
                                            <input type="text" class="form-control" id="supplier_name"
                                                placeholder="Tên nhà cung cấp" required="" name="supplier_name" value="{{$supplier->supplier_name}}">
                                            <div class="invalid-feedback">
                                                Vui lòng nhập tên nhà cung cấp.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col s6">
                                            <label class="form-label" for="supplier_note">Ghi chú:</label>
                                            <input type="text" class="form-control" id="supplier_note"
                                                placeholder="Ghi chú" name="supplier_note" value="{{$supplier->supplier_note}}">
                                        </div>

                                        <div class="col s6">
                                            <span class="form-label" style="font-weight:600">Kích
                                                hoạt ngay:</span><br><br>
                                            <input type="checkbox" id="switch3" {{$supplier->supplier_status ? 'checked' : ''}} data-switch="success"
                                                name="supplier_status" />
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
                        </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container -->
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->
@endsection
