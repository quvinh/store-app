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
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> --}}
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> --}}
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <link href="{{ asset('assets/css/demo-autocomplete.css') }}" rel="stylesheet" type="text/css">
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
                            <li class="breadcrumb-item active">Tạo phiếu xuất</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Tạo phiếu xuất</h4>
                </div>
            </div>
        </div>
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
                        <form class="needs-validation" novalidate action="{{ route('export.exstore') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="text-sm-start">
                                        <a href="{{ route('export.index') }}" class="btn btn-primary mb-2 me-1"><i
                                                class="mdi mdi-backburger"></i> Back to list</a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-sm-end">
                                        <button type="submit" class="btn btn-success mb-2 me-1" id="save-list">Lưu</button>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col s6">
                                    <input type="text" name="id" id="id" hidden>
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
                                <div class="col s6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="item_quantity" class="form-label">Số lượng</label>
                                                <input class="form-control" id="item_quantity" data-toggle="touchspin"
                                                    value="0" type="text"
                                                    data-bts-button-down-class="btn btn-danger"
                                                    data-bts-button-up-class="btn btn-info"><br>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="export_price" class="form-label">Đơn giá:</label>
                                                <input type="number" name="export_price" id="export_price"
                                                    class="form-control" placeholder="Đơn giá" aria-describedby="helpId">
                                            </div>
                                            {{--  <div class="mb-3">
                                                <label for="quantity" class="form-label">Trong kho:</label>
                                                <input type="text" name="quantity" id="quantity"
                                                    class="form-control" aria-describedby="helpId" readonly>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col s6">
                                    <div class="mb-3">
                                        <label for="itemdetail_id" class="form-label">Vật tư/Phụ tùng:</label>
                                        <select data-toggle="select2" title="Item" id="itemdetail_id"
                                            name="item_detail">
                                            @foreach ($items as $item)
                                                <option value="{{ $item->itemdetails_id }}">
                                                    {{ $item->item_name }} - {{ $item->item_code }} - {{ $item->supplier_name }} - {{ $item->shelf_name }} - {{ $item->floor_id }} - {{ $item->cell_id }} - SL:{{ $item->item_detail_quantity }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="row">
                                        <div class="col">

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="text-sm-end">
                                    <button type="button" class="btn btn-primary" id="btnAdd">Thêm</button>

                                    <button type="button" class="btn btn-danger" id="destroy-list">Hủy</button>
                                </div>
                            </div>

                            <br>
                            <hr>
                            <br>
                            <table id="export-datatable" class="table dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Vật tư</th>
                                        <th>Mã vật tư</th>
                                        <th>Kho</th>
                                        <th>Giá/Kệ</th>
                                        <th>Tầng</th>
                                        <th>Ô</th>
                                        <th>Nhà sản xuất</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="list_export">
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

    {{-- <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->
    <script>
        let list = [];
        $(document).ready(function() {
            $('#warehouse').on('change', function() {
                document.getElementById("btnFilter").click();
            })
            $('#btnFilter').on('click', function() {
                var warehouse = $('#warehouse').val();
                window.location.href = (warehouse) ? ('?warehouse_id=' + warehouse) : '';
            })

            $('#btnAdd').click(function() {
                var html = '';
                var item_detail = $("#itemdetail_id").val();
                var warehouse_id = $('#warehouse').val();
                var item_name = $("#itemdetail_id option:selected").text().split(' - ')[0];
                var supplier_name = $("#itemdetail_id option:selected").text().split(' - ')[2];
                var item_code = $("#itemdetail_id option:selected").text().split(' - ')[1];
                var warehouse_name = $("#warehouse option:selected").text().split(' - ')[1];
                var shelf_name = $("#itemdetail_id option:selected").text().split(' - ')[3];
                var floor_id = $("#itemdetail_id option:selected").text().split(' - ')[4];
                var cell_id = $("#itemdetail_id option:selected").text().split(' - ')[5];
                var item_quantity = $("#item_quantity").val();
                var price = $("#export_price").val();

                if (item_name !== '' && supplier_name !== '' && item_quantity > 0 && price > 0) {
                    if (list.filter(item => item.id == item_detail).length > 0) {
                        var data = [...list];
                        var newdata = [];
                        list.map(item => {
                            if (item.id === parseInt(item_detail)) {
                                console.log(item.id, item.quantity, item.quantity + parseInt(
                                    item_quantity), item.price);
                                newdata.push(...data.filter(value => value.id !== item.id), {
                                    id: item.id,
                                    name: item.name,
                                    code: item.code,
                                    supplier_name: item.supplier_name,
                                    warehouse_name: item.warehouse_name,
                                    price: item.price,
                                    quantity: item.quantity + parseInt(item_quantity),
                                    floor_id: item.floor_id,
                                    cell_id: item.cell_id,
                                    shelf_name: item.shelf_name
                                    // warehouse_id: item.warehouse_id,
                                });
                            }
                        });
                        list = [...newdata];
                    } else {
                        list.push({
                            id: parseInt(item_detail),
                            name: item_name,
                            quantity: parseInt(item_quantity),
                            supplier_name: supplier_name,
                            warehouse_name: warehouse_name,
                            price: parseInt(price),
                            code: item_code,
                            shelf_name: shelf_name,
                            floor_id: floor_id,
                            cell_id: cell_id,
                            // warehouse_id: warehouse_id,
                        })
                        console.log(list);
                    }
                    list.map((item, index) => {
                        html += `<tr>
                                    <td>${parseInt(index + 1)}</td>
                                    <td>
                                        <span class="text-primary">${item.name}</span>
                                        <input name="itemdetail_id[]" value="${item.id}" hidden>
                                        <input name="warehouse_id" value="${warehouse_id}" hidden>
                                        <input name="item_quantity[]" value="${item.quantity}" hidden>
                                        <input name="export_price[]" value="${item.price}" hidden>
                                    </td>
                                    <td><b>${item.code}</b></td>
                                    <td><b>${item.warehouse_name}</b></td>
                                    <td><b>${item.shelf_name}</b></td>
                                    <td><b>${item.floor_id}</b></td>
                                    <td><b>${item.cell_id}</b></td>
                                    <td><b>${item.supplier_name}</b></td>
                                    <td><b>${item.quantity}</b></td>
                                    <td><b>${item.price}</b></td>
                                    <td class="table-action">
                                        <a type="button" class="action-icon text-warning" id="btn${item.id}" data-id="${item.id}" onclick="remove_button('btn${item.id}')"> <i
                                                class="mdi mdi-close-circle"></i></a>
                                    </td>
                                </tr>`;
                    })
                    $('#item_quantity').val(0);
                    // $('#export_price').val(0);
                    $('#export-datatable tbody').html(html);
                    $('#warehouse').attr('disabled', true);
                    $('#save-list').attr('disabled', false);
                } else {
                    alert('Chọn kho, phụ tùng và số lượng lớn hơn 0');
                }
                $('#destroy-list').on('click', function() {
                    $('#warehouse_from').attr('disabled', false);
                    $('#warehouse_to').attr('disabled', false);
                    $('#save-list').attr('disabled', true);
                    $('#export-datatable tbody').html('');
                    list = [];
                })
            })
        });

        function remove_button(id) {
            $('#' + id).closest('tr').remove();
            var getId = parseInt(id.replace('btn', ''));
            var data = [...list.filter(item => item.id !== getId)];
            list = [...data];
            if (list.length === 0) {
                $('#warehouse_from').attr('disabled', false);
                $('#warehouse_to').attr('disabled', false);
                $('#save-list').attr('disabled', true);
            }
        }
    </script>
@endsection
