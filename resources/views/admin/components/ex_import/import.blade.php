@extends('admin.home.master')

@section('title')
    Import
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
                            <li class="breadcrumb-item active">Danh mục vật tư</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Danh mục vật tư</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate action="{{ route('ex_import.imstore') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <table class="table dt-responsive nowrap">
                                {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                <thead>
                                    <tr>
                                        <th width="15%">Phụ tùng/ Vật tư</th>
                                        <th width="15%">Mã phụ tùng/ Vật tư</th>
                                        <th width="15%">Nhà cung cấp</th>
                                        <th width="15%">Loại phụ tùng/ vật tư</th>
                                        <th width="10%">Đơn vị tính</th>
                                        <th width="10%">Số lượng</th>
                                        <th width="10%">Đơn giá</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="list-import">
                                    <tr id="tr1">
                                        <td hidden><input type="text" name="id[]" id="id1"></td>
                                        <td>
                                            <input id="item1" class="form-control" name="item[]">
                                        </td>

                                        <td>
                                            <input type="text" id="code1" class="form-control" name="code[]">
                                        </td>

                                        <td>
                                            <select data-toggle="select2" title="Supplier" id="supplier1" name="supplier[]">
                                                <option value=""></option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">
                                                        {{ $supplier->supplier_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select data-toggle="select2" title="Category" id="category1" name="category[]">
                                                <option value=""></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <select data-toggle="select2" title="Supplier" id="unit1" name="unit[]">
                                                <option value=""></option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->unit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" min="1" id="quantity1" name="quantity[]"
                                                value="" class="form-control"></td>
                                        <td><input type="text" value="0" class="form-control"id="price"
                                                name="price[]"></td>
                                        <td><button class="btn btn-danger" id="cancel1">Hủy</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-end">
                                <button class="btn btn-info mb-2" id="btnAdd">Thêm mới</button>
                                <button class="btn btn-success mb-2" type="submit">Lưu</button>
                            </div>

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
        $(function() {
            var items = <?php echo json_encode($items); ?>;
            $('#item1').autocomplete({
                lookup: items,
                onSelect: function(suggestion) {
                    $("#item1").val(suggestion.value);
                    $("#id1").val(suggestion.id);
                    $("#code1").val(suggestion.item_code);
                    $("#category1").val(suggestion.category_id).trigger('change');
                    $("#supplier1").val(suggestion.supplier_id).trigger('change');
                    $("#unit1").val(suggestion.item_unit).trigger('change');
                }
            });
        });
    </script>
@endsection
