<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @if (!empty($meta_title)) {{ $meta_title }} @else Shops @endif </title>
    @if (!empty($meta_description)) <meta name="description" content="{{ $meta_description }}">@endif

    @if (!empty($meta_keyword)) <meta name="keywords" content="{{ $meta_keyword }}">@endif

    <link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/easyzoom.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('user/css/passtrength.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{asset('user/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('user/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('user/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('user/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('user/images/ico/apple-touch-icon-57-precomposed.png')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet">
</head><!--/head-->

<body>
	@include('layouts.frontLayouts.front_header')
	
	@section('main-content')
        
    @show
	
	
	@include('layouts.frontLayouts.front_footer')

  
    <script src="{{asset('user/js/jquery.js')}}"></script>
    <script src="{{asset('user/js/validate.js')}}"></script>
	<script src="{{asset('user/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('user/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('user/js/price-range.js')}}"></script>
    <script src="{{asset('user/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('user/js/easyzoom.js')}}"></script>
    <script src="{{asset('user/js/main.js')}}"></script>
    <script src="{{ asset('user/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('user/js/passtrength.js')}}"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    
</body>
</html>