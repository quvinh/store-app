@extends('admin.home.master')

@section('title')
    Add Transfer
@endsection

@section('css')
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <style>
        .separator {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #DDD;
        }

        .separator:not(:empty)::before {
            margin-right: .25em;
        }

        .separator:not(:empty)::after {
            margin-left: .25em;
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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Add Transfer</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Transfer</h4>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="custom-styles-preview">
                                <a href="{{route('transfer.index')}}" class="btn btn-info">Quay lại</a><br><br>
                                <form action="{{ route('transfer.store') }}" method="post">
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <div class="col-md-12 ms-1 me-1 mb-1">
                                                <label class="form-label">
                                                    <span class="text-danger">(*)</span> <span class="text-primary">Kho xuất
                                                        hàng</span>
                                                </label>
                                                <select class="form-control select2" data-toggle="select2"  onchange="filter()"
                                                    id="warehouse_from">
                                                    <option value="">Chọn kho xuất</option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}" {{app('request')->input('warehouse_id') == $warehouse->id ? 'selected' : ''}}>
                                                            {{ $warehouse->warehouse_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 ms-1 me-1 mb-1">
                                                <label class="form-label">
                                                    <span class="text-danger">(*)</span> <span class="text-primary">Kho nhận
                                                        hàng</span>
                                                </label>
                                                <select class="form-control select2" data-toggle="select2"
                                                    id="warehouse_to">
                                                    <option value="">Chọn kho nhận</option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">
                                                            {{ $warehouse->warehouse_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 ms-1 me-1 mb-1">
                                                <label class="form-label">Mô tả chung</label>
                                                <textarea class="form-control" id="example-textarea" rows="3" placeholder="Nhập mô tả..." name="transfer_note"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 ms-1 me-1 mb-1">
                                                <label class="form-label"><span class="text-danger">(*)</span> <span
                                                        class="text-primary">Phụ tùng</span></label>
                                                <select class="form-control select2" data-toggle="select2"
                                                    id="itemdetail_id">
                                                    <option value="">Chọn phụ tùng</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->itemdetail_id }}">{{ $item->item_name }}
                                                            - {{ $item->item_code }} - {{ $item->supplier_name }} -
                                                            {{ $item->shelf_name }} - Tầng {{ $item->floor_id }} - Ô
                                                            {{ $item->cell_id }} - SLKD:{{ $item->item_quantity[0] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 ms-1 me-1 mb-3">
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <label class="form-label" for="item_quantity"><span
                                                                class="text-danger">(*)</span> <span class="text-primary">Số
                                                                lượng</span></label>
                                                        <div class="mb-3">
                                                            <input class="form-control form-control-sm" id="item_quantity"
                                                                data-toggle="touchspin" value="0" type="text"
                                                                data-bts-button-down-class="btn btn-danger btn-sm"
                                                                data-bts-button-up-class="btn btn-info btn-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-1">
                                                        <label class="form-label">&nbsp;</label>
                                                        <div><button type="button" class="btn btn-sm btn-success"
                                                                id="add-row"><i class="mdi mdi-chevron-double-down"></i>
                                                                Thêm vào DS</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button type="button" class="btn btn-secondary" id="destroy-list"><i
                                                            class="mdi mdi-close-circle"></i> Xóa danh sánh</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">&nbsp;</label>
                                                    <button type="submit" class="btn btn-info" id="save-list"
                                                        disabled><i class="mdi mdi-content-save"></i> Xác nhận lưu</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator mb-2"><b class="text-dark">DANH SÁCH PHỤ TÙNG</b></div>
                                    {{-- LIST --}}
                                    <div class="mt-1 mb-3">
                                        <div class="row mb-1">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-8">
                                                <input type="text" name="warehouse_from" hidden>
                                                <input type="text" name="warehouse_to" hidden>
                                                <table class="table table-striped table-centered mb-0" id="list-item">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th style="width:70%;" title="Tên phụ tùng">Phụ tùng</th>
                                                            <th title="Số lượng">SL</th>
                                                            <th>Thao tác</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- end preview-->

                        </div> <!-- end tab-content-->

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script>
        let list = [];
        $(document).ready(function() {
            $('input[name="warehouse_from"]').val($('#warehouse_from').val());
            $('#warehouse_from').on('change', function() {
                $('input[name="warehouse_from"]').val($(this).val());
            })

            $('#warehouse_to').on('change', function() {
                $('input[name="warehouse_to"]').val($(this).val());
            })

            $('#add-row').on('click', function() {
                var html = '';
                var a = [],
                    b = [];
                var text = $("#itemdetail_id option:selected").text()
                var c = text.split('-');
                a = [...c.slice(4)];
                for (var val of a) {
                    b.push(val.replace(/\D/g, ' ').trim().replace(/\s+/g, ' '))
                }
                console.log('a', a); console.log('b', b); console.log('c', c);
                var from = $('#warehouse_from').val();
                var to = $('#warehouse_to').val();
                var item_detail = $('#itemdetail_id').val();
                var item_name = $('#itemdetail_id option:selected').text();
                var item_quantity = parseInt($('#item_quantity').val());
                if (from !== '' && to !== '' && item_detail !== '' && item_quantity > 0) {
                    if (list.filter(item => item.id == item_detail).length > 0) {
                        var data = [...list];
                        var newdata = [];
                        list.map(item => {
                            if (item.id === parseInt(item_detail) && item_quantity <= (b[2] - item
                                    .quantity)) {
                                console.log(item.id, item.quantity, item.quantity + parseInt(
                                    item_quantity));
                                newdata.push(...data.filter(value => value.id !== item.id), {
                                    id: item.id,
                                    name: item.name,
                                    quantity: item.quantity + parseInt(item_quantity),
                                });
                                list = [...newdata];
                            } else alert('Số lượng vượt quá số khả dụng.');
                        });
                    } else {
                        if (item_quantity <= b[2])
                            list.push({
                                id: parseInt(item_detail),
                                name: item_name,
                                quantity: parseInt(item_quantity),
                            })
                        else alert('Số lượng vượt quá số khả dụng.');
                    }
                    list.map((item, index) => {
                        html += `<tr>
                                    <td>${parseInt(index + 1)}</td>
                                    <td><span class="text-primary">${item.name}</span><input name="itemdetail_id[]" value="${item.id}" hidden><input name="item_quantity[]" value="${item.quantity}" hidden></td>
                                    <td><b>${item.quantity}</b></td>
                                    <td class="table-action">
                                        <a type="button" class="action-icon text-warning" id="btn${item.id}" data-id="${item.id}" onclick="remove_button('btn${item.id}')"> <i
                                                class="mdi mdi-close-circle"></i></a>
                                    </td>
                                </tr>`;
                    })
                    $('#item_quantity').val(0);
                    $('#list-item tbody').html(html);
                    // $('#warehouse_from').attr('disabled', true);
                    // $('#warehouse_to').attr('disabled', true);
                    $('#save-list').attr('disabled', false);
                } else {
                    alert('Chọn kho, phụ tùng và số lượng lớn hơn 0');
                }
            });

            $('#destroy-list').on('click', function() {
                $('#warehouse_from').attr('disabled', false);
                $('#warehouse_to').attr('disabled', false);
                $('#save-list').attr('disabled', true);
                $('#list-item tbody').html('');
                list = [];
            })
        });

        function remove_button(id) {
            $('#' + id).closest('tr').remove();
            var getId = parseInt(id.replace('btn', ''));
            var data = [...list.filter(item => item.id !== getId)];
            list = [...data];
            if (list.length === 0) {
                // $('#warehouse_from').attr('disabled', false);
                // $('#warehouse_to').attr('disabled', false);
                $('#save-list').attr('disabled', true);
            }
        }

        function filter() {
            var warehouseVal = $('#warehouse_from').val();
            const paramsObj = {
                warehouse_id: warehouseVal,
            };
            if (warehouseVal === '') delete paramsObj.warehouse_id;
            const searchParams = new URLSearchParams(paramsObj);
            let url = new URL(window.location.href);
            url.search = searchParams;
            window.location.href = url;
        }
    </script>
@endsection
