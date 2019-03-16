@extends('layouts.frontLayouts.front_design')

@section('main-content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{url('/')}}">Home</a></li>
              <li class="active">Cancel Paypal</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading text-center">
            <h3>Your Paypal Order Has Been Cancel</h3>
            <p>Please contact us if there is any enquiry.</p>
        </div>
    </div>
</section>
@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
?>