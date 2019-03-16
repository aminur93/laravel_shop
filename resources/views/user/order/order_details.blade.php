@extends('layouts.frontLayouts.front_design')

@section('main-content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{url('/')}}">Home</a></li>
              <li><a href="{{url('/user/orders')}}">Orders</a></li>
              <li class="active">{{ $ordersDetails->id}}</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading">
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
                    @foreach ($ordersDetails->orders as $pro)
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
</section>
@endsection
