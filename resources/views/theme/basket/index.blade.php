@extends('theme.layouts.app')@section("title",$langJson->menu->products)
@section("header")
@endsection
@section("content")

    <!-- Page Banner Section Start -->
    <div class="page-banner-section section bg-image" data-bg="assets/images/bg/breadcrumb.png">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="page-banner text-left">
                        <h2>{{$langJson->menu->basket}}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="{{route("theme.{$langJson->routes->home}")}}">{{$langJson->menu->home}}</a>
                            </li>
                            <li>{{$langJson->menu->basket}}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page Banner Section End -->

    <!--Cart section start-->
    <div class="cart-section section pt-90 pt-lg-70 pt-md-60 pt-sm-50 pt-xs-45  pb-70 pb-lg-50 pb-md-40 pb-sm-30 pb-xs-20">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <!-- Cart Table -->
                    <div class="cart-table table-responsive mb-30">
                        @if($cart->count()>0)
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="pro-title">{{$langJson->basket->product_image}}</th>
                                    <th class="pro-title">{{$langJson->basket->product_name}}</th>
                                    <th class="pro-price">{{$langJson->basket->price}}</th>
                                    <th class="pro-quantity">{{$langJson->basket->qty}}</th>
                                    <th class="pro-subtotal">{{$langJson->basket->total}}</th>
                                    <th class="pro-remove">{{$langJson->basket->delete}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart as $item)
                                    <tr class="single-cart-item" data-id="{{$item->id}}">
                                        <td class="pro-thumbnail ">
                                            <a href="#"><img src="{{asset("storage/{$item->associatedModel->cover_photo->img_url}")}}" alt=""></a>
                                        </td>
                                        <td class="product_name">
                                            <a href="{{route("theme.{$langJson->routes->product}",$item->associatedModel->seo_url->$lang)}}">{{$item->name->$lang}}</a>
                                        </td>
                                        <td class="product-price">{{$item->price." ".$langJson->home->price}}</td>
                                        <td class="pro-quantity">
                                            <div class="pro-qty">
                                                <button data-id="{{$item->id}}" class="dec qtybtn">-</button>
                                                <input type="text" data-id="{{$item->id}}" data-price="{{$item->price}}" class="pro-quantity-input" value="{{$item->quantity}}">
                                                <button data-id="{{$item->id}}" class="inc qtybtn">+</button>
                                            </div>
                                        </td>
                                        <td class="product_total" data-id="{{$item->id}}">{{$item->price*$item->quantity." ".$langJson->home->price}}</td>
                                        <td class="product_remove">
                                            <a href="javascript:void(0)" class="delete-cart-item" data-id="{{$item->id}}"><i class="fa fa-trash "></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger">{{$langJson->alert->basket_null}}</div>
                        @endif
                    </div>
                    @if($cart->count()>0)
                        <div class="row">

                            <div class="col-lg-6 col-12 mb-5">

                                <!-- Discount Coupon -->
                                <div class="discount-coupon">
                                    <h4>{{$langJson->basket->discount_coupon}}</h4>
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-md-6 col-12 mb-25">
                                                <input type="text" placeholder="{{$langJson->basket->discount_coupon}}">
                                            </div>
                                            <div class="col-md-6 col-12 mb-25">
                                                <button class="btn">{{$langJson->basket->discount_apply}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Cart Summary -->
                            <div class="col-lg-6 col-12 mb-30 d-flex">
                                <div class="cart-summary">
                                    <div id="cart-summary-render">
                                        <div class="cart-summary-wrap">
                                            <h4>{{$langJson->basket->cart_summary}}</h4>
                                            <p>{{$langJson->home->sub_total}}
                                                <span>{{\Cart::getSubTotal()}} {{$langJson->home->price}}</span></p>
                                            <h2>{{$langJson->home->total}}
                                                <span>{{\Cart::getTotal()}} {{$langJson->home->price}}</span></h2>
                                        </div>
                                        <div class="cart-summary-button">
                                            <button class="btn">Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                </div>
                @endif
            </div>
        </div>
    </div>
    <!--Cart section end-->

@endsection
@section("footer")
    <script>
        $(document).ready(function () {
            $(document).on("change", ".pro-quantity-input", function () {
                if ($(this).val() < 0) {
                    $(this).val(0)
                }
            })
            $(document).on("click", ".delete-cart-item", function () {
                let id = $(this).data("id")
                $.ajax({
                    "url": "{{route("theme.{$langJson->routes->basket_delete}")}}",
                    "data": {"id": id},
                    "type": "POST"
                }).done(function (response) {
                    $(".delete-cart-item[data-id=" + id + "]").parent().parent().hide("slow", function () {
                        $(".item_count").text(response.count)
                        $("#cart-render").html(response.data)
                        $(".mini_cart").addClass("active")
                    });
                    $.ajax({
                        "url": "{{route("theme.{$langJson->routes->basket_update}")}}",
                        "type": "POST"
                    }).done(function (response) {
                        $("#cart-summary-render").html(response.data)
                        $("#cart-render").html(response.mini_cart_data)
                        iziToast.success({
                            title: "{{$langJson->alert->success}}",
                            message: response.alert,
                            position: "topCenter",
                            displayMode: "once"
                        });
                    })
                })
            })

            $(document).on("change click", ".pro-quantity-input,.inc,.dec", function () {
                console.lo
                let id = $(this).data("id");
                let input = $(".pro-quantity-input[data-id=" + id + "]");
                let qty = input.val();
                let price = input.data("price");
                let total = (parseFloat(qty) * parseFloat(price));
                $(".product_total[data-id=" + id + "]").text(total + "{{$langJson->home->price}}")
                $.ajax({
                    "url": "{{route("theme.{$langJson->routes->basket_update}")}}",
                    "data": {"id": id, "qty": qty},
                    "type": "POST"
                }).done(function (response) {
                    $("#cart-summary-render").html(response.data)
                    $("#cart-render").html(response.mini_cart_data)
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
@endsection
