@extends('admin.home.master')

@section('title')
    Sửa tầng
@endsection

@section('css')
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        {{-- @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route, $floor->id) }}--}}
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <form class="needs-validation" novalidate action="{{ route('floor.update', $floor->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <div class="col s12 m6 l6">
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="floor_name">Tên tầng:</label>
                                                <input type="text" class="form-control" id="floor_name"
                                                    placeholder="Tên tầng" required="" name="floor_name"
                                                    value="{{ $floor->floor_name }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập mã giá/kệ.
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <label class="form-label" for="floor_capacity">Thể tích:</label>
                                                <input type="text" class="form-control" id="floor_capacity"
                                                    placeholder="Thể tích" required="" name="floor_capacity"
                                                    value="{{ $floor->floor_capacity }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h3 class="text-center">Danh sách các ô</h3>
                                    <div class="row">
                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên ô</th>
                                                    <th>Thể tích</th>
                                                    <th style="width: 10%">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cells as $key => $cell)
                                                    <tr>
                                                        <td>{{ $key + 1 }} <input type="text" name="cell_id[]" id="" hidden value="{{$cell->id}}"></td>
                                                        <td><input class="form-control" type="text" name="cell_name[]" id="" value="{{ $cell->cell_name }}"></td>
                                                        <td><input class="form-control" type="number" name="cell_capacity[]" id="" value="{{ $cell->cell_capacity }}"></td>
                                                        <td class="table-action">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button class="btn btn-success mb-2 me-1" type="submit">Lưu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
