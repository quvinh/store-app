@extends('admin.home.master')

@section('title')
    Nhà cung cấp
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
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route) }}
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @can('sup.add')
                            <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('supplier.add') }}" class="btn btn-danger mb-2">
                                    Tạo mới nhà cung cấp
                                </a>
                            </div>
                        </div>
                        <div>
                            <hr>
                        </div>
                        @endcan

                        <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                            {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã nhà cung cấp</th>
                                    <th>Tên</th>
                                    <th>Ghi chú</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $key => $supplier)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $supplier->supplier_code }}</td>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>{{ $supplier->supplier_note }}</td>
                                        <td>
                                            @if ($supplier->supplier_status == '1')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Deactive</span>
                                            @endif
                                        </td>
                                        <td class="table-action">
                                            @can('sup.edit')
                                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                            @can('sup.delete')
                                                <a href="{{ route('supplier.delete', $supplier->id) }}" class="action-icon">
                                                    <i class="mdi mdi-delete"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        @can('sup.delete')
            @if (count($supplierTrash) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-title text-center" style="padding-top: 10px">
                                <h4>Danh sách nhà cung cấp đã xóa</h4>
                                <div align="center">
                                    <hr width="95%">
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                                    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã nhà cung cấp</th>
                                            <th>Tên</th>
                                            <th>Ghi chú</th>
                                            <th style="width: 10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($supplierTrash as $key => $supplier)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $supplier->supplier_code }}</td>
                                                <td>{{ $supplier->supplier_name }}</td>
                                                <td>{{ $supplier->supplier_note }}</td>
                                                <td class="table-action">
                                                    <a href="{{ route('supplier.restore', $supplier->id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-delete-restore"></i></a>
                                                    <a href="{{ route('supplier.destroy', $supplier->id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-delete-forever"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            @endif
        @endcan

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
