@extends('layouts.frontLayouts.front_design')

@section('main-content')

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
                                                        @if ($item->status == "1")
                                                            <li><a href="{{ url('/user/products/'.$item->url)}}">{{$item->name}} </a></li>
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

                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--Pages-->
                        <h2 class="title text-center">Contact us</h2>
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
                        <div class="contact-form">
                            <div class="status alert alert-success" style="display: none"></div>
                            <form action="{{ url('/page/contact') }}" id="main-contact-form" class="contact-form row" name="contact-form" method="post">
                                @csrf
                                <div class="form-group col-md-6">
                                    <input type="text" name="name" class="form-control" required="required" placeholder="Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" name="email" class="form-control" required="required" placeholder="Email">
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="text" name="subject" class="form-control" required="required" placeholder="Subject">
                                </div>
                                <div class="form-group col-md-12">
                                    <textarea name="body" id="body" required="required" class="form-control" rows="8" placeholder="Your Message Here"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div><!--Pages-->

                </div>
            </div>
        </div>
    </section>
@endsection