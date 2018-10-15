@extends('layouts.adminLayouts.admin_design')

@section('main-content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Category</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Category</li>
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
            <form action="{{ url('/admin/add-category') }}" method="POST" id="category_validate">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Add Category</h4>
                        <div class="form-group row">
                            <label for="category_name" class="col-sm-3 text-right control-label col-form-label">Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_name" class="col-sm-3 text-right control-label col-form-label">Category Level</label>
                            <div class="col-sm-6">
                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="parent_id" id="">
                                    <option value="0">Main category</option>
                                    @foreach ($levels as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="description" id="description" placeholder="Description">  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">URL</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="url" id="url" placeholder="URL">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Enable</label>
                            <div class="col-sm-1" style="margin-top:10px;margin-left:-30px;">
                                <input type="checkbox" class="form-control" name="status" id="status" value="1">
                            </div>
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Add category</button>
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