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

            <li class="side-nav-title side-nav-item">Apps</li>

            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('calendar.index') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Calendar </span>
                </a>
            </li>
            <li class="side-nav-title side-nav-item">Chức năng</li>



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
                            <a href="{{ route('warehouse.warehouse-by-id') }}">Quản lý kho vật tư</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideImport" aria-expanded="false"
                    aria-controls="sideImport" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Quản lý nhập</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideImport">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="javascript: void(0);">Tạo phiếu nhập</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);">Quản lý nhập</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideExport" aria-expanded="false"
                    aria-controls="sideExport" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Quản lý xuất </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideExport">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="javascript: void(0);">Tạo phiếu xuất</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);">Quản lý xuất</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title side-nav-item">Danh mục</li>
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
                            <a href="{{ route('item.index') }}">Danh mục vật tư</a>
                        </li>
                        <li>
                            <a href="{{ route('unit.index') }}">Đơn vị tính</a>
                        </li>
                        <li>
                            <a href="{{ route('category.index') }}">Danh mục loại vật tư</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideAccount" aria-expanded="false" aria-controls="sideAccount"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Tài khoản</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideAccount">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('account.index') }}">Quản lý tài khoản</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-title side-nav-item">Hệ thống</li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sideSystem" aria-expanded="false" aria-controls="sideSystem"
                    class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> Hệ thống</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sideSystem">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('role.index') }}">Phân quyền</a>
                        </li>
                        <li>
                            <a href="#">Logs</a>
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
