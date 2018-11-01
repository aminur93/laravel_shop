@extends('layouts.adminLayouts.admin_design')

@section('main-content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Edit Coupons</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Coupons</li>
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
            <form action="{{ url('/admin/edit-coupons/'.$coupons->id) }}" method="POST" id="coupons_validate">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Edit Coupons</h4>
                        <div class="form-group row">
                            <label for="brand_name" class="col-sm-3 text-right control-label col-form-label">Coupons Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="coupon_code" id="coupon_code" value="{{$coupons->coupon_code}}" minlength="3" maxlength="15" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="amount" id="amount" value="{{$coupons->amount}}" min="1" required>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Amount Type</label>
                            <div class="col-sm-6">
                               <select name="amount_type" id="amount_type" class="form-control">
                                   <option value="Percentage" @if($coupons->amount_type=="Percentage") selected @endif>Percentage</option>
                                   <option value="Fixed" @if($coupons->amount_type=="Fixed") selected @endif>Fixed</option>
                               </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Expire Date</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="expire_date" id="expire_date" value="{{$coupons->expire_date}}" autocomplete="off">  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                            <div class="col-sm-1" style="margin-top:10px;margin-left:-30px;">
                                <input type="checkbox" class="form-control" name="status" id="status" @if($coupons->status == 1) checked @endif value="1">
                            </div>
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Edit Coupons</button>
                                <a href="{{url('/admin/view-coupons')}}" class="btn btn-success">Back</a>
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