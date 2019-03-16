@extends('layouts.frontLayouts.front_design')

@section('main-content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{url('/')}}">Home</a></li>
              <li class="active">Orders</li>
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
                    <th>Order Id</th>
                    <th>Orderd Product</th>
                    <th>Payment Method</th>
                    <th>Grand Total</th>
                    <th>Created On</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>
                            @foreach ($order->orders as $pro)
                                <a href="{{url('/user/orderDetails/'.$order->id)}}">{{$pro->product_code}} - Qty : {{ $pro->product_qty }}</a><br>
                            @endforeach
                        </td>
                        <td>{{$order->payment_method}}</td>
                        <td>Tk {{$order->grand_total}}</td>
                        <td>{{$order->created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
