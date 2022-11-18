@extends('admin.home.master')

@section('title')
    Sửa vật tư
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
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
        {{ Breadcrumbs::render($route, $item->id) }}
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col s2">
                                <a href={{ route('item.index') }} class="btn btn-info">Quay lại</a>
                            </div>
                        </div>
                        <hr>

                        <form class="needs-validation" novalidate action="{{ route('item.update', $item->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <div class="col s12 m6 l6">
                                    <div class="row mb-2">
                                        <div class="col s6">
                                            <label class="form-label" for="item_name">Tên vật tư:</label>
                                            <input type="text" class="form-control" id="item_name"
                                                placeholder="Tên vật tư" required="" name="item_name"
                                                value="{{ $item->item_name }}">
                                            <div class="invalid-feedback">
                                                Vui lòng nhập tên vật tư.
                                            </div>
                                        </div>
                                        <div class="col s6">
                                            <label for="category" class="mb-1">Loại vật tư</label>
                                            <select data-toggle="select2" title="Category" id="category" name="category">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $item->category_id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @foreach ($units as $unit)
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="unit_name">Đơn vị tính</label>
                                                <input type="text" class="form-control" id="unit_name"
                                                    value="{{ $unit->unit_name }}" placeholder="Đơn vị tính" required=""
                                                    name="unit_name[]">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập ĐVT.
                                                </div>
                                            </div>
                                            <div class="col s3">
                                                <label class="form-label" for="unit_amount">Số lượng (bóc tách)</label>
                                                <input type="number" min="1" max="1000000" class="form-control"
                                                    id="unit_amount" placeholder="Số lượng"
                                                    value="{{ $unit->unit_amount }}" required="" name="unit_amount[]">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập SL.
                                                </div>
                                            </div>
                                            <input type="text" name="unit_id[]" id="" hidden
                                                value="{{ $unit->id }}">
                                        </div>
                                    @endforeach

                                    <div id="list-unit"></div>
                                    <div class="row mb-2">
                                        <div class="col s6">
                                            <label class="form-label" for="item_note">Ghi chú:</label>
                                            <input type="text" class="form-control" id="item_note" placeholder="Ghi chú"
                                                name="item_note" value="{{ $item->item_note }}">
                                        </div>

                                        <div class="col s6">
                                            <span class="form-label" style="font-weight:600">Kích
                                                hoạt ngay:</span><br><br>
                                            <input type="checkbox" id="switch3" data-switch="success"
                                                name="item_status" {{ $item->item_status == 1 ? 'checked' : '' }} />
                                            <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col s6">
                                            <label class="form-label" for="item_capacity">Thể tích:</label>
                                            <input type="text" class="form-control" id="item_capacity" placeholder="Thể tích"
                                                name="item_capacity" value="{{$item->item_capacity}}">
                                        </div>

                                        <div class="col s6">
                                            <span class="form-label" style="font-weight:600">Vật tư lớn:</span><br><br>
                                            <input type="checkbox" id="switch_bigsize" data-switch="success" name="item_bigsize" {{ $item->item_bigsize == 1 ? 'checked' : '' }}/>
                                            <label for="switch_bigsize" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
                        </form>
                    </div>
                </div>
            </div>
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

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->
@endsection
