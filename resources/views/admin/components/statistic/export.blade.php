@extends('admin.home.master')

@section('title')
    Thống kê Xuất
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

        <div class="row">
            <div class="col-12">
                <div class="row mb-3 mt-3">
                    <div {{ count($warehouses) > 1 ? '' : 'hidden' }} class="col-2">
                        <select data-toggle="select2" title="Warehouse" id="warehouse">
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}"
                                    {{ app('request')->input('warehouse') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->warehouse_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <select data-toggle="select2" title="Month" id="month">
                            <option value="">Chọn tháng</option>
                            @for ($i = 0; $i < 12; $i++)
                                <option value={{ $i + 1 }}
                                    {{ app('request')->input('month') == $i + 1 ? 'selected' : '' }}>Tháng
                                    {{ $i + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-2">
                        <select data-toggle="select2" title="Quarter" id="quarter">
                            <option value="">Chọn quý</option>
                            @for ($i = 0; $i < 4; $i++)
                                <option value={{ $i + 1 }}
                                    {{ app('request')->input('quarter') == $i + 1 ? 'selected' : '' }}>Quý
                                    {{ $i + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-2">
                        <div class="mb-3 position-relative" id="yearpicker">
                            <input type="text" id="year" class="form-control" placeholder="Chọn năm"
                                data-date-format="yyyy" data-provide="datepicker" data-date-min-view-mode="2"
                                data-date-container="#yearpicker"
                                value="{{ app('request')->input('year') ? app('request')->input('year') : '' }}">
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-2 text-end">
                        <button type="button" class="btn btn-primary" onclick="filter()">Tìm kiếm</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table id="export-datatable" class="table table-centered table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Mã phiếu nhập</th>
                                    <th>Người tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian tạo</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ex as $key => $item)
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
                        "#export-datatable_length label").addClass("form-label")
                },
            })
        });

        function filter() {
            var warehouse = $('#warehouse').val();
            var month = $('#month').val();
            var quarter = $('#quarter').val();
            var year = $('#year').val();
            const paramsObj = {
                warehouse: warehouse,
                month: month,
                quarter: quarter,
                year: year,
            };
            if (warehouse === '') delete paramsObj.warehouse;
            if (month === '') delete paramsObj.month;
            if (quarter === '') delete paramsObj.quarter;
            if (year === '' || year === null) delete paramsObj.year;
            const searchParams = new URLSearchParams(paramsObj);
            let url = new URL(window.location.href);
            url.search = searchParams;
            window.location.href = url;
        }
    </script>
@endsection
