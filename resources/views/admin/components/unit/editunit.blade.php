@extends('admin.home.master')

@section('title')
    Sửa đơn vị tính
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
                    <h4 class="page-title">{{ $unit->unit_name }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <form class="needs-validation" novalidate action="{{ route('unit.update', $unit->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <div class="col s12 m6 l6">
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="unit_name">Tên đơn vị tính:</label>
                                                <input type="text" class="form-control" id="unit_name"
                                                    placeholder="Tên đơn vị tính" required="" name="unit_name"
                                                    value="{{ $unit->unit_name }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập tên đơn vị tính.
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <label class="form-label" for="unit_amount">Mã đơn vị tính:</label>
                                                <input type="text" class="form-control" id="unit_amount"
                                                    placeholder="Mã đơn vị tính" name="unit_amount"
                                                    value="{{ $unit->unit_amount }}">
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
