@extends('layouts.adminLayouts.admin_design')

@section('main-content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Edit Banners</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Banners</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->

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

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ url('/admin/edit-banners/'.$banners->id) }}" method="POST" id="banner_validate" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Edit Banners</h4>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 text-right control-label col-form-label">Image Upload</label>
                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                            </div>
                        </div>

                        @if(!empty($banners->image))
                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Image</label>
                            <div class="col-sm-3">
                                <img src="{{asset('user/images/banners/'.$banners->image)}}" alt="" width="200px;">

                                <div class="col-sm-3" style="margin-top:20px;">
                                    <a href="{{ url('/admin/delete-banner-image/'. $banners->id)}}" class="btn btn-sm btn-danger" id="delImage">Delete Image</a>
                                </div>
                                
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="title" class="col-sm-3 text-right control-label col-form-label">Title</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{$banners->title}}" class="form-control" name="title" id="title" placeholder="Title">  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="link" class="col-sm-3 text-right control-label col-form-label">Link</label>
                            <div class="col-sm-6">
                                <input type="text" value="{{$banners->link}}" class="form-control" name="link" id="link" placeholder="Link">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                            <div class="col-sm-1" style="margin-top:10px;margin-left:-30px;">
                                <input type="checkbox" class="form-control" name="status" id="status" @if($banners->status == 1) checked @endif value="1">
                            </div>
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Edit Brand</button>
                                <a href="{{url('/admin/view-banners')}}" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>   
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
    
@endsection