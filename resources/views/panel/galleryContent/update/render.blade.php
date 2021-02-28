<div class="container-fluid">
    <form action="{{route("panel.galleryContent.update",$data->item->id)}}" method="POST" id="content-form" class="form-material">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="form-group form-default">
                    <input type="text" value="{{$data->item->title}}" name="title"
                           class="form-control">
                    <span class="form-bar"></span>
                    <label class="float-label">Başlık</label>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="form-group ">
                    <label>İçerik Bilgisi</label>
                    <textarea name="description" class="m-0 tinymce">{{$data->item->description}}</textarea>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-success w-100" id="content-submit" data-url="{{route("panel.galleryContent.update",$data->item->id)}}" type="button">Gönder</button>
            </div>
        </div>
    </form>

</div>
</div>
