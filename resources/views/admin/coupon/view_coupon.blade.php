@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin View Coupons</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Coupons</li>
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
        <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">View Coupons List</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Coupon Code</th>
                                <th>Amount</th>
                                <th>Amount Type</th>
                                <th>Expire Date</th>
                                <th>Create Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                
                           
                            <tr>
                                <td>{{$coupon->id}}</td>
                                <td>{{$coupon->coupon_code}}</td>
                                <td>
                                    {{$coupon->amount}}
                                    @if($coupon->amount_type == "Percentage") % @else Tk @endif
                                </td>
                                <td>{{$coupon->amount_type}}</td>
                                <td>{{$coupon->expire_date}}</td>
                                <td>{{$coupon->created_at}}</td>
                                <td>
                                    @if($coupon->status == '1') Active @else Inactive @endif
                                </td>
                                <td>
                                <a href="{{url('/admin/edit-coupons/'.$coupon->id)}}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>

                                <a rel="{{$coupon->id}}" rel1="delete-coupons" href="javascript:" 
                                    {{--href="{{url('/admin/delete-brand',$brand->id)}}"--}}
                                    class="btn btn-xs btn-danger deleteRecord"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl No</th>
                                <th>Coupon Code</th>
                                <th>Amount</th>
                                <th>Amount Type</th>
                                <th>Expire Date</th>
                                <th>Create Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>   
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection
