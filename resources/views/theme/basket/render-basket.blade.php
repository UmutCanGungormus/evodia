<div class="cart-summary-wrap">
    <h4>{{$langJson->basket->cart_summary}}</h4>
    <p>{{$langJson->home->sub_total}}
        <span>{{\Cart::getSubTotal()}} {{$langJson->home->price}}</span></p>
    @foreach(\Cart::getConditions() as $condition)
        <p>{{$langJson->account->discount_coupon}}
            <span>{{ $condition->getName()}} {{$condition->getValue()}}</span>
            <a href="javascript:void(0)" data-id="{{$condition->getName()}}" class="delete-discount"><i class="fas fa-times"></i></a>

        </p>
    @endforeach
    <h2>{{$langJson->home->total}}
        <span>{{\Cart::getTotal()}} {{$langJson->home->price}}</span></h2>
</div>
<div class="cart-summary-button">
    <a href="" class="btn">{{$langJson->basket->checkout}}</a>
</div>
