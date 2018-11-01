@extends('layouts.adminLayouts.admin_design')

@section('main-content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Coupons</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Coupons</li>
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
            <form action="{{ url('/admin/add-coupons') }}" method="POST" id="coupons_validate">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Add Coupons</h4>
                        <div class="form-group row">
                            <label for="brand_name" class="col-sm-3 text-right control-label col-form-label">Coupons Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupons Code" minlength="3" maxlength="15" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount" min="1" required>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Amount Type</label>
                            <div class="col-sm-6">
                               <select name="amount_type" id="amount_type" class="form-control">
                                   <option value="Percentage">Percentage</option>
                                   <option value="Fixed">Fixed</option>
                               </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Expire Date</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="expire_date" id="expire_date" placeholder="Expire Date" autocomplete="off">  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                            <div class="col-sm-1" style="margin-top:10px;margin-left:-30px;">
                                <input type="checkbox" class="form-control" name="status" id="status" value="1">
                            </div>
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Add Coupons</button>
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