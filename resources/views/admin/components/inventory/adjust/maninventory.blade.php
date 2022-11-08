@extends('admin.home.master')

@section('title')
    Inventory
@endsection

@section('css')
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Điều chỉnh thiết bị</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Điều chỉnh thiết bị</h4>
                </div>
            </div>
        </div>
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
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('inventory.create') }}" class="btn btn-danger mb-2">
                                    Tạo phiếu
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div {{ count($warehouses) > 1 ? '' : 'hidden' }}>
                                <div class="col s8">
                                    <input type="text" name="id" id="id" hidden>
                                    <div class="mb-3">
                                        <label for="warehouse" class="form-label">Kho:</label>
                                        <div class="row">
                                            <div class="col">
                                                <select data-toggle="select2" title="Warehouse" id="warehouse"
                                                    name="warehouse">
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}"
                                                            {{ app('request')->input('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                            {{ $warehouse->id }} - {{ $warehouse->warehouse_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <br>
                                            </div>
                                            <div class="col">
                                                <input type="button" class="btn btn-success" value="Filter" id="btnFilter">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col s4"></div> --}}
                        <table id="adjust-item-datatable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã phiếu</th>
                                    <th>Người tạo</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventories as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->inventory_code }}</td>
                                        <td><span class="badge bg-primary">{{ $item->name }}</span></td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if ($item->inventory_status == 0)
                                                <span class="badge bg-secondary">Chờ duyệt</span>
                                            @elseif($item->deleted_at != null)
                                                <span class="badge bg-danger">Đã xóa</span>
                                            @else
                                                <span class="badge bg-success">Đã duyệt</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-warning mb-2 me-1" type="button">Chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <!-- third party js ends -->
    <script>
        $(document).ready(function() {

            // $('#warehouse').on('change', function() {
            // document.getElementById("btnFilter").click();
            // })
            $('#btnFilter').on('click', function() {
                var warehouse = $('#warehouse').val();
                window.location.href = (warehouse) ? ('?warehouse_id=' + warehouse) : '';
            })

            "use strict";
            $("#adjust-item-datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing inventory_START_ to _END_ of _TOTAL_",
                    lengthMenu: 'Display <select class="form-select form-select-sm ms-1 me-1"><option value="50">50</option><option value="100">100</option><option value="200">200</option><option value="-1">All</option></select>'
                },
                pageLength: 50,
                columns: [{
                    orderable: !1
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(
                        "#adjust-item-datatable_length label").addClass("form-label")
                },
            })
        });
    </script>
@endsection