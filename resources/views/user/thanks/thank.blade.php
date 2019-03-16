@extends('layouts.frontLayouts.front_design')

@section('main-content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{url('/')}}">Home</a></li>
              <li class="active">Thanks</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading text-center">
            <h3>Your COD Order Has Been Placed</h3>
            <p>Your Order Number Is {{Session::get('order_id')}} and Totoal payable amount is TK {{Session::get('grand_total')}}</p>
        </div>
    </div>
</section>
@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
?>