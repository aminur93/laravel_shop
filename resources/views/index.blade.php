@extends('layouts.frontLayouts.front_design')

@section('main-content')
    <?php use App\Product; ?>
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($banners as $key => $banner)
                        <li data-target="#slider-carousel" data-slide-to="0" @if($key == 0) class="active" @endif></li>
                        @endforeach
                    </ol>
                    
                    <div class="carousel-inner">
                        @foreach ($banners as $key => $banner)
                            <div class="item @if($key == 0) active @endif">
                                <a href="{{$banner->link}}" title="{{$banner->title}}"><img src="{{asset('/user/images/banners/'.$banner->image)}}" alt=""></a>
                            </div>
                        @endforeach
                        
                    </div>
                    
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</section><!--/slider-->

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Category</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        <div class="panel panel-default">
                            @foreach ($categories as $cat)
                             @if ($cat->status == "1")
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordian" href="#{{ $cat->id }}">
                                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                      {{ $cat->name }}
                                    </a>
                                </h4>
                            </div>
                            <div id="{{ $cat->id }}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        @foreach ($cat->cate as $item)
                                            <?php

                                            $productCount = Product::productCount($item->id);
                                            ?>
                                            @if ($item->status == "1")
                                            <li><a href="{{ url('/user/products/'.$item->url)}}">{{$item->name}} </a>({{ $productCount }})</li>
                                            @endif          
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div><!--/category-products-->
                
                    <div class="brands_products"><!--brands_products-->
                        <h2>Brands</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach ($brands as $brand)
                                <li><a href="{{url('/user/brand/'.$brand->url)}}"> <span class="pull-right">({{ $brand->products()->count() }})</span>{{$brand->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div><!--/brands_products-->
                    
                    <div class="price-range"><!--price-range-->
                        <h2>Price Range</h2>
                        <div class="well text-center">
                             <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                             <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                        </div>
                    </div><!--/price-range-->
                    
                    <div class="shipping text-center"><!--shipping-->
                        <img src="{{asset('user/images/home/shipping.jpg')}}" alt="" />
                    </div><!--/shipping-->
                
                </div>
            </div>
            
            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Feature Items</h2>
                    @foreach ($productAll as $product)
                        
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="{{asset('admin/products/small/'.$product->image)}}" alt="" />
                                        <h2>Tk {{$product->price}}</h2>
                                        <p>{{$product->product_name}}</p>
                                        <a href="{{url('/user/details/product/'.$product->id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </div>
                                    {{-- <div class="product-overlay">
                                        <div class="overlay-content">
                                            <h2>${{$product->price}}</h2>
                                            <p>{{$product->product_name}}</p>
                                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                    </div> --}}
                            </div>
                            <div class="choose">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @endforeach

                </div><!--features_items-->

                <div class="text-center">

                    {{ $productAll->links() }}
                </div>

            </div>
        </div>
    </div>
</section>
@endsection