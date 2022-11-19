@extends('admin.home.master')

@section('title')
    Quản lý Nhập - Xuất
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
                                <div class="row mb-3 mt-3">
                                    <div {{ count($warehouses) > 1 ? '' : 'hidden' }} class="col-3">
                                        <select data-toggle="select2" title="Warehouse" id="warehouse1">
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ app('request')->input('warehouse') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->warehouse_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select data-toggle="select2" title="Status" id="status1">
                                            <option value="">Hiển thị tất cả</option>
                                            <option value="cduyet"
                                                {{ app('request')->input('status') == 'cduyet' ? 'selected' : '' }}>
                                                Hiển thị phiếu chưa duyệt</option>
                                            <option value="duyet"
                                                {{ app('request')->input('status') == 'duyet' ? 'selected' : '' }}>
                                                Hiển thị phiếu đã duyệt</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3 input-group">
                                            <span class="input-group-text"><i
                                                    class="mdi mdi-calendar text-primary"></i></span>
                                            <input type="text" class="form-control date" id="date_change1"
                                                data-toggle="date-picker" data-cancel-class="btn-warning"
                                                name="date_change1"
                                                value="{{ app('request')->input('date') ? str_replace('_', ' - ', str_replace('-', '/', app('request')->input('date'))) : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <button type="button" class="btn btn-primary" onclick="filter1()">Tìm kiếm</button>
                                    </div>
                                </div>
                                @can('eim.add')
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <a href="{{ route('import.index') }}" class="btn btn-danger mb-2">
                                                Thêm mới phiếu nhập
                                            </a>
                                        </div>
                                    </div>
                                @endcan

                                <hr>
                                <table id="import-datatable"
                                    class="table table-centered table-striped dt-responsive nowrap w-100">
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
                                                @can('eim.edit')
                                                    <td><a href="{{ route('import.edit', $item->id) }}">
                                                            <span class="text-info">{{ $item->exim_code }}</span></a></td>
                                                @endcan
                                                @cannot('eim.edit')
                                                    <td><span class="text-info">{{ $item->exim_code }}</span></td>
                                                @endcannot
                                                <td>{{ $item->created_by }}</td>
                                                <th>
                                                    @if ($item->item->duplicates('item')->count())
                                                        {{ $item->item->duplicates('item')->first() }}
                                                    @else
                                                        @foreach ($item->item as $index => $vt)
                                                            {{ $vt->item }}<br>
                                                        @endforeach
                                                    @endif
                                                </th>
                                                <th>
                                                    <span style="font-size: 15px"
                                                        class="badge badge-{{ $item->exim_status == '0' ? 'info-lighten' : 'success-lighten' }}">
                                                        {{ $item->exim_status == '0' ? 'Chờ duyệt' : '' }}{{ $item->exim_status == '1' ? 'Đã duyệt' : '' }}</span>
                                                </th>
                                                <td>{{ $item->created }}</td>
                                                <td class="table-action">
                                                    @can('eim.edit')
                                                        @if ($item->exim_status == 0)
                                                            {{-- <a href="{{ route('import.edit', $item->id) }}"
                                                                class="action-icon">
                                                                <i class="mdi mdi-square-edit-outline"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Sửa phiếu"></i></a> --}}
                                                            <a href="{{ route('import.confirm', $item->id) }}"
                                                                class="action-icon">
                                                                <i class="mdi mdi-clipboard-edit-outline"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Duyệt phiếu"></i></a>
                                                        @endif
                                                    @endcan
                                                    @can('eim.delete')
                                                        {{-- <a href="{{ route('ex_import.delete', $item->id) }}"
                                                            class="action-icon">
                                                            <i class="mdi mdi-delete" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Xóa phiếu"></i></a> --}}
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
            </div>
            <div class="tab-pane" id="export">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3 mt-3">
                                    <div {{ count($warehouses) > 1 ? '' : 'hidden' }} class="col-3">
                                        <select data-toggle="select2" title="Warehouse" id="warehouse">
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ app('request')->input('warehouse') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->warehouse_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select data-toggle="select2" title="Status" id="status2">
                                            <option value="">Hiển thị tất cả</option>
                                            <option value="cduyet"
                                                {{ app('request')->input('status') == 'cduyet' ? 'selected' : '' }}>
                                                Hiển thị phiếu chưa duyệt</option>
                                            <option value="duyet"
                                                {{ app('request')->input('status') == 'duyet' ? 'selected' : '' }}>
                                                Hiển thị phiếu đã duyệt</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3 input-group">
                                            <span class="input-group-text"><i
                                                    class="mdi mdi-calendar text-primary"></i></span>
                                            <input type="text" class="form-control date" id="date_change"
                                                data-toggle="date-picker" data-cancel-class="btn-warning"
                                                name="date_change"
                                                value="{{ app('request')->input('date') ? str_replace('_', ' - ', str_replace('-', '/', app('request')->input('date'))) : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-3 text-end">
                                        <button type="button" class="btn btn-primary" onclick="filter()">Tìm
                                            kiếm</button>
                                    </div>
                                </div>
                                @can('eim.add')
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <a href="{{ route('export.index') }}" class="btn btn-danger mb-2">
                                                Thêm mới phiếu xuất
                                            </a>
                                        </div>
                                    </div>
                                @endcan

                                <hr>
                                <table id="export-datatable"
                                    class="table table-centered table-striped dt-responsive nowrap w-100">
                                    {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                    <thead>
                                        <tr>
                                            <th>Mã phiếu xuất</th>
                                            <th>Người tạo</th>
                                            <th>Vật tư/ Phụ tùng</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian tạo</th>
                                            <th style="width: 10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ex_items as $key => $item)
                                            <tr>
                                                @can('eim.edit')
                                                    <td><a href="{{ route('export.edit', $item->id) }}">
                                                            <span class="text-info">{{ $item->exim_code }}</span></a></td>
                                                @endcan
                                                @cannot('eim.edit')
                                                    <td><span class="text-info">{{ $item->exim_code }}</span></td>
                                                @endcannot
                                                <td>{{ $item->created_by }}</td>
                                                <th>
                                                    @foreach ($item->item as $vt)
                                                        {{ $vt->item }}<br>
                                                    @endforeach
                                                </th>
                                                <th>
                                                    <span style="font-size: 15px"
                                                        class="badge badge-{{ $item->exim_status == '0' ? 'info-lighten' : 'success-lighten' }}">
                                                        {{ $item->exim_status == '0' ? 'Chờ duyệt' : 'Đã duyệt' }}</span>
                                                </th>
                                                <td>{{ $item->created }}</td>
                                                <td class="table-action">
                                                    @can('eim.edit')
                                                        <a href="{{ route('export.edit', $item->id) }}" class="action-icon">
                                                            <i class="mdi mdi-square-edit-outline" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Sửa phiếu"></i></a>
                                                        <a href="{{ route('export.confirm', $item->id) }}"
                                                            class="action-icon">
                                                            <i class="mdi mdi-clipboard-edit-outline" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Duyệt phiếu"></i></a>
                                                    @endcan
                                                    @can('eim.delete')
                                                        <a href="{{ route('ex_import.delete', $item->id) }}"
                                                            class="action-icon"> <i class="mdi mdi-delete"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Xóa phiếu"></i></a>
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

        function filter1() {
            var dt = $('#date_change1').val();
            var dateVal = dt.replace(' - ', '_');
            dateVal = dateVal.replaceAll('/', '-');
            var statusVal = $('#status1').val();
            var warehouseVal = $('#warehouse1').val();
            const paramsObj = {
                status: statusVal,
                warehouse: warehouseVal,
                date: dateVal,
                type: 1,
            };
            if (statusVal === '') delete paramsObj.status;
            if (warehouseVal === '') delete paramsObj.warehouse;
            if (dateVal === '') delete paramsObj.date;
            const searchParams = new URLSearchParams(paramsObj);
            let url = new URL(window.location.href);
            url.search = searchParams;
            window.location.href = url;
        }

        function filter() {
            var dt = $('#date_change').val();
            var dateVal = dt.replace(' - ', '_');
            dateVal = dateVal.replaceAll('/', '-');
            var statusVal = $('#status2').val();
            var warehouseVal = $('#warehouse').val();
            const paramsObj = {
                status: statusVal,
                warehouse: warehouseVal,
                date: dateVal,
                type: 0,
            };
            console.log(statusVal);
            if (statusVal === '') delete paramsObj.status;
            if (warehouseVal === '') delete paramsObj.warehouse;
            if (dateVal === '') delete paramsObj.date;
            const searchParams = new URLSearchParams(paramsObj);
            let url = new URL(window.location.href);
            url.search = searchParams;
            window.location.href = url;
        }
    </script>
@endsection
