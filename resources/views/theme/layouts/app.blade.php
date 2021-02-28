<!doctype html>
<html class="no-js" lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{$thisSetting->company_name}} | @yield("title") </title>
    <meta name="description" content="{{$thisSetting->meta_descripton}}">
    <meta name="keywords" content="{{$thisSetting->meta_keywords}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset("storage/{$thisSetting->favicon}")}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Place favicon.ico in the root directory -->
    <link href="{{asset("storage/{$thisSetting->favicon}")}}" type="img/x-icon" rel="shortcut icon">
    <!-- All css files are included here. -->
    <link rel="stylesheet" href="{{asset("theme/assets/css/vendor/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("theme/assets/css/vendor/iconfont.min.css")}}">
    <link rel="stylesheet" href="{{asset("theme/assets/css/vendor/helper.css")}}">
    <link rel="stylesheet" href="{{asset("theme/assets/css/plugins/plugins.css")}}">
    <link rel="stylesheet" href="{{asset("theme/assets/css/iziToast.css")}}">
    <link rel="stylesheet" href="{{asset("theme/assets/css/font-awesome.css")}}">
    <link rel="stylesheet" href="{{asset("theme/assets/css/jquery-ui.min.css")}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{asset("theme/assets/css/iziModal.min.css")}}">
    <link rel="stylesheet" href="{{asset("theme/assets/css/style.css")}}">
    <!-- Modernizr JS -->
    <script src="{{asset("theme/assets/js/vendor/modernizr-2.8.3.min.js")}}"></script>
    <script>let base_url = "{{asset("theme/assets")}}" </script>
    <script>let ajax_url = "{{url("/")}}" </script>
</head>

<body>

<div id="main-wrapper">

    <!--Header section start-->
    <header class="header header-transparent header-sticky  d-lg-block d-none">
        <div class="header-deafult-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-2 col-md-4 col-12">
                        <!--Logo Area Start-->
                        <div class="logo-area">
                            <a href="{{route("theme.{$langJson->routes->home}")}}"><img src="{{asset("storage/{$thisSetting->logo}")}}" alt="{{$thisSetting->company_name}}"></a>
                        </div>
                        <!--Logo Area End-->
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-4 d-none d-lg-block col-12">
                        <!--Header Menu Area Start-->
                        <div class="header-menu-area text-center">
                            <nav class="main-menu">
                                <ul>
                                    <li>
                                        <a href="{{route("theme.{$langJson->routes->home}")}}">{{$langJson->menu->home}}</a>
                                    </li>
                                    <li><a href="javascript:void(0)">{{$langJson->menu->products}}</a>
                                        <ul class="mega-menu four-column left-0">
                                            {!! $viewData->categories!!}

                                        </ul>
                                    </li>
                                    <li><a href="javascript:void(0)">{{$langJson->menu->corporate}}</a>
                                        <ul class="sub-menu">
                                            @foreach($viewData->corporates as $corporate)
                                                <li>
                                                    <a href="{{route("theme.{$langJson->routes->corporate}",$corporate->seo_url->$lang)}}">{{$corporate->title->$lang}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{route("theme.{$langJson->routes->contact}")}}">{{$langJson->menu->contact}}</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!--Header Menu Area End-->
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-5 col-12">
                        <!--Header Search And Mini Cart Area Start-->
                        <div class="header-search-cart-area">
                            <ul>
                                <li>
                                    <a class="header-search-toggle" href="#"><i class="flaticon-magnifying-glass"></i></a>
                                </li>
                                <li class="currency-menu"><a href="#"><i class="flaticon-user"></i></a>
                                    <!--Crunccy dropdown-->
                                    <ul class="currency-dropdown">
                                        <!--Language Currency Start-->
                                        <li><a href="#">{{$langJson->menu->language}}</a>
                                            <ul>
                                                @foreach($settings as $setting)
                                                    @php
                                                        $url=\App\Helpers\Helpers::thisPageUrl($setting->language,$langJson,$page);
                                                        $parameterLang=$setting->language;
                                                    @endphp
                                                    <li {{($lang==$setting->language?'class="active"':'')}}>
                                                        <a href="{{(!empty($parameter)?route("theme.{$url}",$parameter->$parameterLang):route("theme.{$url}"))}}">
                                                            <span class="flex-shrink-1 mr-1 align-middle my-auto py-auto flag-icon  flag-icon-{{($setting->language=="en"?"us":$setting->language)}}"></span>
                                                            <span class='flex-grow-1 align-middle  my-auto py-auto'>{{strtoupper($setting->language)}}</span>
                                                        </a>
                                                    </li>

                                                @endforeach


                                            </ul>
                                        </li>
                                        <!--Language Currency End-->
                                        <!--Account Currency Start-->
                                        <li><a href="javascript:void(0)">{{$langJson->home->account}}</a>
                                            <ul>
                                                @if(\Session::has('user'))
                                                    <li>
                                                        <a href="{{route("theme.{$langJson->routes->account}")}}"><i class="fas fa-user-circle"></i> {{$langJson->home->account}}
                                                        </a></li>
                                                    <li>
                                                        <a href="{{route("theme.{$langJson->routes->logout}")}}"><i class="fas fa-sign-out-alt"></i> {{$langJson->home->logout}}
                                                        </a></li>
                                                @else
                                                    <li>
                                                        <a href="{{route("theme.{$langJson->routes->login}")}}"><i class="fas fa-user"></i> {{$langJson->login->login}}
                                                        </a></li>
                                                @endauth
                                            </ul>
                                        </li>
                                        <!--Account Currency End-->
                                    </ul>
                                    <!--Crunccy dropdown-->
                                </li>
                                <li class="mini-cart">
                                    <a class="mini_cart_wrapper" href="javascript:void(0)"><i class="flaticon-shopping-cart"></i>
                                        <span class="mini-cart-total item_count">({{$cart->count()}})</span></a>
                                    <!--Mini Cart Dropdown Start-->
                                    <div id="cart-render">

                                        <div class="header-cart">
                                            <ul class="cart-items">
                                                @foreach($cart as $cartItem)
                                                    <li class="single-cart-item" data-id="{{$cartItem->id}}">
                                                        <div class="cart-img">
                                                            <a href="{{route("theme.{$langJson->routes->product}",$cartItem->associatedModel->seo_url->$lang)}}"><img src="{{asset("storage/{$cartItem->associatedModel->cover_photo->img_url}")}}" alt=""></a>
                                                        </div>
                                                        <div class="cart-content">
                                                            <h5 class="product-name">
                                                                <a href="{{route("theme.{$langJson->routes->product}",$cartItem->associatedModel->seo_url->$lang)}}">{{$cartItem->name->$lang}}</a>
                                                            </h5>
                                                            <span class="product-quantity">{{$cartItem->quantity}} ×</span>
                                                            <span class="product-price">{{$cartItem->associatedModel->price->$lang." ".$langJson->home->price}}</span>
                                                        </div>
                                                        <div class="cart-item-remove">
                                                            <a href="javascript:void(0)"><i class="fa fa-trash delete-cart-item" data-id="{{$cartItem->id}}"></i></a>
                                                        </div>
                                                    </li>

                                                @endforeach
                                            </ul>
                                            <div class="cart-total">
                                                <div class="cart_total">
                                                    <h5>{{$langJson->home->sub_total}}: {{\Cart::getSubTotal()." ".$langJson->home->price}}</h5>
                                                </div>
                                                <div class="cart_total mt-10">
                                                    <h5>{{$langJson->home->total}}: {{\Cart::getTotal()." ".$langJson->home->price}}</h5>
                                                </div>
                                            </div>
                                            <div class="cart-btn">
                                                <a href="{{route("theme.{$langJson->routes->basket}")}}"><i class="fa fa-shopping-cart"></i> {{$langJson->home->basket_go}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Mini Cart Dropdown End-->
                                </li>
                            </ul>
                        </div>
                        <!--Header Search And Mini Cart Area End-->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--Header section end-->

    <!--Header Mobile section start-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-bottom menu-right">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header-mobile-navigation d-block d-lg-none">
                            <div class="row align-items-center">
                                <div class="col-6 col-md-6">
                                    <div class="header-logo">
                                        <a href="{{route("theme.{$langJson->routes->home}")}}">
                                            <img src="{{asset("storage/{$thisSetting->logo}")}}" class="img-fluid" alt="{{$thisSetting->company_name}}">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="mobile-navigation text-right">
                                        <div class="header-icon-wrapper">
                                            <ul class="icon-list justify-content-end">
                                                <li>
                                                    <div class="header-cart-icon mini_cart_wrapper">
                                                        <a href="{{route("theme.{$langJson->routes->basket}")}}"><i class="flaticon-shopping-cart"></i>

                                                        </a>
                                                        <span class="item_count">({{$cart->count()}})</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="mobile-menu-icon" id="mobile-menu-trigger"><i class="fa fa-bars"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Mobile Menu start-->
                <div class="row">
                    <div class="col-12 d-flex d-lg-none">
                        <div class="mobile-menu"></div>
                    </div>
                </div>
                <!--Mobile Menu end-->

            </div>
        </div>
    </header>
    <!--Header Mobile section end-->

    <!-- Offcanvas Menu Start -->
    <div class="offcanvas-mobile-menu d-block d-lg-none" id="offcanvas-mobile-menu">
        <a href="javascript:void(0)" class="offcanvas-menu-close" id="offcanvas-menu-close-trigger">
            <i class="fa fa-times"></i>
        </a>

        <div class="offcanvas-wrapper">

            <div class="offcanvas-inner-content">
                <div class="offcanvas-mobile-search-area">
                    <form action="{{route("theme.{$langJson->routes->search}")}}" method="GET">
                        <input name="search" placeholder="{{$langJson->header->search_placeholder}}" type="text">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <nav class="offcanvas-navigation">
                    <ul>
                        <li class="menu-item-has-children">
                            <a href="{{route("theme.{$langJson->routes->home}")}}">{{$langJson->menu->home}}</a></li>
                        <li class="menu-item-has-children">
                            <a href="javascript:void(0)">{{$langJson->menu->products}}</a>
                            <ul class="submenu2">
                                {!! $viewData->mobileCategories !!}
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="javascript:void(0)">{{$langJson->menu->corporate}}</a>
                            <ul class="submenu2">
                                @foreach($viewData->corporates as $corporate)
                                    <li>
                                        <a href="{{route("theme.{$langJson->routes->corporate}",$corporate->seo_url->$lang)}}">{{$corporate->title->$lang}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{route("theme.{$langJson->routes->contact}")}}">{{$langJson->menu->contact}}</a>
                        </li>

                    </ul>
                </nav>

                <div class="offcanvas-settings">
                    <nav class="offcanvas-navigation">
                        <ul>
                            <li class="menu-item-has-children"><a href="#">{{$langJson->home->account}} </a>
                                <ul class="submenu2">
                                    @if(\Session::has('user'))
                                        <li>
                                            <a href="{{route("theme.{$langJson->routes->account}")}}"><i class="fas fa-user-circle"></i> {{$langJson->home->account}}
                                            </a></li>
                                        <li>
                                            <a href="{{route("theme.{$langJson->routes->logout}")}}"><i class="fas fa-sign-out-alt"></i> {{$langJson->home->logout}}
                                            </a></li>
                                    @else
                                        <li>
                                            <a href="{{route("theme.{$langJson->routes->login}")}}"><i class="fas fa-user"></i> {{$langJson->login->login}}
                                            </a></li>
                                    @endauth

                                </ul>
                            </li>
                            <li class="menu-item-has-children"><a href="#">{{$langJson->menu->language}}:
                                    <span class="flex-shrink-1 mr-1 align-middle my-auto py-auto flag-icon flag-icon-{{($lang=="en"?"us":$lang)}}"></span>
                                    <span class='flex-grow-1 align-middle  my-auto py-auto'>{{strtoupper($lang)}}</span>
                                </a>
                                <ul class="submenu2">
                                    @foreach($settings as $setting)
                                        @php
                                            $url=\App\Helpers\Helpers::thisPageUrl($setting->language,$langJson,$page);
                                            $parameterLang=$setting->language;
                                        @endphp
                                        <li {{($lang==$setting->language?'class="active"':'')}}>
                                            <a href="{{(!empty($parameter)?route("theme.{$url}",$parameter->$parameterLang):route("theme.{$url}"))}}">
                                                <span class="flex-shrink-1 mr-1 align-middle my-auto py-auto flag-icon flag-icon-{{($setting->language=="en"?"us":$setting->language)}}"></span>
                                                <span class='flex-grow-1 align-middle  my-auto py-auto'>{{strtoupper($setting->language)}}</span>
                                            </a>
                                        </li>

                                    @endforeach

                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="offcanvas-widget-area">
                    <div class="off-canvas-contact-widget">
                        <div class="header-contact-info">
                            <ul class="header-contact-info-list">
                                <li><i class="ion-android-phone-portrait"></i>
                                    <a href="tel:{{$thisSetting->phone_1}}">{{$thisSetting->phone_1}} </a></li>
                                <li><i class="ion-android-phone-portrait"></i>
                                    <a href="tel:{{$thisSetting->phone_2}}">{{$thisSetting->phone_2}} </a></li>
                                <li><i class="ion-android-mail"></i>
                                    <a href="mailto:{{$thisSetting->email}}">{{$thisSetting->email}}</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--Off Canvas Widget Social Start-->
                    <div class="off-canvas-widget-social">
                        @if(!empty($thisSetting->facebook))
                            <a href="{{$thisSetting->facebook}}"><i class="fab fa-facebook fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if(!empty($thisSetting->twitter))
                            <a href="{{$thisSetting->twitter}}"><i class="fab fa-twitter fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if(!empty($thisSetting->youtube))
                            <a href="{{$thisSetting->youtube}}"><i class="fab fa-youtube fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if(!empty($thisSetting->instagram))
                            <a href="{{$thisSetting->instagram}}"><i class="fab fa-instagram fa-2x" aria-hidden="true"></i></a>
                        @endif
                    </div>
                    <!--Off Canvas Widget Social End-->
                </div>
            </div>
        </div>

    </div>
    <!-- Offcanvas Menu End -->

    <!-- main-search start -->
    <div class="main-search-active">
        <div class="sidebar-search-icon">
            <button class="search-close"><i class="fa fa-times"></i></button>
        </div>
        <div class="sidebar-search-input">
            <form action="{{route("theme.{$langJson->routes->search}")}}" method="GET">
                <div class="form-search">
                    <input id="search" class="input-text" name="search" value="" style="font-size:20px" placeholder="{{$langJson->header->search_placeholder}}" type="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- main-search start -->


    <!--header area start-->

@yield("content")

<!--Footer section start-->
    <footer class="footer-section section bg-gray">

        <!--Footer Top start-->
        <div class="footer-top section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-55 pb-lg-35 pb-md-25 pb-sm-15 pb-xs-10">
            <div class="container">
                <div class="row">

                    <!--Footer Widget start-->
                    <div class="footer-widget col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-40 mb-xs-35">
                        <a href="{{route("theme.{$langJson->routes->home}")}}"><img class="img-fluid" src="{{asset("storage/{$thisSetting->logo}")}}" alt="{{$thisSetting->company_name}}"></a>
                        <h4 class="opeaning-title text-center mt-2">{{$thisSetting->slogan}}</h4>
                    </div>
                    <!--Footer Widget end-->


                    <!--Footer Widget start-->
                    <div class="footer-widget col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-40 mb-xs-35">
                        <h4 class="title"><span class="text">{{$langJson->menu->corporate}}</span></h4>
                        <ul class="ft-menu">
                            @foreach($viewData->corporates as $corporate)
                                <li>
                                    <a href="{{route("theme.{$langJson->routes->corporate}",$corporate->seo_url->$lang)}}">{{$corporate->title->$lang}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--Footer Widget end-->
                    <div class="footer-widget col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-40 mb-xs-35 off-canvas-widget-social">
                        <h4 class="title"><span class="text">{{$langJson->footer->social_media}}</span></h4>

                        @if(!empty($thisSetting->facebook))
                            <a href="{{$thisSetting->facebook}}"><i class="fab fa-facebook fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if(!empty($thisSetting->twitter))
                            <a href="{{$thisSetting->twitter}}"><i class="fab fa-twitter fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if(!empty($thisSetting->youtube))
                            <a href="{{$thisSetting->youtube}}"><i class="fab fa-youtube fa-2x" aria-hidden="true"></i></a>
                        @endif
                        @if(!empty($thisSetting->instagram))
                            <a href="{{$thisSetting->instagram}}"><i class="fab fa-instagram fa-2x" aria-hidden="true"></i></a>
                        @endif
                    </div>
                    <!--Footer Widget start-->
                    <div class="footer-widget text-lg-right  col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 mb-40 mb-xs-35">
                        <h4 class="title" href="#!"><span class="text">{{$thisSetting->company_name}}</span></h4>
                        <p href="#!" class="contact-text text-left"> {{$thisSetting->address}}
                        </p>
                        <p href="tel: {{$thisSetting->phone_1}}" class="contact-text text-left">
                            {{$thisSetting->phone_1}}
                        </p>
                        <p href="tel: {{$thisSetting->phone_1}}" class="contact-text text-left">
                            {{$thisSetting->phone_2}}
                        </p>
                        <p href="#!" class="contact-text text-left"> {{$thisSetting->email}}</p>
                    </div>
                    <!--Footer Widget end-->
                </div>
            </div>
        </div>
        <!--Footer Top end-->

        <!--Footer bottom start-->
        <div class="footer-bottom section">
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-12 ft-border pt-25 pb-25">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="copyright text-left">
                                    <a href="{{route("theme.{$langJson->routes->home}")}}">
                                        <img class="ml-3 w-50" src="{{asset("storage/{$thisSetting->logo}")}}" alt="{{$thisSetting->company_name}}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="copyright text-left">
                                    <p>Copyright © 2021
                                        <a href="{{route("theme.{$langJson->routes->home}")}}">{{$thisSetting->company_name}}</a>.
                                        <a href="{{route("theme.{$langJson->routes->home}")}}" target="_blank">Tüm Hakları
                                            Saklıdır.</a></p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="payment-getway text-lg-right off-canvas-widget-social text-center">
                                    @if(!empty($thisSetting->facebook))
                                        <a href="{{$thisSetting->facebook}}"><i class="fab fa-facebook fa-2x" aria-hidden="true"></i></a>
                                    @endif
                                    @if(!empty($thisSetting->twitter))
                                        <a href="{{$thisSetting->twitter}}"><i class="fab fa-twitter fa-2x" aria-hidden="true"></i></a>
                                    @endif
                                    @if(!empty($thisSetting->youtube))
                                        <a href="{{$thisSetting->youtube}}"><i class="fab fa-youtube fa-2x" aria-hidden="true"></i></a>
                                    @endif
                                    @if(!empty($thisSetting->instagram))
                                        <a href="{{$thisSetting->instagram}}"><i class="fab fa-instagram fa-2x" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3 col-md- col-sm-12">
                                <div class="payment-getway text-lg-right text-center">
                                    <a href="https://mutfakyapim.com.tr"><img class="w-75" data-toggle="tooltip" data-placement="top" title="{{$langJson->footer->author}}" style="filter: drop-shadow(1px 1px 1px black);" src="{{asset("theme/assets/images/logo.png")}}" alt="{{$langJson->footer->author}}"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Footer bottom end-->

    </footer>
    <!--Footer section end-->

</div>
<script src="{{asset("theme/assets/js/vendor/jquery-1.12.4.min.js")}}"></script>
<script src="{{asset("theme/assets/js/vendor/popper.min.js")}}"></script>
<script src="{{asset("theme/assets/js/vendor/bootstrap.min.js")}}"></script>
<script src="{{asset("theme/assets/js/plugins/plugins.js")}}"></script>
<script src="{{asset("theme/assets/js/jquery-ui.min.js")}}"></script>
<script src="{{asset("theme/assets/js/iziToast.js")}}"></script>
<script src="{{asset("theme/assets/js/font-awesome.min.js")}}"></script>
<script src="{{asset("theme/assets/js/iziModal.min.js")}}"></script>
<script src="{{asset("theme/assets/js/main.js")}}"></script>
<script src="{{asset("theme/assets/js/script.js")}}"></script>


</body>
@yield("footer")
<script>
    $(document).ready(function () {
        $(document).on("click", ".delete-cart-item", function () {
            let id = $(this).data("id")
            $.ajax({
                "url": "{{route("theme.{$langJson->routes->basket_delete}")}}",
                "data": {"id": id},
                "type": "POST"
            }).done(function (response) {
                $(".single-cart-item[data-id=" + id + "]").hide("slow", function () {
                    $(".item_count").text(response.count)
                    $("#cart-render").html(response.data)
                });
                iziToast.success({
                    title: "{{$langJson->alert->success}}",
                    message: response.alert,
                    position: "topCenter",
                    displayMode: "once"
                });
            })
        })
    })
</script>
@if(\Illuminate\Support\Facades\Session::get("alert"))
    @php
        $data=\Illuminate\Support\Facades\Session::get("alert")
    @endphp
    <script>
        iziToast.{{$data["status"]}}({
            title: "{{$data["title"]}}",
            message: "{{$data["msg"]}}",
            position: "topCenter"
        });
    </script>
@endif

</html>
