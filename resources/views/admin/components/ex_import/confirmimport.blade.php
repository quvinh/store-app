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
                        <a href="{{route('ex_import.index')}}" class="btn btn-info">Quay lại</a><br><br>
                        <form class="needs-validation" novalidate action="{{ route('import.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col s6">
                                    <input type="text"id="id" hidden>
                                    <div {{ count($warehouses) > 1 ? '' : 'hidden' }}>
                                        <select data-toggle="select2" title="Warehouse" id="warehouse">
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}">
                                                    {{ $warehouse->warehouse_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <br>
                                    </div>

                                    <label for="item">Tên vật tư</label>
                                    <input id="item" class="form-control"><br>
                                    <label for="code">Mã vật tư</label>
                                    <input type="text" id="code" class="form-control"><br>

                                    <div class="row">
                                        <div class="col s6">
                                            <label for="quantity">Số lượng</label>
                                            <input class="form-control" id="quantity" data-toggle="touchspin"
                                                value="0" type="text" data-bts-button-down-class="btn btn-danger"
                                                data-bts-button-up-class="btn btn-info"><br>
                                        </div>
                                        <div class="col s6">
                                            <label for="price">Giá nhập</label>
                                            <input type="text" value="0" class="form-control" id="price">
                                        </div>
                                    </div>


                                </div>
                                <div class="col s6">
                                    <div><label for="supplier">Nhà cung cấp</label>
                                        <select data-toggle="select2" title="Supplier" id="supplier">
                                            <option value="">Chọn nhà cung cấp</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">
                                                    {{ $supplier->supplier_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div><label for="category">Loại vật tư</label>
                                        <select data-toggle="select2" title="Category" id="category">
                                            <option value="">Chọn loại vật tư</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div><label for="unit">Đơn vị tính</label>
                                        <select data-toggle="select2" title="Supplier" id="unit">
                                            <option value="">Chọn đơn vị tính</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">
                                                    {{ $unit->unit_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>

                                </div>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-info mb-2" id="btnAdd" type="button"><i
                                        class="mdi mdi-chevron-double-down"></i> Thêm vào danh
                                    sách</button>
                                <button class="btn btn-danger mb-2" id="btnDelete" type="button"><i
                                        class="mdi mdi-close-circle"></i> Hủy danh
                                    sách</button>
                                <button class="btn btn-success mb-2" id="btnSave" type="submit" disabled><i
                                        class="mdi mdi-content-save"></i>
                                    Lưu</button>
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
        $(document).ready(function() {

        });
    </script>
@endsection
