@extends('layouts.frontLayouts.front_design')

@section('main-content')
<?php use App\Product; ?>
<section>
    <div class="container">
        <div class="row">
            @if (Session::has('flash_message_error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>	
                        <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif
            
            <div class="col-sm-3">
                @include('layouts.frontLayouts.front_sidebar')
            </div>
            
            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                <a href="{{asset('admin/products/large/'.$products->image)}}">
                                   <img style="width:300px;" class="mainImage" src="{{asset('admin/products/medium/'.$products->image)}}" alt="" />
                                </a>
                            </div>
                        </div>
                        <div id="similar-product" class="carousel slide" data-ride="carousel">
                            
                              <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active thumbnails">
                                            <a href="{{asset('admin/products/large/'.$products->image)}}" data-standard="{{asset('admin/products/small/'.$products->image)}}">
                                                <img class="changeImage" style="width:80px;" class="mainImage" src="{{asset('admin/products/small/'.$products->image)}}" alt="" />
                                             </a>
                                        @foreach ($productAltimages as $altimage)
                                        <a href="{{asset('admin/products/large/'.$altimage->image)}}" data-standard="{{asset('admin/products/small/'.$altimage->image)}}">
                                        <img style="cursor:pointer;" class="changeImage" src="{{asset('admin/products/small/'.$altimage->image)}}" alt="" width="80">
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <form action="{{url('/user/add-cart')}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" value="{{$products->id}}">
                            <input type="hidden" name="product_name" value="{{$products->product_name}}">
                            <input type="hidden" name="product_code" value="{{$products->product_code}}">
                            <input type="hidden" name="product_color" value="{{$products->product_color}}">
                            <input type="hidden" name="price" id="price" value="{{$products->price}}">

                            <div class="product-information"><!--/product-information-->
                                <div align="left"><?php echo $breadcrumb; ?></div>
                                <div>&nbsp;</div>
                                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                                <h2>{{$products->product_name}}</h2>
                                <p>Code : {{$products->product_code}}</p>
                                <p>Color : {{ $products->product_color }}</p>
                                @if (!empty($products->sleeve))
                                    <p>Sleeve : {{ $products->sleeve }}</p>
                                @endif
                                <p>
                                    <select name="size" id="Selsize" style="width:150px;" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($products->attributes as $sizes)
                                            <option value="{{$products->id}}-{{$sizes->size}}">{{$sizes->size}}</option>
                                        @endforeach
                                    </select>
                                </p>
                                <img src="images/product-details/rating.png" alt="" />
                                <span>
                                    <?php $getCurrencyRate = Product::getCurrencyRate($products->price); ?>
                                    <span id="getPrice">
                                        TK {{$products->price}}<br>
                                        <hr>
                                        <h2>
                                            USD {{ $getCurrencyRate['USD_Rate'] }}<br>
                                            <hr>
                                            EURO {{ $getCurrencyRate['EURO_Rate'] }}<br>
                                        </h2>
                                    </span>
                                    <label>Quantity:</label>
                                    <input type="text" name="quantity" value="1" />
                                    @if ($total_stock > 0)
                                        <button type="submit" class="btn btn-default cart" id="cartButton" name="cartButton" value="shopping cart">
                                            <i class="fa fa-shopping-cart"></i>
                                            Add to cart
                                        </button>
                                    @endif
                                        <button type="submit" class="btn btn-default cart" id="wishlistButton" name="wishlistButton" value="wish list">
                                            <i class="fa fa-briefcase"></i>
                                            Add to WishList
                                        </button>
                                </span>
                                <p><b>Availability:</b> <span id="Availability"> @if($total_stock > 0)In Stock @else Out Of Stock @endif </span></p>
                                <p><b>Condition:</b> New</p>
                                <p><b>Brand:</b> {{$products->brand->name}}</p>
                                <p>
                                    <b>Delivert:</b>
                                    <input type="text" name="pincode" id="chkPincode"
                                           placeholder="Check Pincode" style="width:150px;" class="form-control">
                                    <button type="button" onclick="return checkPincode();" style="margin-left: 154px;margin-top: -55px;" class="btn btn-primary">Go</button>
                                </p>
                                <span id="pincodeResponse" style="margin-top: -15px;margin-bottom: 20px;"></span>
                                <div style="margin-left: -180px;" class="sharethis-inline-share-buttons"></div>
                            </div><!--/product-information-->
                        </form>
                    </div>
                </div><!--/product-details-->
                
                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#description" data-toggle="tab">Description</a></li>
                            <li><a href="#care" data-toggle="tab">Metrials & Care</a></li>
                            <li><a href="#delivery" data-toggle="tab">Delivery Options</a></li>
                            @if(!empty($products->video))
                            <li><a href="#videos" data-toggle="tab">Product Videos</a></li>
                                @endif
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="description" >
                            <div class="col-sm-12">
                                <p style="margin:10px;">{{$products->description}}</p>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="care" >
                            <div class="col-sm-12">
                                <p style="margin:10px;">{{$products->care}}</p>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="delivery" >
                            <div class="col-sm-12">
                                <p style="margin:10px;">
                                    100% Original Products<br>
                                    Cash On deivery
                                </p>
                            </div>
                        </div>

                        @if (!empty($products->video))
                            <div class="tab-pane fade" id="videos" >
                                <div class="col-sm-12">
                                    <p style="margin:10px;">
                                        <video width="320" height="240" controls>
                                            <source src="{{asset('admin/videos/'.$products->video)}}" type="video/mp4">
                                        </video>
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>
                </div><!--/category-tab-->
                
                <div class="recommended_items"><!--recommended_items-->
                    <h2 class="title text-center">recommended items</h2>

                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $count = 1;?>
                            @foreach ($relatedProducts->chunk(3) as $chunk)
                        <div <?php if($count == 1) { ?> class="item active" <?php } else { ?> class="item" <?php }?>>
                                @foreach ($chunk as $item)
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="{{asset('admin/products/small/'.$item->image)}}" alt="" />
                                                <h2>Tk {{$item->price}}</h2>
                                                <p>{{$item->product_name}}</p>
                                                <a href="{{url('/user/details/product/'.$item->id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach	
                            </div>
                            <?php $count++;?>
                            @endforeach
                        </div>
                         <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                          </a>
                          <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                          </a>			
                    </div>

                </div><!--/recommended_items-->
                
            </div>
        </div>
    </div>
</section>
@endsection