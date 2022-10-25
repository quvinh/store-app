@extends('admin.home.master')

@section('title')
    Inventory
@endsection

@section('css')
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Tồn kho</li>
                    </ol>
                </div>
                <h4 class="page-title">Tồn kho <small>xem chi tiết</small></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bánh xe</h5>
                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#detail" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                <span class="d-none d-md-block">Chi tiết</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#import" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                <span class="d-none d-md-block">Phiếu nhập</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#export" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                <span class="d-none d-md-block">Phiếu xuất</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#transfer" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                <span class="d-none d-md-block">Phiếu luân chuyển</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="detail">
                            @include('admin.components.inventory.detail')
                        </div>
                        <div class="tab-pane" id="import">
                            @include('admin.components.inventory.import')
                        </div>
                        <div class="tab-pane" id="export">
                            @include('admin.components.inventory.export')
                        </div>
                        <div class="tab-pane" id="transfer">
                            @include('admin.components.inventory.transfer')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
