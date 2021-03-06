@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Admin Edit Shipping Charges</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Shipping Charges</li>
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
                    <form action="{{ url('/admin/edit-shipping', $shipping_charge->id) }}" method="POST" id="edit_brand_validate">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $shipping_charge->id }}">
                        <div class="card-body">
                            <h4 class="card-title">Edit Shipping Charges</h4>
                            <div class="form-group row">
                                <label for="brand_name" class="col-sm-3 text-right control-label col-form-label">Country</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ $shipping_charge->country }}" class="form-control" name="country" id="country" placeholder="country name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shipping_charges0_500g" class="col-sm-3 text-right control-label col-form-label">Shipping Charge(0g-500g)</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ $shipping_charge->shipping_charges0_500g }}" class="form-control" name="shipping_charges0_500g" id="shipping_charges0_500g" placeholder="shipping charges 0g-500g">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shipping_charges501_1000g" class="col-sm-3 text-right control-label col-form-label">Shipping Charge(501g-1000g)</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ $shipping_charge->shipping_charges501_1000g }}" class="form-control" name="shipping_charges501_1000g" id="shipping_charges501_1000g" placeholder="shipping charges 501g-1000g">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shipping_charges1001_2000g" class="col-sm-3 text-right control-label col-form-label">Shipping Charge(1001g-2000g)</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ $shipping_charge->shipping_charges1001_2000g }}" class="form-control" name="shipping_charges1001_2000g" id="shipping_charges1001_2000g" placeholder="shipping charges 1001g-2000g">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="shipping_charges2001_5000g" class="col-sm-3 text-right control-label col-form-label">Shipping Charge(2000g-5000g)</label>
                                <div class="col-sm-6">
                                    <input type="text" value="{{ $shipping_charge->shipping_charges2001_5000g }}" class="form-control" name="shipping_charges2001_5000g" id="shipping_charges2001_5000g" placeholder="shipping charges 2000g-5000g">
                                </div>
                            </div>

                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary">Edit Shipping Charge</button>
                                    <a href="{{ url('/admin/view-shipping') }}" class="btn btn-default">Back</a>
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