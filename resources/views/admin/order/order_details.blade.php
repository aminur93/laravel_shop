@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Admin View Orders Details  #{{ $orderdetails->id }}</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Orders Details</li>
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
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->

        @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0">Order Details</h5>
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Order Date</td>
                            <td>{{ \Carbon\Carbon::parse($orderdetails->created_at)->diffForHumans() }}</td>

                        </tr>
                        <tr>
                            <td>Order status</td>
                            <td class="text-warning">{{ $orderdetails->order_status }}</td>

                        </tr>
                        <tr>
                            <td>Order Total</td>
                            <td class="text-warning">{{ $orderdetails->grand_total }}</td>

                        </tr>
                        <tr>
                            <td>Order Coupon</td>
                            <td class="text-warning">{{ $orderdetails->coupon_code }}</td>

                        </tr>
                        <tr>
                            <td>Order Coupon Amount</td>
                            <td class="text-warning">{{ $orderdetails->coupon_amount }}</td>

                        </tr>
                        <tr>
                            <td>Order Shipping Charge</td>
                            <td class="text-warning">{{ $orderdetails->shipping_charge }}</td>

                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- card new -->
                <div class="card">
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="card m-b-0">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                            <span>Billing Address</span>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                       {{ $userDetails->name }}<br>
                                        {{ $userDetails->address }}<br>
                                        {{ $userDetails->city }}<br>
                                        {{ $userDetails->state }}<br>
                                        {{ $userDetails->country }}<br>
                                        {{ $userDetails->pincode }}<br>
                                        {{ $userDetails->mobile }}<br>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0">Customer Details</h5>
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Customer Name</td>
                            <td>{{ $orderdetails->name }}</td>

                        </tr>
                        <tr>
                            <td>Customer Email</td>
                            <td class="text-warning">{{ $orderdetails->user_email }}</td>

                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="card m-b-0">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <span>Update Order Status</span>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <form action="{{ url('/admin/update-order-status') }}" method="post">{{ csrf_field() }}
                                            <input type="hidden" name="order_id" value="{{ $orderdetails->id }}">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <select name="order_status" id="order_status" class="form-control" required>
                                                            <option value="" selected>Select</option>
                                                            <option value="New" @if ($orderdetails->order_status == "New")
                                                                selected
                                                            @endif>New</option>
                                                            <option value="Pending"  @if ($orderdetails->order_status == "Pending")
                                                            selected
                                                                    @endif>Pending</option>
                                                            <option value="Canceled"  @if ($orderdetails->order_status == "Canceled")
                                                            selected
                                                                    @endif>Canceled</option>
                                                            <option value="In Process"  @if ($orderdetails->order_status == "In Process")
                                                            selected
                                                                    @endif>In Process</option>
                                                            <option value="Shipped"  @if ($orderdetails->order_status == "Shipped")
                                                            selected
                                                                    @endif>Shipped</option>
                                                            <option value="Delivered"  @if ($orderdetails->order_status == "Delivered")
                                                            selected
                                                                    @endif>Delivered</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="submit" value="update status" class="btn btn-primary">
                                                    </td>
                                                </tr>
                                            </table>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- card new -->
                <div class="card">
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="card m-b-0">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <span>Shipping Address</span>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        {{ $orderdetails->name }}<br>
                                        {{ $orderdetails->address }}<br>
                                        {{ $orderdetails->city }}<br>
                                        {{ $orderdetails->state }}<br>
                                        {{ $orderdetails->country }}<br>
                                        {{ $orderdetails->pincode }}<br>
                                        {{ $orderdetails->mobile }}<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product name</th>
                                <th>Product Color</th>
                                <th>Product Size</th>
                                <th>Product Price</th>
                                <th>Product Qty</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orderdetails->orders as $pro)
                                <tr>
                                    <td>{{$pro->product_code}}</td>
                                    <td>{{$pro->product_name}}</td>
                                    <td>{{$pro->product_color}}</td>
                                    <td>{{$pro->product_size}}</td>
                                    <td>{{$pro->product_price}}</td>
                                    <td>{{$pro->product_qty}}</td>
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