@extends('admin.home.master')

@section('title')
    Admin | Điều chuyển
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
            <div class="col-sm-12">
                <div class="text-sm-start">
                    <a href="{{ route('transfer.add') }}" class="btn btn-danger mb-3"><i
                            class="mdi mdi-plus"></i> Thêm mới</a>
                </div>
            </div>
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
                                <select data-toggle="select2" title="Status" id="status">
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
                                <button type="button" class="btn btn-primary" onclick="filter()">Tìm kiếm</button>
                            </div>
                        </div>
                        <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                            {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã điều chuyển</th>
                                    <th>Người tạo</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian tạo</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $key => $transfer)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $transfer->transfer_code }}</td>
                                        <td>{{ $transfer->name }}</td>
                                        <td>{{ $transfer->transfer_note }}</td>
                                        <td>
                                            @if ($transfer->transfer_status == '1')
                                                <span class="badge bg-success">Đã duyệt</span>
                                            @else
                                                <span class="badge bg-info">Chưa duyệt</span>
                                            @endif
                                        </td>
                                        <td>{{ $transfer->created_at }}</td>
                                        <td class="table-action">
                                            <a href="{{ route('transfer.edit', $transfer->id) }}" class="action-icon">
                                                <i class="mdi mdi-square-edit-outline" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Sửa phiếu"></i></a>
                                            <a href="{{ route('transfer.confirm', $transfer->id) }}" class="action-icon">
                                                <i class="mdi mdi-clipboard-edit-outline" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Duyệt phiếu"></i></a>
                                            <a href="{{ route('transfer.delete', $transfer->id) }}"
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
            @if($trashes->count() >0)
                <hr>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center">Danh sách phiếu đã xóa</h3>
                            </div>
                            <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                                {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã điều chuyển</th>
                                        <th>Người tạo</th>
                                        <th>Mô tả</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian tạo</th>
                                        <th style="width: 10%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($trashes as $key => $transfer)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $transfer->transfer_code }}</td>
                                            <td>{{ $transfer->name }}</td>
                                            <td>{{ $transfer->transfer_note }}</td>
                                            <td>
                                                @if ($transfer->transfer_status == '1')
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                @else
                                                    <span class="badge bg-info">Chưa duyệt</span>
                                                @endif
                                            </td>
                                            <td>{{ $transfer->created_at }}</td>
                                            <td class="table-action">
                                                <a href="{{ route('transfer.restore', $transfer->id) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-delete-restore" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Khôi phục"></i></a>
                                                <a href="{{ route('transfer.destroy', $transfer->id) }}"
                                                    class="action-icon">
                                                    <i class="mdi mdi-delete-forever" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Xóa vĩnh viễn"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            @endisset
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
        function filter() {
            var dt = $('#date_change').val();
            var dateVal = dt.replace(' - ', '_');
            dateVal = dateVal.replaceAll('/', '-');
            var statusVal = $('#status').val();
            var warehouseVal = $('#warehouse').val();
            const paramsObj = {
                status: statusVal,
                warehouse: warehouseVal,
                date: dateVal,
            };
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
