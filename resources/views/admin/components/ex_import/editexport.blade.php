@extends('admin.home.master')

@section('title')
    Sửa phiếu Xuất
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
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route, $export_details[0]->exim_id) }}
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
        <form action="{{ route('export.update', $export->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('ex_import.index') }}" class="btn btn-info">Quay lại</a>
                                </div>
                                <div class="col-6 text-end">
                                    <!-- <button type="submit" class="btn btn-primary"
                                        {{ $export->exim_status == '0' ? '' : 'disabled' }}>Lưu</button> -->
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="" class="form-control">Người nhận</label><br>
                                    <label for="" class="form-control">Mã phiếu</label><br>
                                    <label for="" class="form-control">Trạng thái</label><br>
                                    <label for="" class="form-control">Người tạo</label><br>
                                    <label for="" class="form-control">Ghi chú</label><br>
                                </div>
                                <div class="col-9">
                                    <input type="text" hidden value="1" name="status">
                                    <input type="text" class="form-control" readonly value="{{ $export->receiver }}"><br>
                                    <input type="text" class="form-control" readonly value="{{ $export->exim_code }}"><br>
                                    <input type="text" class="form-control" readonly
                                    value="{{ $export->exim_status == 1 ? 'Đã duyệt' : ($export->exim_status == 2 ? 'Đã hủy' : 'Chưa duyệt') }}"><br>
                                    <input type="text" class="form-control" readonly value="{{ $export->name }}"><br>
                                    <input type="text" class="form-control" readonly value="{{ $export->note }}"><br>
                                </div>
                            </div>
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
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($export_details as $key => $item)
                                        <tr>

                                            <td>{{ $key + 1 }} <input type="text" hidden name="id[]" value="{{$item->ex_import_details_id}}"></td>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->supplier_name }}</td>
                                            <td><input type="number" name="quantity[]"
                                                    value="{{ $item->ex_item_quantity }}" class="form-control"
                                                    id="quantity" readonly>
                                            </td>
                                            <td><input type="text" name="price[]" value="{{ $item->item_price }}"
                                                    data-toggle="input-mask" data-mask-format="000.000.000.000.000"
                                                    data-reverse="true" class="form-control" id="price"
                                                    readonly></td>
                                            <td>
                                                <button type="button" title="Chi tiết" class="view-item btn btn-warning"
                                                    data-name="{{ $item->item_name }}" data-unit="{{ $item->unit_name }}"
                                                    data-supplier="{{ $item->supplier_name }}"
                                                    data-category="{{ $item->category_name }}"
                                                    data-price="{{ $item->item_price }}"
                                                    data-long="{{ $item->item_long }}"
                                                    data-height="{{ $item->item_height }}"
                                                    data-width="{{ $item->item_width }}"
                                                    data-note="{{ $item->item_note }}"
                                                    data-weight="{{ $item->item_weight }}"
                                                    data-weightunit="{{ $item->item_weightuint }}"
                                                    data-image="{{ $item->item_images }}"
                                                    data-shelf-name="{{ $item->shelf_name }}"
                                                    data-floor="{{ $item->floor_id }}" data-cell="{{ $item->cell_id }}"
                                                    data-warehouse-name="{{ $item->warehouse_name }}" id="view">
                                                    Chi tiết
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="modal fade" id="item_details" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myCenterModalLabel">
                                        <p id="name"></p>
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Loại:</label>
                                                <input type="text" id="category" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="supplier" class="form-label">Nhà SX:</label>
                                                <input type="text" id="supplier" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="unit" class="form-label">Đơn vị tính:</label>
                                                <input type="text" id="unit" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="warehouse" class="form-label">Kho:</label>
                                                <input type="text" id="warehouse" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="shelf" class="form-label">Giá/Kệ:</label>
                                                <input type="text" id="shelf" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="floor" class="form-label">Tầng:</label>
                                                <input type="text" id="floor" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="cell" class="form-label">Ô:</label>
                                                <input type="text" id="cell" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="item_price" class="form-label">Đơn giá:</label>
                                                <input type="text" id="item_price" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="long" class="form-label">Dài:</label>
                                                <input type="text" id="long" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="height" class="form-label">Cao:</label>
                                                <input type="text" id="height" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="width" class="form-label">Rộng:</label>
                                                <input type="text" id="width" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label for="weight" class="form-label">Nặng:</label>
                                                        <input type="text" id="weight" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label for="weightuint" class="form-label">Đơn vị:</label>
                                                        <input type="text" id="weightuint" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="note" class="form-label">Mô tả:</label>
                                                <input type="text" id="note" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
            </div>
        </form>
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
                console.log($(this).attr('data-code'));
                $('#name').text($(this).attr('data-name'));
                $('#unit').val($(this).attr('data-unit'));
                $('#supplier').val($(this).attr('data-supplier'));
                $('#category').val($(this).attr('data-category'));
                $('#item_price').val($(this).attr('data-price'));
                $('#long').val($(this).attr('data-long'));
                $('#height').val($(this).attr('data-height'));
                $('#width').val($(this).attr('data-width'));
                $('#note').val($(this).attr('data-note'));
                $('#weight').val($(this).attr('data-weight'));
                $('#weightuint').val($(this).attr('data-weightuint'));
                $('#warehouse').val($(this).attr('data-warehouse-name'));
                $('#shelf').val($(this).attr('data-shelf-name'));
                $('#floor').val($(this).attr('data-floor'));
                $('#cell').val($(this).attr('data-cell'));
                $('#item_details').modal('show');
            })
        })
    </script>
@endsection
