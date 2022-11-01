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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Transfer</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Transfer</h4>
                </div>
            </div>
        </div>
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
@endsection
