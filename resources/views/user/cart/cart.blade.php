@extends('layouts.frontLayouts.front_design')

@section('main-content')
<?php use App\Product; ?>
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{url('/')}}">Home</a></li>
              <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
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
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_amount = 0; ?>
                    @foreach ($userCart as $cart)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img style="width:80px;" src="{{asset('admin/products/small/'.$cart->image)}}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$cart->product_name}}</a></h4>
                            <p>{{$cart->product_code}} | {{$cart->size}}</p>
                        </td>
                        <td class="cart_price">
                            <?php
                              $product_price = Product::getProductPrice($cart->product_id,$cart->size);
                            ?>
                            <p>Tk {{$product_price}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="{{url('/users/cart/update-quantity/'.$cart->id.'/1')}}"> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$cart->quantity}}" autocomplete="off" size="2">
                                @if ($cart->quantity>1)
                                <a class="cart_quantity_down" href="{{url('/users/cart/update-quantity/'.$cart->id.'/-1')}}"> - </a>
                                @endif
                                
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">Tk {{$product_price * $cart->quantity}}</p>
                        </td>
                        <td class="cart_delete">
                            <a rel="{{$cart->id}}" rel1="cart-delete" href="javascript:"
                            class="cart_quantity_delete deleteRecord"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php $total_amount = $total_amount+($product_price * $cart->quantity); ?>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a Coupon code you want to use.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <form action="{{url('/users/cart/apply-coupon')}}" method="POST">
                              {{ csrf_field() }}
                                <label>Use Coupon Code</label>
                                <input type="text" name="coupon_code">
                                <input type="submit" value="apply" class="btn btn-default">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        @if(!empty(Session::get('couponAmount')))
                            <li>Sub-Total <span>Tk <?= $total_amount; ?></span></li>
                            <li>Coupon Discount <span>Tk <?= Session::get('couponAmount'); ?></span></li>
                            <?php $getCurrencyRate = Product::getCurrencyRate($total_amount); ?>
                            <li>Grand Total <span class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="
                                            USD {{ $getCurrencyRate['USD_Rate'] }}<br>
                                            <hr>
                                            EURO {{ $getCurrencyRate['EURO_Rate'] }}
                                        ">Tk <?= $total_amount - Session::get('couponAmount'); ?></span></li>
                        @else
                            <?php $getCurrencyRate = Product::getCurrencyRate($total_amount); ?>
                            <li>Grand Total <span class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="
                                            USD {{ $getCurrencyRate['USD_Rate'] }}<br>
                                            <hr>
                                            EURO {{ $getCurrencyRate['EURO_Rate'] }}
                                      ">Tk <?= $total_amount; ?></span></li>
                        @endif
                    </ul>
                        <a class="btn btn-default update" href="{{url('/')}}">Continue Shopping</a>
                        <a class="btn btn-default check_out" href="{{url('/user/checkout')}}">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section><!--/#do_action-->
@endsection