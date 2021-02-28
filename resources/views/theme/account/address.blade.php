@foreach ($viewData->address as $address)
    <div class="row" data-id="{{ $address->id }}">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <address>
                <p><strong>{{ $address->title }}</strong></p>
                <p>{{ $address->address }}</p>
                <p>
                    {{ $address->quarter->mahalle_adi }}
                    {{ $address->neighborhood->semt_adi }}
                    <br>
                    {{ $address->district->ilce_adi }} /
                    {{ $address->city->il_adi }}
                </p>
                <p>{{ $address->phone }}</p>
            </address>
        </div>
        <div
            class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 align-items-center align-content-center align-middle text-right my-auto py-auto">
            <a href="javascript:void(0)" data-id="{{ $address->id }}"
                class="btn d-inline-block edit-address-btn align-items-center align-content-center align-middle my-auto py-auto"><i
                    class="fa fa-edit"></i>{{ $langJson->account->edit_address }}</a>
            <a href="javascript:void(0)" data-id="{{ $address->id }}"
                class="btn d-inline-block AddressDelete align-items-center align-content-center align-middle my-auto py-auto"><i
                    class="fa fa-trash"></i>{{ $langJson->account->delete_address }}</a>
        </div>
    </div>
    <hr>
@endforeach
