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
                        @if(!empty($cart))
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="pro-thumbnail">Image</th>
                                    <th class="pro-title">Product</th>
                                    <th class="pro-price">Price</th>
                                    <th class="pro-quantity">Quantity</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-remove">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart as $item)
                                    <tr>
                                        <td class="product_remove">
                                            <a href="javascript:void(0)" class="delete-cart-item" data-id="{{$item->id}}"><i class="fa fa-trash "></i></a>
                                        </td>
                                        <td class="pro-thumbnail">
                                            <a href="#"><img src="{{asset("storage/{$item->associatedModel->cover_photo->img_url}")}}" alt=""></a>
                                        </td>
                                        <td class="product_name">
                                            <a href="{{route("theme.{$langJson->routes->product}",$item->associatedModel->seo_url->$lang)}}">{{$item->name->$lang}}</a>
                                        </td>
                                        <td class="product-price">{{$item->price." ".$langJson->home->price}}</td>
                                        <td class="product_quantity"><label>Adet</label>
                                            <input min="1" max="100" value="{{$item->quantity}}" type="number"></td>
                                        <td class="product_total">{{$item->price*$item->quantity." ".$langJson->home->price}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger">saa</div>
                        @endif
                    </div>

                    <div class="row">

                        <div class="col-lg-6 col-12 mb-5">

                            <!-- Discount Coupon -->
                            <div class="discount-coupon">
                                <h4>Discount Coupon Code</h4>
                                <form action="#">
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-25">
                                            <input type="text" placeholder="Coupon Code">
                                        </div>
                                        <div class="col-md-6 col-12 mb-25">
                                            <button class="btn">Apply Code</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Cart Summary -->
                        <div class="col-lg-6 col-12 mb-30 d-flex">
                            <div class="cart-summary">
                                <div class="cart-summary-wrap">
                                    <h4>Cart Summary</h4>
                                    <p>Sub Total <span>$75.00</span></p>
                                    <p>Shipping Cost <span>$00.00</span></p>
                                    <h2>Grand Total <span>$75.00</span></h2>
                                </div>
                                <div class="cart-summary-button">
                                    <button class="btn">Checkout</button>
                                    <button class="btn">Update Cart</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <!--Cart section end-->

@endsection
@section("footer")
    <script>

    </script>
@endsection
