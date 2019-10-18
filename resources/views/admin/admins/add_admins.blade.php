@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Add Admin</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Admins</li>
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
                    <form action="{{ url('/admin/add-admins') }}" method="POST" id="admins_validate">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <h4 class="card-title">Add Admins</h4>

                            <div class="form-group row">
                                <label for="type" class="col-sm-3 text-right control-label col-form-label">Type</label>
                                <div class="col-sm-6">
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Sub-Admin">Sub-Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-sm-3 text-right control-label col-form-label">UserName</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="User Name">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password" class="col-sm-3 text-right control-label col-form-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                </div>
                            </div>

                            <div class="form-group row" id="access">
                                <label for="access" class="col-sm-3 text-right control-label col-form-label">Access</label>
                                <div class="col-sm-6" style="margin-top:20px;">
                                    <input type="checkbox" class="form-control" name="category_view_access" id="category_access" value="1">&nbsp; Category View Access
                                    <input type="checkbox" class="form-control" name="category_edit_access" id="category_access" value="1">&nbsp; Category Edit Access
                                    <input type="checkbox" class="form-control" name="category_full_access" id="category_access" value="1">&nbsp; Category Full Access
                                    <hr><br>
                                    <input type="checkbox" class="form-control" name="brand_access" id="brand_access" value="1"> Brand Access
                                    <input type="checkbox" class="form-control" name="product_access" id="product_access" value="1"> Product Access
                                    <input type="checkbox" class="form-control" name="order_access" id="order_access" value="1"> Order Access
                                    <input type="checkbox" class="form-control" name="user_access" id="user_access" value="1"> User Access
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                                <div class="col-sm-1" style="margin-top:10px;margin-left:-30px;">
                                    <input type="checkbox" class="form-control" name="status" id="status" value="1">
                                </div>
                            </div>

                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary">Add Admin</button>
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
@stop