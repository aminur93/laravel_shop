@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Admin Edit Currency</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Currency</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->

    @if (Session::has('flash_message_error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
    @endif

    @if (Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ url('/admin/edit-currency',$currency->id) }}" method="POST" id="currency_validate">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <h4 class="card-title">Edit Currency</h4>
                            <div class="form-group row">
                                <label for="brand_name" class="col-sm-3 text-right control-label col-form-label">Currency Code</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ $currency->currency_code }}" class="form-control" name="currency_code" id="currency_code" placeholder="Currency Code">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-3 text-right control-label col-form-label">Exchange Rate</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ $currency->exchange_rate }}" class="form-control" name="exchange_rate" id="exchange_rate" placeholder="Exchange Rate">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="url" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                                <div class="col-sm-1" style="margin-top:10px;margin-left:-30px;">
                                    <input type="checkbox" class="form-control" name="status" id="status" value="1" @if($currency->status ==1) checked @endif>
                                </div>
                            </div>

                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary">Edit Currency</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

@endsection