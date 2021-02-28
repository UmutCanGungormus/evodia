<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$data->settings->company_name}}</title>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <meta name="keywords" content="{{$data->settings->meta_keywords}}"/>
    <meta name="author" content="{{$data->settings->meta_description}}"/>
    <!-- Favicon icon -->

    <link rel="icon" href="{{asset("Panel/assets/images/favicon.ico")}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{asset("Panel/assets/css/bootstrap/css/bootstrap.min.css")}}">
    <!-- waves.css -->
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
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset("Panel/assets/css/style.css")}}">
</head>

<body themebg-pattern="theme1">
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

<section class="login-block">
    <!-- Container-fluid starts -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Authentication card start -->

                <form class="md-float-material form-material" action="{{route("panel.login")}}" method="POST">
                    @csrf
                    <div class="text-center">
                        <img src="{{asset("Panel/assets/images/my/logo.png")}}"
                             alt="MUTFAK YAPIM DİJİTAL REKLAM AJANSI">
                    </div>
                    <div class="auth-box card">
                        <div class="card-block">
                            <div class="row m-b-20">
                                <div class="col-md-12">
                                    <h3 class="text-center">Giriş Yap</h3>
                                </div>
                            </div>
                            <div class="form-group form-primary">
                                <input required type="text" name="email" id="email" class="form-control">
                                <span class="form-bar"></span>
                                <label class="float-label">E-Posta</label>
                            </div>
                            <div class="form-group form-primary">
                                <input required type="password" name="password" class="form-control">
                                <span class="form-bar"></span>
                                <label class="float-label">Şifre</label>
                            </div>

                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                                        Giriş Yap
                                    </button>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-6 my-auto py-auto align-items-center">
                                    <p class="text-inverse text-left my-auto py-auto"><a
                                            href="{{route("theme.home")}}"> <i class="fas fa-home"></i> <b>Siteye
                                                Dön</b></a></p>
                                </div>
                                <div class="col-md-6 text-right my-auto py-auto">
                                    <a target="_blank" href="https://mutfakyapim.com/">
                                        <img class="w-75" src="{{asset("Panel/assets/images/my/footer_logo.png")}}"
                                             alt="MUTFAK YAPIM DİJİTAL REKLAM AJANSI">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- end of form -->
            </div>
            <!-- end of col-sm-12 -->
        </div>
        <!-- end of row -->
    </div>
    <!-- end of container-fluid -->
</section>
<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="{{asset("panel/assets/images/browser/chrome.png")}}" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="{{asset("panel/assets/images/browser/firefox.png")}}" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="{{asset("panel/assets/images/browser/opera.png")}}" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="{{asset("panel/assets/images/browser/safari.png")}}" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="{{asset("panel/assets/images/browser/ie.png")}}" alt="">
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
<script type="text/javascript" src="{{asset("Panel/assets/js/jquery/jquery.min.js ")}}"></script>
<script type="text/javascript" src="{{asset("Panel/assets/js/jquery-ui/jquery-ui.min.js")}} "></script>
<script type="text/javascript" src="{{asset("Panel/assets/js/popper.js/popper.min.js")}}"></script>
<script type="text/javascript" src="{{asset("Panel/assets/js/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- waves js -->
<script src="{{asset("Panel/assets/pages/waves/js/waves.min.js")}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{asset("Panel/assets/js/jquery-slimscroll/jquery.slimscroll.js")}}"></script>
<script type="text/javascript" src="{{asset("Panel/assets/js/common-pages.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
        integrity="sha512-F5QTlBqZlvuBEs9LQPqc1iZv2UMxcVXezbHzomzS6Df4MZMClge/8+gXrKw2fl5ysdk4rWjR0vKS7NNkfymaBQ=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/v4-shims.min.js"
        integrity="sha512-fBnQ7cKP6HMwdVNN5hdkg0Frs1NfN7dgdTauot35xVkdhkIlBJyadHNcHa9ExyaI2RwRM7sBhoOt4R8W6lloBw=="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous"></script>
<script src="{{asset("Panel/assets/js/script.js")}}"></script>
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
<script>
    $(document).ready(function (){
        $("#email").focus();
    })
</script>
</body>


</html>
