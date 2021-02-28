@extends('theme.layouts.app')@section("title",$langJson->menu->home)
@section("header")
@endsection
@section("content")
    <!--slider section start-->
    <div class="hero-section section position-relative">
        <div class="hero-slider section">
        @foreach($viewData->slider as $slide)
            <!--Hero Item start-->
                <div class="hero-item  bg-image" data-bg="{{asset("storage/{$slide->img_url->$lang}")}}">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <!--Hero Content start-->
                                <div class="hero-content-2 center">
                                    <h2>{{$slide->title->$lang}}</h2>
                                    <a href="{{(!empty($slide->url->$lang)?$slide->url->$lang:"#")}}" class="btn">{{$langJson->home->examine}}</a>
                                </div>
                                <!--Hero Content end-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--Hero Item end-->
            @endforeach
        </div>
    </div><!--slider section end-->


    <!-- Banner section start -->
    <div class="banner-section section pt-30">
        <div class="container">
            <div class="row">
                @foreach($viewData->banners as $item)
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <!-- Single Banner Start -->
                        <div class="single-banner-item mb-30">
                            <div class="banner-image">
                                <a href="{{$item->url->$lang}}">
                                    <img src="{{asset("storage/{$item->img_url->$lang}")}}" alt="{{$item->title->$lang}}">
                                </a>
                            </div>
                            <div class="banner-content">
                                <h3 class="title">{{$item->title->$lang}}</h3>
                                <a href="{{$item->url->$lang}}">{{$langJson->home->examine}}</a>
                            </div>
                        </div>
                        <!-- Single Banner End -->
                    </div>
                @endforeach

            </div>
        </div>
    </div><!-- Banner section End -->


    <!--Product section start-->
    <div class="product-section section pt-70 pt-lg-50 pt-md-40 pt-sm-30 pt-xs-20 pb-55 pb-lg-35 pb-md-25 pb-sm-15 pb-xs-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title text-center mb-15">
                        <h2>{{$langJson->home->trendProduct}}</h2>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div id="home" class="tab-pane fade active show">
                    <div class="row">
                        @foreach($viewData->discountProduct as $item)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <!--  Single Grid product Start -->
                                <div class="single-grid-product mb-40">
                                    <div class="product-image">
                                        @if($item->isDiscount)
                                            <div class="product-label">
                                                <span>{{$langJson->home->discount}}</span>
                                            </div>
                                        @endif

                                        <a href="{{route("theme.{$langJson->routes->product}",$item->seo_url->$lang)}}">
                                            <img src="{{asset("storage/{$item->cover_photo->img_url}")}}" class="img-fluid" alt="{{$item->title->$lang}}">
                                        </a>

                                        <div class="product-action">
                                            <ul>
                                                <li>
                                                    <a href="{{route("theme.{$langJson->routes->product}",$item->seo_url->$lang)}}"><i class="fa fa-search mt-2"></i></a>
                                                </li>
                                                <li>
                                                    <a data-id="{{$item->id}}" class="deleteToFavourite {{!empty($item->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->delete_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favouriteDelete}}"><i class="fa fa-heart  mt-2"></i></a>
                                                </li>

                                                <li>
                                                    <a data-id="{{$item->id}}" class="addToFavourite {{empty($item->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->add_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="far fa-heart  mt-2"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title">
                                            <a href="{{route("theme.{$langJson->routes->product}",$item->seo_url->$lang)}}">{{$item->title->$lang}}</a>
                                        </h3>
                                        <p class="product-price">
                                            <span class="discounted-price">{{$item->price->$lang}} {{$langJson->home->price}}</span>
                                        </p>
                                    </div>
                                </div>
                                <!--  Single Grid product End -->
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>


        </div>
    </div><!--Product section end-->

    <!--Product section start-->
    <div class="product-section section pt-70 pt-lg-50 pt-md-40 pt-sm-30 pt-xs-20 pb-55 pb-lg-35 pb-md-25 pb-sm-15 pb-xs-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-title text-center mb-15">
                        <h2>{{$langJson->home->isComing}}</h2>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div id="home" class="tab-pane fade active show">
                    <div class="row">
                        @foreach($viewData->homeProduct as $item)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <!--  Single Grid product Start -->
                                <div class="single-grid-product mb-40">
                                    <div class="product-image">
                                        @if($item->isDiscount)
                                            <div class="product-label">
                                                <span>{{$langJson->home->discount}}</span>
                                            </div>
                                        @endif

                                        <a href="{{route("theme.{$langJson->routes->product}",$item->seo_url->$lang)}}">
                                            <img src="{{asset("storage/{$item->cover_photo->img_url}")}}" class="img-fluid" alt="{{$item->title->$lang}}">
                                        </a>

                                        <div class="product-action">
                                            <ul>
                                                <li>
                                                    <a href="{{route("theme.{$langJson->routes->product}",$item->seo_url->$lang)}}"><i class="fa fa-search  mt-2"></i></a>
                                                </li>
                                                    <li>
                                                        <a data-id="{{$item->id}}" class="deleteToFavourite {{!empty($item->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->delete_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favouriteDelete}}"><i class="fa fa-heart  mt-2"></i></a>
                                                    </li>

                                                    <li>
                                                        <a data-id="{{$item->id}}" class="addToFavourite {{empty($item->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->add_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="far fa-heart  mt-2"></i></a>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3 class="title">
                                            <a href="{{route("theme.{$langJson->routes->product}",$item->seo_url->$lang)}}">{{$item->title->$lang}}</a>
                                        </h3>
                                        <p class="product-price">
                                            <span class="discounted-price">{{$item->price->$lang}} {{$langJson->home->price}}</span>
                                        </p>
                                    </div>
                                </div>
                                <!--  Single Grid product End -->
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>


        </div>
    </div><!--Product section end-->

@endsection
