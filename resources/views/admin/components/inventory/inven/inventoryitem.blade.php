@extends('admin.home.master')

@section('title')
    Inventory
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->

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
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="warehouse" class="form-label">Kho:</label>
                                    <div {{ count($warehouses) > 1 ? '' : 'hidden' }}>
                                        <select data-toggle="select2" title="Warehouse" id="warehouse" name="warehouse">
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ app('request')->input('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->id }} - {{ $warehouse->warehouse_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <br>
                                    </div>
                                    <input type="button" class="btn btn-success" value="Filter" id="btnFilter" hidden>
                                </div>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                        {{-- <table id="scroll-vertical-datatable" class="table dt-responsive nowrap"> --}}
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên vật tư</th>
                                    <th>Số lượng</th>
                                    <th>SL khả dụng</th>
                                    <th>SL không khả dụng</th>
                                    <th>Giá kệ</th>
                                    <th>Tầng</th>
                                    <th>Ô</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->item_detail_quantity }}</td>
                                        <td>{{ $item->item_quantity[0] }}</td>
                                        <td>{{ $item->item_quantity[1] }}</td>
                                        <td>{{ $item->shelf_name }}</td>
                                        <td>{{ $item->floor_id }}</td>
                                        <td>{{ $item->cell_id }}</td>
                                        <td>
                                            @if ($item->item_quantity[0] > 0)
                                                <span class="badge bg-success">Còn hàng</span>
                                            @else
                                                <span class="badge bg-danger">hết hàng</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->item_note ? $item->item_note : '----- ' }}</td>
                                        <td class="table-action">
                                            <a href="{{ route('inventory-item.show', $item->itemdetail_id) }}" class="action-icon" title="Xem chi tiết">
                                                <i class="mdi mdi-eye-outline"></i></a>
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
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    <!-- demo js -->
    {{-- <script src="{{ asset('assets/js/pages/demo.toastr.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <script>
        $('document').ready(function() {
            $('#warehouse').on('change', function() {
                document.getElementById("btnFilter").click();
            })
        })
        $('#btnFilter').on('click', function() {
            var warehouse = $('#warehouse').val();
            window.location.href = (warehouse) ? ('?warehouse_id=' + warehouse) : '';
        })
    </script>
@endsection
