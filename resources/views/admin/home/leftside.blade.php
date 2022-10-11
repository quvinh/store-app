<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="assets/images/logo.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm.png" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="assets/images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title side-nav-item">Apps</li>

            <li class="side-nav-item">
                <a href="{{ route('calendar.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Calendar </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarWarehouse" aria-expanded="false"
                    aria-controls="sidebarWarehouse" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Kho vật tư </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarWarehouse">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('warehouse.index') }}">Quản lý kho vật tư</a>
                        </li>
                        <li>
                            <a href="{{ route('ex_import.index') }}">Quản lý nhập / xuất</a>
                        </li>
                        <li>
                            <a href="{{route('transfer.index')}}">Quản lý điều chuyển</a>
                        </li>
                        <li>
                            <a href="{{route('item.index')}}">Quản lý tồn kho</a>
                        </li>
                        <li>
                            <a href="{{route('inventory.index')}}">Quản lý điều chỉnh vật tư</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideStatistic" aria-expanded="false" aria-controls="sideStatistic"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Thống kê </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideStatistic">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="#">Thống kê thiết bị</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideGroup" aria-expanded="false" aria-controls="sideGroup"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Danh mục </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideGroup">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('category.index') }}">Danh mục loại vật tư</a>
                        </li>
                        <li>
                            <a href="{{ route('unit.index') }}">Danh mục đơn vị tính</a>
                        </li>
                        <li>
                            <a href="{{ route('supplier.index') }}">Danh mục nhà cung cấp</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideSystem" aria-expanded="false" aria-controls="sideSystem"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Hệ thống </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideSystem">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('account.index') }}">Tài khoản</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- Help Box -->
        {{-- <div class="help-box text-white text-center">
            <a href="javascript: void(0);" class="float-end close-btn text-white">
                <i class="mdi mdi-close"></i>
            </a>
            <img src="assets/images/help-icon.svg" height="90" alt="Helper Icon Image">
            <h5 class="mt-3">Unlimited Access</h5>
            <p class="mb-3">Upgrade to plan to get access to unlimited reports</p>
            <a href="javascript: void(0);" class="btn btn-outline-light btn-sm">Upgrade</a>
        </div> --}}
        <!-- end Help Box -->
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
