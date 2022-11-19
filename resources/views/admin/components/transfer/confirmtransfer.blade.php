@extends('admin.home.master')

@section('title')
    Xác nhận Điều chuyển
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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Duyệt luân chuyển</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Duyệt luân chuyển</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate
                            action="{{ route('transfer.update-status', $transfers->first()->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('transfer.index') }}" class="btn btn-info">Quay lại</a>
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
                                        value="{{ $transfers[0]->transfer_code }}"><br>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $transfers[0]->transfer_status == 1 ? 'Đã duyệt' : 'Chưa duyệt' }}"><br>
                                    <input type="text" class="form-control" readonly
                                        value="{{ $transfers[0]->name }}"><br>
                                </div>
                            </div>
                            <table class="table dt-responsive nowrap text-center">
                                {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                <thead>
                                    <tr>
                                        <th width="15%">Phụ tùng/ Vật tư</th>
                                        <th width="10%">Thể tích</th>
                                        <th width="15%">Kho nhận</th>
                                        <th width="10%">Số lượng</th>
                                        <th width="15%">Chọn Kệ</th>
                                        <th width="15%">Chọn Tầng</th>
                                        <th width="20%">Chọn Ô</th>
                                    </tr>
                                </thead>
                                <tbody id="list-transfer">
                                    @foreach ($transfers as $key => $item)
                                        <tr>
                                            <td><input type="text" value="{{ $item->item }}"
                                                    class="form-control text-center" readonly id="name{{ $key }}">
                                                <input type="text" value="{{ $item->id }}" name="id[]"
                                                    id="id{{ $key }}" class="form-control text-center" hidden>
                                            </td>
                                            <th><input type="text" value="{{ $item->item_capacity }}"
                                                    class="form-control text-center" readonly
                                                    id="capacity{{ $key }}"></th>
                                            <th><input type="text" value="{{ $item->warehouse_name }}"
                                                    class="form-control text-center" readonly></th>
                                            <th><input type="text" value="{{ $item->item_quantity }}"
                                                    class="form-control text-center" readonly
                                                    id="quantity{{ $key }}"></th>
                                            <th>
                                                <select data-toggle="select2" title="Shelf" id="{{ 'shelf' . $key }}"
                                                    name="shelf[]"
                                                    onchange="dispatchShelf(this.value, {{ $key }});">
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
                                                <select data-toggle="select2" title="Floor"
                                                    id="floor{{ $key }}"
                                                    onchange="dispatchFloor(this.value, {{ $key }});"
                                                    name="floor[]" disabled>
                                                </select>
                                            </th>
                                            <th>
                                                <select data-toggle="select2" title="Cell"
                                                    id="cell{{ $key }}"
                                                    onchange="dispatchCell(this.value, {{ $key }})"
                                                    name="cell[]" disabled>
                                                    <option value="">Ô</option>
                                                </select>
                                            </th>
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
        let cell_selected = [];

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
                            // console.log(item);
                            $('#floor' + key).append(
                                `<option value="${item.id}">${item.floor_name}</option>`)
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
                let capacity_value = $('#capacity' + key).val();
                let quantity_value = $('#quantity' + key).val();
                $.ajax({
                    type: 'GET',
                    url: `/admin/import/dispatch/floor/${id}`,
                    success: function(res) {
                        const cells = res.cells;
                        let html = '<option value="">Ô</option>';
                        $('#cell' + key).html(html);
                        cells.map((item, index) => {
                            let add_count = cell_selected.filter(value => value.id == item.id);
                            let sub = add_count.length > 0 ? add_count[0].capacity : 0;
                            let total = item.sum + sub;
                            let visible = (total + (capacity_value * quantity_value)) <= item
                                .cell_capacity ? true : false;
                            $('#cell' + key).append(
                                `<option value="${item.id}" data-capacity="${total}" ${visible ? '' : 'disabled'}>${item.cell_name} (${total}/${item.cell_capacity})</option>`
                                )
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

        function dispatchCell(id, key) {
            if (!isNaN(parseInt(id))) {
                let capacity_value = $('#capacity' + key).val();
                let quantity_value = $('#quantity' + key).val();
                let cell_capacity = $('#cell' + key).find(':selected').attr('data-capacity');
                console.log(id, capacity_value, quantity_value, cell_capacity);
                if (cell_capacity <= capacity_value * quantity_value) {
                    cell_selected.push({
                        'id': id,
                        'capacity': capacity_value * quantity_value
                    });
                } else {
                    alert('Không đủ không gian để chứu vật tư');
                }
            } else {}
            console.log(cell_selected);
        }
    </script>
@endsection
