@extends('admin.home.master')

@section('title')
    Tồn kho
@endsection

@section('css')
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">

    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Tồn kho</li>
                    </ol>
                </div>
                <h4 class="page-title">Tồn kho <small>xem chi tiết</small></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bánh xe</h5>
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#detail" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                <span class="d-none d-md-block">Chi tiết</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#import" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                <span class="d-none d-md-block">Phiếu nhập</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#export" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                <span class="d-none d-md-block">Phiếu xuất</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#transfer" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                <span class="d-none d-md-block">Phiếu luân chuyển</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="detail">
                            @include('admin.components.inventory.inven.detail')
                        </div>
                        @can('eim.view')
                            <div class="tab-pane" id="import">
                            @include('admin.components.inventory.inven.import')
                        </div>
                        <div class="tab-pane" id="export">
                            @include('admin.components.inventory.inven.export')
                        </div>
                        @endcan
                        @can('tra.view')
                            <div class="tab-pane" id="transfer">
                            @include('admin.components.inventory.inven.transfer')
                        </div>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
    <script>
        $(document).ready(function() {
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
                        "#import-datatable_length label").addClass("form-label")
                },
            })
            $("#transfer-datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing transfer _START_ to _END_ of _TOTAL_",
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
                        "#transfer-datatable_length label").addClass("form-label")
                },
            })
        })
    </script>
@endsection
