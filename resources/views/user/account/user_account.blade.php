@extends('layouts.frontLayouts.front_design')

@section('main-content')

<section id="form" style="margin-top:10px;">
    <div class="container">
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
                    <h2>Update Account</h2>
                    <form action="{{url('/user/user-account')}}" method="POST" id="accountForm">
                        {{ csrf_field() }}
                        <input type="text" value="{{$userDetails->name}}" id="name" name="name" placeholder="Name"/>
                        <input type="text" value="{{$userDetails->address}}" id="address" name="address" placeholder="Address"/>
                        <input type="text" value="{{$userDetails->city}}" id="city" name="city" placeholder="City"/>
                        <input type="text" value="{{$userDetails->state}}" id="state" name="state" placeholder="State"/>
                        <select name="country" id="country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{$country->country_name}}" @if($country->country_name == $userDetails->country) selected @endif>{{$country->country_name}}</option>
                            @endforeach
                        </select>
                        <input style="margin-top:10px;" type="text" value="{{$userDetails->pincode}}" id="pincode" name="pincode" placeholder="Pincode"/>
                        <input type="text" value="{{$userDetails->mobile}}" id="mobile" name="mobile" placeholder="Mobile"/>
                        <button type="submit" class="btn btn-default">Update</button>
					</form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Update Password</h2>
                    <form action="{{url('/user/user-update-password')}}" method="post" id="UpdatePassword">
                        {{ csrf_field() }}
                        <input type="password" name="current_pwd" id="current_pwd" placeholder="Current Password">
                        <span id="chkpwd"></span>
                        <input type="password" name="new_pwd" id="new_pwd" placeholder="New Password">
                        <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirm Password">
                        <button type="submit" class="btn btn-default">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection