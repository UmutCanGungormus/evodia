
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
        @foreach(\Cart::getConditions() as $condition)
            <p>{{$langJson->account->discount_coupon}}
                <span>{{ $condition->getName()}} {{$condition->getValue()}}</span>
                <a href="javascript:void(0)" data-id="{{$condition->getName()}}" class="delete-discount"><i class="fas fa-times"></i></a>

            </p>
        @endforeach
        <div class="cart_total mt-10">
            <h5>{{$langJson->home->total}}: {{\Cart::getTotal()." ".$langJson->home->price}}</h5>
        </div>
    </div>
    <div class="cart-btn">
        <a href="{{route("theme.{$langJson->routes->basket}")}}"><i class="fa fa-shopping-cart"></i> {{$langJson->home->basket_go}}
        </a>
    </div>
</div>
