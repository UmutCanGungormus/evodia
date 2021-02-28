@extends('theme.layouts.app')@section("title",$langJson->menu->products)
@section("header")
@endsection
@section("content")
@section("menuClass","bg-dark")
<!-- Page Banner Section Start -->
<div class="page-banner-section section bg-image" data-bg="{{asset("storage/{$viewData->item->img_url->$lang}")}}">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="page-banner text-left">
                    <h2>{{$viewData->item->title->$lang}}</h2>
                    <ul class="page-breadcrumb">
                        <li><a href="index.html">{{$langJson->menu->home}}</a></li>
                        <li>{{$viewData->item->title->$lang}}</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div><!-- Page Banner Section End --><!-- Shop Section Start -->
<div class="shop-section section pt-60 pt-lg-40 pt-md-30 pt-sm-20 pt-xs-30  pb-70 pb-lg-50 pb-md-40 pb-sm-60 pb-xs-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shop-area">
                    <div class="row">
                        <div class="col-12">
                            <!-- Grid & List View Start -->
                            <div class="shop-topbar-wrapper d-flex justify-content-between align-items-center">
                                <div class="grid-list-option d-flex">
                                    <ul class="nav">
                                        <li>
                                            <a data-toggle="tab" href="#grid"><i class="fa fa-th"></i></a>
                                        </li>
                                        <li>
                                            <a class="active show" data-toggle="tab" href="#list" class=""><i class="fa fa-th-list"></i></a>
                                        </li>
                                    </ul>
                                    <p>{{(empty($viewData->products->data)?"0":count((array)$viewData->products->data))}} {{$langJson->category->showing}}</p>
                                </div>
                                <!--Toolbar Short Area Start-->
                                <div class="toolbar-short-area d-md-flex align-items-center">
                                    <div class="toolbar-shorter ">
                                        <select name="orderby" class="order-by wide" id="short">
                                            <option {{(Cookie::get("order")=="desc" && Cookie::get("column")=="id" ?"selected":"")}} value="id,desc">{{$langJson->select_order->new}}</option>
                                            <option {{(Cookie::get("order")=="asc" && Cookie::get("column")=="id" ?"selected":"")}} value="id,asc">{{$langJson->select_order->old}}</option>
                                            <option {{(Cookie::get("order")=="asc" && Cookie::get("column")=="price->{$lang}" ?"selected":"")}} value="price->{{$lang}},asc">{{$langJson->select_order->cheap}}</option>
                                            <option {{(Cookie::get("order")=="desc" && Cookie::get("column")=="price->{$lang}" ?"selected":"")}} value="price->{{$lang}},desc">{{$langJson->select_order->expensive}}</option>
                                        </select>
                                    </div>
                                </div>
                                <!--Toolbar Short Area End-->
                            </div>
                            <!-- Grid & List View End -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 order-lg-1 order-2">
                            <!-- Single Sidebar Start  -->
                            <div class="common-sidebar-widget">
                                <h3 class="sidebar-title">{{$langJson->category->sub_category}}</h3>
                                <ul class="sidebar-list">
                                    @foreach($viewData->sub as $category)
                                        <li><a href="#"><i class="fa fa-plus"></i>{{$category->title->$lang}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- Single Sidebar End  -->

                        </div>
                        <div class="col-lg-9 order-lg-2 order-1">
                           @if(count((array)$viewData->products)>0)
                                <div class="row">
                                    <div class="col-12">
                                        <div class="shop-product">
                                            <div class="render-data">
                                                <div id="myTabContent-2" class="tab-content">
                                                    <div id="grid" class="tab-pane fade">
                                                        <div class="product-grid-view">
                                                            <div class="row">
																
                                                                @foreach($viewData->products->data as $product)
                                                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                                                        <!--  Single Grid product Start -->
                                                                        <div class="single-grid-product mb-40">
                                                                            <div class="product-image">
                                                                                @if($product->isDiscount)
                                                                                    <div class="product-label">
                                                                                        <span>{{$langJson->home->discount}}</span>
                                                                                    </div>
                                                                                @endif

                                                                                <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">
                                                                                    <img src="{{asset("storage/{$product->cover_photo->img_url}")}}" class="img-fluid" alt="{{$product->title->$lang}}"></a>
                                                                                <div class="product-action">
                                                                                    <ul>
                                                                                        <li>
                                                                                            <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}"><i class="fa fa-search  mt-2"></i></a>
                                                                                        </li>

                                                                                        <li>
                                                                                            <a data-id="{{$product->id}}" class="addToFavourite" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="fa fa-heart  mt-2"></i></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-content">
                                                                                <h3 class="title">
                                                                                    <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">{{$product->title->$lang}}</a>
                                                                                </h3>
                                                                                <p class="product-price">
                                                                                    <span class="discounted-price">{{$product->price->$lang}} {{$langJson->home->price}}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <!--  Single Grid product End -->
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="list" class="tab-pane fade active show">
                                                        <div class="product-list-view">
                                                            <!-- Single List Product Start -->
                                                            @foreach($viewData->products->data as $product)
                                                                <div class="product-list-item mb-40">
                                                                    <div class="row">
                                                                        <div class="col-md-4 col-sm-6">
                                                                            <div class="single-grid-product">
                                                                                <div class="product-image">
                                                                                    @if($product->isDiscount)
                                                                                        <div class="product-label">
                                                                                            <span>{{$langJson->home->discount}}</span>
                                                                                        </div>
                                                                                    @endif

                                                                                    <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">
                                                                                        <img src="{{asset("storage/{$product->cover_photo->img_url}")}}" class="img-fluid" alt="{{$product->title->$lang}}"></a>

                                                                                    <div class="product-action">
                                                                                        <ul>
                                                                                            <li>
                                                                                                <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}"><i class="fa fa-search  mt-2"></i></a>
                                                                                            </li>

                                                                                            <li>
                                                                                                <a data-id="{{$product->id}}" class="addToFavourite" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="fa fa-heart  mt-2"></i></a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-8 col-sm-6">
                                                                            <div class="product-content-shop-list">
                                                                                <div class="product-content">
                                                                                    <h3 class="title">
                                                                                        <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">{{$product->title->$lang}}</a>
                                                                                    </h3>
                                                                                    <p class="product-price">
                                                                                        <span class="discounted-price">{{$product->price->$lang}} {{$langJson->home->price}}</span>
                                                                                    </p>
                                                                                    <p class="product-desc">{{Str::words($product->description->$lang,"3","...")}}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        @endforeach
                                                        <!-- Single List Product Start -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-30 mb-sm-40 mb-xs-30">
                                    <div class="col">
                                        <ul class="page-pagination">
                                            {!! $links !!}
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger">{{$langJson->alert->no_product}}</div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Shop Section End -->


@endsection

@section("footer")
    <script>
        $(document).ready(function () {
            $(document).on("change", ".order-by", function () {
                let value = $(this).val();
                value = value.split(",")
                setCookie("column", value[0]);
                setCookie("order", value[1])
                $.ajax({
                    "url": "{{route("theme.{$langJson->routes->render_category}",$viewData->item->seo_url->$lang)}}",
                    "data": {"column": value[0], "order": value[1]},
                    "type": "POST"
                }).done(function (response) {
                    $(".render-data").html(response)
                })
            })
        })
    </script>
@endsection
