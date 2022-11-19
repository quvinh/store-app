@extends('admin.home.master')

@section('title')
    Xác nhận Nhập
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <style>
        .autocomplete-suggestions {
            border: 1px solid #999;
            background: #FFF;
            cursor: default;
            overflow: auto;
        }

        .autocomplete-suggestion {
            padding: 2px 5px;
            white-space: nowrap;
            overflow: hidden;
        }

        .autocomplete-selected {
            background: #F0F0F0;
        }

        .autocomplete-suggestions strong {
            font-weight: normal;
            color: #3399FF;
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route, $im_items[0]->exim_id) }}
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate
                            action="{{ route('import.update-status', $im_items->first()->exim_id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('ex_import.index') }}" class="btn btn-info">Quay lại</a>
                                </div>
                                <div class="col-6 text-end">
                                    <button class="btn btn-primary" type="submit">Lưu</button>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="" class="form-control">Mã phiếu</label><br>
                                    <label for="" class="form-control">Trạng thái</label><br>
                                    <label for="" class="form-control">Người tạo</label><br>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" readonly
                                        value="{{ $im_items[0]->exim_code }}"><br>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $im_items[0]->exim_status == 1 ? 'Đã duyệt' : 'Chưa duyệt' }}"><br>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $im_items[0]->name }}"><br>
                                </div>
                            </div>
                            <table class="table dt-responsive nowrap text-center">
                                {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                <thead>
                                    <tr>
                                        <th width="15%">Phụ tùng/ Vật tư</th>
                                        <th width="10%">Thể tích</th>
                                        <th width="15%">Nhà cung cấp</th>
                                        <th width="10%">Số lượng</th>
                                        <!-- <th width="10%">Đơn giá</th> -->
                                        <th width="15%">Chọn Kệ</th>
                                        <th width="15%">Chọn Tầng</th>
                                        <th width="20%">Chọn Ô</th>
                                    </tr>
                                </thead>
                                <tbody id="list-import">
                                    @foreach ($im_items as $key => $item)
                                        <tr>
                                            <td><input type="text" value="{{ $item->item }}"
                                                    class="form-control text-center" readonly>
                                                <input type="text" value="{{ $item->id }}" name="id[]"
                                                    class="form-control text-center" hidden>
                                            </td>
                                            <th><input type="text" value="{{ $item->item_capacity }}"
                                                class="form-control text-center" readonly></th>
                                            <th><input type="text" value="{{ $item->supplier_name }}"
                                                    class="form-control text-center" readonly></th>
                                            <th><input type="text" value="{{ $item->item_quantity }}"
                                                    class="form-control text-center" readonly></th>
                                            <!-- <th><input type="text" value="{{ $item->item_price }}"
                                                            class="form-control text-center" readonly></th> -->
                                            <th>
                                                <select data-toggle="select2" title="Shelf" id="{{ 'shelf' . $key }}"
                                                    name="shelf[]" onchange="dispatchShelf(this.value, {{ $key }});">
                                                    <option value="">Chọn Kệ</option>
                                                    @foreach ($shelves as $shelf)
                                                        <option
                                                            value="{{ $shelf->id }} {{ $shelf->id == $item->shelf_to ? 'selected' : '' }}">
                                                            {{ $shelf->shelf_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th>
                                                <select data-toggle="select2" title="Floor" id="floor{{ $key }}" onchange="dispatchFloor(this.value, {{ $key }});"
                                                    name="floor[]" disabled>
                                                    {{-- <option value="">Tầng</option> --}}
                                                </select>
                                            </th>
                                            <th>
                                                <select data-toggle="select2" title="Cell" id="cell{{ $key }}"
                                                    name="cell[]" disabled>
                                                    <option value="">Ô</option>
                                                </select>
                                            </th>
                                            <!-- <th><input type="number" name="floor[]" id="{{ $key }}"
                                                            class="form-control text-center" min="1" max="3"
                                                            value="{{ $item->floor_to ? $item->floor_to : '' }}"></th>
                                                    <th><input type="number" name="cell[]" id="{{ $key }}"
                                                            class="form-control text-center" min="1" max="5"
                                                            value="{{ $item->cell_to ? $item->cell_to : '' }}"></th> -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>

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
    {{-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js">
    </script>
    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->
    <script>
        function dispatchShelf(id, key) {
            if (!isNaN(parseInt(id))) {
                $.ajax({
                    type: 'GET',
                    url: `/admin/import/dispatch/shelf/${id}`,
                    success: function(res) {
                        const floors = res.floors;
                        let html = '<option value="">Tầng</option>';
                        $('#floor' + key).html(html);
                        floors.map((item, index) => {
                            console.log(item);
                            $('#floor' + key).append(`<option value="${item.id}">${item.floor_name}</option>`)
                        })
                        $('#floor' + key).attr('disabled', false);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
            } else {
                $('#floor' + key).html('<option value="">Tầng</option>');
                $('#cell' + key).html('<option value="">Ô</option>');
                $('#floor' + key).attr('disabled', true);
                $('#cell' + key).attr('disabled', true);
            }
        }

        function dispatchFloor(id, key) {
            if (!isNaN(parseInt(id))) {
                $.ajax({
                    type: 'GET',
                    url: `/admin/import/dispatch/floor/${id}`,
                    success: function(res) {
                        const cells = res.cells;
                        let html = '<option value="">Ô</option>';
                        $('#cell' + key).html(html);
                        cells.map((item, index) => {
                            $('#cell' + key).append(`<option value="${item.id}">${item.cell_name} (${item.sum}/${item.cell_capacity})</option>`)
                        })
                        $('#cell' + key).attr('disabled', false);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
            } else {
                $('#cell' + key).html('<option value="">Ô</option>');
                $('#cell' + key).attr('disabled', true);
            }
        }

        function dispatchCell(id) {
            if (!isNaN(parseInt(id))) {
                let sum = 0;
                $.ajax({
                    type: 'GET',
                    url: `/admin/import/dispatch/cell/${id}`,
                    success: function(res) {
                        const cell = res.cell;
                        // let sum = 0;
                        cell.map((item, index) => {
                            sum += item.item_capacity * item_quantity;
                        })
                        // console.log(sum)
                        return 1;
                    },
                    error: function(e) {
                        console.log(e);
                        return 2;
                    }
                })
                return sum;
            } else {
                return 0;
            }
        }
    </script>
@endsection
