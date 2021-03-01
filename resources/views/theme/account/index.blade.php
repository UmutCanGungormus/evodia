@extends('theme.layouts.app')@section('title', $langJson->menu->corporate)
@section('header')
    <link rel="stylesheet" href="{{ asset('theme/assets/css/sweet-alert.min.css') }}">
@endsection
@section('content')
    <!-- Page Banner Section Start -->
    <div class="page-banner-section section bg-image" data-bg="assets/images/bg/breadcrumb.png">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="page-banner text-left">
                        <h2>{{ $langJson->menu->account }}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">{{ $langJson->menu->home }}</a></li>
                            <li>{{ $langJson->menu->account }}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Page Banner Section End -->

    <div class="my-account-section section pt-90 pt-lg-70 pt-md-60 pt-sm-50 pt-xs-45  pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="row">
                        <!-- My Account Tab Menu Start -->
                        <div class="col-lg-3 col-12">
                            <div class="myaccount-tab-menu nav" role="tablist">

                                <a href="#account-info" class="active" data-toggle="tab"><i class="fa fa-user"></i> Hesap
                                    Detaylarım</a>

                                <a href="#orders" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Siparişlerim</a>

                                <a href="#download" data-toggle="tab"><i class="fas fa-tags"></i> İndirim Kuponlarım</a>

                                <a href="#address-edit" data-toggle="tab"><i class="fas fa-map-marker-alt"></i>
                                    Adreslerim</a>
                                <a href="#favourites" data-toggle="tab"><i class="fa fa-heart"></i> Favorilerim</a>


                                <a href="{{ route("theme.{$langJson->routes->logout}") }}"><i class="fas fa-sign-out-alt"></i> {{ $langJson->home->logout }}
                                </a>
                            </div>
                        </div>
                        <!-- My Account Tab Menu End -->

                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-12">
                            <div class="tab-content" id="myaccountContent">

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Orders</h3>

                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Mostarizing Oil</td>
                                                    <td>Aug 22, 2018</td>
                                                    <td>Pending</td>
                                                    <td>$45</td>
                                                    <td><a href="cart.html" class="btn">View</a></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Katopeno Altuni</td>
                                                    <td>July 22, 2018</td>
                                                    <td>Approved</td>
                                                    <td>$100</td>
                                                    <td><a href="cart.html" class="btn">View</a></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Murikhete Paris</td>
                                                    <td>June 12, 2017</td>
                                                    <td>On Hold</td>
                                                    <td>$99</td>
                                                    <td><a href="cart.html" class="btn">View</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="favourites" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Favorilerim</h3>
                                        <div class="product-grid-view">
                                            <div class="row">

                                                @foreach ($viewData->favourites as $product)
                                                    @php
                                                        $photo = array_search($lang, array_column(\App\Helpers\Helpers::objectToArray($product->cover_photos), 'lang'));
                                                        $product->cover_photo = $product->cover_photos->$photo;
                                                    @endphp
                                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                                        <!--  Single Grid product Start -->
                                                        <div class="single-grid-product mb-40">
                                                            <div class="product-image">
                                                                @if ($product->isDiscount)
                                                                    <div class="product-label">
                                                                        <span>{{ $langJson->home->discount }}</span>
                                                                    </div>
                                                                @endif

                                                                <a href="{{ route("theme.{$langJson->routes->product}", $product->seo_url->$lang) }}">
                                                                    <img src="{{ asset("storage/{$product->cover_photo->img_url}") }}" class="img-fluid" alt="{{ $product->title->$lang }}"></a>
                                                                <div class="product-action">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="{{ route("theme.{$langJson->routes->product}", $product->seo_url->$lang) }}"><i class="fa fa-search  mt-2"></i></a>
                                                                        </li>
                                                                        <li>
                                                                            <a data-id="{{ $product->id }}" class="deleteToFavourite {{ !empty($product->favourite_control) ? '' : 'd-none' }}" data-url="{{ route("theme.{$langJson->routes->delete_favourite}") }}" href="javascript:void(0)" title="{{ $langJson->home->favouriteDelete }}"><i class="fa fa-heart  mt-2"></i></a>
                                                                        </li>

                                                                        <li>
                                                                            <a data-id="{{ $product->id }}" class="addToFavourite {{ empty($product->favourite_control) ? '' : 'd-none' }}" data-url="{{ route("theme.{$langJson->routes->add_favourite}") }}" href="javascript:void(0)" title="{{ $langJson->home->favourite }}"><i class="far fa-heart  mt-2"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product-content">
                                                                <h3 class="title">
                                                                    <a href="{{ route("theme.{$langJson->routes->product}", $product->seo_url->$lang) }}">{{ $product->title->$lang }}</a>
                                                                </h3>
                                                                <p class="product-price">
                                                                    <span class="discounted-price">{{ $product->price->$lang }}
                                                                        {{ $langJson->home->price }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <!--  Single Grid product End -->
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="download" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>{{$langJson->account->discount_coupon}}</h3>

                                      @if(count((array)$viewData->coupons)>0)
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>{{$langJson->account->coupon_code}}</th>
                                                        <th>{{$langJson->account->expiration_date}}</th>
                                                        <th>{{$langJson->account->rate}}</th>
                                                        <th>{{$langJson->account->copy}}</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($viewData->coupons as $coupon)
                                                        <tr>
                                                            <td>{{$coupon->title->$lang}}</td>
                                                            <td>{{date("d/m/Y",strtotime($coupon->time))}}</td>
                                                            <td>%{{$coupon->discount_rate}}</td>
                                                            <td>
                                                                <a class="btn copy-btn" data-clipboard-text="{{$coupon->title->$lang}}" href="javascript:void(0)">
                                                                    <i class="fas fa-copy"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                          <div class="alert alert-danger">{{$langJson->alert->not_coupon}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                    <div class="myaccount-content">
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                <h3>{{ $langJson->contact->address }}</h3>
                                            </div>
                                            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                                <a class="text-dark addAddress" href="javascript:void(0)"><i class="fa fa-edit"></i>{{ $langJson->account->add_address }}
                                                </a>
                                            </div>

                                        </div>
                                        <div id="address-render">

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
                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 align-items-center align-content-center align-middle text-right my-auto py-auto">
                                                        <a href="javascript:void(0)" data-id="{{ $address->id }}" class="btn d-inline-block edit-address-btn align-items-center align-content-center align-middle my-auto py-auto"><i class="fa fa-edit"></i>{{ $langJson->account->edit_address }}
                                                        </a>
                                                        <a href="javascript:void(0)" data-id="{{ $address->id }}" class="btn d-inline-block AddressDelete align-items-center align-content-center align-middle my-auto py-auto"><i class="fa fa-trash"></i>{{ $langJson->account->delete_address }}
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade  show active" id="account-info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Hesap Detayları </h3>

                                        <div class="account-details-form">
                                            <form method="POST" action="{{ route("theme.{$langJson->routes->account}") }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{ $langJson->login->full_name }}</label>
                                                        <input type="text" value="{{ \Session::get('user')->full_name }}" name="full_name">
                                                    </div>
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{ $langJson->login->email }}</label>
                                                        <input type="text" value="{{ \Session::get('user')->email }}" name="email">
                                                    </div>
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{ $langJson->login->phone }}</label>
                                                        <input type="text" value="{{ \Session::get('user')->phone }}" name="phone">
                                                    </div>

                                                    <div class="col-12 mb-30">
                                                        <h4>Password change</h4>
                                                    </div>

                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{ $langJson->login->password }}
                                                            <small class="text-danger">({{ $langJson->account->pass_null }})</small></label>
                                                        <input type="password" name="password">
                                                    </div>
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{ $langJson->login->confirm_password }}
                                                            <small class="text-danger">({{ $langJson->account->pass_null }})</small></label>
                                                        <input type="password" name="password_confirmation">
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="w-100 btn btn-success save-change-btn">{{ $langJson->home->submit }}</button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                            </div>
                        </div>
                        <!-- My Account Tab Content End -->
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="iziModal addressModal">
        <form onsubmit="return false;" method="post" id="addressAdd" enctype="multipart/form-data">
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_title">Adres Başlığı :</label>
                </div>
                <div class="col-9">
                    <input type="text" name="title" id="address_title" placeholder="Adres Başlığı" class="form-control rounded-0 addAddressTitle">
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="tc">Telefon :</label>
                </div>
                <div class="col-9">
                    <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control rounded-0 ">
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="addresss_city">İl :</label>
                </div>
                <div class="col-9">
                    <select name="city_id" id="address_city" onchange="changeCity($(this),'.nsdistrict','.nsneighborhood','.nsquarter')" class="city nscity w-100 form-control rounded-0 addAddressCity">
                        <option value="">Lütfen İl Seçiniz.</option>
                        @foreach ($viewData->cities as $city)
                            <option value="{{ $city->id }}">{{ $city->il_adi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_district">İlçe :</label>
                </div>
                <div class="col-9">
                    <select name="district_id" id="address_district" onchange="changeDistrict($(this),'.nsneighborhood','.nsquarter')" class="district nsdistrict w-100 form-control rounded-0 addAddressDistrict">
                        <option value="">Lütfen Önce İl Seçiniz.</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_neighborhood">Semt :</label>
                </div>
                <div class="col-9">
                    <select name="neighborhood_id" id="address_neighborhood" onchange="changeNeighborhood($(this),'.nsquarter')" class="neighborhood nsneighborhood w-100 form-control rounded-0 addAddressNeighborhood">
                        <option value="">Lütfen Önce İlçe Seçiniz.</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_quarter">Mahalle :</label>
                </div>
                <div class="col-9">
                    <select name="quarter_id" id="address_quarter" class="quarter nsquarter form-control w-100 rounded-0 addAddressQuarter">
                        <option value="">Lütfen Önce Semt Seçiniz.</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_address">Sokak Bilgisi :</label>
                </div>
                <div class="col-9">
                    <textarea name="address" id="address_address" placeholder="Sokak Bilgisi" class="form-control rounded-0 addAddressAddress"></textarea>
                </div>
            </div>
            <div class="form-group mb-3">
                <button role="button" class="btn btn-dark AddressAdd float-right rounded-0" data-url="{{ url('/adres_ekle') }}">Adres Bilgisini Kaydet</button>
            </div>
        </form>
    </div>
    <div class="editAddress iziModal">

    </div>
@endsection
@section('footer')
    <script src="{{ asset('theme/assets/js/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/clipboard.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            new ClipboardJS('.copy-btn');
            $(document).on("click",".copy-btn",function (){
                iziToast.success({
                    title: "{{$langJson->alert->success}}",
                    message: "{{$langJson->alert->copy}}",
                    position: 'topCenter',
                    display: 'once'
                })
            })

            $(document).on("click", ".addAddress", function () {
                createModal(".addressModal", "{{ $langJson->account->add_address }}",
                    "{{ $langJson->account->add_address }}")
                openModal(".addressModal")
            })
            $(document).on("click", ".AddressAdd", function () {
                let data = $("#addressAdd").serialize();

                $.ajax({
                    url: "{{ route("theme.{$langJson->routes->add_address}") }}",
                    type: "POST",
                    dataType: "json",
                    data: data
                }).done(function (response) {
                    if (response.success) {
                        iziToast.success({
                            title: response.title,
                            message: response.msg,
                            position: 'topCenter',
                            display: 'once'
                        })
                        getAddressData();
                        closeModal(".addressModal");
                    } else {
                        iziToast.error({
                            title: response.title,
                            message: response.msg,
                            position: 'topCenter',
                            display: 'once'
                        })
                    }
                })
            })
            $(document).on("click", ".edit-address-btn", function () {
                let dataid = $(this).data("id");
                $.post("{{ route("theme.{$langJson->routes->edit_address}") }}", {
                    id: dataid
                }, function (response) {
                    if (response.success) {

                        destroyModal(".editAddress");
                        $(".editAddress").html(response.render);
                        createModal(".editAddress", response.title, response.message)
                        openModal(".editAddress")
                    } else {
                        iziToast.error({
                            title: response.title,
                            message: response.msg,
                            position: 'topCenter',
                            display: 'once'
                        })
                    }
                }, 'JSON');

            })
            $(document).on("click", ".AddressEdit", function () {
                let data = $("#addressEdit").serialize();

                let formData = new FormData($("#addressEdit")[0]);
                formData.append("id", $(this).data(
                    "id"));
                formData.append("process", "update");
                let id = $(this).data("id");
                $.ajax({
                    url: "{{ route("theme.{$langJson->routes->edit_address}") }}",
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                }).done(function (response) {
                    if (response.success) {
                        iziToast.success({
                            title: response.title,
                            message: response.msg,
                            position: 'topCenter',
                            display: 'once'
                        })
                        getAddressData();
                        $(".edit-address-btn[data-id=" + id + "]").trigger("click")
                    } else {
                        iziToast.error({
                            title: response.title,
                            message: response.msg,
                            position: 'topCenter',
                            display: 'once'
                        })
                    }
                })
            })
            $(document).on("click", ".AddressDelete", function () {
                let id = $(this).data("id");
                let data = $(this);
                Swal.fire({
                    title: "{{ $langJson->alert->remove_item }}",
                    text: "{{ $langJson->alert->remove_item_desc }}",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "{{ $langJson->alert->cancel }}",
                    confirmButtonText: "{{ $langJson->alert->confirm }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route("theme.{$langJson->routes->delete_address}") }}",
                            data: {
                                id
                            },
                            dataType: "json",
                            type: "POST"
                        }).done(function (response) {
                            if (response.success) {
                                iziToast.success({
                                    title: response.title,
                                    message: response.msg,
                                    position: 'topCenter',
                                    display: 'once'
                                })
                                getAddressData();
                            } else {
                                iziToast.error({
                                    title: response.title,
                                    message: response.msg,
                                    position: 'topCenter',
                                    display: 'once'
                                })
                            }
                        })

                    }
                })

            })
        });

        function getAddressData() {
            $.post("{{ route("theme.{$langJson->routes->render_address}") }}", {}, function (response) {
                $("#address-render").html(response.data);
            });
        }

        // IF CHANGE CITY GET DISTRICTS
        function changeCity($this, district, neighborhood, quarter) {
            let city_id = $this.val();
            if (!city_id || city_id === null || city_id === "") {
                $(district).html("<option value='' data-city-id='' selected>Lütfen Önce İl Seçiniz.</option>");
                $(neighborhood).html("<option value='' data-district-id='' selected>Lütfen Önce İlçe Seçiniz.</option>");
                $(quarter).html("<option value='' data-neighborhood-id='' selected>Lütfen Önce Semt Seçiniz.</option>");
            } else {
                $(district).html("<option value='' data-city-id='' selected>Lütfen Önce İl Seçiniz.</option>");
                $(neighborhood).html("<option value='' data-district-id='' selected>Lütfen Önce İlçe Seçiniz.</option>");
                $(quarter).html("<option value='' data-neighborhood-id='' selected>Lütfen Önce Semt Seçiniz.</option>");
                let options = "<option value='' data-city-id='' selected>Lütfen İlçe Seçiniz.</option>";
                $.post("{{ route("theme.{$langJson->routes->change_city}") }}", {
                    "city_id": city_id
                }, function (response) {
                    response.forEach(function (value, index) {
                        options += "<option value='" + value.id + "' data-city-id='" + value.il_id +
                            "'>" + value.ilce_adi + "</option>";
                    });
                    $(district).html(options);
                    $(district).niceSelect('update');
                }, 'JSON');
            }
        }

        // IF CHANGE DISTRICT GET NEIGHBORHOODS
        function changeDistrict($this, neighborhood, quarter) {
            let district_id = $this.val();
            if (!district_id || district_id === null || district_id === "") {
                $(neighborhood).html("<option value='' data-district-id='' selected>Lütfen Önce İlçe Seçiniz.</option>");
                $(quarter).html("<option value='' data-neighborhood-id='' selected>Lütfen Önce Semt Seçiniz.</option>");
            } else {
                $(neighborhood).html("<option value='' data-district-id='' selected>Lütfen Önce İlçe Seçiniz.</option>");
                $(quarter).html("<option value='' data-neighborhood-id='' selected>Lütfen Önce Semt Seçiniz.</option>");
                let options = "<option value='' data-district-id='' selected>Lütfen Semt Seçiniz.</option>";
                $.post("{{ route("theme.{$langJson->routes->change_district}") }}", {
                    "district_id": district_id
                }, function (response) {
                    response.forEach(function (value, index) {
                        options += "<option value='" + value.id + "' data-district-id='" +
                            value.ilce_id + "'>" + value.semt_adi + "</option>";
                    });
                    $(neighborhood).html(options);
                    $(neighborhood).niceSelect('update');
                }, 'JSON');
            }
        }

        // IF CHANGE NEIGHBORHOOD GET QUARTERS
        function changeNeighborhood($this, quarter) {
            let neighborhood_id = $this.val();
            if (!neighborhood_id || neighborhood_id === null || neighborhood_id === "") {
                $(quarter).html("<option value='' data-neighborhood-id='' selected>Lütfen Önce Semt Seçiniz.</option>");
            } else {
                $(quarter).html("<option value='' data-neighborhood-id='' selected>Lütfen Önce Semt Seçiniz.</option>");
                let options = "<option value='' data-neighborhood-id='' selected>Lütfen Mahalle Seçiniz.</option>";
                $.post("{{ route("theme.{$langJson->routes->change_neighborhood}") }}", {
                    "neighborhood_id": neighborhood_id
                }, function (response) {
                    response.forEach(function (value, index) {
                        options += "<option value='" + value.id + "' data-neighborhood-id='" + value
                            .semt_id + "'>" + value.mahalle_adi + "</option>";
                    });
                    $(quarter).html(options);
                    $(quarter).niceSelect('update');

                }, 'JSON');
            }
        }


    </script>
@endsection
