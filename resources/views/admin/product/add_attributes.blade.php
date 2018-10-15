@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin Product Attributes</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Attributes</li>
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
            <form action="{{ url('/admin/add-attributes',$product->id) }}" method="POST" id="attribute_validate">
                {{ csrf_field() }}
                    <div class="card-body">
                        <h4 class="card-title">Add Product Attributes</h4>

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
                            <label for="product_color" class="col-sm-3 text-right control-label col-form-label">Product Color</label>
                            <label for="product_name" class="col-sm-3 text-right control-label col-form-label"><strong>{{$product->product_color}}</strong></label>
                        </div>

                        <div class="form-group row">
                            <label for="product_color" class="col-sm-3 text-right control-label col-form-label">Product Attributes</label>
                            <div class="field_wrapper">
                                <div>
                                    <input required type="text" name="sku[]" id="sku" placeholder="SKU"/>
                                    <input required type="text" name="size[]" id="size" placeholder="Size"/>
                                    <input required type="text" name="price[]" id="price" placeholder="Price"/>
                                    <input required type="text" name="stock[]" id="stock" placeholder="Stock"/>
                                    <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                </div>
                            </div>
                        </div>

                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Add Attributes</button>
                                <a href="{{url('/admin/view-product')}}" class="btn btn-success">Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>   
</div>

<div class="container-fluid" style="margin-top:-60px;">
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">View Product Attributes List</h5>
                <div class="table-responsive">
                    <form action="{{ url('/admin/edit-attributes/'.$product->id) }}" method="POST">
                        {{ csrf_field() }}
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>SUK</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product['attributes'] as $attribute)
                                <tr>
                                    <td><input type="hidden" name="idAttr[]" value="{{$attribute->id}}">{{$attribute->id}}</td>
                                    <td>{{$attribute->sku}}</td>
                                    <td>{{$attribute->size}}</td>
                                    <td><input type="text" name="price[]" value="{{$attribute->price}}"></td>
                                    <td><input type="text" name="stock[]" value="{{$attribute->stock}}"></td>

                                    <td>
                                        <input type="submit" value="Update" class="btn btn-primary btn-sm">
                                    <a rel="{{$attribute->id}}" rel1="delete-attribute" href="javascript:" 
                                        {{--href="{{url('/admin/delete-product',$product->id)}}"--}}
                                        class="btn btn-danger btn-sm deleteRecord"><i class="fas fa-trash" style="margirn-top:10px;"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>SUK</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
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