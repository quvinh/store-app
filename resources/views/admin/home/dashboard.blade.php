@extends('admin.home.master')
@section('title')
    Home
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
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-light" id="dash-daterange">
                                <span class="input-group-text bg-primary border-primary text-white">
                                    <i class="mdi mdi-calendar-range font-13"></i>
                                </span>
                            </div>
                            <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                <i class="mdi mdi-autorenew"></i>
                            </a>
                            <a href="javascript: void(0);" class="btn btn-primary ms-1">
                                <i class="mdi mdi-filter-variant"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <a href="{{ route('admin.station') }}"><i class='uil uil-window-restore float-end'></i></a>
                        <h6 class="text-uppercase mt-0"><a href="{{ route('admin.station') }}">Số trạm đăng ký</a></h6>
                        <h2 class="my-2" id="active-views-count">0</h2>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><span class="mdi mdi-sticker-check"></span> Hoạt động</span>
                            <span class="text-nowrap"></span>
                        </p>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->

                <div class="card tilebox-one">
                    <div class="card-body">
                        <a href="{{ route('admin.patient') }}"><i class='uil uil-users-alt float-end'></i></a>
                        <h6 class="text-uppercase mt-0"><a href="{{ route('admin.patient') }}">Người đăng ký</a>
                            {{ date('d-m-Y') }}</h6>
                        <h2 class="my-2" id="amount-register">0</h2>
                        <p class="mb-0 text-muted">
                            <span class="text-primary me-2" id="per-register"><span class="mdi mdi-arrow-up-bold"
                                    id="icon-register"></span>&nbsp;<span id="percent">0</span></span>
                            <span class="text-nowrap">hôm qua.</span>
                        </p>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->

                <div class="card cta-box overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h3 class="m-0 fw-normal cta-box-title">Enhance your <b>Campaign</b> for better outreach <i
                                        class="mdi mdi-arrow-right"></i></h3>
                            </div>
                            <img class="ms-3" src="assets/images/email-campaign.svg" width="92"
                                alt="Generic placeholder image">
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
            </div> <!-- end col -->

            <div class="col-xl-9 col-lg-8">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                        <h4 class="header-title mb-3">Projections Vs Actuals</h4>

                        <div dir="ltr">
                            <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#e3eaef"></div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Monthly Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                            </div>
                        </div>
                        <h4 class="header-title mb-3">HÔM NAY</h4>

                        <div class="row">
                            <div class="col-md-7">
                                <div data-provide="datepicker-inline" data-date-today-highlight="true" class="calendar-widget"></div>
                            </div> <!-- end col-->
                            <div class="col-md-5">
                                <ul class="list-unstyled">
                                    <li class="mb-4">
                                        <p class="text-muted mb-1 font-13">
                                            <i class="mdi mdi-calendar"></i> 7:30 AM - 10:00 AM
                                        </p>
                                        <h5>Meeting with BD Team</h5>
                                    </li>
                                    <li class="mb-4">
                                        <p class="text-muted mb-1 font-13">
                                            <i class="mdi mdi-calendar"></i> 10:30 AM - 11:45 AM
                                        </p>
                                        <h5>Design Review - Hyper Admin</h5>
                                    </li>
                                    <li class="mb-4">
                                        <p class="text-muted mb-1 font-13">
                                            <i class="mdi mdi-calendar"></i> 12:15 PM - 02:00 PM
                                        </p>
                                        <h5>Setup Github Repository</h5>
                                    </li>
                                    <li>
                                        <p class="text-muted mb-1 font-13">
                                            <i class="mdi mdi-calendar"></i> 5:30 PM - 07:00 PM
                                        </p>
                                        <h5>Meeting with Design Studio</h5>
                                    </li>
                                </ul>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div> <!-- end col-->

            <div class="col-xl-3 col-lg-6 order-lg-1">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                        <h4 class="header-title">THÔNG TIN CÁC TRẠM</h4>

                        <div id="average-sales" class="apex-charts mb-4 mt-4"
                            data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00"></div>


                        <div class="chart-widget-list">
                            {{-- <p>
                                <i class="mdi mdi-square text-primary"></i> Direct
                                <span class="float-end">123</span>
                            </p> --}}
                            <p class="text-center">Số người đăng ký các trạm</p>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xl-3 col-lg-6 order-lg-1">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                        <h4 class="header-title mb-2"><a href="{{ route('admin.group') }}">Log Sửa nhóm</a></h4>

                        <div data-simplebar="" style="max-height: 419px;">
                            <div class="timeline-alt pb-0">
                                @php
                                    $group_logs = DB::table('group_logs')
                                        ->where('group_status', 1)
                                        ->orderByDesc('created_at')
                                        ->get();
                                @endphp
                                @forelse ($group_logs as $key => $log)
                                    @if ($key % 2 == 0)
                                        <div class="timeline-item">
                                            <i
                                                class="mdi mdi-square-edit-outline bg-info-lighten text-info timeline-icon"></i>
                                            <div class="timeline-item-info">
                                                <a href="#" class="text-info fw-bold mb-1 d-block">Sửa Nhóm</a>
                                                <small>Nhóm <b>{{ $log->group_title }}</b></small>
                                                <p class="mb-0 pb-2">
                                                    <small
                                                        class="text-muted">{{ date('d-m-Y H:i:s', strtotime($log->created_at)) }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="timeline-item">
                                            <i class="mdi mdi-square-edit-outline bg-primary-lighten text-primary timeline-icon"></i>
                                            <div class="timeline-item-info">
                                                <a href="#" class="text-primary fw-bold mb-1 d-block">Sửa Nhóm</a>
                                                <small>Nhóm <b>{{ $log->group_title }}</b></small>
                                                <p class="mb-0 pb-2">
                                                    <small
                                                        class="text-muted">{{ date('d-m-Y H:i:s', strtotime($log->created_at)) }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                @endforelse
                            </div>
                            <!-- end timeline -->
                        </div> <!-- end slimscroll -->
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->

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
    {{-- <script src="{{ asset('assets/js/pages/demo.dashboard-analytics.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/pages/demo.dashboard-projects.js') }}"></script> --}}
@endsection
