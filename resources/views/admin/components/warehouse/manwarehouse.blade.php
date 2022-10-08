@extends('admin.home.master')

@section('title')
    Kho vật tư | Admin
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
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample" class="btn btn-danger mb-2 collapsed">
                                    Tạo mới kho vật tư
                                </a>
                            </div>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="tab-pane show active" id="custom-styles-preview">
                                @include('admin.components.warehouse.addwarehouse')
                            </div>
                        </div>
                        <div>
                            <hr>
                        </div>
                        <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                        {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã kho</th>
                                    <th>Ảnh</th>
                                    <th>Tên</th>
                                    <th>Vị trí</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $key => $warehouse)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $warehouse->warehouse_code }}</td>
                                        <td>
                                            @if ($warehouse->warehouse_image == '' || $warehouse->warehouse_image == null)
                                                <img src="{{ asset('images/img/no-image.jpg') }}" alt="No-image"
                                                    height="32">
                                            @else
                                                <img src="{{ asset($warehouse->warehouse_image) }}" alt="image"
                                                    height="32">
                                            @endif
                                        </td>
                                        <td>{{ $warehouse->warehouse_name }}</td>
                                        <td>{{ $warehouse->warehouse_street }}</td>
                                        <td>
                                            @if ($warehouse->warehouse_status == '1')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Deactive</span>
                                            @endif
                                        </td>
                                        <td class="table-action">
                                            <a href="{{ route('shelf.shelf-list',$warehouse->id) }}"
                                                class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                            <a href="{{ route('warehouse.edit', $warehouse->id) }}" class="action-icon">
                                                <i class="mdi mdi-square-edit-outline"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
