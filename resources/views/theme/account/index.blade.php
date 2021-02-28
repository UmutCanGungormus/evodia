@extends('theme.layouts.app')@section("title",$langJson->menu->corporate)
@section("header")
@endsection
@section("content")
    <!-- Page Banner Section Start -->
    <div class="page-banner-section section bg-image" data-bg="assets/images/bg/breadcrumb.png">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="page-banner text-left">
                        <h2>{{$langJson->menu->account}}</h2>
                        <ul class="page-breadcrumb">
                            <li><a href="index.html">{{$langJson->menu->home}}</a></li>
                            <li>{{$langJson->menu->account}}</li>
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

                                <a href="#account-info" class="active" data-toggle="tab"><i class="fa fa-user"></i> Hesap Detaylarım</a>

                                <a href="#orders" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Siparişlerim</a>

                                <a href="#download" data-toggle="tab"><i class="fas fa-tags"></i> İndirim Kuponlarım</a>

                                <a href="#address-edit" data-toggle="tab"><i class="fas fa-map-marker-alt"></i> Adreslerim</a>
                                <a href="#favourites" data-toggle="tab"><i class="fa fa-heart"></i> Favorilerim</a>


                                <a href="{{route("theme.{$langJson->routes->logout}")}}"><i class="fas fa-sign-out-alt"></i> {{$langJson->home->logout}}
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

                                                @foreach($viewData->favourites as $product)
                                                    @php
                                                        $photo=array_search($lang,array_column(\App\Helpers\Helpers::objectToArray($product->cover_photos), 'lang'));
                                                        $product->cover_photo=$product->cover_photos->$photo;
                                                    @endphp
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
                                                                            <a data-id="{{$product->id}}" class="deleteToFavourite {{!empty($product->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->delete_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favouriteDelete}}"><i class="fa fa-heart  mt-2"></i></a>
                                                                        </li>

                                                                        <li>
                                                                            <a data-id="{{$product->id}}" class="addToFavourite {{empty($product->favourite_control)?"":"d-none"}}" data-url="{{route("theme.{$langJson->routes->add_favourite}")}}" href="javascript:void(0)" title="{{$langJson->home->favourite}}"><i class="far fa-heart  mt-2"></i></a>
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
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="download" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Downloads</h3>

                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Date</th>
                                                    <th>Expire</th>
                                                    <th>Download</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <tr>
                                                    <td>Mostarizing Oil</td>
                                                    <td>Aug 22, 2018</td>
                                                    <td>Yes</td>
                                                    <td><a href="#" class="btn">Download File</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Katopeno Altuni</td>
                                                    <td>Sep 12, 2018</td>
                                                    <td>Never</td>
                                                    <td><a href="#" class="btn">Download File</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                    <div class="myaccount-content">
                                     <div class="row">
                                         <div class="col-6">
                                             <h3>{{$langJson->contact->address}}</h3>
                                         </div>
                                         <div class="col-6">
                                             <a class="float-right text-dark addAddress" href="javascript:void(0)"><i class="fa fa-edit"></i>Adres Ekle</a>
                                         </div>

                                     </div>
                                        <div id="address-render">
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
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade  show active" id="account-info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Hesap Detayları </h3>

                                        <div class="account-details-form">
                                            <form method="POST" action="{{route("theme.{$langJson->routes->account}")}}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{$langJson->login->full_name}}</label>
                                                        <input type="text" value="{{\Session::get("user")->full_name}}" name="full_name">
                                                    </div>
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{$langJson->login->email}}</label>
                                                        <input type="text" value="{{\Session::get("user")->email}}" name="email">
                                                    </div>
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{$langJson->login->phone}}</label>
                                                        <input type="text" value="{{\Session::get("user")->phone}}" name="phone">
                                                    </div>

                                                    <div class="col-12 mb-30">
                                                        <h4>Password change</h4>
                                                    </div>

                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{$langJson->login->password}}
                                                            <small class="text-danger">({{$langJson->account->pass_null}})</small></label>
                                                        <input type="password" name="password">
                                                    </div>
                                                    <div class="col-lg-6 col-12 mb-30">
                                                        <label>{{$langJson->login->confirm_password}}
                                                            <small class="text-danger">({{$langJson->account->pass_null}})</small></label>
                                                        <input type="password" name="password_confirmation">
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="w-100 btn btn-success save-change-btn">{{$langJson->home->submit}}</button>
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
        <form onsubmit="return false;" method="post" enctype="multipart/form-data">
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
                    <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control rounded-0 " >
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="addresss_city">İl :</label>
                </div>
                <div class="col-9">
                    <select name="city" id="address_city" onchange="changeCity($(this),'.nsdistrict','.nsneighborhood','.nsquarter')" class="city nscity w-100 form-control rounded-0 addAddressCity">
                        <option value="">Lütfen İl Seçiniz.</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_district">İlçe :</label>
                </div>
                <div class="col-9">
                    <select name="district" id="address_district" onchange="changeDistrict($(this),'.nsneighborhood','.nsquarter')" class="district nsdistrict w-100 form-control rounded-0 addAddressDistrict">
                        <option value="">Lütfen Önce İl Seçiniz.</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_neighborhood">Semt :</label>
                </div>
                <div class="col-9">
                    <select name="neighborhood" id="address_neighborhood" onchange="changeNeighborhood($(this),'.nsquarter')" class="neighborhood nsneighborhood w-100 form-control rounded-0 addAddressNeighborhood">
                        <option value="">Lütfen Önce İlçe Seçiniz.</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <div class="col-3 align-items-center">
                    <label for="address_quarter">Mahalle :</label>
                </div>
                <div class="col-9">
                    <select name="quarter" id="address_quarter" class="quarter nsquarter form-control w-100 rounded-0 addAddressQuarter">
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
                <button role="button" class="btn btn-dark AddressAdd float-right rounded-0" data-load-url="https://vencosmetic.com/get_address" data-url="https://vencosmetic.com/adres_ekle">Adres Bilgisini Kaydet</button>
            </div>
        </form>
    </div>
@endsection
@section("footer")
    <script>
        $(document).ready(function () {
            $(document).on("click",".addAddress",function (){
                createModal(".addressModal","Adres Ekle","Yeni Bir Adres Ekle")
                openModal(".addressModal")
            })
        });
    </script>
    @endsection
