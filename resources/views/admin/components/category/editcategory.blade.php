@extends('admin.home.master')

@section('title')
    Sửa loại vật tư
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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">Kho vật tư</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{ $category->category_name }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <form class="needs-validation" novalidate
                                action="{{ route('category.update',$category->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <div class="col s12 m6 l6">
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="category_code">Mã loại vật tư:</label>
                                                <input type="text" class="form-control" id="category_code" placeholder="Mã loại vật tư"
                                                    required="" name="category_code" value="{{$category->category_code}}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập mã loại vật tư.
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <label class="form-label" for="category_name">Tên loại vật tư:</label>
                                                <input type="text" class="form-control" id="category_name" placeholder="Tên loại vật tư"
                                                    required="" name="category_name" value="{{$category->category_name}}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập tên loại vật tư.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="category_note">Ghi chú:</label>
                                                <input type="text" class="form-control" id="category_note" placeholder="Ghi chú"
                                                    name="category_note" value="{{$category->category_note}}">
                                            </div>

                                            <div class="col s6">
                                                <span class="form-label" style="font-weight:600">Kích
                                                    hoạt ngay:</span><br><br>
                                                <input type="checkbox" id="switch3" {{$category->category_status == 1 ? 'checked' : ''}} data-switch="success" name="category_status" />
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
