@extends('admin.home.master')

@section('title')
    Add
@endsection

@section('css')
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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">ABC</li>
                        </ol>
                    </div>
                    <h4 class="page-title">ABC</h4>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="custom-styles-preview">
                                <form action="" method="post">
                                    @csrf
                                    <div class="row mb-1">
                                        <div class="col-md-3 text-sm-end mt-2"><span class="text-danger">(*)</span> <span
                                                class="text-primary">Kho xuất hàng</span></div>
                                        <div class="col-md-6">
                                            <select class="form-control select2" data-toggle="select2">
                                                <option>Select</option>
                                                <option value="CA">California</option>
                                                <option value="NV">Nevada</option>
                                                <option value="OR">Oregon</option>
                                                <option value="WA">Washington</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-3 text-sm-end mt-2"><span class="text-danger">(*)</span> <span
                                                class="text-primary">Kho nhận hàng</span></div>
                                        <div class="col-md-6">
                                            <select class="form-control select2" data-toggle="select2">
                                                <option>Select</option>
                                                <option value="CA">California</option>
                                                <option value="NV">Nevada</option>
                                                <option value="OR">Oregon</option>
                                                <option value="WA">Washington</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-3 text-sm-end mt-2"><span class="text-primary">Mô tả chung</span>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <textarea class="form-control" id="example-textarea" rows="3" placeholder="Nhập mô tả..."></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    <style>
                                        .separator {
                                            display: flex;
                                            align-items: center;
                                            text-align: center;
                                        }

                                        .separator::before,
                                        .separator::after {
                                            content: '';
                                            flex: 1;
                                            border-bottom: 1px solid #DDD;
                                        }

                                        .separator:not(:empty)::before {
                                            margin-right: .25em;
                                        }

                                        .separator:not(:empty)::after {
                                            margin-left: .25em;
                                        }
                                    </style>
                                    <div class="separator mb-2"><b class="text-dark">DANH SÁCH PHỤ TÙNG</b></div>
                                    {{-- LIST --}}
                                    <div class="mt-1 mb-3" id="list-item">
                                        <div class="row mb-1">
                                            <div class="col-md-3 text-sm-end mt-2">
                                                <span class="text-danger">(*)</span> <span class="text-primary">Phụ tùng</span>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control select2" data-toggle="select2" id="itemdetail_id" name="itemdetail_id">
                                                    <option>Select</option>
                                                    <option value="CA">California</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-3 text-sm-end mt-2">
                                                <span class="text-danger">(*)</span> <span class="text-primary">Số lượng</span>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <input class="form-control form-control-sm" id="item_quantity" name="item_quantity" data-toggle="touchspin" value="0" type="text" data-bts-button-down-class="btn btn-danger btn-sm" data-bts-button-up-class="btn btn-info btn-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-sm-end">
                                                        <button class="btn btn-sm btn-warning" type="button"><i class="mdi mdi-card-remove-outline"></i> Xóa dòng</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-1">
                                        <div class="col-md-3 text-sm-end mt-2"></div>
                                        <div class="col-md-6">
                                            <div class="row">
                                            <div class="text-sm-start col-md-6"><button type="button" class="btn btn-sm btn-success "><i class="mdi mdi-chevron-double-down"></i> Thêm dòng</button></div>
                                            <div class="text-sm-end col-md-6"><button type="button" class="btn btn-sm btn-info "><i class="mdi mdi-content-save"></i> Xác nhận lưu</button></div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </form>
                            </div> <!-- end preview-->

                        </div> <!-- end tab-content-->

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
