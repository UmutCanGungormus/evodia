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
                                                  action="{{route("panel.emailSettings.save")}}">
                                                @csrf
                                                <div class="tab-content card-block">
                                                    @foreach($data->settings_all as $key=>$item)
                                                        <div class="tab-pane <?=($key == 0 ? "active" : "")?>"
                                                             id="{{$item->languages->code}}" role="tabpanel">
                                                            <div class="row">
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                                    <div class="form-group form-default">
                                                                        <input type="text" name="protocol[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Protokol</label>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text"name="host[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Sunucu Bilgisi</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" name="port[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Port Numarası</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" name="user_name[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Başlık</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" name="user[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Adresi (User)</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" name="password[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">E-Posta Adresine Ait Şifre</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" name="from[{{$item->languages->code}}]"
                                                                               class="form-control">
                                                                        <span class="form-bar"></span>
                                                                        <label class="float-label">Kimden Gidecek (From)</label>
                                                                    </div>
                                                                </div><div
                                                                    class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">

                                                                    <div class="form-group form-default">
                                                                        <input type="text" name="to[{{$item->languages->code}}]"
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
