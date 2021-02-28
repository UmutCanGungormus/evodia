<div id="myTabContent-2" class="tab-content">
    <div id="grid" class="tab-pane fade">
        <div class="product-grid-view">
            <div class="row">
                @foreach($viewData->products->data as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <!--  Single Grid product Start -->
                        <div class="single-grid-product mb-40">
                            <div class="product-image">
                                @if($product->isDiscount)
                                    <div class="product-label">
                                        <span>{{$langJson->home->discount}}</span>
                                    </div>
                                @endif

                                <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">
                                    <img src="{{asset("storage/{$product->cover_photo->img_url}")}}" class="img-fluid" alt="{{$product->title->$lang}}"></a>
                                <div class="product-action">
                                    <ul>
                                        <li>
                                            <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}"><i class="fa fa-search  mt-2"></i></a>
                                        </li>

                                        <li>
                                            <a data-id="{{$product->id}}" class="addToFavourite" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="fa fa-heart  mt-2"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">{{$product->title->$lang}}</a>
                                </h3>
                                <p class="product-price">
                                    <span class="discounted-price">{{$product->price->$lang}} {{$langJson->home->price}}</span>
                                </p>
                            </div>
                        </div>
                        <!--  Single Grid product End -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="list" class="tab-pane fade active show">
        <div class="product-list-view">
            <!-- Single List Product Start -->
            @foreach($viewData->products->data as $product)
                <div class="product-list-item mb-40">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="single-grid-product">
                                <div class="product-image">
                                    @if($product->isDiscount)
                                        <div class="product-label">
                                            <span>{{$langJson->home->discount}}</span>
                                        </div>
                                    @endif

                                    <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">
                                        <img src="{{asset("storage/{$product->cover_photo->img_url}")}}" class="img-fluid" alt="{{$product->title->$lang}}"></a>

                                    <div class="product-action">
                                        <ul>
                                            <li>
                                                <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}"><i class="fa fa-search  mt-2"></i></a>
                                            </li>

                                            <li>
                                                <a data-id="{{$product->id}}" class="addToFavourite" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="fa fa-heart  mt-2"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-6">
                            <div class="product-content-shop-list">
                                <div class="product-content">
                                    <h3 class="title">
                                        <a href="{{route("theme.{$langJson->routes->product}",$product->seo_url->$lang)}}">{{$product->title->$lang}}</a>
                                    </h3>
                                    <p class="product-price">
                                        <span class="discounted-price">{{$product->price->$lang}} {{$langJson->home->price}}</span>
                                    </p>
                                    <p class="product-desc">{{Str::words($product->description->$lang,"3","...")}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
        <!-- Single List Product Start -->
        </div>
    </div>
</div>
