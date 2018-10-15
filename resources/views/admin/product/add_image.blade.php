@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Product Images</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Images</li>
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
            <form action="{{ url('/admin/add-image',$product->id) }}" method="POST" id="image_validate" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Add Product Images</h4>

                        <input type="hidden" name="product_id" value="{{$product->id}}">

                        <div class="form-group row">
                            <label for="product_name" class="col-sm-3 text-right control-label col-form-label">Product Name</label>
                            <label for="product_name" class="col-sm-3 text-right control-label col-form-label"><strong>{{$product->product_name}}</strong></label>
                        
                        </div>

                        <div class="form-group row">
                            <label for="product_code" class="col-sm-3 text-right control-label col-form-label">Product Code</label>
                            <label for="product_name" class="col-sm-3 text-right control-label col-form-label"><strong>{{$product->product_code}}</strong></label>
                        </div>

                        <div class="form-group row">
                            <label for="url" class="col-sm-3 text-right control-label col-form-label">Image Upload</label>
                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="form-control" name="image[]" id="image" multiple="multiple">
                                </div>
                            </div>
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Add Images</button>
                                <a href="{{url('/admin/view-product')}}" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>   
</div>

<div class="container-fluid" style="margin-top:-120px;">
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">View Product Images List</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Image</th>
                                <th>Product Id</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($product_Images as $proImages)
                               <tr>
                                   <td>{{$proImages->id}}</td>
                                    <td>
                                        <img src="{{asset('admin/products/large/'.$proImages->image)}}" alt="" width="50">
                                    </td>
                                   <td>{{$proImages->product_id}}</td>

                                   <td>
                                        <a rel="{{$proImages->id}}" rel1="delete-image" href="javascript:" 
                                            {{--href="{{url('/admin/delete-product',$product->id)}}"--}}
                                            class="btn btn-danger btn-sm deleteRecord"><i class="fas fa-trash" style="margirn-top:10px;"></i></a>
                                    </td>
                               </tr>
                           @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl No</th>
                                <th>Image</th>
                                <th>Product ID</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>   
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection