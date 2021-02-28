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
                                    <h5> {{$data->page->title}}</h5>
                                </div>
                                <div class="card-block">
                                    <!-- Row start -->
                                    <div class="row m-b-30">
                                        <div class="col-12">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                                @foreach($data->settings_all as $key=>$v)
                                                    <li class="nav-item">
                                                        <a class="nav-link <?=($key == 0 ? "active" : "")?>"
                                                           data-toggle="tab" href="#{{$v->languages->code}}"
                                                           role="tab">Dil: {{$v->languages->code}}</a>
                                                        <div class="slide"></div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <!-- Tab panes -->
                                            <form enctype="multipart/form-data" class="form-material" method="POST"
                                                  action="{{route("panel.productCategory.update",$data->item->id)}}">
                                                @csrf
                                                <div class="tab-content card-block">
                                                    @foreach($data->settings_all as $key=>$v)
                                                        @php
                                                            $lang=$v->languages->code;
                                                        @endphp
                                                        <div class="tab-pane <?=($key == 0 ? "active" : "")?>"
                                                             id="{{$lang}}" role="tabpanel">
                                                            <div class="row">
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                    <div class="form-group form-default">
                                                                        <input type="text"
                                                                               value="{{$data->item->title->$lang}}"
                                                                               name="title[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Kategori Adı</label>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 ">


                                                                    <div class="form-group row">
                                                                        <label
                                                                            class="col-sm-1 col-form-label">Görsel</label>
                                                                        <div class="col-2">
                                                                            <img
                                                                                src="{{asset("storage/{$data->item->img_url->$lang}")}}"
                                                                                class="img-fluid">
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <input type="file"
                                                                                   name="img_url[{{$lang}}]"
                                                                                   data-id="img-inputs-{{$lang}}"
                                                                                   id="img-input-{{$lang}}"
                                                                                   class="form-control img-input">
                                                                        </div>
                                                                        <div class="col-3 d-none"
                                                                             id="img-inputs-{{$lang}}">
                                                                            <a href="javascript:void(0)"
                                                                               data-id="img-input-{{$lang}}"
                                                                               class="btn btn-primary input-change">Değiştir</a>
                                                                            <a href="javascript:void(0)"
                                                                               data-id="img-input-{{$lang}}"
                                                                               class="btn btn-danger input-destroy">Kaldır</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                    <div class="form-group form-default">
                                                                        <label>Kategori Açıklaması</label>
                                                                        <textarea
                                                                            name="description[{{$lang}}]"
                                                                            class="m-0 tinymce">{{$data->item->description->$lang}}</textarea>
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
                                                                        @if($category->id!=$data->item->id)
                                                                            <option
                                                                                <?=($data->item->top_id == $category->id ? "selected" : "")?> value="{{$category->id}}">{{$category->title}}  </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                <label class="float-label">Üst Kategori Seç</label>

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

        });
    </script>
@endsection
