@extends('admin.home.master')

@section('title')
    Export
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
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Phiếu xuất</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Chi tiết phiếu xuất</h4>
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
                        <h5 class="card-title">Thông tin</h5>
                        <form action="" class="px-5">
                            <div class="mb-3">
                                <label for="user_name" class="form-label">Nhân viên phụ trách:</label>
                                <input type="text" id="user_name" class="form-control" readonly
                                    value="{{ $export[0]->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="export_code" class="form-label">Mã phiếu:</label>
                                <input type="text" id="export_code" class="form-control" readonly
                                    value="{{ $export[0]->exim_code }}">
                            </div>
                            <div class="mb-3">
                                <label for="export_status" class="form-label">Trạng thái:</label>
                                <input type="text" id="export_status" class="form-control" readonly
                                    value="{{ $export[0]->exim_status == '0' ? 'Chờ duyệt' : 'Đã duyệt' }}">
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chi tiết</h5>
                        <table id="scroll-vertical-datatable" class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Vật tư/Phụ tùng</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($export_details as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>{{ $item->supplier_name }}</td>
                                        <td>{{ $item->ex_item_quantity }}</td>
                                        <td>{{ $item->item_price }}</td>
                                        <td>Đã duyệt</td>
                                        <td>
                                            <a type="button" title="Chi tiết" class="view-item action-icon"
                                                data-code="{{ $item->item_code }}" id="view">
                                                <i class="mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="item_details" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myCenterModalLabel">ID:<p id="code"></p>
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li></li>
                                </ul>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
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
    <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
    <!-- third party js ends -->

    <script>
        $(document).ready(function() {
            $('.view-item').on('click', function() {
                // alert('1');
                console.log($(this).attr('data-code'));
                $('#code').text($(this).attr('data-code'));
                $('#item_details').modal('show');
            })
        })
    </script>
@endsection
