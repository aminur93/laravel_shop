@extends('layouts.frontLayouts.front_design')

@section('main-content')
<section id="form" style="margin-top:10px;">
    <div class="container">
            <div class="breadcrumbs">
                    <ol class="breadcrumb">
                      <li><a href="{{url('/')}}">Home</a></li>
                      <li class="active">Checkout</li>
                    </ol>
                </div>
        <form action="{{ url('/user/checkout') }}" method="POST" id="accountForm">{{ csrf_field() }}
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
                        <h2>Bill To</h2>
                            <div class="form-group">
                                <input type="text" class="form-control" @if(!empty($userDetails->name)) value="{{$userDetails->name}}" @endif id="billing_name" name="billing_name" placeholder="Billing Name"/>
                            </div>
                            <div class="form-group">
                            <input type="text" class="form-control" @if(!empty($userDetails->name)) value="{{$userDetails->address}}" @endif id="billing_address" name="billing_address" placeholder="Billing Address"/>
                            </div>

                            <div class="form-group">
                            <input type="text" class="form-control" @if(!empty($userDetails->name)) value="{{$userDetails->city}}" @endif id="billing_city" name="billing_city" placeholder="Billing City"/>
                            </div>

                            <div class="form-group">
                            <input type="text" class="form-control" @if(!empty($userDetails->name)) value="{{$userDetails->state}}" @endif id="billing_state" name="billing_state" placeholder="Billing State"/>
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
                            <input type="text" class="form-control" @if(!empty($userDetails->name)) value="{{$userDetails->pincode}}" @endif id="billing_pincode" name="billing_pincode" placeholder="Billing Pincode"/>
                            </div>

                            <div class="form-group">
                            <input type="text" class="form-control" @if(!empty($userDetails->name)) value="{{$userDetails->mobile}}" @endif id="billing_mobile" name="billing_mobile" placeholder="Billing Mobile"/>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="billtoship">
                                <label class="form-check-label" for="billtoship">Shipping Address same as Billing Address</label>
                            </div>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2></h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form">
                        <h2>Shipping Order</h2>
                        <div class="form-group">
                                <input type="text" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name}}" @endif class="form-control" id="shipping_name" name="shipping_name" placeholder="Shipping Name"/>
                            </div>
                            <div class="form-group">
                            <input type="text" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->address}}"  @endif class="form-control" id="shipping_address" name="shipping_address" placeholder="Shipping Address"/>
                            </div>

                            <div class="form-group">
                            <input type="text" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->city}}" @endif class="form-control" id="shipping_city" name="shipping_city" placeholder="Shipping City"/>
                            </div>

                            <div class="form-group">
                            <input type="text" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->state}}" @endif class="form-control" id="shipping_state" name="shipping_state" placeholder="Shipping State"/>
                            </div>

                            <div class="form-group">
                                <select name="shipping_country" id="shipping_country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach ($country as $item)
                                        <option value="{{$item->country_name}}" @if($item->country_name == !empty($shippingDetails->country)) selected @endif>{{$item->country_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                            <input type="text" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->pincode}}" @endif class="form-control" id="shipping_pincode" name="shipping_pincode" placeholder="Shipping Pincode"/>
                            </div>

                            <div class="form-group">
                            <input type="text" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->mobile}}" @endif class="form-control" id="shipping_mobile" name="shipping_mobile" placeholder="Shipping Mobile"/>
                            </div>
                        <button type="submit" class="btn btn-default">Checkout</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection