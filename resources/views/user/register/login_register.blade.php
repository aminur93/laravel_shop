@extends('layouts.frontLayouts.front_design')

@section('main-content')

<section id="form" style="margin-top:10px;"><!--form-->
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
                <div class="login-form"><!--login form-->
                    <h2>Login to your account</h2>
                    <form action="{{url('/user/user-login')}}" method="post" id="loginForm">
                        {{ csrf_field() }}
                        <input type="email" id="email" name="email" placeholder="Email Address" required />
                        <input type="password" id="password" name="password" placeholder="Password" required />
                        {{-- <span>
                            <input type="checkbox" class="checkbox"> 
                            Keep me signed in
                        </span> --}}
                        <button type="submit" class="btn btn-default">Login</button>
                        <br>
                        <a href="{{ url('/user/forget-password') }}">Forget Password</a>
                    </form>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>New User Signup!</h2>
                    <form action="{{url('/user/user-register')}}" method="post" id="registerFrom">
                        {{ csrf_field() }}
                        <input type="text" id="name" name="name" placeholder="Name"/>
                        <input type="email" id="remail" name="remail" placeholder="Email Address"/>
                        <input type="password" id="myPassword" name="password" placeholder="Password"/>
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->
@endsection