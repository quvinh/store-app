@extends('admin.home.master')

@section('title')
    Quản lý tài khoản
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
    <!-- third party css end -->
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
@endsection
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route) }}
        <!-- end page title -->
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{-- {{ Breadcrumbs::render($route) }} --}}
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-8">
                                <div class="text-sm-start">
                                    {{-- <button type="button" class="btn btn-success mb-2 me-1"><i
                                        class="mdi mdi-cog"></i></button>
                                <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                <button type="button" class="btn btn-light mb-2">Export</button> --}}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="text-sm-end">
                                    {{-- <a href="{{route('admin.account.create')}}" class="btn btn-primary mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Account</a> --}}
                                </div>
                            </div>
                            <!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-striped dt-responsive nowrap w-100"
                                id="accounts-datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;" hidden>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Customer</th>
                                        <th>Username</th>
                                        <th>Chức vụ</th>
                                        <th>Email</th>
                                        <th>Create Date</th>
                                        <th style="width: 75px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accounts as $key => $account)
                                        <tr>
                                            <td hidden>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="check{{ $key + 1 }}" value="acc{{ $account->id }}">
                                                    <label class="form-check-label"
                                                        for="check{{ $key + 1 }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td class="table-user">
                                                @if ($account->gender == 1)
                                                    <img src="{{ asset('images/register/avatarMale.png') }}"
                                                        alt="table-user" class="me-2 rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/register/avatarFemale.png') }}"
                                                        alt="table-user" class="me-2 rounded-circle">
                                                @endif
                                                <a href="{{ route('account.show', $account->id) }}"
                                                    class="fw-semibold text-primary">{{ $account->name }}</a>
                                            </td>
                                            <td>
                                                <span class="text-dark fw-semibold">{{ $account->username }}</span><br>
                                                <span class="badge badge-success-lighten">Active</span>
                                            </td>
                                            <td>
                                                @if ($account->getRoleNames()->first() == null)
                                                    <span class="badge badge-outline-warning rounded-pill">Chưa phân
                                                        quyền</span>
                                                @else
                                                    <span
                                                        class="badge badge-outline-primary rounded-pill">{{ $account->getRoleNames()->first() }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $account->email }}
                                            </td>
                                            <td>
                                                {{ $account->created_at }}
                                            </td>
                                            <td>
                                                @can('acc.edit')
                                                    <a href="{{ route('account.show', $account->id) }}" class="action-icon"> <i
                                                            class="mdi mdi-square-edit-outline"></i></a>
                                                @endcan
                                                @can('acc.delete')
                                                    <a href="{{ route('account.destroy', $account->id) }}" class="action-icon">
                                                        <i class="mdi mdi-delete"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
    <!-- demo js -->
    <script src="{{ asset('assets/js/pages/demo.toastr.js') }}"></script>
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            const accounts = <?php echo json_encode($accounts->pluck('id')); ?>;
            console.log(accounts);
            $("#accounts-datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Showing accounts _START_ to _END_ of _TOTAL_",
                    lengthMenu: 'Display <select class="form-select form-select-sm ms-1 me-1"><option value="50">50</option><option value="100">100</option><option value="200">200</option><option value="-1">All</option></select> <a href="{{ route('account.create') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus-circle me-2"></i> Add Account</a>'
                },
                pageLength: 50,
                columns: [{
                    orderable: !1
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }],
                select: {
                    style: "multi"
                },
                // order: [
                //     [1, "asc"]
                // ],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(
                        "#accounts-datatable_length label").addClass("form-label")
                },
            })
        });

        function notify(title, content, alert) {
            $.NotificationApp.send(title, content, "top-right", "rgba(0,0,0,0.2)", alert);
        }
    </script>
@endsection
