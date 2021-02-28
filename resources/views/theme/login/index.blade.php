@extends('theme.layouts.app')@section("title",$langJson->menu->corporate)
@section("header")
@endsection
@section("content")
@section("menuClass","bg-dark")
<!--breadcrumbs area start-->

<!-- Page Banner Section Start -->
<div class="page-banner-section section bg-image" data-bg="assets/images/bg/breadcrumb.png">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="page-banner text-left">
                    <h2>{{$langJson->login->login}} / {{$langJson->login->register}}</h2>
                    <ul class="page-breadcrumb">
                        <li><a href="{{route("theme.{$langJson->routes->home}")}}">{{$langJson->menu->home}}</a></li>
                        <li>{{$langJson->login->login}} / {{$langJson->login->register}}</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div><!-- Page Banner Section End --><!-- customer login start -->
<div class="login-register-section section pt-90 pt-lg-70 pt-md-60 pt-sm-55 pt-xs-45  pb-70 pb-lg-50 pb-md-40 pb-sm-30 pb-xs-20">
    <div class="container">
        <div class="row">
            <!--Login Form Start-->
            <div class="col-md-6 col-sm-6">
                <div class="customer-login-register">
                    <div class="form-login-title">
                        <h2>{{$langJson->login->login}}</h2>
                    </div>
                    <div class="login-form">
                        <form onsubmit="return false;">
                            @csrf
                            <div class="form-fild">
                                <label>{{$langJson->login->email}} <span>*</span></label>
                                <input id="login-email" name="email" type="text">
                            </div>
                            <div class="form-fild">
                                <label>{{$langJson->login->password}} <span>*</span></label>
                                <input id="login-pass" name="password" type="password">
                            </div>
                            <div class="login-submit">
                                <a class="d-none" href="#">{{$langJson->login->forgot_password}}</a>
                                <button id="login-btn" class="btn" type="button">{{$langJson->login->login}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Login Form End-->
            <!--Register Form Start-->
            <div class="col-md-6 col-sm-6">
                <div class="customer-login-register register-pt-0">
                    <div class="form-register-title">
                        <h2>{{$langJson->login->register}}</h2>
                    </div>
                    <div class="register-form">
                        <form action="#">
                            @csrf
                            <div class="form-fild">
                                <label>{{$langJson->login->full_name}} <span>*</span></label>
                                <input id="register-full_name" name="full_name" type="text">
                            </div>
                            <div class="form-fild">
                                <label>{{$langJson->login->phone}} <span>*</span></label>
                                <input id="register-phone" class="phone-number" name="phone" type="text">
                            </div>

                            <div class="form-fild">
                                <label>{{$langJson->login->email}} <span>*</span></label>
                                <input id="register-email" name="email" type="text">
                            </div>
                            <div class="form-fild">
                                <label>{{$langJson->login->user_name}} </label>
                                <input id="register-user_name" name="user_name" type="text">
                            </div>
                            <div class="form-fild">
                                <label>{{$langJson->login->password}} <span>*</span></label>
                                <input id="register-pass" name="password" type="password">
                            </div>
                            <div class="form-fild">
                                <label>{{$langJson->login->confirm_password}} <span>*</span></label>
                                <input id="register-confirm_password" name="confirm_password" type="password">
                            </div>

                            <div class="register-submit">
                                <button id="register-btn" class="btn" type="button">{{$langJson->login->register}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Register Form End-->
        </div>
    </div>
</div>

@endsection
@section("footer")
    <script src="https://unique.mutfakyapim.com.tr/theme/assets/js/jquery-mask.min.js"></script>

    <script>
        $(document).ready(function (data) {
            data.mask.definitions['~'] = '[+-]';
            $('.phone-number').mask('0999 999 9999');
        })
        $(document).ready(function () {
            $(document).on("click", "#login-btn", function () {
                let email = $("#login-email").val();
                let pass = $("#login-pass").val();
                let control = 1;
                if (email === "" || email === "undefined" || email === null || !isEmail(email)) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->email." ".$langJson->alert->null}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (pass === "" || pass === "undefined" || pass === null) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->password." ".$langJson->alert->null}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (control === 1) {
                    $.ajax({
                        "url": "{{route("theme.{$langJson->routes->login}")}}",
                        "data": {"email": email, "password": pass},
                        "type": "POST"
                    }).done(function (response) {
                        if (response.success) {
                            iziToast.success({
                                title: response.title,
                                message: response.msg,
                                position: "topCenter"
                            });
                            if (response.url !== "" || response.url !== "undefined" || response.url !== null) {
                                setTimeout(function () {
                                    window.location.href = response.url
                                }, 2000);

                            }
                        } else {
                            iziToast.error({
                                title: response.title,
                                message: response.msg,
                                position: "topCenter"
                            });
                        }
                    })
                }
            })
            $(document).on("click", "#register-btn", function () {
                let email = $("#register-email").val();
                let pass = $("#register-pass").val();
                let username = $("#register-user_name").val();
                let full_name = $("#register-full_name").val();
                let phone = $("#register-phone").val();
                let confirmpass = $("#register-confirm_password").val();
                let control = 1;
                if (email === "" || email === "undefined" || email === null || !isEmail(email)) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->email." ".$langJson->alert->null}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (pass === "" || pass === "undefined" || pass === null) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->password." ".$langJson->alert->null}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (full_name === "" || full_name === "undefined" || full_name === null) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->full_name." ".$langJson->alert->null}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (phone === "" || phone === "undefined" || phone === null) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->phone." ".$langJson->alert->null}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (confirmpass === "" || confirmpass === "undefined" || confirmpass === null) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->phone." ".$langJson->alert->null}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (confirmpass !== pass) {
                    iziToast.error({
                        title: "{{$langJson->alert->error}}",
                        message: "{{$langJson->login->password." & ".$langJson->login->confirm_password ." ". $langJson->alert->not_mach}}",
                        position: "topCenter"
                    });
                    control = 0;
                }
                if (control === 1) {
                    $.ajax({
                        "url": "{{route("theme.{$langJson->routes->register}")}}",
                        "data": {
                            "email": email,
                            "password": pass,
                            "password_confirmation": confirmpass,
                            "user_name": username,
                            "phone": phone,
                            "full_name": full_name
                        },
                        "type": "POST",
                        "dataType": "json"
                    }).done(function (response) {
                        if (response.success) {
                            iziToast.success({
                                title: response.title,
                                message: response.msg,
                                position: "topCenter"
                            });
                            if (response.url !== "" || response.url !== "undefined" || response.url !== null) {
                                setTimeout(function () {
                                    window.location.href = response.url
                                }, 2000);

                            }
                        } else {
                            iziToast.error({
                                title: response.title,
                                message: response.msg,
                                position: "topCenter"
                            });
                        }
                    })
                }
            })
        })
    </script>
@endsection
