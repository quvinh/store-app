@extends('admin.home.master')

@section('title')
    Ex_Import
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
        <!-- start page title -->
        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#import" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                    <span class="d-none d-md-block">Quản lý phiếu nhập</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#export" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                    <span class="d-none d-md-block">Quản lý phiếu xuất</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show active" id="import">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <a href="{{ route('import.index') }}" class="btn btn-danger mb-2">
                                            Thêm mới
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <table id="import-datatable"
                                    class="table table-centered table-striped dt-responsive nowrap w-100">
                                    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                    <thead>
                                        <tr>
                                            <th>Mã phiếu nhập</th>
                                            <th>Người tạo</th>
                                            <th>Vật tư/ Phụ tùng</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian tạo</th>
                                            <th style="width: 10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($im_items as $key => $item)
                                            <tr>
                                                <td>{{ $item->exim_code }}</td>
                                                <td>{{ $item->created_by }}</td>
                                                <th>
                                                    @foreach ($item->item as $vt)
                                                        {{ $vt->item }} <br>
                                                    @endforeach
                                                </th>
                                                <th>
                                                    <span style="font-size: 15px"
                                                        class="badge badge-{{ $item->exim_status == '0' ? 'info-lighten' : 'success-lighten' }}">
                                                        {{ $item->exim_status == '0' ? 'Chờ duyệt' : 'Đã duyệt' }}</span>
                                                </th>
                                                <td>{{ $item->created_at }}</td>
                                                <td class="table-action">
                                                    <a href="{{ route('import.edit', $item->id) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Sửa phiếu"></i></a>
                                                    <a href="{{ route('import.confirm', $item->id) }}" class="action-icon">
                                                        <i class="mdi mdi-clipboard-edit-outline" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Duyệt phiếu"></i></a>
                                                    <a href="{{ route('ex_import.delete', $item->id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-delete" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Xóa phiếu"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div>
            <div class="tab-pane" id="export">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <a href="{{ route('ex_import.export') }}" class="btn btn-danger mb-2">
                                            Thêm mới
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                <table id="export-datatable"
                                    class="table table-centered table-striped dt-responsive nowrap w-100">
                                    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                    <thead>
                                        <tr>
                                            <th>Mã phiếu xuất</th>
                                            <th>Người tạo</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian tạo</th>
                                            <th style="width: 10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ex_items as $key => $item)
                                            <tr>
                                                <td>{{ $item->exim_code }}</td>
                                                <<<<<<< HEAD <td>{{ $item->created_by }}</td>
                                                    <th>
                                                        @foreach ($item->item as $vt)
                                                            {{ $vt->item }}<br>
                                                        @endforeach
                                                    </th>
                                                    <th>{{ $item->exim_status == '0' ? 'Chờ duyệt' : 'Đã duyệt' }}</th>
                                                    =======
                                                    <td>{{ $item->user_name }}</td>
                                                    <th>
                                                        @if ($item->exim_status == '0')
                                                            <span class="badge bg-light text-dark">Chờ xác nhận</span>
                                                        @elseif ($item->exim_status == '1')
                                                            <span class="badge bg-info">Đã xác nhận</span>
                                                        @elseif($item->exim_status == '2')
                                                            <span class="badge bg-primary">Chờ duyệt</span>
                                                        @else
                                                            <span class="badge bg-success">Hoàn thành</span>
                                                        @endif
                                                    </th>
                                                    >>>>>>> quocvuong2106
                                                    <td>{{ $item->created_at }}</td>
                                                    <td class="table-action">
                                                        <a href="{{ route('export.export-detail', $item->id) }}"
                                                            class="action-icon">
                                                            <i class="mdi mdi-eye-outline"></i></a>
                                                        <a href="{{ route('ex_import.delete', $item->id) }}"
                                                            class="action-icon">
                                                            <i class="mdi mdi-delete"></i></a>
                                                    </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div>
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
    <script>
        $(document).ready(function() {
            "use strict";
            $("#import-datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing import _START_ to _END_ of _TOTAL_",
                    lengthMenu: 'Display <select class="form-select form-select-sm ms-1 me-1"><option value="50">50</option><option value="100">100</option><option value="200">200</option><option value="-1">All</option></select>'
                },
                pageLength: 50,
                columns: [{
                    orderable: !1
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }],
                // select: {
                //     style: "multi"
                // },
                order: true,
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(
                        "#import-datatable_length label").addClass("form-label")
                },
            })
            $("#export-datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing export _START_ to _END_ of _TOTAL_",
                    lengthMenu: 'Display <select class="form-select form-select-sm ms-1 me-1"><option value="50">50</option><option value="100">100</option><option value="200">200</option><option value="-1">All</option></select>'
                },
                pageLength: 50,
                columns: [{
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }, {
                    orderable: !1
                }],
                // select: {
                //     style: "multi"
                // },
                // order: [
                //     [1, "asc"]
                // ],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(
                        "#export-datatable_length label").addClass("form-label")
                },
            })
        });
    </script>
@endsection
