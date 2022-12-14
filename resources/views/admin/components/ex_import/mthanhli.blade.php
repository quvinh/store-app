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

        <br><br>
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
                                            <option value="huy"
                                                {{ app('request')->input('status') == 'huy' ? 'selected' : '' }}>
                                                Hiển thị phiếu đã hủy</option>
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
                                        <button type="button" class="btn btn-primary" onclick="filter()">Tìm kiếm</button>
                                    </div>
                                </div>
                                @can('eim.add')
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <a href="{{ route('export.thanhli') }}" class="btn btn-danger mb-2">
                                                Thêm mới phiếu đổi trả
                                            </a>
                                        </div>
                                        {{-- <div class="col text-end">
                                            <a href="{{ route('export.tl') }}" class="btn btn-danger mb-2">
                                                Xuất phiếu thanh lí
                                            </a>
                                        </div> --}}
                                    </div>
                                @endcan

                                <hr>
                                <table id="import-datatable"
                                    class="table table-centered table-striped dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Mã phiếu đổi trả</th>
                                            <th>Người tạo</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian tạo</th>
                                            <th style="width: 10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($im_items as $key => $item)
                                            <tr>
                                                @can('eim.edit')
                                                    <td><span class="text-info">{{ $item->exim_code }}</span></td>
                                                @endcan
                                                @cannot('eim.edit')
                                                    <td><span class="text-info">{{ $item->exim_code }}</span></td>
                                                @endcannot
                                                <td>{{ $item->created_by }}</td>
                                                <th>
                                                    @if ($item->exim_status == '0')
                                                        <span style="font-size: 15px" class="badge badge-info-lighten">Chờ
                                                            duyệt</span>
                                                    @elseif ($item->exim_status == '1')
                                                    <span style="font-size: 15px" class="badge badge-success-lighten">Đã
                                                        duyệt</span>
                                                    @else
                                                    <span style="font-size: 15px" class="badge badge-danger-lighten">Đã
                                                        hủy</span>
                                                    @endif
                                                </th>
                                                <td>{{ $item->created }}</td>
                                                <td class="table-action">
                                                    <a href="{{ route('export.ccthanhli', $item->id) }}" class="action-icon">
                                                        <i class="mdi mdi-clipboard-alert-outline" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Hủy phiếu"></i></a>
                                                    <a href="{{ route('export.cthanhli', $item->id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-clipboard-edit-outline"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Duyệt phiếu"></i></a>
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
        });

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
