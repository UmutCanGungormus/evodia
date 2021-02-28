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
                        <h2>{{$viewData->item->title->$lang}}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">{{$langJson->menu->home}}</a></li>
                            <li>{{$viewData->item->title->$lang}}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page Banner Section End -->
    <!-- Single Product Section Start -->
    <div class="single-product-section section pt-60 pt-lg-40 pt-md-30 pt-sm-20 pt-xs-25 pb-100 pb-lg-80 pb-md-70 pb-sm-30 pb-xs-20">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop-area">
                        <div class="row">
                            <div class="col-md-6 pr-35 pr-lg-15 pr-md-15 pr-sm-15 pr-xs-15">
                                <!-- Product Details Left -->
                                <div class="product-details-left">
                                    <div class="product-details-images">
                                        @foreach($viewData->products->photos as $key=> $photo)
                                            <div class="lg-image">
                                                <img src="{{asset("storage/{$photo->img_url}")}}" alt="{{$viewData->item->title->$lang}}">
                                                <a href="{{asset("storage/{$photo->img_url}")}}" class="popup-img venobox" data-gall="myGallery"><i class="fa fa-expand"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="product-details-thumbs">
                                        @foreach($viewData->products->photos as $key=> $photo)
                                            <div class="sm-image">
                                                <img src="{{asset("storage/{$photo->img_url}")}}" alt="{{$viewData->item->title->$lang}}">
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <!--Product Details Left -->
                            </div>
                            <div class="col-md-6">
                                <!--Product Details Content Start-->
                                <div class="product-details-content">

                                    <h2>{{$viewData->item->title->$lang}}</h2>

                                    <div class="single-product-price">
                                        <span class="price new-price">{{number_format($viewData->item->price->$lang,"2")}} {{$langJson->home->price}}</span>
                                    </div>
                                    <div class="product-description">
                                        <p>{{Str::words($viewData->item->description->$lang,"3","...")}}</p>
                                    </div>
                                    <div class="single-product-quantity">
                                        <div class="product-variants">
                                            <div class="product-variants-item ml-0">
                                                @if(!empty($viewData->products->option_categories))
                                                    <span class="control-label">{{$langJson->products->options}}</span>

                                                    <h3></h3>
                                                    @foreach($viewData->products->option_categories as $key=>$option)
                                                        <div class="input-group">
                                                            <label class="input-group-text" for="select-{{$key}}">{{$option->title->$lang}}</label>
                                                            <select class="form-select product-option" id="select-{{$key}}">
                                                                <option data-name="{{$option->title->$lang}}" value="0">{{$langJson->products->select}}</option>
                                                                @foreach($viewData->products->options as $opt)
                                                                    @if($opt->category_id==$option->id)
                                                                        <option value="{{$opt->id}}" data-name="{{$option->title->$lang}}" {{($opt->stock->$lang<=0?"disabled":"")}}>{{$opt->title->$lang}} </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    @endforeach
                                                @endif

                                            </div>
                                        </div>
                                        <div class="product-quantity">
                                            <label class="d-none">{{$langJson->products->count}}</label>
                                            <input class="product-count" min="1" max="100" value="1" type="number">
                                        </div>
                                        <div class="add-to-link">
                                            <button class="button btn rounded-0 add-to-basket" type="button">
                                                <i class="fa fa-shopping-bag"></i> {{$langJson->products->add_basket}}
                                            </button>

                                        </div>
                                    </div>
                                    <div class="product-action">
                                        <ul>
                                            <li>
                                                <a data-id="{{$viewData->item->id}}" class="deleteToFavourite {{!empty($viewData->item->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->delete_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favouriteDelete}}"><i class="fa fa-heart  mt-2"></i></a>
                                            </li>

                                            <li>
                                                <a data-id="{{$viewData->item->id}}" class="addToFavourite {{empty($viewData->item->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->add_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="far fa-heart  mt-2"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-meta">
                                         <span class="posted-in">
                                             {{$langJson->menu->category}}:
                                            @foreach($viewData->products->category as $key=>$category)
                                                 <a class="ml-1" href="{{route("theme.{$langJson->routes->category}",$category->seo_url->$lang)}}">{{$category->title->$lang}} {{($key%2==0 ? (count((array)$viewData->products->category)>1?"/":""):"")}}</a>
                                             @endforeach
                                         </span>

                                    </div>
                                </div>
                                <!--Product Details Content End-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product Section End -->

    <!--Product Description Review Section Start-->
    <div class="product-description-review-section section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-review-tab section">
                        <!--Review And Description Tab Menu Start-->
                        <ul class="nav dec-and-review-menu">
                            <li>
                                <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">{{$langJson->products->description}}</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">{{$langJson->products->features}}</a>
                            </li>

                        </ul>
                        <!--Review And Description Tab Menu End-->
                        <!--Review And Description Tab Content Start-->
                        <div class="tab-content product-review-content-tab" id="myTabContent-4">
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="product_info_content">
                                    <p>{{$viewData->item->description->$lang}}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel">

                                <div class="product_info_content">
                                    <p>{{$viewData->item->features->$lang}}</p>
                                </div>
                            </div>
                        </div>
                        <!--Review And Description Tab Content End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Product Description Review Section Start-->

    <!--Product section start-->
    <div class="product-section section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-55 pb-lg-35 pb-md-25 pb-sm-15 pb-xs-5">
        <div class="container">

            <div class="row">
                <div class="col">
                    <div class="section-title text-center mb-50 mb-xs-20">
                        <h2>{{$langJson->home->isComing}}</h2>
                    </div>
                </div>
            </div>
            <div class="row product-slider">
                @foreach($viewData->homeProduct as $item)
                    <div class="col">
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
    <!--Product section end-->
    <!--Product section start-->
    <div class="product-section section pt-100 pt-lg-80 pt-md-70 pt-sm-60 pt-xs-50 pb-55 pb-lg-35 pb-md-25 pb-sm-15 pb-xs-5">
        <div class="container">

            <div class="row">
                <div class="col">
                    <div class="section-title text-center mb-50 mb-xs-20">
                        <h2>{{$langJson->home->trendProduct}}</h2>
                    </div>
                </div>
            </div>
            <div class="row product-slider">
                @foreach($viewData->discountProduct as $item)
                    <div class="col">
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
    <!--Product section end-->

@endsection
@section("footer")
    <script>

        $(document).ready(function () {
            $(document).on("change", ".product-count", function () {
                if ($(this).val() <= 0) {
                    $(this).val(1)
                }
            })
            $(document).on("click", ".add-to-basket", function () {
                let count = $(".product-option").length;
                let qty = 0;
                let options = [];
                $(".product-option option:selected").each(function (i, item) {
                    let data = $(this)
                    if (data.val() == 0) {
                        iziToast.error({
                            title: "{{$langJson->alert->error}}",
                            message: data.data("name") + "{{$langJson->alert->null}}",
                            position: "topCenter"
                        });
                    } else {
                        options.push(data.val())
                    }
                })

                if (options.length === (count / 2)) {
                    qty = $(".product-count").val()
                    $.ajax({
                        "url": "{{route("theme.{$langJson->routes->basket_add}")}}",
                        "data": {"options": options, "count": qty, "id": {{$viewData->item->id}}},
                        "type": "POST"
                    }).done(function (response) {
                        $(".item_count").text(response.count)
                        $("#cart-render").html(response.data)
                        iziToast.success({
                            title: "{{$langJson->alert->success}}",
                            message: response.alert,
                            position: "topCenter"
                        });
                        $(".mini_cart_wrapper").effect("shake", {
                            distance: 5,
                            times: 2
                        })
                    })
                }
            })
        })
    </script>
@endsection
