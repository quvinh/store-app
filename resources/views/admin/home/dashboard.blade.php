@extends('admin.home.master')
@section('title')
    Admin | Bản tin
@endsection
@section('css')
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        {{ Breadcrumbs::render('dashboard') }}
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="card cta-box overflow-hidden">
                    <div class="card-body">
                        <h6 for="warehouse" class="text-uppercase mt-0"><a href="#">Kho</a></h6>
                        @if (count($warehouses) > 1)
                            <select data-toggle="select2" title="Warehouse" id="warehouse" onchange="filter()">
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}"
                                        {{ app('request')->input('warehouse') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->warehouse_name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <select data-toggle="select2" title="Warehouse" id="warehouse" disabled>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}"
                                        {{ app('request')->input('warehouse') == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->warehouse_name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                    </div>
                    <!-- end card-body -->
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <a href="#"><i class='uil uil-window-restore float-end'></i></a>
                        <h6 class="text-uppercase mt-0"><a href="#">Vật tư/ phụ tùng đã nhập trong tháng</a></h6>
                        {{-- <h2 class="my-2" id="active-views-count">{{ $sum_ex }}</h2> --}}
                        <p class="mb-10 text-muted">
                            <span class="text-success me-2"><span class="mdi mdi-sticker-check"></span>
                                {{ number_format($sum_im, 0, ',', '.') }}</span>
                            <span class="text-nowrap"></span>
                        </p>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->
            </div> <!-- end col -->
            <div class="col-xl-4 col-lg-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <a href="#"><i class='uil uil-window-restore float-end'></i></a>
                        <h6 class="text-uppercase mt-0"><a href="#">Vật tư/ phụ tùng đã xuất trong tháng</a></h6>
                        {{-- <h2 class="my-2" id="active-views-count">{{ $sum_ex }}</h2> --}}
                        <p class="mb-10 text-muted">
                            <span class="text-success me-2"><span class="mdi mdi-sticker-check"></span>
                                {{ number_format($sum_ex, 0, ',', '.') }}</span>
                            <span class="text-nowrap"></span>
                        </p>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->
            </div> <!-- end col -->
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-title">
                        <div class="text-center mt-3"><h4>Danh sách nhập chưa duyệt</h4></div>
                    </div>
                    <div class="card-body">
                        <table id="import-datatable" class="table table-centered table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã phiếu nhập</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($imports as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><a href="{{ route('import.edit', $item->id) }}">
                                                <span class="text-info">{{ $item->exim_code }}</span></a></td>
                                        <th>
                                            <span style="font-size: 15px" class="badge badge-info-lighten">Chờ duyệt</span>
                                        </th>
                                        <td>{{ $item->created }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-title">
                        <div class="text-center mt-3"><h4>Danh sách xuất chưa duyệt</h4></div>
                    </div>
                    <div class="card-body">
                        <table id="export-datatable" class="table table-centered table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã phiếu xuất</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exports as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><a href="{{ route('export.edit', $item->id) }}">
                                                <span class="text-info">{{ $item->exim_code }}</span></a></td>
                                        <th>
                                            <span style="font-size: 15px" class="badge badge-info-lighten">Chờ duyệt</span>
                                        </th>
                                        <td>{{ $item->created }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container -->
@endsection

@section('script')
    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/Chart.bundle.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
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
                }, ],
                // select: {
                //     style: "multi"
                // },
                // order: true,
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
                }, ],
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
        function filter() {
            // var dt = $('#date_change').val();
            // var dateVal = dt.replace(' - ', '_');
            // dateVal = dateVal.replaceAll('/', '-');
            // var statusVal = $('#status2').val();
            var warehouseVal = $('#warehouse').val();
            const paramsObj = {
                // status: statusVal,
                warehouse: warehouseVal,
                // date: dateVal,
                // type: 0,
            };
            // console.log(statusVal);
            // if (statusVal === '') delete paramsObj.status;
            if (warehouseVal === '') delete paramsObj.warehouse;
            // if (dateVal === '') delete paramsObj.date;
            const searchParams = new URLSearchParams(paramsObj);
            let url = new URL(window.location.href);
            url.search = searchParams;
            window.location.href = url;
        }

    </script>
@endsection
