@extends('admin.home.master')
@section('title')
Admin | Bản tin
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
    {{ Breadcrumbs::render('dashboard') }}
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card cta-box overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <select class="form-control select2" data-toggle="select2">
                            <option value="CA">California</option>
                            <option value="NV">Nevada</option>
                            <option value="OR">Oregon</option>
                            <option value="WA">Washington</option>
                        </select>
                    </div>
                </div>
                <!-- end card-body -->
            </div>
            <div class="card tilebox-one">
                <div class="card-body">
                    <a href="#"><i class='uil uil-window-restore float-end'></i></a>
                    <h6 class="text-uppercase mt-0"><a href="#">Vật tư/ phụ tùng</a></h6>
                    <h2 class="my-2" id="active-views-count">100</h2>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><span class="mdi mdi-sticker-check"></span>
                            {{ number_format(100000, 0, ',', '.') }}</span>
                        <span class="text-nowrap"></span>
                    </p>
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div> <!-- end col -->

        <div class="col-xl-9 col-lg-8">
            <div class="card widget-flat card-h-100">
                <div class="card-body">
                    <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                    <h4 class="header-title mb-3">Revenue</h4>

                    <div class="chart-content-bg">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <p class="text-muted mb-0 mt-3">Nhập {{ date('m/Y') }}</p>
                                <h2 class="fw-normal mb-3">
                                    <small class="mdi mdi-checkbox-blank-circle text-primary align-middle me-1"></small>
                                    <span>$58,254</span>
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-0 mt-3">Xuất {{ date('m/Y') }}</p>
                                <h2 class="fw-normal mb-3">
                                    <small class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                    <span>$69,524</span>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div dir="ltr">
                        <div id="revenue-chart" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>


</div> <!-- container -->
@endsection

@section('script')
<!-- bundle -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<!-- third party js -->
<script src="{{ asset('assets/js/vendor/Chart.bundle.min.js') }}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
@endsection