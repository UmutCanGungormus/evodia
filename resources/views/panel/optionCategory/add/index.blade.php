@extends('panel.layouts.app')
@section("title","panel Ayarlar")
@section("header")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous"/>
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
                                    <h5>{{$data->page->title}}</h5>
                                </div>
                                <div class="card-block">
                                    <!-- Row start -->
                                    <div class="row m-b-30">
                                        <div class="col-12">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs md-tabs" role="tablist">

                                                @foreach($data->settings_all as $key=>$item)
                                                    <li class="nav-item">
                                                        <a class="nav-link <?=($key == 0 ? "active" : "")?>"
                                                           data-toggle="tab" href="#{{$item->languages->code}}"
                                                           role="tab">Dil: {{$item->languages->code}}</a>
                                                        <div class="slide"></div>
                                                    </li>
                                                @endforeach

                                            </ul>
                                            <!-- Tab panes -->
                                            <form enctype="multipart/form-data" class="form-material" method="POST"
                                                  action="{{route("panel.optionCategory.save")}}">
                                                @csrf
                                                <div class="tab-content card-block">
                                                    @foreach($data->settings_all as $key=>$item)
                                                        <div class="tab-pane <?=($key == 0 ? "active" : "")?>"
                                                             id="{{$item->languages->code}}" role="tabpanel">
                                                            <div class="row">
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                    <div class="form-group form-default">
                                                                        <input type="text"
                                                                               name="title[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">
                                                                            Kategori Adı</label>
                                                                    </div>
                                                                </div>

                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-sm-2 col-form-label">Görsel</label>
                                                                        <div class="col-6">
                                                                            <input type="file"
                                                                                   name="img_url[{{$item->languages->code}}]"
                                                                                   data-id="img-inputs-{{$item->languages->code}}"
                                                                                   id="img-input-{{$item->languages->code}}"
                                                                                   class="form-control img-input">
                                                                        </div>
                                                                        <div class="col-4 d-none"
                                                                             id="img-inputs-{{$item->languages->code}}">
                                                                            <a href="javascript:void(0)"
                                                                               data-id="img-input-{{$item->languages->code}}"
                                                                               class="btn btn-primary input-change">Değiştir</a>
                                                                            <a href="javascript:void(0)"
                                                                               data-id="img-input-{{$item->languages->code}}"
                                                                               class="btn btn-danger input-destroy">Kaldır</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                    <div class="form-group form-default">
                                                                        <label>Kategori Açıklaması</label>
                                                                        <textarea
                                                                            name="description[{{$item->languages->code}}]"
                                                                            class="m-0 tinymce"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group form-default">
                                                                <select name="top_id"
                                                                        class="form-control fill category">
                                                                    <option value="0">Ana Kategori</option>
                                                                    @foreach($data->categories as $category)
                                                                        <option
                                                                            value="{{$category->id}}">{{$category->title}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <label class="float-label">Üst Kategori
                                                                    Seçiniz</label>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div
                                                    class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 offset-0 offset-sm-0 offset-md-0 offset-lg-8 offset-xl-8 text-right">
                                                    <input type="submit" class="btn btn-primary rounded" value="Kaydet">
                                                    <a href="{{route("panel.settings.index")}}"
                                                       class="btn btn-danger rounded">İptal</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.category').select2({
                language: "tr"
            });
            $(document).on("change", ".img-input", function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let value = $(this).val().split('\\').pop();
                if (value !== null && value !== "" && value !== undefined) {
                    $("#" + $(this).data("id")).removeClass("d-none")
                } else {
                    $("#" + $(this).data("id")).addClass("d-none")
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
