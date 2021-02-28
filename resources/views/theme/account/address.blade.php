@foreach($viewData->address as $address)
    <address>
        <p><strong>{{$address->title}}</strong></p>
        <p>{{$address->address}}</p>
        <p>
            {{$address->quarter->mahalle_adi}}
            {{$address->neighborhood->semt_adi}}
            <br>
            {{$address->district->ilce_adi}} /
            {{$address->city->il_adi}}
        </p>
        <p>{{$address->phone}}</p>
    </address>
    <a href="#" data-id="{{$address->id}}" class="btn d-inline-block edit-address-btn"><i class="fa fa-edit"></i>Edit Address</a>
@endforeach
