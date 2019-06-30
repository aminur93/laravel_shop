<?php use App\Product; ?>
<form action="{{ url('/products/filters') }}" method="post">{{ csrf_field() }}
    @if (!empty($url))
        <input type="hidden" name="url" value="{{ $url }}">
    @endif
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
        
        @if (!empty($url))
            <h2>Colors</h2>
            <div class="panel-group category-products"><!--color filter-productsr-->
                @foreach($colorArray as $ca)
                    @if (!empty($_GET['color']))
                            @php $colorArr = explode('-', $_GET['color']); @endphp
                                @if (in_array($ca, $colorArr))
                                    @php $checkcolor = 'checked'; @endphp
                                @else
                                    @php $checkcolor = ''; @endphp
                                @endif
                        @else
                           @php $checkcolor = ''; @endphp
                    @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="">
                                <input onchange="javascript:this.form.submit();" type="checkbox" name="colorFilters[]" value="{{ $ca }}" id="{{ $ca }}" {{ $checkcolor }}>
                                <span class="products-colors">{{ $ca }}</span>
                            </a>
                        </h4>
                    </div>
                </div>
                    @endforeach
            </div>

            <h2>Sleeve</h2>
            <div class="panel-group category-products"><!--color filter-productsr-->
                @foreach($sleeveArray as $sa)
                    @if (!empty($_GET['sleeve']))
                        @php $sleeveArr = explode('-', $_GET['sleeve']); @endphp
                        @if (in_array($sa, $sleeveArr))
                            @php $checksleeve = 'checked'; @endphp
                        @else
                            @php $checksleeve = ''; @endphp
                        @endif
                    @else
                        @php $checksleeve = ''; @endphp
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="">
                                    <input onchange="javascript:this.form.submit();" type="checkbox" name="sleeveFilters[]" value="{{ $sa }}" id="{{ $sa }}" {{ $checksleeve }}>
                                    <span class="products-colors">{{ $sa }}</span>
                                </a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>

            <h2>Pattern</h2>
            <div class="panel-group category-products"><!--color filter-productsr-->
                @foreach($patternArray as $pa)
                    @if (!empty($_GET['pattern']))
                        @php $patternArr = explode('-', $_GET['pattern']); @endphp
                        @if (in_array($pa, $patternArr))
                            @php $checkpattern = 'checked'; @endphp
                        @else
                            @php $checkpattern = ''; @endphp
                        @endif
                    @else
                        @php $checkpattern = ''; @endphp
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="">
                                    <input onchange="javascript:this.form.submit();" type="checkbox" name="patternFilters[]" value="{{ $pa }}" id="{{ $pa }}" {{ $checkpattern }}>
                                    <span class="products-colors">{{ $pa }}</span>
                                </a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>

            <h2>Sizes</h2>
            <div class="panel-group category-products"><!--color filter-productsr-->
                @foreach($sizeArray as $size)
                    @if (!empty($_GET['size']))
                        @php $sizeArr = explode('-', $_GET['size']); @endphp
                        @if (in_array($size, $sizeArr))
                            @php $checksize = 'checked'; @endphp
                        @else
                            @php $checksize = ''; @endphp
                        @endif
                    @else
                        @php $checksize = ''; @endphp
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="">
                                    <input onchange="javascript:this.form.submit();" type="checkbox" name="sizeFilters[]" value="{{ $size }}" id="{{ $size }}" {{ $checksize }}>
                                    <span class="products-colors">{{ $size }}</span>
                                </a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif


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
        </div><br><br>

    </div>
</form>
