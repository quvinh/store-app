@extends('admin.home.master')

@section('title')
    Add
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
        @php
            $route = preg_replace('/(admin)|\d/i', '', str_replace('/', '', Request::getPathInfo()));
        @endphp
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                            <li class="breadcrumb-item active">ABC</li>
                        </ol>
                    </div>
                    <h4 class="page-title">ABC</h4>
                </div>
            </div>
        </div>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="custom-styles-preview">
                                <form class="needs-validation" novalidate="" method="POST"
                                    action="{{ route('admin.station.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="station_code">@lang('station.id')</label>
                                                <input type="text" class="form-control" id="station_code"
                                                    name="station_code" placeholder="Code"
                                                    value="{{ old('station_code') ? old('station_code') : 'bot' . ($maxid + 1) }}"
                                                    required="">
                                                <!-- <div class="valid-feedback">
                                                    Looks good!
                                                </div> -->
                                                <!-- <div class="invalid-feedback">
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="station_name">@lang('station.name')</label>
                                                <input type="text" class="form-control" id="station_name"
                                                    name="station_name" placeholder="Name" value="{{ old('station_name') }}"
                                                    required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <textarea class="form-control" name="station_note" id="station_note" placeholder="Note" rows="1"></textarea>
                                                <div class="invalid-feedback">
                                                    @lang('station.please')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-checkbox-success mb-3">
                                                <input type="checkbox" class="form-check-input" id="station_status"
                                                    name="station_status" checked="" value="1">
                                                <label class="form-check-label" for="station_status">@lang('station.active')</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="customRadio3" name="station_action"
                                                class="form-check-input" value="add" checked>
                                            <label class="form-check-label" for="customRadio3">@lang('station.continue')</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="customRadio4" name="station_action"
                                                class="form-check-input" value="list">
                                            <label class="form-check-label" for="customRadio4">@lang('station.redirect')</label>
                                        </div>
                                    </div>
                                    <br>
                                    <button class="btn btn-primary" type="submit">@lang('station.submit')</button>
                                </form>
                            </div> <!-- end preview-->

                        </div> <!-- end tab-content-->

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
@endsection
