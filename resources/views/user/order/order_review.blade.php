@extends('layouts.frontLayouts.front_design')

@section('main-content')
<?php use App\Product; ?>
<section id="cart_items" style="margin-top:10px;">
    <div class="container">
        <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">Order review</li>
                </ol>
            </div>
        <div class="row">
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
            
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <h2>Bill Details</h2>
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{$userDetails->name}}" id="billing_name" name="billing_name" placeholder="Billing Name"/>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" value="{{$userDetails->address}}" id="billing_address" name="billing_address" placeholder="Billing Address"/>
                        </div>

                        <div class="form-group">
                        <input type="text" class="form-control" value="{{$userDetails->city}}" id="billing_city" name="billing_city" placeholder="Billing City"/>
                        </div>

                        <div class="form-group">
                        <input type="text" class="form-control" value="{{$userDetails->state}}" id="billing_state" name="billing_state" placeholder="Billing State"/>
                        </div>

                        <div class="form-group">
                            <select name="billing_country" id="billing_country" class="form-control">
                                <option value="">Select Country</option>
                                @foreach ($country as $item)
                                    <option value="{{$item->country_name}}" @if($item->country_name == $userDetails->country) selected @endif>{{$item->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                        <input type="text" class="form-control" value="{{$userDetails->pincode}}" id="billing_pincode" name="billing_pincode" placeholder="Billing Pincode"/>
                        </div>

                        <div class="form-group">
                        <input type="text" class="form-control" value="{{$userDetails->mobile}}" id="billing_mobile" name="billing_mobile" placeholder="Billing Mobile"/>
                        </div>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2></h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Shipping Details</h2>
                    <div class="form-group">
                            <input type="text" value="{{ $shippingDetails->name}}" class="form-control" id="shipping_name" name="shipping_name" placeholder="Shipping Name"/>
                        </div>
                        <div class="form-group">
                        <input type="text" value="{{ $shippingDetails->address}}" class="form-control" id="shipping_address" name="shipping_address" placeholder="Shipping Address"/>
                        </div>

                        <div class="form-group">
                        <input type="text" value="{{ $shippingDetails->city}}" class="form-control" id="shipping_city" name="shipping_city" placeholder="Shipping City"/>
                        </div>

                        <div class="form-group">
                        <input type="text" value="{{ $shippingDetails->state}}" class="form-control" id="shipping_state" name="shipping_state" placeholder="Shipping State"/>
                        </div>

                        <div class="form-group">
                            <select name="shipping_country" id="shipping_country" class="form-control">
                                <option value="">Select Country</option>
                                @foreach ($country as $item)
                                    <option value="{{$item->country_name}}" @if($item->country_name == $shippingDetails->country) selected @endif>{{$item->country_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                        <input type="text" value="{{ $shippingDetails->pincode}}" class="form-control" id="shipping_pincode" name="shipping_pincode" placeholder="Shipping Pincode"/>
                        </div>

                        <div class="form-group">
                        <input type="text" value="{{ $shippingDetails->mobile}}" class="form-control" id="shipping_mobile" name="shipping_mobile" placeholder="Shipping Mobile"/>
                        </div>
                </div>
            </div>
        </div>

        <div class="review-payment">
			<h2>Review & Payment</h2>
		</div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
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
                                <p> {{$cart->product_code}} || {{$cart->size}}</p>
                            </td>
                            <td class="cart_price">
                                <p>Tk {{$cart->price}}</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button" style="margin-left:20px;">
                                    {{$cart->quantity}}
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">Tk {{$cart->price * $cart->quantity}}</p>
                            </td>
                        </tr>
                        <?php $total_amount = $total_amount + ($cart->price * $cart->quantity)?>
                    @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Cart Sub Total</td>
                                    <td>Tk {{$total_amount}}</td>
                                </tr>
                                <tr>
                                    <td>Discount (-)</td>
                                    <td>
                                        @if (!empty(Session::get('couponAmount')))
                                            Tk {{Session::get('couponAmount')}}
                                        @else
                                            0
                                        @endif
                                        
                                    </td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Shipping Cost (+)</td>
                                    <td>{{ $shipping_charge }}</td>
                                </tr>
                                <tr>
                                    <td>Grand Total</td>
                                    <?php $getCurrencyRate = Product::getCurrencyRate($total_amount); ?>
                                    <td><span class="btn btn-secondary" data-toggle="tooltip" data-html="true" title="
                                            USD {{ $getCurrencyRate['USD_Rate'] }}<br>
                                            <hr>
                                            EURO {{ $getCurrencyRate['EURO_Rate'] }}
                                                ">Tk {{ $grand_total= ($total_amount + $shipping_charge) - Session::get('couponAmount') }}</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form action="{{url('/user/place-order')}}" id="paymentForm" name="paymentForm" method="POST">{{ csrf_field() }}
            <input type="hidden" name="grand_total" value="{{$grand_total}}">
            <input type="hidden" name="shipping_charge" value="{{ $shipping_charge }}">
            <div class="payment-options">
                <span>
                    <label><strong>Select Payment Method: </strong></label>
                </span>
                @if ($cod_pincode_count > 0)

                    <span>
                    <label><input type="radio" name="payment_method" id="cod" value="COD"> <strong>COD</strong></label>
                </span>
                @endif

                @if($prepaid_pincode_count > 0)
                <span>
                    <label><input type="radio" name="payment_method" id="paypal" value="Paypal"> <strong>Paypal</label>
                </span>
                @endif

                <span style="float:right">
                    <button type="submit" class="btn btn-default" onclick="return selectPaymentMethod();">Place order</button>
                </span>
            </div>
        </form>
    </div>
</section>
@endsection