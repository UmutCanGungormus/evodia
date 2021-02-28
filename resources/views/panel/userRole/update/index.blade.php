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

                                            <form enctype="multipart/form-data" class="form-material" method="POST"
                                                  action="{{route("panel.userRole.update",$data->item->id)}}">
                                                @csrf


                                                <div class="row">
                                                    <div
                                                        class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <div class="form-group form-default">
                                                            <input type="text"
                                                                   value="{{$data->item->title}}"
                                                                   name="title"
                                                                   class="form-control">
                                                            <span class="form-bar"></span>
                                                            <label class="float-label">Kullanıcı Yetkisi Adı</label>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                       <div class="row mr-0 pr-0 pb-3">
                                                           <div class="col-12 mr-0 pr-0 text-right justify-content-end">
                                                           <button class="btn btn-success all-checked-btn text-right" type="button">Tümünü Seç</button>
                                                           <button class="btn btn-danger all-not-checked-btn text-right" type="button">Tümünü Kaldır</button>
                                                           </div>
                                                       </div>
                                                        <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>

                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>Modül Adı</td>
                                                                <td>Görüntüle</td>
                                                                <td>Ekle</td>
                                                                <td>Güncelle</td>
                                                                <td>Sil</td>
                                                            </tr>
                                                            @foreach($data->controllers as $key =>$item)
                                                                @php
                                                                    $name=strtolower($key);
                                                                @endphp
                                                                <tr>
                                                                    <td>{{$item["title"]}} </td>
                                                                    <td>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox"

                                                                                   name='{{$name}}[list]'
                                                                                   <?=(!empty($data->item->permissions->$key->list)?($data->item->permissions->$key->list=="on"?"checked":""):"")?>
                                                                                   class="custom-control-input"
                                                                                   id="{{$key}}">
                                                                            <label class="custom-control-label"
                                                                                   for="{{$key}}"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox"
                                                                                   <?=(!empty($data->item->permissions->$key->create)?($data->item->permissions->$key->create=="on"?"checked":""):"")?>

                                                                                   name='{{$name}}[create]'
                                                                                   class="custom-control-input"
                                                                                   id="{{$key}}-1">
                                                                            <label class="custom-control-label"
                                                                                   for="{{$key}}-1"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox"
                                                                                   <?=(!empty($data->item->permissions->$key->update)?($data->item->permissions->$key->update=="on"?"checked":""):"")?>

                                                                                   name='{{$name}}[update]'
                                                                                   class="custom-control-input"
                                                                                   id="{{$key}}-2">
                                                                            <label class="custom-control-label"
                                                                                   for="{{$key}}-2"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-switch">
                                                                            <input type="checkbox"
                                                                                   <?=(!empty($data->item->permissions->$key->delete)?($data->item->permissions->$key->delete=="on"?"checked":""):"")?>

                                                                                   name='{{$name}}[delete]'
                                                                                   class="custom-control-input"
                                                                                   id="{{$key}}-3">
                                                                            <label class="custom-control-label"
                                                                                   for="{{$key}}-3"></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                            <tfoot></tfoot>
                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 offset-0 offset-sm-0 offset-md-0 offset-lg-8 offset-xl-8 text-right">
                                                        <input type="submit" class="btn btn-primary submit-btn rounded"
                                                               value="Kaydet">
                                                        <a href="{{route("panel.userRole.index")}}"
                                                           class="btn btn-danger rounded">İptal</a>
                                                    </div>
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
            $(document).on("click",".all-checked-btn",function (){
                $(".custom-control-input").each(function (e,elem){
                    $(this).prop('checked', true);
                });
            })
            $(document).on("click",".all-not-checked-btn",function (){
                $(".custom-control-input").each(function (e,elem){
                  $(this).prop('checked', false);
                });
            })
           /* $(document).on("click",".submit-btn",function (){
                $(".custom-control-input").each(function (e,elem){
                  if(!$(this).is(":checked")){
                      $(this).val("off");
                  }
                });
            })*/

        });
    </script>
@endsection
