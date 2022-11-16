<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topbar-menu float-end mb-0">
        <li class="dropdown notification-list d-lg-none">
            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <i class="dripicons-search noti-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                <form class="p-3">
                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                </form>
            </div>
        </li>
        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <img src="{{ asset('assets/images/flags/' . app()->getLocale() . '.svg') }}" alt="user-image" class="me-0 me-sm-1" height="12">
                <span class="align-middle d-none d-sm-inline-block"></span> <i
                    class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu">

                <!-- item-->
                <a href="/locale/vn" class="dropdown-item notify-item" data-language="vn">
                    <img src="{{ asset('assets/images/flags/vn.svg') }}" alt="user-image" class="me-1" height="12"> <span
                        class="align-middle">@lang('header.vietnam')</span>
                </a>

                <!-- item-->
                <a href="/locale/en" class="dropdown-item notify-item" data-language="en">
                    <img src="{{ asset('assets/images/flags/en.svg') }}" alt="user-image" class="me-1" height="12"> <span
                        class="align-middle">@lang('header.english')</span>
                </a>
            </div>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <i class="dripicons-bell noti-icon"></i>
                <span class="noti-icon-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-end">
                            <a href="javascript: void(0);" class="text-dark">
                                <small>Xóa hết</small>
                            </a>
                        </span>Thông báo
                    </h5>
                </div>

                <div style="max-height: 230px;" data-simplebar="">
                    <!-- item-->
                </div>

                <!-- All-->
                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                    Xem tất cả
                </a>

            </div>
        </li>

        <li class="dropdown notification-list d-none d-sm-inline-block">
            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <i class="dripicons-view-apps noti-icon"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg p-0">

                <div class="p-2">
                    <div class="row g-0">
                        <div class="col">
                            <a class="dropdown-icon-item" href="https://mail.google.com/" target="_blank" rel="noopener noreferree">
                                <img src="{{ asset('assets/images/brands/gmail.png') }}" alt="Gmail">
                                <span>Gmail</span>
                            </a>
                        </div>
                        <div class="col">
                            <a class="dropdown-icon-item" href="https://drive.google.com/" target="_blank" rel="noopener noreferree">
                                <img src="{{ asset('assets/images/brands/drive.png') }}" alt="Drive">
                                <span>Drive</span>
                            </a>
                        </div>
                        <div class="col">
                            <a class="dropdown-icon-item" href="https://workspace.google.com/" target="_blank" rel="noopener noreferree">
                                <img src="{{ asset('assets/images/brands/g-suite.png') }}" alt="G Suite">
                                <span>G Suite</span>
                            </a>
                        </div>
                    </div>

                    <div class="row g-0">
                        <div class="col">
                            <a class="dropdown-icon-item" href="https://chat.zalo.me/" target="_blank" rel="noopener noreferree">
                                <img src="{{ asset('assets/images/brands/zalo.png') }}" alt="Zalo">
                                <span>Zalo</span>
                            </a>
                        </div>
                        <div class="col">
                            <a class="dropdown-icon-item" href="https://www.facebook.com/" target="_blank" rel="noopener noreferree">
                                <img src="{{ asset('assets/images/brands/facebook.png') }}" alt="Facebook">
                                <span>Facebook</span>
                            </a>
                        </div>
                        <div class="col">
                            <a class="dropdown-icon-item" href="https://www.youtube.com/" target="_blank" rel="noopener noreferree">
                                <img src="{{ asset('assets/images/brands/youtube.png') }}" alt="Youtube">
                                <span>Youtube</span>
                            </a>
                        </div>
                    </div> <!-- end row-->
                </div>

            </div>
        </li>

        <li class="notification-list">
            <a class="nav-link" href="" title="Refresh">
                <i class="dripicons-clockwise noti-icon mt-1"></i>
            </a>
        </li>

        <li class="notification-list">
            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                <i class="dripicons-gear noti-icon"></i>
            </a>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                <span class="account-user-avatar">
                    <img src="{{ asset('assets/images/users/avatar.png') }}" alt="user-image" class="rounded-circle">
                </span>
                <span>
                    <span class="account-user-name">{{Auth::user()->name}}</span>
                    <span class="account-position">{{Auth::user()->getRoleNames()->first()}}</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <!-- item-->
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">@lang('header.welcome') !</h6>
                </div>

                <!-- item-->
                <a href="{{route('account.profile')}}" class="dropdown-item notify-item">
                {{-- <a href="#" class="dropdown-item notify-item"> --}}

                    <i class="mdi mdi-account-circle me-1"></i>
                    <span>@lang('header.myaccount')</span>

                <!-- item-->
                <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout me-1"></i>
                    <span>@lang('header.logout')</span>
                </a>
            </div>
        </li>

    </ul>
    <button class="button-menu-mobile open-left">
        <i class="mdi mdi-menu"></i>
    </button>
</div>
<!-- end Topbar -->
