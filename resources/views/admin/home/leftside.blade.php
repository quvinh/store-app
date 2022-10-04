<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- LOGO -->

    <a href="{{ route('admin.dashboard') }}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/bvy.png') }}" alt="" height="70">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="16">
        </span>
    </a>
    <br><br>

    <!-- LOGO -->
    {{-- <a href="{{ route('admin.dashboard') }}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo_sm_dark.png') }}" alt="" height="16">
        </span>
    </a> --}}

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">
            <!-- <li class="side-nav-title side-nav-item">Navigation</li> -->
            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> @lang('leftside.dashboard') </span>
                </a>
            </li>

            {{-- <li class="side-nav-title side-nav-item"></li> --}}

            <li class="side-nav-item">
                <a href="{{ route('admin.calendar') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> @lang('leftside.calendar') </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPatient" aria-expanded="false" aria-controls="sidebarPatient" class="side-nav-link">
                    <i class="uil-registered"></i>
                    <span> @lang('leftside.subcriber.subcriber') </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPatient">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.patient') }}">@lang('leftside.subcriber.mansubcriber')</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarGroup" aria-expanded="false" aria-controls="sidebarGroup" class="side-nav-link">
                    <i class="uil-layer-group"></i>
                    <span> @lang('leftside.group.group') </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarGroup">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.group') }}">@lang('leftside.group.mangroup')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.group.create') }}">@lang('leftside.group.addgroup')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.group.createsameprice') }}">@lang('leftside.group.addgroupsameprice')</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarStation" aria-expanded="false" aria-controls="sidebarStation" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> @lang('leftside.station.station') </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarStation">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.station') }}">@lang('leftside.station.manstation')</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCategory" aria-expanded="false" aria-controls="sidebarCategory" class="side-nav-link">
                    <i class="uil-list-ul"></i>
                    <span> @lang('leftside.category.category') </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCategory">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.test_type') }}">@lang('leftside.category.testtype')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.print-bill') }}">@lang('leftside.category.bill')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.list-patient')}}">In danh sách</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.list-bill')}}">Danh sách thu tiền</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.excel') }}">Nhập liệu Excel</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a href="#" class="side-nav-link">
                    <i class="uil-bell"></i>
                    <span> @lang('leftside.notify') </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarAccount" aria-expanded="false" aria-controls="sidebarAccount" class="side-nav-link">
                    <i class="uil-user-square"></i>
                    <span> @lang('leftside.account.account') </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarAccount">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.account') }}">@lang('leftside.account.manaccount')</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSystem" aria-expanded="false" aria-controls="sidebarSystem" class="side-nav-link">
                    <i class="uil-spin"></i>
                    <span> @lang('leftside.system.system') </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSystem">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.role') }}">@lang('leftside.system.role')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.invoice') }}">@lang('leftside.system.invoice')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sample') }}">@lang('leftside.system.sample')</a>
                        </li>
                        <li>
                            <a href="{{ url('/log-viewer') }}" target="_blank" rel="noopener noreferrer">Logs</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

        <!-- Help Box -->
        <div class="help-box text-white text-center">
            <a href="javascript: void(0);" class="float-end close-btn text-white">
                <i class="mdi mdi-close"></i>
            </a>
            <img src="{{ asset('assets/images/help-icon.svg') }}" height="90" alt="Helper Icon Image">
            <h5 class="mt-3"></h5>
            <p class="mb-3"></p>
            <a href="javascript: void(0);" class="btn btn-outline-light btn-sm">Upgrade</a>
        </div>
        <!-- end Help Box -->
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
