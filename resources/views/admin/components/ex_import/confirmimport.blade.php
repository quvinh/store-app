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
                                        {{-- <th width="8%">Tách</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="list-import">
                                    @foreach ($im_items as $key => $item)
                                        <tr id="row{{ $key }}">
                                            <td><input type="text" value="{{ $item->item }}"
                                                    class="form-control text-center" readonly id="name{{ $key }}">
                                                <input type="text" value="{{ $item->id }}" name="id[]" id="id{{ $key }}"
                                                    class="form-control text-center" hidden>
                                            </td>
                                            <th><input type="text" value="{{ $item->item_capacity }}"
                                                class="form-control text-center" readonly id="capacity{{ $key }}"></th>
                                            <th><input type="text" value="{{ $item->supplier_name }}"
                                                    class="form-control text-center" readonly id="supplier{{ $key }}"></th>
                                            <th><input type="text" value="{{ $item->item_quantity }}"
                                                    class="form-control text-center" readonly id="quantity{{ $key }}"></th>
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
                                                <select data-toggle="select2" title="Cell" id="cell{{ $key }}" onchange="dispatchCell(this.value, {{ $key }})"
                                                    name="cell[]" disabled>
                                                    <option value="">Ô</option>
                                                </select>
                                            </th>
                                            {{-- <th>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="visually-hidden">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"><input type="number" value="1" min="1" max="10000" class="form-control text-center"></a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" type="button" onclick="seprateRow({{ $key }})">Tách SL</a>
                                                    </div>
                                                </div>
                                            </th> --}}
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
                            let visible = (total + (capacity_value * quantity_value)) <= item.cell_capacity ? true : false;
                            $('#cell' + key).append(`<option value="${item.id}" data-capacity="${total}" ${visible ? '' : 'disabled'}>${item.cell_name} (${total}/${item.cell_capacity})</option>`)
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
                if(cell_capacity <= capacity_value * quantity_value) {
                    cell_selected.push({
                        'id' : id,
                        'capacity' : capacity_value *  quantity_value
                    });
                } else {
                    alert('Không đủ không gian để chứu vật tư');
                }
            } else {
            }
            console.log(cell_selected);
        }

        function seprateRow(key) {
            let id = $('#id' + key).val();
            let random = (Math.floor(Math.random() * 1000)).toString();
            let name = 'name' + key + '_' + random;
            let name_value = $('#name' + key).val();
            let capacity = 'capacity' + key + '_' + random;
            let capacity_value = $('#capacity' + key).val();
            let supplier = 'supplier' + key + '_' + random;
            let supplier_value = $('#supplier' + key).val();
            let quantity = 'quantity' + key + '_' + random;
            let quantity_value = $('#quantity' + key).val();
            let shelf = 'shelf' + key + '_' + random;
            let floor = 'floor' + key + '_' + random;
            let cell = 'cell' + key + '_' + random;
            let html = `<tr id="row${key + '_' + random}">
                <td><input type="text" value="${name_value}"
                        class="form-control text-center" readonly id="${name}">
                    <input type="text" value="${id}" name="id[]"
                        class="form-control text-center" hidden>
                </td>
                <th><input type="text" value="${capacity_value}"
                    class="form-control text-center" readonly id="${capacity}"></th>
                <th><input type="text" value="${supplier_value}"
                        class="form-control text-center" readonly id="${supplier}"></th>
                <th><input type="text" value="${quantity_value}"
                        class="form-control text-center" readonly id="${quantity}"></th>
                <th>
                    <select data-toggle="select2" title="Shelf" id="${shelf}"
                        name="shelf[]" onchange="dispatchShelf(this.value, ${key + '_' + random});">
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
                    <select data-toggle="select2" title="Floor" id="${floor}" onchange="dispatchFloor(this.value, ${key + '_' + random});"
                        name="floor[]" disabled>
                    </select>
                </th>
                <th>
                    <select data-toggle="select2" title="Cell" id="${cell}"
                        name="cell[]" disabled>
                        <option value="">Ô</option>
                    </select>
                </th>
                <th>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item"><input type="number" value="1" min="1" max="10000" class="form-control text-center"></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" type="button" onclick="seprateRow(${key + '_' + random})">Tách SL</a>
                        </div>
                    </div>
                </th>
            </tr>`;
            $('#row' + key).after(html);
        }
    </script>
@endsection
