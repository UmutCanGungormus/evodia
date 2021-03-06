<?php

namespace App\Http\Controllers\Panel\GalleryContent;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\Gallery;
use App\Models\Panel\GalleryFile;
use App\Models\Panel\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function __construct(Session $session, Request $request)
    {
        $this->viewData = new \stdClass();
        $this->viewData->admin = Session::get("admin");
        $this->viewData->page = new \stdClass();
        $this->viewData->segment = $request->segment(2);
        $this->viewData->page->title = "Galeriler";
        $this->viewData->page->description = "Bu Sayfada Sitenizin Galerilerini Görebilirsiniz.";
        $this->viewData->settings = Settings::where("isActive", 1)->first();
    }

    public function index($id)
    {
        $this->viewData->id = $id;
        $this->viewData->settings_all = Settings::where("isActive", 1)->get();
        return view("panel.galleryContent.list.index")->with("data", $this->viewData);
    }

    public function create()
    {
        $this->viewData->page->title = "Galeri Ekle";
        $this->viewData->page->description = "Sitenize Yeni Bir Galeri Ekleyin.";
        $this->viewData->settings_all = Settings::where("isActive", 1)->get();
        return view("panel.galleryContent.add.index")->with("data", $this->viewData);
    }

    public function fileUpload(Request $request, $lang)
    {
        $data = Gallery::where("id", $request->id)->first();
        $count = GalleryFile::where("gallery_id", $request->id)->count();
        if ($data) {
            foreach ($request->file() as $key => $file):
                $strFileName = json_decode($data->seo_url, true)[$lang];
                $extension = $file->extension();
                $fileNameWithExtension = $strFileName . "-" . rand(0, 99999999999) . "-" . time() . "." . $extension;
                $path = $file->storeAs("uploads/galleries/{$strFileName}", $fileNameWithExtension, "public");
                $insertData["img_url"] = $path;
                if (!$path) {
                    $status = 0;
                }
            endforeach;
            $insertData["lang"] = $lang;
            $insertData["gallery_id"] = $request->id;
            $insertData["rank"] = $count + 1;
            $insertData["isActive"] = 1;
            $add = GalleryFile::insert($insertData);

        } else {
            return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Galeri Bulunamadı"], 200, [], JSON_UNESCAPED_UNICODE);
        }

    }

    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title" => "required",

        ]);
        $languages = DB::table("languages")->get();
        $all_settings = Settings::where("isActive", 1)->get();
        if ($validator->fails()) {
            $this->viewData->languages = $languages;
            $request->session()->flash("validator", ['status' => 'error', "msg" => $validator->messages(), "title" => "Hata!"]);
            return redirect()->back();
        } else {
            $data = $request->except("_token");
            $seo_url = Helpers::seoJson($request->title, $all_settings);
            if (!empty($request->file())) {
                if (is_array($request->file())) {
                    $status = 1;
                    foreach ($request->file() as $key => $file):
                        foreach ($file as $k => $v) {
                            $strFileName = json_decode($seo_url, true)[$k];
                            $extension = $v->extension();
                            $fileNameWithExtension = $strFileName . "-" . rand(0, 99999999999) . "-" . time() . "." . $extension;
                            $path = $v->storeAs("uploads/galleries/{$strFileName}", $fileNameWithExtension, "public");
                            $data["img_url"][$k] = $path;
                            if (!$path) {
                                $status = 0;
                            }
                        }
                    endforeach;
                }
            }
            $data = Helpers::makeJson($data);
            $data["seo_url"] = $seo_url;
            $data["rank"] = Gallery::count() + 1;
            $data["isActive"] = 1;
            $add = Gallery::insert($data);
            if ($add) {
                $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Eklendi.", "title" => "Başarılı!"]);
                return redirect()->route("panel.galleryContent.index");
            } else {
                $this->viewData->languages = DB::table("languages")->get();
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Ayarlarınız Eklenirken Bir Hata Oluştu.", "title" => "Hata!"]);
                return redirect()->back();
            }
        }
    }

    public function edit(Request $request, $id = null)
    {

        if ($id) {
            $this->viewData->item = GalleryFile::where("id", $id)->first();
            $this->viewData->page->title = $this->viewData->item->title . " Dosyasını Düzenle";
            $this->viewData->page->description = $this->viewData->item->title . " Dosyasını Düzenleyin";
            $data = view("panel.galleryContent.update.render")->with("data", $this->viewData)->render();
            return response()->json(["success" => "render", "data" => $data,"title"=>$this->viewData->item->title ." İçeriğini Düzenle","subtitle"=>$this->viewData->item->title ." İçeriğini Düzenle"], 200, [], JSON_UNESCAPED_UNICODE);

        } else {
            return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Dosya Bulunamadı"], 200, [], JSON_UNESCAPED_UNICODE);
        }

    }

    public function update(Request $request, $id = null)
    {
        $item = GalleryFile::where("id", $id)->first();
        if ($item) {
            $data["title"]=$request->title;
            $data["description"]=$request->description;
            $update=GalleryFile::where("id",$id)->update($data);
            return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "İçerik Başarıyla Düzenlendi"], 200, [], JSON_UNESCAPED_UNICODE);

        } else {
            return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "İçerik Düzenlenemedi"], 200, [], JSON_UNESCAPED_UNICODE);

        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        if (!empty($id)) {
            $data = GalleryFile::where("id", $id)->first();
            $delete = GalleryFile::where("id", $id)->delete();
            if ($delete) {

                Storage::disk("public")->delete($data->img_url);

                if ($request->ajax()) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Kayıt başarıyla Silindi"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    $request->session()->flash("alert", ['status' => 'success', "msg" => "Kayıt Başarıyla Silindi.", "title" => "Başarılı!"]);
                    return redirect()->back();
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Kayıt Silme İşlemi Sırasında Bir Hata Oluştu"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    $request->session()->flash("alert", ['status' => 'error', "msg" => "Kayıt Silinemedi.", "title" => "Hata!"]);
                    return redirect()->back();
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Böyle Bir Kayıt Yok"], 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Böyle Bir Kayıt Yok.", "title" => "Hata!"]);
                return redirect()->back();
            }
        }
    }



    public function datatable(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = GalleryFile::where("gallery_id", $id)->orderBy("rank")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        İşlemler
                      </button>
                      <div class="dropdown-menu">
                        <a  data-url="' . route("panel.galleryContent.edit", $row->id) . '" class="dropdown-item edit-item" href="#"><i class="fas fa-pen"></i> İçerik Düzenle</a>
                        <a data-url="' . route("panel.galleryContent.delete") . '" data-id="' . $row->id . '" class="dropdown-item delete-item" href="#"><i class="fas fa-trash"></i> Kaydı Sil</a>
                      </div>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isActive', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isActive == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.galleryContent.isactive") . '" type="checkbox" class="custom-control-input isActive" id="customSwitch' . $row->id . '">
                      <label class="custom-control-label" for="customSwitch' . $row->id . '"></label>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('order', function ($row) {
                    $btn = '<i data-id="' . $row->id . '" class="fas fa-arrows-alt"></i>';
                    return $btn;
                })
                ->editColumn("rank", function ($row) {
                    return $row->rank + 1;
                })
                ->setRowClass(function ($row) {
                    return 'text-center';
                })
                ->rawColumns(['action', 'isActive', 'order'])
                ->make(true);
        }
    }

    public function rankSetter(Request $request)
    {
        $data = $request->except("_token");
        if (!empty($data)):
            $durum = 1;
            foreach ($data["data"] as $item):
                $update = GalleryFile::where("id", $item["id"])->update(["rank" => $item["position"]]);
                if (!$update) {
                    $durum = 0;
                }
            endforeach;
            if ($durum == 1) {
                return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Sıralama İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Sıralama İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
            }
        endif;
    }

    public function isActiveSetter(Request $request)
    {

        $data = $request->except("_token");
        if (!empty($data)):

            $data = Gallery::where($data)->first();
            if ($data) {
                $isActive = ($data->isActive == 1 ? 0 : 1);
                $update = Gallery::where("id", $data->id)->update(["isActive" => $isActive]);
                if ($update) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Güncelleme İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Güncelleme İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
                }
            }

        endif;
    }
}
