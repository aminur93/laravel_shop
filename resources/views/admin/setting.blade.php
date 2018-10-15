@extends('layouts.adminLayouts.admin_design')

@section('main-content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Setting</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Setting</li>
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
            <form action="{{ url('/admin/update-pwd')}}" method="POST" id="password_validate">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Update Password</h4>
                        <div class="form-group row">
                            <label for="current-pwd" class="col-sm-3 text-right control-label col-form-label">Current Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="current_pwd" id="current_pwd" placeholder="Current Password Here">
                                <span id="chkPwd"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_pwd" class="col-sm-3 text-right control-label col-form-label">New Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="new_pwd" id="new_pwd" placeholder="New Password Here">  
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="confirm_pwd" class="col-sm-3 text-right control-label col-form-label">Confirm Password</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password Here">
                                </div>
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Update Password</button>
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
