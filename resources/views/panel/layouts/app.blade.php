<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$data->settings->company_name}}- @yield('title')</title>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords"
          content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive"/>
    <meta name="author" content="Codedthemes"/>
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset("uploads/settings/logo.png")}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css"
          integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g=="
          crossorigin="anonymous"/>    <!-- waves.css -->
    <link rel="stylesheet" href="{{asset("Panel/assets/pages/waves/css/waves.min.css")}}" type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{asset("Panel/assets/icon/themify-icons/themify-icons.css")}}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{asset("Panel/assets/icon/icofont/css/icofont.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset("Panel/assets/icon/font-awesome/css/font-awesome.min.css")}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/v4-shims.min.css"
          integrity="sha512-KNosrY5jkv7dI1q54vqk0N3x1xEmEn4sjzpU1lWL6bv5VVddcYKQVhHV08468FK6eBBSXTwGlMMZLPTXSpHYHA=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
          integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/skins/ui/oxide/skin.min.css"
          integrity="sha512-/BeINBA5/Gyo9Jlu9DElOGmHER/TdKhnKTzEdzOzIJimCQPzB9Opbl/3Ln54HIbjZLyVtNySv1i0bCo4qvY2KQ=="
          crossorigin="anonymous"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/skins/ui/oxide/skin.mobile.min.css"
          integrity="sha512-qKmZsWuafR0gSkC1Mvgcc6zDtbhHDJOBDjLZ91+aUJk7UFgoDTsA7v0VDTc5lWgqLe0QNsZXXexyehr4mGXxSg=="
          crossorigin="anonymous"/>
    <!-- Style.css -->
    @yield('header')
    <link rel="stylesheet" type="text/css" href="{{asset("Panel/assets/css/style.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("Panel/assets/css/jquery.mCustomScrollbar.css")}}">
    <script>let base_url = "{{asset("Panel/assets")}}" </script>
</head>

</head>

<!--<body class="fix-menu dark-layout">-->

<body>
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="loader-track">
        <div class="preloader-wrapper">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pre-loader end -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">
                <div class="navbar-logo">
                    <a class="mobile-menu waves-effect waves-light " id="mobile-collapse" href="#!">
                        <i class="ti-menu"></i>
                    </a>
                    <div class="mobile-search waves-effect waves-light">
                        <div class="header-search">
                            <div class="main-search morphsearch-search">
                                <div class="input-group">
                                    <span class="input-group-prepend search-close"><i
                                            class="ti-close input-group-text"></i></span>
                                    <input type="text" class="form-control" placeholder="Enter Keyword">
                                    <span class="input-group-append search-btn"><i
                                            class="ti-search input-group-text"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{route("panel.home")}}">
                        <img class="img-fluid img-fluid w-75 px-auto mx-auto"
                             src="{{asset("Panel/assets/images/my/logo.png")}}" alt="Mutfak Yapım"/>
                    </a>
                    <a class="mobile-options waves-effect waves-light">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <div class="navbar-container">
                    <ul class="nav-left">
                        <li>
                            <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                        </li>
                        <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right ">
                        <li class="header-notification d-none">
                            <a href="#!" class="waves-effect waves-light">
                                <i class="ti-bell"></i>
                                <span class="badge bg-c-red"></span>
                            </a>
                            <ul class="show-notification d-none">
                                <li>
                                    <h6>Notifications</h6>
                                    <label class="label label-danger">New</label>
                                </li>
                                <li class="waves-effect waves-light">
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius"
                                             src="assets/images/avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user"</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="waves-effect waves-light">
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius"
                                             src="assets/images/avatar-4.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">Joseph William</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="waves-effect waves-light">
                                    <div class="media">
                                        <img class="d-flex align-self-center img-radius"
                                             src="assets/images/avatar-3.jpg" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <h5 class="notification-user">Sara Soudein</h5>
                                            <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer
                                                elit.</p>
                                            <span class="notification-time">30 minutes ago</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="user-profile header-notification">
                            <a href="#!" class="waves-effect waves-light">
                                <img src="{{asset("Panel/assets/images/avatar-4.jpg")}}" class="img-radius"
                                     alt="User-Profile-Image">
                                <span>{{$data->admin->full_name}}</span>
                                <i class="ti-angle-down"></i>
                            </a>
                            <ul class="show-notification profile-notification">
                                <li class="waves-effect waves-light  d-none">
                                    <a href="#!">
                                        <i class="ti-settings"></i> Settings
                                    </a>
                                </li>
                                <li class="waves-effect waves-light  d-none">
                                    <a href="user-profile.html">
                                        <i class="ti-user"></i> Profile
                                    </a>
                                </li>
                                <li class="waves-effect waves-light  d-none">
                                    <a href="email-inbox.html">
                                        <i class="ti-email"></i> My Messages
                                    </a>
                                </li>
                                <li class="waves-effect waves-light d-none">
                                    <a href="auth-lock-screen.html">
                                        <i class="ti-lock"></i> Lock Screen
                                    </a>
                                </li>
                                <li class="waves-effect waves-light">
                                    <a href="{{route("panel.logout")}}">
                                        <i class="ti-layout-sidebar-left"></i> Çıkış Yap
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <div class="">
                            <div class="main-menu-header">
                                <img class="img-80 img-radius" src="{{asset("Panel/assets/images/avatar-4.jpg")}}"
                                     alt="User-Profile-Image">
                                <div class="user-details">

                                    <span id="more-details">{{$data->admin->full_name}}<i
                                            class="fa fa-caret-down"></i></span>
                                </div>
                            </div>
                            <div class="main-menu-content">
                                <ul>
                                    <li class="more-details">
                                        <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                                        <a href="#!"><i class="ti-settings"></i>Settings</a>
                                        <a href="{{route("panel.logout")}}"><i class="ti-layout-sidebar-left"></i>Çıkış
                                            Yap</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-15 p-b-0">
                            Sitenizi Kolayca Yönetin
                        </div>
                        <div class="pcoded-navigation-label">Modüller</div>
                        <ul class="pcoded-item pcoded-left-item">
                            <li class="<?=($data->segment == "home" ? "active" : "")?>">
                                <a href="{{route("panel.home")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Anasayfa</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            <li class="<?=($data->segment == "settings" ? "active" : "")?>">
                                <a href="{{route("panel.settings.index")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Site Ayarları</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="<?=($data->segment == "email-settings" ? "active" : "")?>">
                                <a href="{{route("panel.emailSettings.index")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Email Ayarları</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="<?=($data->segment == "corporate" ? "active" : "")?>">
                                <a href="{{route("panel.corporate.index")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-file-alt"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Kurumsal Sayfalar</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="<?=($data->segment == "galleries" ? "active" : "")?>">
                                <a href="{{route("panel.galleries.index")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-images"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Galeri İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="<?=($data->segment == "stories" ? "active" : "")?>">
                                <a href="{{route("panel.home")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-images"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Hikaye İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="<?=($data->segment == "slider" ? "active" : "")?>">
                                <a href="{{route("panel.slider.index")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-images"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Slider İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{route("panel.banner.index")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-images"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Banner İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="pcoded-hasmenu <?=($data->segment == "product-category" ? "active pcoded-trigger" : ($data->segment == "product" ? "active pcoded-trigger" : ($data->segment == "product-image" ? "active pcoded-trigger" :  ($data->segment == "option" ? "active pcoded-trigger" :  ($data->segment == "option-category" ? "active pcoded-trigger" : "")))))?> ">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fab fa-dropbox"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Ürün İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="<?=($data->segment == "product-category" ? "active" : "")?>">
                                        <a href="{{route("panel.productCategory.index")}}"
                                           class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-list"></i></span>
                                            <span class="pcoded-mtext">Ürün Kategorileri</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>

                                    <li class="<?=($data->segment == "product" ? "active" : ($data->segment == "product-image" ? "active" : ""))?>">
                                        <a href="{{route("panel.product.index")}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fab fa-dropbox"></i></span>
                                            <span class="pcoded-mtext">Ürünler</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>

                                    <li class="d-none <?=($data->segment == "option" ? "active" : "")?>">
                                        <a href="{{route("panel.product.index")}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fab fa-dropbox"></i></span>
                                            <span class="pcoded-mtext">Varyasyonlar</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="<?=($data->segment == "option-category" ? "active" : "")?>">
                                        <a href="{{route("panel.optionCategory.index")}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fab fa-dropbox"></i></span>
                                            <span class="pcoded-mtext">Varyasyon Kategori</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="{{route("panel.home")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-list"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Sipariş İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{route("panel.discountCoupon.index")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-tags"></i><b>D</b></span>
                                    <span class="pcoded-mtext">İndirim Kuponları</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="pcoded-hasmenu <?=($data->segment == "user" ? "active pcoded-trigger" : ($data->segment == "user-role" ? "active pcoded-trigger" : ($data->segment == "multi-mail" ? "active pcoded-trigger" : "")))?>">
                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-users"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Kullanıcı İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="<?=($data->segment == "user-role" ? "active" : "")?>">
                                        <a href="{{route("panel.userRole.index")}}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-list"></i></span>
                                            <span class="pcoded-mtext">Kullanıcı Yetkileri</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="<?=route("panel.user.index")?>" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fab fa-dropbox"></i></span>
                                            <span class="pcoded-mtext">Kullanıcılar</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="breadcrumb.html" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fab fa-dropbox"></i></span>
                                            <span class="pcoded-mtext">Toplu Mail</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="breadcrumb.html" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fab fa-dropbox"></i></span>
                                            <span class="pcoded-mtext">Toplu SMS</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="{{route("panel.home")}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-university"></i><b>D</b></span>
                                    <span class="pcoded-mtext">Banka İşlemleri</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>

                    </div>
                </nav>
                <div class="pcoded-content">
                    <!-- Page-header start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">{{$data->page->title}}</h5>
                                        <p class="m-b-0">{{$data->page->description}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{route("panel.home")}}"> <i class="fa fa-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="javascript:void(0)">{{$data->page->title}}</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                @yield("content")
                <!-- Main-body end -->

                    <div id="styleSelector">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web
        browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="{{asset("Panel/assets/js/jquery/jquery.min.js")}} "></script>
<script type="text/javascript" src="{{asset("Panel/assets/js/jquery-ui/jquery-ui.min.js")}} "></script>
<script type="text/javascript" src="{{asset("Panel/assets/js/popper.js/popper.min.js")}}"></script>
<script type="text/javascript" src="{{asset("Panel/assets/js/bootstrap/js/bootstrap.min.js")}} "></script>
<!-- waves js -->
<script src="{{asset("Panel/assets/pages/waves/js/waves.min.js")}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{asset("Panel/assets/js/jquery-slimscroll/jquery.slimscroll.js")}}"></script>
<script src="{{asset("Panel/assets/js/pcoded.min.js")}}"></script>
<script src="{{asset("Panel/assets/js/jquery.mCustomScrollbar.concat.min.js")}}"></script>
<script src="{{asset("Panel/assets/js/vertical/vertical-layout.min.js")}}"></script>
<!-- Custom js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
        integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/v4-shims.min.js"
        integrity="sha512-fBnQ7cKP6HMwdVNN5hdkg0Frs1NfN7dgdTauot35xVkdhkIlBJyadHNcHa9ExyaI2RwRM7sBhoOt4R8W6lloBw=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/jquery.tinymce.min.js"
        integrity="sha512-0+DXihLxnogmlHWg1hVntlqMiGthwA02YWrzGnOi+yNyoD3IA4yDBzxvm+EwTCZeUM4zNy3deF9CbQqQBQx2Yg=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/plugins/autosave/plugin.min.js"
        integrity="sha512-mulmrcllxdAIXKi8k+2+ylJAjeU+QrAKkMWHhytFTyzAgM61RNp+n/C0vKz2YfGuvh2HTTWCxiiTyn65zRngIQ=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/plugins/autolink/plugin.min.js"
        integrity="sha512-WizvB4gafa9mrOrscRoABIDD9f+Xz5M2jEN0nVJ8Vy0jZPlJVkj363McUJLXJ2o5e9SmzKOdvJwrcKzMn2xH7w=="
        crossorigin="anonymous"></script>
@yield("footer")
<script type="text/javascript" src="{{asset("Panel/assets/js/script.js")}}"></script>

@if(\Illuminate\Support\Facades\Session::get("validator"))
    @php
        $data=\Illuminate\Support\Facades\Session::get("validator")
    @endphp
    @foreach($data["msg"]->messages() as $item)
        <script>
            iziToast.{{$data["status"]}}({
                title: "{{$data["title"]}}",
                message: "{{$item[0]}}",
                position: "topCenter"
            });
        </script>
    @endforeach
@endif
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
</body>

</html>
