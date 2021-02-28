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
                                    <h5>Site Ayarlarınızı Ekleyin</h5>
                                </div>
                                <div class="card-block">
                                    <!-- Row start -->
                                    <div class="row m-b-30">
                                        <div class="col-12">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                                @php
                                                    $i=0;
                                                @endphp
                                                @foreach($data->content as $key=>$item)

                                                    <li class="nav-item">
                                                        <a class="nav-link <?=($i == 0 ? "active" : "")?>"
                                                           data-toggle="tab" href="#{{$key}}"
                                                           role="tab">{{$key}}</a>
                                                        <div class="slide"></div>
                                                    </li>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach

                                            </ul>
                                            <!-- Tab panes -->
                                            <form enctype="multipart/form-data" class="form-material" method="POST"
                                                  action="{{route("panel.settings.json",$data->lang)}}">
                                                @csrf
                                                <div class="tab-content card-block">
                                                    @php
                                                        $i=0;
                                                    @endphp
                                                    @foreach($data->content as $key=>$item)
                                                        <div class="tab-pane <?=($i == 0 ? "active show" : "")?>"
                                                             id="{{$key}}" role="tabpanel">
                                                            <div class="row">
                                                                @foreach((array)$item as $v_key=>$value)
                                                                    @if(is_object($value))
                                                                        <label for="">{{$value->top}}</label>
                                                                        <input class="form-control" type="text"
                                                                               name="{{$key}}[{{$v_key}}][value]"
                                                                               value="{{$value->value}}">
                                                                    @else
                                                                        <label for="">{{$v_key}}</label>
                                                                        <input class="form-control" type="text"
                                                                               name="{{$key}}[{{$v_key}}]"
                                                                               value="{{$value}}">
                                                                        @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @php
                                                            $i++;
                                                        @endphp
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/tr.min.js"
            integrity="sha512-2386tYyq9+EGdON3UecxdBTaO5lnboGy/rq93uHoVeBqxHAPvjnQsXJMfKBJck63KwQ3xidTlPBDvW3DR+Yo+Q=="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
