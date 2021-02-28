@extends('panel.layouts.app')
@section("title","panel Ayarlar")
@section("header")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />
@endsection
@section("content")
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Material tab card start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Site Ayarlarınızı Ekleyin</h5>
                                </div>
                                <div class="card-block">
                                    <!-- Row start -->
                                    <div class="row m-b-30">
                                        <div class="col-12">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#site-info"
                                                       role="tab">Site Bilgileri</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#address" role="tab">Adres
                                                        Bilgisi</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#social-media"
                                                       role="tab">Sosyal Medya</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#logo"
                                                       role="tab">Logo</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#meta-tags" role="tab">Meta
                                                        Tags</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#analytics" role="tab">Site
                                                        Analiz Kodları</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#live-support"
                                                       role="tab">Live Support</a>
                                                    <div class="slide"></div>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <form enctype="multipart/form-data" class="form-material" method="POST" action="{{route("panel.settings.update",$data->item->id)}}">
                                                @csrf
                                                <div class="tab-content card-block">
                                                    <div class="tab-pane active" id="site-info" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->company_name}}" name="company_name"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Firma Adı</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                <div class="form-group form-default">
                                                                    <input type="text"  value="{{$data->item->email}}" name="email"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">E-posta</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->slogan}}" name="slogan"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Firma Slogan</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div
                                                                class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group form-default">
                                                                    <input type="text"  value="{{$data->item->phone_1}}" name="phone_1"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Telefon 1</label>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group form-default">
                                                                    <input type="text"  value="{{$data->item->phone_2}}" name="phone_2"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Telefon 2</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div
                                                                class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group form-default">
                                                                    <input type="text"  value="{{$data->item->fax_1}}" name="fax_1"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Fax 1</label>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->fax_2}}" name="fax_2"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Fax 2</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group form-default">
                                                                    <select name="language" class="form-control fill languages">
                                                                        <option value="">Dil Seçiniz</option>
                                                                        @foreach($data->languages as $language)
                                                                            <option <?=($data->item->language==$language->code ?"selected" :"")?> value="{{$language->code}}">{{$language->name}}  ({{$language->code}})</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="tab-pane" id="address" role="tabpanel">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->g_map}}" name="g_map"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Map Kodu (Not: Sadece
                                                                        https://... Linkini Ekleyiniz)</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label>Adres Bilgisi</label>
                                                                <textarea name="address" class="m-0 tinymce">{{$data->item->address}}</textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="tab-pane" id="social-media" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->facebook}}" name="facebook"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Facebook</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->twitter}}" name="twitter"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Twitter</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->instagram}}" name="instagram"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">İnstagram</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->linkedin}}" name="linkedin"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Linkedin</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                <div class="form-group form-default">
                                                                    <input type="text" value="{{$data->item->youtube}}" name="youtube"
                                                                           class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Youtube</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="logo" role="tabpanel">

                                                        <div class="form-group row">
                                                            <label class="col-sm-1 col-form-label">Logo</label>
                                                            <div class="col-2">
                                                                <img src="{{asset("storage/{$data->item->logo}")}}" class="img-fluid" >
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="file" name="logo" style="height:34px" id="logo-input"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="col-3 d-none" id="logo-inputs">
                                                                <a href="javascript:void(0)" data-id="logo-input"
                                                                   class="btn btn-primary input-change p-2">Değiştir</a>
                                                                <a href="javascript:void(0)" data-id="logo-input"
                                                                   class="btn btn-danger input-destroy p-2">Kaldır</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-1 col-form-label">Mobil Logo</label>
                                                            <div class="col-2">
                                                                <img src="{{asset("storage/{$data->item->mobile_logo}")}}" class="img-fluid" >
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="file" name="mobile_logo"
                                                                       id="mobile-logo-input" style="height:34px"  class="form-control">
                                                            </div>
                                                            <div class="col-3 d-none" id="mobile-logo-inputs">
                                                                <a href="javascript:void(0)" data-id="mobile-logo-input"
                                                                   class="btn btn-primary input-change p-2">Değiştir</a>
                                                                <a href="javascript:void(0)" data-id="mobile-logo-input"
                                                                   class="btn btn-danger input-destroy p-2">Kaldır</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-1 col-form-label">Favicon</label>
                                                            <div class="col-2">
                                                                <img src="{{asset("storage/{$data->item->favicon}")}}" class="img-fluid" >
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="file" name="favicon" style="height:34px" id="favicon-input"
                                                                       class="form-control">
                                                            </div>
                                                            <div class="col-3 d-none" id="favicon-inputs">
                                                                <a href="javascript:void(0)" data-id="favicon-input"
                                                                   class="btn btn-primary input-change p-2">Değiştir</a>
                                                                <a href="javascript:void(0)" data-id="favicon-input"
                                                                   class="btn btn-danger input-destroy p-2">Kaldır</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="meta-tags" role="tabpanel">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>Meta Keywords</label>
                                                                <textarea name="meta_keywords" class="m-0 tinymce">{{$data->item->meta_keywords}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>Meta Description</label>
                                                                <textarea name="meta_description" class="m-0 tinymce">{{$data->item->meta_description}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="analytics" role="tabpanel">

                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>Google Analytics</label>
                                                                <textarea name="analytics" class="m-0 tinymce">{{$data->item->analytics}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>Yandex Metrica</label>
                                                                <textarea name="metrica" class="m-0 tinymce">{{$data->item->metrica}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="live-support" role="tabpanel">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label>Canlı Destek (Script kodlarını editörün "Code View (< / >)" bölümünden ekleyiniz!)</label>
                                                                <textarea name="live_support" class="m-0 tinymce">{{$data->item->live_support}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 offset-0 offset-sm-0 offset-md-0 offset-lg-8 offset-xl-8 text-right">
                                                    <input type="submit" class="btn btn-primary rounded" value="Düzenle">
                                                    <a href="{{route("panel.settings.index")}}" class="btn btn-danger rounded">İptal</a>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                    <!-- Row end -->
                                </div>
                            </div>
                            <!-- Material tab card end -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section("footer")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/tr.min.js" integrity="sha512-2386tYyq9+EGdON3UecxdBTaO5lnboGy/rq93uHoVeBqxHAPvjnQsXJMfKBJck63KwQ3xidTlPBDvW3DR+Yo+Q==" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $("input").focus();
            $('.languages').select2({
                language: "tr"
            });

            $(document).on("change", "#logo-input", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let value = $(this).val().split('\\').pop();
                if (value !== null && value !== "" && value !== undefined) {
                    $("#logo-inputs").removeClass("d-none")
                } else {
                    $("#logo-inputs").addClass("d-none")
                }
            })
            $(document).on("change", "#mobile-logo-input", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let value = $(this).val().split('\\').pop();
                if (value !== null && value !== "" && value !== undefined) {
                    $("#mobile-logo-inputs").removeClass("d-none")
                } else {
                    $("#mobile-logo-inputs").addClass("d-none")
                }
            })
            $(document).on("change", "#favicon-input", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let value = $(this).val().split('\\').pop();
                if (value !== null && value !== "" && value !== undefined) {
                    $("#favicon-inputs").removeClass("d-none")
                } else {
                    $("#favicon-inputs").addClass("d-none")
                }
            })
            $(document).on("click", ".input-change", function () {
                let id = $(this).data("id");
                let data = $('#' + id)
                data.trigger("click")

            })
            $(document).on("click", ".input-destroy", function () {
                let id = $(this).data("id");
                let data = $('#' + id)
                data.val("")
                data.trigger("change")
            })
        });
    </script>
@endsection
