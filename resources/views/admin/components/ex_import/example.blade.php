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
                        <div class="table-responsive">
                            <form method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="id">ID:</label>
                                    <input type="text" class="form-control" name="id" id="id"
                                        aria-describedby="helpId" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        aria-describedby="helpId" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <input type="text" class="form-control" name="note" id="note"
                                        aria-describedby="helpId" placeholder="">
                                </div>

                                <div class="mb-3">
                                    <label for="warehouse" class="form-label">Warehouse</label>
                                    <select class="form-select form-select-lg" name="warehouse" id="warehouse">
                                        <option selected disabled>Select one</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select form-select-lg" name="shelf" id="shelf"></select>
                                </div>
                                <div class="mb-3" id="id_shelf"></div>
                                <br>
                                <button type="button" name="btn1" id="btn1" class="btn btn-success">Thêm
                                    mới</button>
                            </form>
                            <br>
                            <hr>
                            <br>
                            <ul id="list">

                            </ul>
                            {{-- <table id="table1" class="table table-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Note</th>
                                    </tr>
                                </thead>
                                <tbody id="list">

                                </tbody>
                            </table> --}}
                        </div>


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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- third party js ends -->
    {{-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js"> --}}
    {{-- </script> --}}
    <!-- demo app -->
    {{-- <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            $(function() {
                var html = '';
                $('#btn1').click(function() {
                    var _id = $('#id').val();
                    var _name = $('#name').val();
                    var _note = $('#note').val();
                    html += '<li><p>' + _id + '</p><p>' + _name + '</p><p>' + _note + '</p></li>'
                    // $('#list').append(
                    //     '<li><p>'+_id+'</p><p>'+_name+'</p><p>'+_note+'</p></li>'
                    // )
                    // var _tr = '<tr><td>' + _id + '</td><td>' + _name + '</td><td>' +
                    //     _note '</td></tr>';alert(_tr);
                    // $('#table1 tbody').append(_tr);
                })
            })
            $('#warehouse').on('change', function() {
                var warehouseId = this.value;
                $('#shelf').html('');
                $.ajax({
                    url: '{{ route('get-shelf') }}?warehouse_id=' + warehouseId,
                    type: 'get',
                    success: function(res) {
                        console.log(res);
                        $('#shelf').html('<option value="">Select</option>');
                        $.each(res, function(key, value) {
                            console.log(value.id);
                            $('#shelf').append('<option value="' + value.id + '">' + value.shelf_name + '</option>');
                        });

                    }
                })
            })
        })
    </script>
    <!-- end demo js-->
@endsection
