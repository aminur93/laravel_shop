@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Product</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product</li>
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
            <form action="{{ url('/admin/add-product') }}" method="POST" id="product_validate" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Add Product</h4>

                        <div class="form-group row">
                            <label for="category_id" class="col-sm-3 text-right control-label col-form-label">Product Category</label>
                            <div class="col-sm-6">
                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="category_id" id="category_id">
                                    <?php echo $categories_dropdown; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category_name" class="col-sm-3 text-right control-label col-form-label">Product Brand</label>
                            <div class="col-sm-6">
                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="brand_id" id="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach ($brand as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_name" class="col-sm-3 text-right control-label col-form-label">Product Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_code" class="col-sm-3 text-right control-label col-form-label">Product Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Product Code">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="product_color" class="col-sm-3 text-right control-label col-form-label">Product Color</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="product_color" id="product_color" placeholder="Product Color">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Product Description</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-sm-3 text-right control-label col-form-label">Product Metrials & Care</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="care" id="care" placeholder="Metrials & Care"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-sm-3 text-right control-label col-form-label">Product Price</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="price" id="price" placeholder="Price">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-sm-3 text-right control-label col-form-label">Image Upload</label>
                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
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
                                <button type="submit" class="btn btn-primary">Add Product</button>
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