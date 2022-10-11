@extends('admin.home.master')

@section('title')
    Warehouse | Admin
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
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
                            <li class="breadcrumb-item active">Kho vật tư</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Kho vật tư</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="custom-styles-preview">
                                <form class="needs-validation" novalidate
                                    action="{{ route('warehouse.update', $warehouse->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <div class="col s12 m6 l6">
                                            <div class="row mb-2">
                                                <div class="col s6">
                                                    <label class="form-label" for="warehouse_code">Mã kho:</label>
                                                    <input type="text" class="form-control" id="warehouse_code"
                                                        placeholder="Mã kho" required="" name="warehouse_code"
                                                        value="{{ $warehouse->warehouse_code }}">
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập mã kho.
                                                    </div>
                                                </div>
                                                <div class="col s6">
                                                    <label class="form-label" for="warehouse_contact">Liên hệ:</label>
                                                    <input type="text" class="form-control" id="warehouse_contact"
                                                        placeholder="Liên hệ" required="" data-toggle="input-mask"
                                                        data-mask-format="(000) 000-0000" name="warehouse_contact"
                                                        value="{{ $warehouse->warehouse_contact }}">
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập số điện thoại.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col s6">
                                                    <label class="form-label" for="warehouse_name">Tên kho:</label>
                                                    <input type="text" class="form-control" id="warehouse_name"
                                                        placeholder="Tên kho" required="" name="warehouse_name"
                                                        value="{{ $warehouse->warehouse_name }}">
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập tên kho.
                                                    </div>
                                                </div>
                                                <div class="col s6">
                                                    <label class="form-label" for="warehouse_note">Ghi chú:</label>
                                                    <input type="text" class="form-control" id="warehouse_note"
                                                        placeholder="Ghi chú" name="warehouse_note"
                                                        value="{{ $warehouse->warehouse_note }}">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col s6">
                                                    <label class="form-label" for="warehouse_street">Địa chỉ:</label>
                                                    <input type="text" class="form-control" id="warehouse_street"
                                                        placeholder="Đại chỉ" required="" name="warehouse_street"
                                                        value="{{ $warehouse->warehouse_street }}">
                                                    <div class="invalid-feedback">
                                                        Vui lòng nhập địa chỉ.
                                                    </div>
                                                </div>
                                                <div class="col s6">
                                                    <div class="row">
                                                        <div class="col s6">
                                                            {{-- <label class="form-label" for="warehouse_code">Mã kho:</label>
                                                        <input type="text" class="form-control"
                                                            id="warehouse_code" placeholder="First name"
                                                            required="">
                                                        <div class="invalid-feedback">
                                                            Vui lòng nhập mã kho.
                                                        </div> --}}
                                                        </div>
                                                        <div class="col s6">
                                                            {{-- <label class="form-label" for="warehouse_code">Mã kho:</label>
                                                        <input type="text" class="form-control"
                                                            id="warehouse_code" placeholder="First name"
                                                            required="">
                                                        <div class="invalid-feedback">
                                                            Vui lòng nhập mã kho.
                                                        </div> --}}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row mb-2"><span class="form-label" style="font-weight:600">Kích
                                                    hoạt ngay:</span>
                                                <div class=" col s6">
                                                    <input type="checkbox" id="switch3" {{ ($warehouse->warehouse_status===1) ? 'checked': '' }} data-switch="success"
                                                        name="warehouse_status"/>
                                                        <label for="switch3" data-on-label="Yes"
                                                        data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 m6 l6">
                                            <label class="form-label" for="warehouse_image">Chọn ảnh kho max:2MB</label>
                                            <input type="file" name="warehouse_image" class="form-control"
                                                data-max-file-size="2M" accept=".jpg, .jepg, .png"
                                                value="{{ $warehouse->warehouse_image }}">
                                        </div>
                                    </div>
                                    <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
                                </form>
                            </div>
                        </div>
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
    <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->
@endsection
