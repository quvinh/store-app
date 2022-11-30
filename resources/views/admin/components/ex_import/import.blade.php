@extends('admin.home.master')

@section('title')
    Nhập vật tư
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
        {{ Breadcrumbs::render($route) }}
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('ex_import.index') }}" class="btn btn-info">Quay lại</a><br><br>
                        <form class="needs-validation" novalidate action="{{ route('import.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col s6">
                                    <input type="text"id="id" hidden>
                                    <div {{ count($warehouses) > 1 ? '' : 'hidden' }}>
                                        <label for="warehouse">Kho</label>
                                        <select data-toggle="select2" title="Warehouse" id="warehouse">
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}"
                                                    {{ app('request')->input('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                    {{ $warehouse->warehouse_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <br><input type="button" class="btn btn-success" value="Filter" id="btnFilter"
                                            hidden><br>
                                    </div>
                                    <label for="item">Tên vật tư</label>
                                    <input id="item" class="form-control"><br>

                                    <div><label for="category">Loại vật tư</label>
                                        <select data-toggle="select2" title="Category" id="category">
                                            <option value="">Chọn loại vật tư</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div><br>

                                    <div class="row">
                                        <div class="col s6">
                                            <label for="quantity">Số lượng</label>
                                            <input class="form-control" id="quantity" data-toggle="touchspin"
                                                value="0" type="text" data-bts-button-down-class="btn btn-danger"
                                                data-bts-button-up-class="btn btn-info"><br>
                                        </div>
                                        <div class="col s6">
                                            <label for="price">Giá nhập</label>
                                            <input type="text" value="100000" data-toggle="input-mask"
                                                data-mask-format="000.000.000.000.000" data-reverse="true"
                                                class="form-control" id="price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div><label for="supplier">Nhà cung cấp</label>
                                        <select data-toggle="select2" title="Supplier" id="supplier"
                                            onchange="changeSupplier(this.selectedOptions[0].getAttribute('data-code'))">
                                            <option value="">Chọn nhà cung cấp</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    data-code="{{ $supplier->supplier_code }}">
                                                    {{ $supplier->supplier_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <label for="code">Mã nhà cung cấp</label>
                                    <input type="text" id="supplier_code" class="form-control" readonly>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div><label for="unit">Đơn vị tính</label>
                                                <select data-toggle="select2" title="Unit" id="unit"
                                                    onchange="changeUnit(this.selectedOptions[0].getAttribute('data-amount'))">
                                                    <option value="">Chọn đơn vị tính</option>
                                                    {{-- @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}" data-amount="{{ $unit->unit_amount }}">
                                                            {{ $unit->unit_name }}
                                                        </option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="unit_amount">SL(bóc tách <span
                                                    id="unit_nameamount"></span>)</label>
                                            <input type="number" min="1" max="1000000" value=""
                                                class="form-control" id="unit_amount">
                                        </div>
                                    </div><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="note">Ghi chú</label>
                                    <textarea class="form-control" id="example-textarea" rows="3" placeholder="Nhập ghi chú..." name="note"></textarea>
                                </div>
                                <div class="col">
                                    <div class="row mb-3">
                                        <label for="receiver">Người nhận:</label>
                                        <select data-toggle="select2" title="receiver" id="receiver" name="receiver">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ app('request')->input('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col text-sm-end">
                                        <button class="btn btn-info" id="btnAdd" type="button"><i
                                                class="mdi mdi-chevron-double-down"></i> Thêm vào phiếu</button>
                                        <button type="button" class="btn btn-danger" id="destroy-list"><i
                                                class="mdi mdi-close-circle"></i> Hủy phiếu</button>
                                        <button type="submit" class="btn btn-success" id="save-list" disabled><i
                                                class="mdi mdi-content-save"></i> Lưu phiếu</button>
                                    </div>
                                </div>
                            </div>

                            <table class="table dt-responsive nowrap text-center">
                                {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                <thead>
                                    <tr>
                                        <th width="15%">Phụ tùng/ Vật tư</th>
                                        <th width="13%" {{ count($warehouses) > 1 ? '' : 'hidden' }}>Nhập kho</th>
                                        <th width="12%">Mã Nhà cung cấp</th>
                                        <th width="15%">Nhà cung cấp</th>
                                        <th width="12%">Loại phụ tùng/ vật tư</th>
                                        <th width="8%">Đơn vị tính</th>
                                        <th width="10%">Số lượng</th>
                                        <th width="10%">Đơn giá</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="list-import">

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
        let list = [];
        var i = 1;
        $(document).ready(function() {
            $('#warehouse').on('change', function() {
                document.getElementById("btnFilter").click();
            })
            $('#btnFilter').on('click', function() {
                var warehouse = $('#warehouse').val();
                window.location.href = (warehouse) ? ('?warehouse_id=' + warehouse) : '';
            })
            var items = <?php echo json_encode($items); ?>;
            $('#item').autocomplete({
                lookup: items,
                onSelect: function(suggestion) {
                    $("#item").val(suggestion.value);
                    $("#id").val(suggestion.id);
                    $("#code").val(suggestion.item_code);
                    $("#category").val(suggestion.category_id).trigger('change');
                    $("#category").attr('disabled', true);
                    // $("#unit").val(suggestion.item_unit).trigger('change');
                    $("#unit").html('');
                    $("#unit_amount").val(1)

                    let units = suggestion.unit;
                    console.log(units)
                    units.map((item, index) => {
                        if (index == 0) {
                            $("#unit_nameamount").text(`theo ${item[0]}`);
                        }
                        $("#unit").append(
                            `<option value="${index}" data-amount="${item[1]}" ${ index == 0 ? 'selected' : ''}>${item[0]}</option>`
                        );
                    })
                }
            });
            $('#btnAdd').on('click', function() {
                var html = '';
                var name = $("#item").val();
                var id = $("#id").val();
                var code = $("#code").val();
                var category_id = $("#category").val();
                var category = $("#category option:selected").text();
                var unit_id = $("#unit").val();
                var unit = $("#unit option:selected").text();
                var price = $("#price").val().replaceAll('.', '');
                var quantity = parseInt($("#quantity").val()) * parseInt($("#unit_amount").val());
                var supplier_id = $("#supplier").val();
                var supplier_code = $("#supplier_code").val();
                var supplier = $("#supplier option:selected").text();
                var warehouse_id = parseInt($("#warehouse").val());
                var warehouse = $("#warehouse option:selected").text();
                var receiver = $("#receiver").val();
                var receiver_name = $("#receiver option:selected").text();
                var note = $("#note").val();
                if (name !== '' && unit_id !== '' && supplier_id !== '' && price > 0 && quantity > 0) {
                    // if (list.filter(item => item.id === id && item.supplier_id === supplier_id).length > 0)
                    // {
                    //     var data = [...list];
                    //     var newData = [];
                    //     list.map(item => {
                    //         console.log('data'+i,data.filter(value => (value.id !== item.id && value.supplier_id !== item.supplier_id)));
                    //         console.log('t/f'+i,(item.id == parseInt(id) && item.supplier_id == parseInt(supplier_id)));
                    //         if (item.id == parseInt(id) && item.supplier_id == parseInt(supplier_id)) {
                    //             newData.push(...data.filter(value => (value.id !== item.id && value.supplier_id === item.supplier_id)), {
                    //                 line: item.line,
                    //                 id: item.id,
                    //                 name: item.name,
                    //                 quantity: item.quantity + parseInt(quantity),
                    //                 code: item.code,
                    //                 unit: item.unit,
                    //                 unit_id: item.unit_id,
                    //                 price: item.price,
                    //                 supplier: item.supplier,
                    //                 supplier: item.supplier,
                    //                 warehouse: item.warehouse,
                    //                 warehouse_id: item.warehouse_id,
                    //                 category: item.category,
                    //                 category_id: item.category_id,
                    //             });
                    //             console.log('new', newData);
                    //         }
                    //     })
                    //     list = [...newData];
                    //     console.log(' += ',list);

                    // } else {
                    list.push({
                        line: i,
                        id: id,
                        name: name,
                        quantity: quantity,
                        code: code,
                        unit: unit,
                        unit_id: unit_id,
                        price: price,
                        supplier: supplier,
                        supplier_id: supplier_id,
                        supplier_code: supplier_code,
                        warehouse: warehouse,
                        warehouse_id: warehouse_id,
                        category: category,
                        category_id: category_id,
                    });
                    // }
                    list.map((item, index) => {
                        console.log('re', receiver);
                        html += `<tr>
                                        <th><input type="text" name="id[]" value="${item.id}" hidden>${item.name}</th>
                                        <th {{ count($warehouses) > 1 ? '' : 'hidden' }}><input type="text"
                                                name="warehouse[]" value="${item.warehouse_id}" hidden>${item.warehouse}</th>
                                        <th hidden><input name="receiver" value="${receiver}" hidden>
                                            <input name="note" value="${note}" hidden></th>
                                        <th><input type="text" name="code[]" value="${item.supplier_code}" hidden>${item.supplier_code}</th>
                                        <th><input type="text" name="supplier[]" value="${item.supplier_id}" hidden>${item.supplier}</th>
                                        <th><input type="text" name="category[]" value="${item.category_id}" hidden>${item.category}</th>
                                        <th><input type="text" name="unit[]" value="${item.unit_id}" hidden>${item.unit}</th>
                                        <th><input type="text" name="quantity[]" value="${item.quantity}" hidden>${item.quantity}</th>
                                        <th><input type="text" name="price[]" value="${item.price}" hidden>${item.price} VND</th>
                                        <th class="table-action"><a type="button" class="action-icon text-warning"
                                                id="btn${item.line}" data-id="${item.id}"
                                                onclick="remove('btn${item.line}')"><i class="mdi mdi-close-circle"></i></a></th>
                                    </tr>`
                    });
                    $('#quantity').val(0);
                    $('#supplier').val('').trigger('change');
                    $('#list-import').html(html);
                    $('#save-list').attr('disabled', false);
                    $("#category").attr('disabled', false);
                    $('#warehouse').attr('disabled', true);
                    $('#unit').html('');
                    $('#item').val('');
                    $('#unit_amount').val(1);
                    $('#unit_nameamount').text('');
                    $('#receiver').attr('disabled', true)
                    i++;
                } else {
                    alert('Chọn tên, ĐVT, nhà cung cấp và số lượng, giá nhập lớn hơn 0');
                }
            })
            $('#destroy-list').on('click', function() {
                $('#save-list').attr('disabled', true);
                $('#list-import').html('');
                i = 1;
                list = [];
                $("#item").val('');
                $("#id").val('');
                $("#code").val('');
                $("#category").val('').trigger('change');
                $("#category").attr('disabled', false);
                $('#warehouse').attr('disabled', false);
                $("#unit").val('').trigger('change');
                $("#price").val(0);
                $("#quantity").val(0);
                $("#supplier").val('').trigger('change');
                $("#warehouse").val('').trigger('change');
            })
        });

        function remove(id) {
            $('#' + id).closest('tr').remove();
            var getId = parseInt(id.replace('btn', ''));
            console.log(getId);
            var data = [...list.filter(item => item.line !== getId)];
            console.log(data);
            list = [...data];
            if (list.length === 0) {
                $('#save-list').attr('disabled', true);
                $('$receiver').attr('readonly', false);
                $("#category").attr('disabled', false);
                $('#warehouse').attr('disabled', false);
            }
        }

        function changeSupplier(value) {
            $('#supplier_code').val(value);
        }

        function changeUnit(value) {
            $('#unit_amount').val(value);
        }
    </script>
@endsection
