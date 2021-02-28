@extends('theme.layouts.app')@section("title",$langJson->menu->corporate)
@section("header")
@endsection
@section("content")
@section("menuClass","bg-dark")
<!--breadcrumbs area start-->
<div class="page-banner-section section bg-image" data-bg="assets/images/bg/breadcrumb.png">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="page-banner text-left">
                    <h2>{{$langJson->menu->contact}}</h2>
                    <ul class="page-breadcrumb">
                        <li><a href="{{route("theme.{$langJson->routes->home}")}}">{{$langJson->menu->home}}</a></li>
                        <li>{{$langJson->menu->contact}}</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div><!--breadcrumbs area end-->

<!--contact map start-->
<div class="contact-map-section section">
    <div class="map-area">
        <div id="googleMap">
            <iframe src="{{$thisSetting->g_map}}" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
</div><!--contact map end-->

<!--contact area start-->
<div class="contact_area mt-3">
    <div class="container">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="contact_message content">
                    <h3>{{$langJson->contact->contact_us}}</h3>
                    <ul>
                        <li><i class="fa fa-fax"></i> {{$langJson->contact->address}} : {{$thisSetting->address}}</li>
                        <li><i class="fa fa-envelope"></i>
                            <a href="mailto:{{$thisSetting->email}}">{{$thisSetting->email}}</a></li>
                        <li>
                            <i class="fa fa-phone mr-2"></i><a href="tel:{{$thisSetting->phone_1}}">{{$thisSetting->phone_1}}</a>
                        </li>
                        <li>
                            <i class="fa fa-phone mr-2"></i><a href="tel:{{$thisSetting->phone_2}}">{{$thisSetting->phone_2}}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="contact-form-wrap">
                    <h3 class="contact-title">Write Us</h3>
                    <form id="contact-form" action="assets/php/mail.php" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="name-fild-padding mb-sm-30 mb-xs-30">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="contact-form-style mb-20">
                                                <label class="fild-name">Name</label>
                                                <input name="name" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="contact-form-style mb-20">
                                                <label class="fild-name">Email</label>
                                                <input name="email" placeholder="" type="email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="contact-form-style bl">
                                    <label class="fild-name pl-15">Message</label>
                                    <textarea class="pl-15" name="message" placeholder="Type your message here.."></textarea>
                                    <button class="btn" type="submit"><span>Send message</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="form-messege"></p>
                </div>
            </div>
        </div>
    </div>
</div><!--contact area end-->

@endsection
