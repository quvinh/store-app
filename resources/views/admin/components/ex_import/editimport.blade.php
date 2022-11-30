@extends('admin.home.master')

@section('title')
    Sửa phiếu Nhập
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
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route, $im_items[0]->exim_id) }}
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('import.update', $im_items[0]->exim_id) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('ex_import.index') }}" class="btn btn-info">Quay lại</a>
                                </div>
                                <div class="col-6 text-end">
                                    @if ($im_items[0]->exim_status == 0)
                                        <!-- <button type="submit" class="btn btn-primary">Lưu</button> -->
                                    @endif

                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="" class="form-control">Người nhận</label><br>
                                    <label for="" class="form-control">Mã phiếu</label><br>
                                    <label for="" class="form-control">Trạng thái</label><br>
                                    <label for="" class="form-control">Người tạo</label><br>
                                    <label for="" class="form-control">Ghi chú</label><br>
                                </div>
                                <div class="col-9">
                                    <input type="text" hidden value="1" name="status">
                                    <input type="text" class="form-control" readonly value="{{ $import->receiver }}"><br>
                                    <input type="text" class="form-control" readonly value="{{ $import->exim_code }}"><br>
                                    <input type="text" class="form-control" readonly
                                    value="{{ $import->exim_status == 1 ? 'Đã duyệt' : ($import->exim_status == 2 ? 'Đã hủy' : 'Chưa duyệt') }}"><br>
                                    <input type="text" class="form-control" readonly value="{{ $import->name }}"><br>
                                    <input type="text" class="form-control" readonly value="{{ $import->note }}"><br>
                                </div>
                            </div>

                            <table class="table dt-responsive nowrap text-center">
                                {{-- <table id="basic-datatable" class="table dt-responsive nowrap w-100"> --}}
                                <thead>
                                    <tr>
                                        <th width="">Phụ tùng/ Vật tư</th>
                                        <th width="">Nhà cung cấp</th>
                                        <th width="10%">Số lượng</th>
                                        <th width="15%">Đơn giá</th>
                                        <th width="">Vị trí</th>
                                    </tr>
                                </thead>
                                <tbody id="list-import">
                                    @foreach ($im_items as $item)
                                        @php
                                            if($item->exim_status == 1) {
                                                $floor = DB::table('floors')->where('id', $item->floor_to)->first()->floor_name;
                                                $cell = DB::table('cells')->where('id', $item->cell_to)->first()->cell_name;
                                            } else {
                                                $floor = '-';
                                                $cell = '-';
                                            }
                                        @endphp
                                        <tr class="text-center">
                                            <td hidden><input type="text" name="id[]" value="{{ $item->id }}">
                                            </td>
                                            <td>{{ $item->item }}</td>
                                            <th>{{ $item->supplier_name }}</th>
                                            <th><input type="number" name="quantity[]" value="{{ $item->item_quantity }}" readonly
                                                    class="form-control" id="quantity"></th>
                                            <th><input type="text" name="price[]" value="{{ $item->item_price }}" readonly
                                                    data-toggle="input-mask" data-mask-format="000.000.000.000.000"
                                                    data-reverse="true" class="form-control" id="price"></th>
                                            <th>{{ $floor }}, {{ $cell }}</th>
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
@endsection
