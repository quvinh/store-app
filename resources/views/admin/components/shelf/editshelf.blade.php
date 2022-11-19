@extends('admin.home.master')

@section('title')
    Sửa giá/kệ
@endsection

@section('css')
    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        {{ Breadcrumbs::render($route, $shelf->id) }}
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
                        <div class="tab-content">
                            <form class="needs-validation" novalidate action="{{ route('shelf.update', $shelf->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <div class="col s12 m6 l6">
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_code">Mã giá/kệ:</label>
                                                <input type="text" class="form-control" id="shelf_code"
                                                    placeholder="Mã giá/kệ" required="" name="shelf_code"
                                                    value="{{ $shelf->shelf_code }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập mã giá/kệ.
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_position">vị trí:</label>
                                                <input type="text" class="form-control" id="shelf_position"
                                                    placeholder="vị trí" required="" name="shelf_position"
                                                    value="{{ $shelf->shelf_position }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập số vị trí.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_name">Tên giá/kệ:</label>
                                                <input type="text" class="form-control" id="shelf_name"
                                                    placeholder="Tên giá/kệ" required="" name="shelf_name"
                                                    value="{{ $shelf->shelf_name }}">
                                                <div class="invalid-feedback">
                                                    Vui lòng nhập tên giá/kệ.
                                                </div>
                                            </div>
                                            <div class="col s6">
                                                <label class="form-label" for="shelf_note">Ghi chú:</label>
                                                <input type="text" class="form-control" id="shelf_note"
                                                    placeholder="Ghi chú" name="shelf_note"
                                                    value="{{ $shelf->shelf_note }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2"><span class="form-label" style="font-weight:600">Kích
                                                hoạt ngay:</span>
                                            <div class=" col s6">
                                                <input type="checkbox" id="switch3"
                                                    {{ $shelf->shelf_status == 1 ? 'checked' : '' }} data-switch="success"
                                                    name="shelf_status" />
                                                <label for="switch3" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h3 class="text-center">Danh sách các tầng</h3>
                                    <div class="row">
                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tên tầng</th>
                                                    <th>Thể tích</th>
                                                    <th>Số ô</th>
                                                    <th style="width: 10%">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($floors as $key => $floor)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $floor->floor_name }}</td>
                                                        <td>{{ $floor->floor_capacity }}</td>
                                                        <td>{{ $cell_number }}</td>
                                                        <td class="table-action">
                                                            @can('she.edit')
                                                                <a href="{{ route('floor.edit', $floor->id) }}"
                                                                    class="action-icon">
                                                                    <i class="mdi mdi-square-edit-outline"></i></a>
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js')}}"></script>

    <!-- Datatable Init js -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js')}}"></script>
@endsection
