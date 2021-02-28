@extends('theme.layouts.app')
@section("title",$langJson->menu->corporate)
@section("header")
@endsection
@section("content")


<!-- Page Banner Section Start -->
<div class="page-banner-section section bg-image" data-bg="assets/images/bg/breadcrumb.png">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="page-banner text-left">
                    <h2>{{$viewData->item->title->$lang}}</h2>
                    <ul class="page-breadcrumb">
                        <li><a  href="{{route("theme.{$langJson->routes->home}")}}">{{$langJson->menu->home}}</a></li>
                        <li>{{$viewData->item->title->$lang}}</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Page Banner Section End -->
<!--Blog section start-->
<div class="blog-section section pt-90 pt-lg-70 pt-md-60 pt-sm-50 pt-xs-40 pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12  mb-sm-40 mb-xs-30 pl-40 pl-md-15 pl-sm-15 pl-xs-15">
                <div class="row">
                    <div class="blog-details col-12">
                        <div class="blog-inner">
                            <div class="blog-media">
                                <div class="image"><img src="{{asset("storage/{$viewData->item->img_url->$lang}")}}" alt="{{$viewData->item->title->$lang}}"></div>
                            </div>
                            <div class="content">

                                <h2 class="title">{{$viewData->item->title->$lang}}</h2>
                                <div class="desc mb-30">

                                    <blockquote class="blockquote mt-30 mb-30">
                                        <p>{{$viewData->item->description->$lang}}</p>
                                        <span class="author">{{$thisSetting->company_name}}</span>
                                    </blockquote>


                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--Blog section end-->
@endsection
