@extends('panel.layouts.app')
@section("title","panel Ayarlar")
@section("header")

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
                                    <h5>Site E-Posta Ayarlarını Ekleyin</h5>
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
                                                  action="{{route("panel.emailSettings.update",$data->item->id)}}">
                                                @csrf
                                                <div class="tab-content card-block">
                                                    @foreach($data->settings_all as $key=>$v)
                                                        @php
                                                        $lang=$v->languages->code;
                                                        @endphp
                                                        <div class="tab-pane <?=($key == 0 ? "active" : "")?>"
                                                             id="{{$v->languages->code}}" role="tabpanel">
                                                            <div class="row">
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group form-default">
                                                                        <input type="text" value="{{$data->item->protocol->$lang}}" name="protocol[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Protokol</label>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" value="{{$data->item->host->$lang}}" name="host[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Sunucu Bilgisi</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" value="{{$data->item->port->$lang}}" name="port[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Port Numarası</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" value="{{$data->item->user_name->$lang}}" name="user_name[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Başlık</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" value="{{$data->item->user->$lang}}" name="user[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Adresi (User)</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="password" value="{{$data->item->password->$lang}}" name="password[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Adresine Ait Şifre</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" value="{{$data->item->from->$lang}}" name="from[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Kimden Gidecek (From)</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" value="{{$data->item->to->$lang}}" name="to[{{$lang}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Kime Gidecek (To)</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach
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

    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
