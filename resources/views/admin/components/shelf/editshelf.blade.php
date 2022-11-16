@extends('admin.home.master')

@section('title')
    Sửa giá/kệ
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
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route, $shelf->id) }}
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <form class="needs-validation" novalidate
                                action="{{ route('shelf.update',$shelf->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <div class="col s12 m6 l6">
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_code">Mã giá/kệ:</label>
                                                <input type="text" class="form-control" id="shelf_code"
                                                    placeholder="Mã giá/kệ" required="" name="shelf_code" value="{{ $shelf->shelf_code }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập mã giá/kệ.
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_position">vị trí:</label>
                                                <input type="text" class="form-control" id="shelf_position"
                                                    placeholder="vị trí" required="" name="shelf_position" value="{{ $shelf->shelf_position }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập số vị trí.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_name">Tên giá/kệ:</label>
                                                <input type="text" class="form-control" id="shelf_name"
                                                    placeholder="Tên giá/kệ" required="" name="shelf_name" value="{{ $shelf->shelf_name }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập tên giá/kệ.
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_note">Ghi chú:</label>
                                                <input type="text" class="form-control" id="shelf_note"
                                                    placeholder="Ghi chú" name="shelf_note" value="{{ $shelf->shelf_note }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2"><span class="form-label" style="font-weight:600">Kích
                                                hoạt ngay:</span>
                                            <div class=" col s6">
                                                <input type="checkbox" id="switch3" {{ ($shelf->shelf_status==1) ? 'checked': ''}} data-switch="success"
                                                    name="shelf_status" />
                                                <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
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
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
