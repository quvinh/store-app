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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
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
                        <form class="needs-validation" novalidate action="{{ route('ex_import.imstore') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col s6">
                                    <input type="text" name="id" id="id" hidden>
                                    <div class="mb-3">
                                        <label for="item_name" class="form-label">Vật tư/Phụ tùng:</label>
                                        <input type="text" name="item_name" id="item_name" class="form-control"
                                            placeholder="Vật tư/Phụ tùng" aria-describedby="helpId">
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="mb-3">
                                        <label for="item_code" class="form-label">Mã vật tư:</label>
                                        <input type="text" name="item_code" id="item_code" class="form-control"
                                            placeholder="Mã vật tư" aria-describedby="helpId">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <div class="mb-3">
                                        <label for="category">Loại vật tư:</label>
                                        <select data-toggle="select2" title="Category" id="category" name="category"
                                            class="form-control">
                                            <option value=""></option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="mb-3">
                                        <label for="supplier">Nhà sản xuất:</label>
                                        <select data-toggle="select2" title="Supplier" id="supplier" name="supplier"
                                            class="form-control">
                                            <option value=""></option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">
                                                    {{ $supplier->supplier_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-1">
                                                <label for="unit">Đơn vị tính:</label>
                                            </div>
                                            <select data-toggle="select2" title="Unit" id="unit" name="unit"
                                                class="form-control">
                                                <option value=""></option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->unit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <div class="">
                                                <label for="export_price" class="form-label">Đơn giá:</label>
                                                <input type="number" name="export_price" id="export_price"
                                                    class="form-control" placeholder="Đơn giá" aria-describedby="helpId">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col s6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-1">
                                                <label for="warehouse">Kho:</label>
                                            </div>
                                            <select data-toggle="select2" title="Warehouse" id="warehouse"
                                                name="warehouse" class="form-control">
                                                <option value=""></option>
                                                @foreach ($warehouses as $warehouse)
                                                    <option value="{{ $warehouse->id }}">
                                                        {{ $warehouse->warehouse_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col">
                                            <div class="mb-1">
                                                <label for="shelf">Giá/kệ:</label>
                                            </div>
                                            <select data-toggle="select2" title="Shelf" id="shelf" name="shelf"
                                                class="form-control">
                                                <option value=""></option>
                                                @foreach ($shelves as $shelf)
                                                    <option value="{{ $shelf->id }}">
                                                        {{ $shelf->shelf_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p></p>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="item_quantity" class="form-label">Số lượng:</label>
                                                <input type="number" name="item_quantity" id="item_quantity"
                                                    class="form-control" placeholder="Số lượng"
                                                    aria-describedby="helpId">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Còn lại:</label>
                                                <input type="number" name="quantity" id="quantity"
                                                    class="form-control" placeholder="Số lượng"
                                                    aria-describedby="helpId">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s6">
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="floor" class="form-label">Tầng:</label>
                                                <input type="text" name="floor" id="floor" class="form-control"
                                                    placeholder="Tầng" aria-describedby="helpId" disabled>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="cell" class="form-label">Ô:</label>
                                                <input type="text" name="cell" id="cell" class="form-control"
                                                    placeholder="Ô" aria-describedby="helpId" disabled>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-primary" id="btnAdd">Thêm</button>
                                <button type="button" class="btn btn-danger" id="btnCancel">Hủy</button>
                            </div>
                            <br>
                            <hr>
                            <br>
                            <table id="export-datatable" class="table dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Vật tư</th>
                                        <th>Mã vật tư</th>
                                        <th>Loại</th>
                                        <th>Đơn vị tính</th>
                                        <th>Kho</th>
                                        <th>Giá/Kệ</th>
                                        <th>Tầng</th>
                                        <th>Ô</th>
                                        <th>Nhà sản xuất</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
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

    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->
    <script>
        $(document).ready(function() {
            // $('#warehouse').on('change', function() {
            //     $('#warehouse').val($(this).val());
            // })
            let list = [];
            var i = 1;
            var items = <?php echo json_encode($items); ?>;
            $('#item_name').autocomplete({
                lookup: items,
                onSelect: function(event, ui) {
                    $("#item_name").val(ui.item.value);
                    $("#category").val(ui.item.category_id).trigger('change');
                    $("#unit").val(ui.item.item_unit).trigger('change');
                    $("#warehouse").val(ui.item.warehouse_id).trigger('change');
                    $("#supplier").val(ui.item.supplier_id).trigger('change');
                    $("#shelf").val(ui.item.shelf_id).trigger('change');
                    $("#floor").val(ui.item.floor_id);
                    $("#cell").val(ui.item.cell_id);
                    $("#quantity").val(ui.item.item_detail_quantity);
                    $("#item_code").val(ui.item.item_code);
                }

            });
            // .autocomplete("instance")._renderItem = function(ul, item) {
            //     return $("<li>")
            //         .append("<div>" + item.item_name +"&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;Loại vật tư:&nbsp;" +item.category_name+ "<br>" + "Số lượng:&nbsp;" + item.item_detail_quantity + " &nbsp;&nbsp;- &nbsp;&nbsp;Kho:&nbsp;"+ item.warehouse_name+"&nbsp;&nbsp; -&nbsp;&nbsp; Kệ:&nbsp;" +item.shelf_name+" &nbsp;&nbsp;- &nbsp;&nbsp;Tầng:&nbsp;"+item.floor_id+"&nbsp;&nbsp; -&nbsp;&nbsp; Ô:&nbsp;"+item.cell_id+"</div>")
            //         .appendTo(ul);
            // };
            // $("#item_name").data("ui-autocomplete")._trigger("change");
            $('#btnAdd').click(function() {
                var html = '';
                var item_name = $("#item_name").val();
                var id = $("#id").val();
                var item_code = $("#item_code").val();
                var category = $("#category option:selected").val();
                var category_id = $("#category").val();
                var unit = $("#unit option:selected").val();
                var unit_id = $("#unit").val();
                var warehouse = $("#warehouse option:selected").val();
                var warehouse_id = $("#warehouse").val();
                var supplier = $("#supplier option:selected").val();
                var supplier_id = $("#supplier").val();
                var shelf = $("#shelf option:selected").val();
                var shelf_id = $("#shelf").val();
                var floor = $("#floor").val();
                var cell = $("#cell").val();
                var quantity = $("#quantity").val();
                var item_quantity = $("#item_quantity").val();
                var price = $("#export_price").val();
                if (item_name !== '' && supplier !== '' && quantity > 0 && price > 0 && item_quantity > 0 &&
                    quantity >= item_quantity) {
                    list.push({
                        line: i,
                        item_id: id,
                        item_name: item_name,
                        item_code: item_code,
                        category_name: category,
                        category_id: category_id,
                        unit_name: unit,
                        unit_id: unit_id,
                        warehouse_name: warehouse,
                        warehouse_id: warehouse_id,
                        supplier_name: supplier,
                        supplier_id: supplier_id,
                        shelf_name: shelf,
                        shelf_id: shelf_id,
                        floor_id: floor,
                        cell_id: cell,
                        item_quantity: item_quantity,
                        item_price: price,
                    });

                    list.map((item, index) => {
                        html +=
                            `<tr>
                                <td><input type="text" name="item_id[]" value="${item.item_id}" hidden>${item.item_name }</td>
                                <td><input type="text" name="item_code[]" value="${item.item_code}" hidden>${item.item_code}</td>
                                <td><input type="text" name="category[]" value="${item.category_id}" hidden>${item.category_name}</td>
                                <td><input type="text" name="unit[]" value="${item.unit_id}" hidden>${item.unit_name}</td>
                                <td><input type="text" name="warehouse[]" value="${item.warehouse_id}" hidden>${item.warehouse_name}</td>
                                <td><input type="text" name="shelf[]" value="${item.shelf_id}" hidden>${item.shelf_name}</td>
                                <td><input type="text" name="floor[]" value="${item.floor_id}" hidden>${item.floor_id}</td>
                                <td><input type="text" name="cell[]" value="${item.cell_id}" hidden>${item.cell_id}</td>
                                <td><input type="text" name="supplier[]" value="${item.supplier_id}" hidden>${item.supplier_name}</td>
                                <td><input type="text" name="item_quantity[]" value="${item.item_quantity}" hidden>${item.item_quantity}</td>
                                <td><input type="text" name="item_price[]" value="${item.item_price}" hidden>${item.item_price}</td>
                            </tr>`
                    });
                    $('#quantity').val(quantity - item_quantity);
                    $('#item_quantity').val(0);
                    $('#list_export').html(html);
                    i++;
                }
            });
        });
    </script>
@endsection
