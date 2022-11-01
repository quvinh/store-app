@extends('admin.home.master')

@section('title')
    Adjust
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
    {{-- <link href="{{ asset('assets/css/demo-autocomplete.css') }}" rel="stylesheet" type="text/css"> --}}
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
                        <form class="needs-validation" novalidate action="{{ route('inventory.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div id="participants"></div>
                            <div class="row">
                                <div class="col">
                                    <div class="text-sm-start">
                                        <a href="{{ route('inventory.index') }}" class="btn btn-primary mb-2 me-1"><i
                                                class="mdi mdi-backburger"></i> Back</a>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="text-sm-end">
                                        <button type="submit" class="btn btn-success mb-2 me-1" disabled
                                            id="save-list">Lưu</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
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
                                <div class="col"></div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="itemdetail_id" class="form-label">Vật tư/Phụ tùng:</label>
                                        <select data-toggle="select2" title="Item" id="itemdetail_id" name="item_detail">
                                            @foreach ($items as $item)
                                                <option value="{{ $item->itemdetail_id }}">
                                                    {{ $item->item_name }} - {{ $item->item_code }} - {{ $item->supplier_name }} - {{ $item->shelf_name }} - Tằng ID:{{ $item->floor_id }} - Ô ID:{{ $item->cell_id }} - SL:{{ $item->item_detail_quantity }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="item_quantity" class="form-label">Số lượng thực tế:</label>
                                        <input class="form-control" id="item_quantity" data-toggle="touchspin"
                                            value="0" type="number" data-bts-button-down-class="btn btn-danger"
                                            data-bts-button-up-class="btn btn-info"><br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="select2">Người tham gia:</label>
                                    <select data-toggle="select2" name="people[]" id="people" multiple required>
                                        @foreach ($user as $user)
                                            <option value="{{ $user->name }}">{{ $user->id }} -
                                                {{ $user->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="inventory_note" class="form-label">Mô tả:</label>
                                        <input type="text" class="form-control" name="" id="inventory_note"
                                            aria-describedby="helpId" placeholder="Nhập mô tả">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-sm-end">
                                        <button type="button" class="btn btn-primary" id="btnAdd">Thêm</button>

                                        <button type="button" class="btn btn-danger" id="destroy-list">Hủy</button>
                                    </div>
                                </div>
                                <br><br>
                                <table id="inventory-datatable" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Vật tư</th>
                                            <th>Nhà sản xuất</th>
                                            <th>Kho</th>
                                            <th>Giá/Kệ</th>
                                            <th>Tầng</th>
                                            <th>Ô</th>
                                            <th>Số lượng</th>
                                            <th>Số lượng thực tế</th>
                                            <th>Hao tổn</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
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

    <script>
        let list = [];
        $(document).ready(function() {
            $('#people').on('change', function() {
                var participants = ''
                var people = $('#people option:selected').text().toString();
                participants += `<input name="people" value="${people}" hidden>`
                $('#participants').html(participants);

            });
            $('#warehouse').on('change', function() {
                document.getElementById("btnFilter").click();
            })
            $('#btnFilter').on('click', function() {
                var warehouse = $('#warehouse').val();
                window.location.href = (warehouse) ? ('?warehouse_id=' + warehouse) : '';
            })
            $('#btnAdd').on('click', function() {
                var a = [],
                    b = [];
                var html = '';
                var text = $("#itemdetail_id option:selected").text();
                var c = text.split('-');
                a = [...c.slice(4)];
                for (var val of a) {
                    b.push(val.replace(/\D/g, ' ').trim().replace(/\s+/g, ' '))
                }
                var item_detail = $("#itemdetail_id").val();
                var warehouse_id = $('#warehouse').val();
                var item_name = text.split(' - ')[0];
                var supplier_name = text.split(' - ')[2];
                var item_code = text.split(' - ')[1];
                var warehouse_name = $("#warehouse option:selected").text().split(' - ')[1];
                var shelf_name = text.split(' - ')[3];
                var floor_id = b[0];
                var cell_id = b[1];
                var item_valid = b[2];

                console.log(floor_id, item_valid)
                var item_quantity = $("#item_quantity").val();
                if (item_name !== '' && supplier_name !== '' && item_quantity > 0) {
                    if (list.filter(item => item.id == item_detail).length > 0) {
                        var data = [...list];
                        var newdata = [];
                        list.map(item => {
                            if (item.id === parseInt(item_detail)) {
                                console.log(item.id, item.quantity, item.quantity + parseInt(
                                    item_quantity));
                                newdata.push(...data.filter(value => value.id !== item.id), {
                                    id: item.id,
                                    name: item.name,
                                    code: item.code,
                                    supplier_name: item.supplier_name,
                                    warehouse_name: item.warehouse_name,
                                    quantity: item.quantity + parseInt(item_quantity),
                                    floor_id: item.floor_id,
                                    cell_id: item.cell_id,
                                    shelf_name: item.shelf_name,
                                    item_valid: item.item_valid
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
                            code: item_code,
                            shelf_name: shelf_name,
                            floor_id: floor_id,
                            cell_id: cell_id,
                            item_valid: item_valid,
                            // warehouse_id: warehouse_id,
                        })
                        console.log(list);
                    }
                    list.map((item, index) => {
                        html += `<tr>
                                    <td>${parseInt(index + 1)}</td>
                                    <td>
                                        <span style="color: blue">${item.name}</span>
                                        <input name="itemdetail_id[]" value="${item.id}" hidden>
                                        <input name="warehouse_id" value="${warehouse_id}" hidden>
                                        <input name="item_difference[]" value="${parseInt(item.item_valid) - parseInt(item.quantity)}" hidden>
                                        <input name="item_valid[]" value="${item.item_valid}" hidden>
                                    </td>
                                    <td><b>${item.supplier_name}</b></td>
                                    <td><b>${item.warehouse_name}</b></td>
                                    <td><b>${item.shelf_name}</b></td>
                                    <td><b>${item.floor_id}</b></td>
                                    <td><b>${item.cell_id}</b></td>
                                    <td><b>${item.item_valid}</b></td>
                                    <td><b>${item.quantity}</b></td>
                                    <td><b style="color: red">${parseInt(item.item_valid) - parseInt(item.quantity)}</b></td>
                                    <td class="table-action">
                                        <a type="button" class="action-icon text-warning" id="btn${item.id}" data-id="${item.id}" onclick="remove_button('btn${item.id}')"> <i
                                                class="mdi mdi-close-circle"></i></a>
                                    </td>
                                </tr>`;
                    })
                    $('#item_quantity').val(0);
                    // $('#export_price').val(0);
                    $('#inventory-datatable tbody').html(html);
                    $('#warehouse').attr('disabled', true);
                    $('#save-list').attr('disabled', false);
                } else {
                    alert('Chọn kho, phụ tùng và số lượng lớn hơn 0');
                }
                $('#destroy-list').on('click', function() {
                    $('#warehouse').attr('disabled', false);
                    $('#save-list').attr('disabled', true);
                    $('#inventory-datatable tbody').html('');
                    list = [];
                })
            })

            // $("#inventory-datatable").DataTable({
            //     language: {
            //         paginate: {
            //             previous: "<i class='mdi mdi-chevron-left'>",
            //             next: "<i class='mdi mdi-chevron-right'>"
            //         },
            //         info: "Showing export _START_ to _END_ of _TOTAL_",
            //         lengthMenu: 'Display <select class="form-select form-select-sm ms-1 me-1"><option value="50">50</option><option value="100">100</option><option value="200">200</option><option value="-1">All</option></select>'
            //     },
            //     pageLength: 50,
            //     columns: [{
            //         orderable: !0
            //     }, {
            //         orderable: !0
            //     }, {
            //         orderable: !0
            //     }, {
            //         orderable: !1
            //     }, {
            //         orderable: !1
            //     }, {
            //         orderable: !1
            //     }, {
            //         orderable: !1
            //     }, {
            //         orderable: !1
            //     }, {
            //         orderable: !1
            //     }, {
            //         orderable: !1
            //     }],
            //     select: {
            //         style: "multi"
            //     },
            //     // order: [
            //     //     [1, "asc"]
            //     // ],
            //     drawCallback: function() {
            //         $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(
            //             "#inventory-datatable_length label").addClass("form-label")
            //     },
            // })
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
    <!-- third party js ends -->
@endsection
