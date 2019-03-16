@extends('layouts.frontLayouts.front_design')

@section('main-content')

    <?php
    use App\Order;
    ?>
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">Paypal</li>
                </ol>
            </div>
        </div>
    </section>

    <section id="do_action">
        <div class="container">
            <div class="heading text-center">
                <h3>Your Order Has Been Placed</h3>
                <p>Your Order Number Is {{Session::get('order_id')}} and
                    Total payable amount is TK {{Session::get('grand_total')}}</p>
                <p>Please make payment by clicking on below on payment button.</p>

                <?php
                  $orderDetails = Order::getOrderDetails(Session::get('order_id'));
                  $orderDetails = json_decode(json_encode($orderDetails));
//                  echo "<pre>"; print_r($orderDetails);die;
                    $nameArr = explode(' ',$orderDetails->name);
                    $getCountryCode = Order::getCountryCode($orderDetails->country);
                ?>

                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">

                    <input type="hidden" name="cmd" value="_xclick">

                    <input type="hidden" name="business" value="aminurriya93@gmail.com">

                    <input type="hidden" name="item_name" value="{{Session::get('order_id')}}">

                    <input type="hidden" name="currency_code" value="USD">

                    <input type="hidden" name="amount" value="{{Session::get('grand_total')}}">

                    <input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
                    <input type="hidden" name="last_name" value="{{ $nameArr[1] }}">
                    <input type="hidden" name="address1" value="{{ $orderDetails->address }}">
                    <input type="hidden" name="address2" value="Apt 5">
                    <input type="hidden" name="city" value="{{ $orderDetails->city }}">
                    <input type="hidden" name="state" value="{{ $orderDetails->state }}">
                    <input type="hidden" name="zip" value="{{ $orderDetails->pincode }}">

                    <input type="hidden" name="email" value="{{ $orderDetails->user_email }}">
                    <input type="hidden" name="country" value="{{ $getCountryCode->country_code }}">
                    <input type="hidden" name="return" value="{{ url('/order/paypal/thanks') }}">
                    <input type="hidden" name="cancel_return" value="{{ url('/order/paypal/cancel') }}">


                    <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_107x26.png" alt="Buy Now">
                    <img alt="" src="https://paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>

            </div>
        </div>
    </section>
@endsection

<?php
Session::forget('grand_total');
Session::forget('order_id');
?>