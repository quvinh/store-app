@extends('admin.home.master')

@section('title')
    Quản lý vật tư
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @can('ite.add')
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    <a href="{{ route('item.create') }}" class="btn btn-danger mb-2">
                                        Tạo mới vật tư
                                    </a>
                                </div>
                            </div>
                            <div>
                                <hr>
                            </div>
                        @endcan

                        <table id="basic-datatable" class="table dt-responsive nowrap text-center">
                            {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Đơn vị tính</th>
                                    <th>Phân loại</th>
                                    <th>Thể tích</th>
                                    <th>Ngày tạo</th>
                                    <th>Ghi chú</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><span class="text-info">{{ $item->item_name }}</span></i>
                                        </td>
                                        <td>{{ $item->unit }}</td>
                                        <td>{{ $item->category }}</td>
                                        <th>{{ $item->item_capacity }}</th>
                                        <th>{{ $item->created_at }}</th>
                                        <td>{{ $item->item_note }}</td>
                                        <td class="table-action">
                                            @can('ite.edit')
                                                <a href="{{ route('item.edit', $item->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i></a>
                                            @endcan
                                            @can('ite.delete')
                                                <a href="{{ route('item.delete', $item->id) }}" class="action-icon">
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
        @if (count($dataTrash) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-title text-center" style="padding-top: 10px">
                            <h4>Danh sách vật tư đã xóa</h4>
                            <div align="center">
                                <hr width="95%">
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                                {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Đơn vị tính</th>
                                        <th>Phân loại</th>
                                        <th>Ghi chú</th>
                                        <th style="width: 10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTrash as $key => $item)
                                        <tr>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <th>{{ $item->category }}</th>
                                            <td>{{ $item->item_note }}</td>
                                            <td class="table-action">
                                                <a href="{{ route('item.restore', $item->id) }}" class="action-icon">
                                                    <i class="mdi mdi-delete-restore"></i></a>
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
