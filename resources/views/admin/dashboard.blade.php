@extends('layouts.adminLayouts.admin_design')

@section('main-content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Dashboard</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Library</li>
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
<div class="container-fluid">
    <!-- ============================================================== -->
<!-- Sales Cards  -->
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

<div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                    <h6 class="text-white"><a href="{{ url('/admin/dashboard') }}" style="color: black;">Dashboard</a></h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        @if(Session::get('adminDetails')['category_view_access'] == 1)
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
                    <h6 class="text-white"><a href="{{ url('/admin/view-category') }}" style="color: black;">Categories</a></h6>
                </div>
            </div>
        </div>
        @endif
        <!-- Column -->
        @if(Session::get('adminDetails')['brand_access'] == 1)
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-purple text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
                    <h6 class="text-white"><a href="{{ url('/admin/view-brand') }}" style="color: black">Brands</a></h6>
                </div>
            </div>
        </div>
        @endif
        <!-- Column -->
        @if(Session::get('adminDetails')['product_access'] == 1)
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-warning text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-collage"></i></h1>
                    <h6 class="text-white"><a href="{{ url('/admin/view-product') }}" style="color: black;">Product</a></h6>
                </div>
            </div>
        </div>
        @endif
        <!-- Column -->
        @if(Session::get('adminDetails')['order_access'] == 1)
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h1>
                    <h6 class="text-white"><a href="{{ url('/admin/view-orders') }}" style="color: black;">Orders</a></h6>
                </div>
            </div>
        </div>
        @endif
        <!-- Column -->
        @if(Session::get('adminDetails')['order_access'] == 1)
        <div class="col-md-6 col-lg-2 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-info text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-arrow-all"></i></h1>
                    <h6 class="text-white"><a href="{{ url('/admin/view-users') }}" style="color: black;">Users</a></h6>
                </div>
            </div>
        </div>
        @endif
        <!-- Column -->
    </div>
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection