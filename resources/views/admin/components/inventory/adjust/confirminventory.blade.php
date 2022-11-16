@extends('admin.home.master')

@section('title')
    Xác nhận điều chỉnh
@endsection

@section('css')
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
        {{ Breadcrumbs::render($route, $inventory[0]->id) }}
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
                        <div class="row">
                            <div class="col">
                                <div class="text-sm-start">
                                    <a href="{{ route('inventory.index') }}" class="btn btn-primary mb-2 me-1"><i
                                            class="mdi mdi-backburger"></i> Back</a>
                                </div>
                            </div>
                            <div class="col">
                                <div class="text-sm-end">
                                    <form action="{{ route('inventory.update', $inventory[0]->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        @if ($inventory[0]->inventory_status == 0)
                                            <button class="btn btn-success mb-2 me-1" type="submit">Duyệt</button>
                                        @else
                                            <button class="btn btn-success mb-2 me-1" disabled type="submit">Đã
                                                duyệt</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>

                        <br>
                        <h5 class="card-title">Thông tin</h5>
                        <form action="" class="px-5">
                            <div class="mb-3">
                                <label for="user_name" class="form-label">Người tạo:</label>
                                <input type="text" id="user_name" class="form-control" readonly
                                    value="{{ $inventory[0]->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="export_code" class="form-label">Mã phiếu:</label>
                                <input type="text" id="export_code" class="form-control" readonly
                                    value="{{ $inventory[0]->inventory_code }}">
                            </div>
                            <div class="mb-3">
                                <label for="export_status" class="form-label">Trạng thái:</label>
                                <input type="text" id="export_status" class="form-control" readonly
                                    value="{{ $inventory[0]->inventory_status == 0 ? 'Chưa duyệt' : 'Đã duyệt' }}">
                            </div>
                            <div class="mb-3">
                                <label for="participants" class="form-label">Người tham gia:</label>
                                <input type="text" id="participants" class="form-control" readonly
                                    value="{{ $inventory[0]->participants }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chi tiết</h5>
                        <table id="inventory-datatable" class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã vật tư</th>
                                    <th>Vật tư</th>
                                    <th>Nhà sản xuất</th>
                                    <th>Kho</th>
                                    <th>Hao tổn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventory_detail as $key => $item)
                                    <tr>
                                        <th>{{ $key + 1 }}</th>
                                        <th>{{ $item->item_code }}</th>
                                        <th>{{ $item->item_name }}</th>
                                        <th>{{ $item->supplier_name }}</th>
                                        <th>{{ $item->warehouse_name }}</th>
                                        <th style="color: red">{{ $item->item_broken }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <!-- third party js ends -->
@endsection
