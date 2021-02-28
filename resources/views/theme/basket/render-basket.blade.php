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
