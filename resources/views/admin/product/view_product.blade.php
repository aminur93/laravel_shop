@extends('layouts.adminLayouts.admin_design')

@section('main-content')
    <!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Admin View Product</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Product</li>
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
        <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">View Product List</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Image</th>
                                <th>Feature Item</th>
                                <th>category</th>
                                <th>Brand</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Color</th>
                                <th>price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                
                           
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>
                                <img src="{{asset('admin/products/large/'.$product->image)}}" alt="" width="50">
                                </td>
                                <td>
                                    @if ($product->feature_item == 1)
                                        <span class="label-success">Feature</span>
                                        @else
                                        <span class="label-warning">Not Feature</span>
                                    @endif
                                </td>
                                <td>{{$product->category_name}}</td>
                                <td>{{$product->brand_name}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->product_code}}</td>
                                <td>{{$product->product_color}}</td>
                                <td>Tk {{$product->price}}</td>
                                <td style="display:inline-block;width:170px;">

                                <a href="{{$product->id}}" data-toggle="modal" data-target="#add-new-event{{$product->id}}" class="btn btn-info btn-sm">
                                        <i class="ti-plus"></i>
                                    </a>

                                <a href="{{url('/admin/edit-product',$product->id)}}" class="btn btn-cyan btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="{{url('/admin/add-attributes',$product->id)}}" class="btn btn-cyan btn-sm"><i class="fas fa-sort-up"></i></a>
                                <a href="{{url('/admin/add-image',$product->id)}}" class="btn btn-cyan btn-sm"><i class="fas fa-image"></i></a>

                                <a rel="{{$product->id}}" rel1="delete-product" href="javascript:" {{--href="{{url('/admin/delete-product',$product->id)}}"--}}
                                    class="btn btn-danger btn-sm deleteRecord"><i class="fas fa-trash" style="margirn-top:10px;"></i>
                                </a>
                                </td>
                            </tr>

                            <!-- Modal Add Category -->
                            <div class="modal fade none-border" id="add-new-event{{$product->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><strong>{{$product->product_name}}</strong></h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Product ID:</strong> {{$product->id}}</p>
                                            <p><strong>Product Category:</strong> {{$product->category_name}}</p>
                                            <p><strong>Product Brand:</strong> {{$product->brand_name}}</p>
                                            <p><strong>Product Description:</strong> {{$product->description}}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END MODAL -->
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl No</th>
                                <th>Image</th>
                                <th>feature Item</th>
                                <th>category</th>
                                <th>Brand</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Color</th>
                                <th>price</th>
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
