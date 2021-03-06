<?php

namespace App\Http\Controllers\Panel\ProductCategory;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\ProductCategory;
use App\Models\Panel\Settings;
use App\Models\Panel\Slider;
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
        $this->viewData->page->title = "Ürün Kategorisi Listesi";
        $this->viewData->page->description = "Bu Sayfada Sitenizin Ürün Kategorilerini Görebilirsiniz.";
        $this->viewData->settings = Settings::where("isActive", 1)->first();
    }

    public function index()
    {
        return view("panel.productCategory.list.index")->with("data", $this->viewData);
    }

    public function create()
    {
        $this->viewData->categories=ProductCategory::where("isActive",1)->get();
        $this->viewData->page->title = "Ürün Kategorisi Ekle";
        $this->viewData->page->description = "Sitenize Yeni Bir Ürün Kategorisi Ekleyin.";
        $this->viewData->settings_all = Settings::where("isActive", 1)->get();

        return view("panel.productCategory.add.index")->with("data", $this->viewData);
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
                            $newFile=$strFileName . "-" . rand(0, 99999999999) . "-" . time();
                            $fileNameWithExtension = $newFile . "." . $extension;
                            $path = $v->storeAs("uploads/product_categories/{$strFileName}", $fileNameWithExtension, "public");
                            $newPath= Helpers::webpConverter($extension,$path,"uploads/product_categories/".$strFileName,$newFile);
                            Storage::disk("public")->delete($path);
                            $data["img_url"][$k] = $newPath;
                            if (!$newPath) {
                                $status = 0;
                            }
                        }
                    endforeach;
                }
            }
            $data = Helpers::makeJson($data);
            $data["seo_url"]=$seo_url;
            $data["rank"] = ProductCategory::count() + 1;
            $data["isActive"] = 1;
            $add = ProductCategory::insert($data);
            if ($add) {
                $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Eklendi.", "title" => "Başarılı!"]);
                return redirect()->route("panel.productCategory.index");
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
            $this->viewData->item = ProductCategory::where("id", $id)->first();
            $this->viewData->categories=ProductCategory::where("isActive",1)->get();
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            if (!empty($this->viewData->item)) {
                $this->viewData->settings_all = Settings::where("isActive", 1)->get();
                $this->viewData->languages = DB::table("languages")->get();
                $this->viewData->page->title = $this->viewData->item->title->tr . " Sayfasını Düzenle";
                $this->viewData->page->description = $this->viewData->item->title->tr . " Sayfasını Düzenleyin";
                return view("panel.productCategory.update.index")->with("data", $this->viewData);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Böyle Bir Kayıt Bulunamadı.", "title" => "Hata!"]);
                return redirect()->back();
            }

        }

    }

    public function update(Request $request, $id = null)
    {

        $item = ProductCategory::where("id", $id)->first();
        if ($item) {
            $validator = Validator::make($request->all(), [

            ]);
            $all_settings = Settings::where("isActive", 1)->get();
            if ($validator->fails()) {
                $this->viewData->languages = DB::table("languages")->get();
                $request->session()->flash("validator", ['status' => 'error', "msg" => $validator->messages(), "title" => "Hata!"]);
                return redirect()->back();
            } else {
                $data = $request->except("_token");
                $item = Helpers::JsonDecodeRecursive($item);
                $seo_url = Helpers::seoJson($request->title, $all_settings);
                $data["img_url"] = $item->img_url;
                if (!empty($request->file())) {
                    if (is_array($request->file())) {
                        $status = 1;
                        foreach ($request->file() as $key => $file):
                            foreach ($file as $k => $v) {
                                $strFileName = json_decode($seo_url, true)[$k];
                                if (!empty($item->img_url->$k)) {
                                    Storage::disk("public")->delete($item->img_url->$k);
                                }
                                $extension = $v->extension();
                                $newFile=$strFileName . "-" . rand(0, 99999999999) . "-" . time();
                                $fileNameWithExtension = $newFile . "." . $extension;
                                $path = $v->storeAs("uploads/product_categories/{$strFileName}", $fileNameWithExtension, "public");
                                $newPath= Helpers::webpConverter($extension,$path,"uploads/product_categories/".$strFileName,$newFile);
                                Storage::disk("public")->delete($path);
                                if (!empty($data["img_url"]->$k)) {
                                    $data["img_url"]->$k = $newPath;
                                } else {
                                    $data["img_url"]->$k = $newPath;
                                }
                                if (!$newPath) {
                                    $status = 0;
                                }
                            }
                        endforeach;
                    }
                }
                $data["img_url"] = (array)$data["img_url"];
                $data = Helpers::makeJson($data);
                $data["seo_url"]=$seo_url;
                $update = ProductCategory::where("id", $id)->update($data);
                if ($update) {
                    $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Güncellendi.", "title" => "Başarılı!"]);
                    return redirect()->route("panel.productCategory.index");
                } else {
                    $this->viewData->languages = DB::table("languages")->get();
                    $request->session()->flash("alert", ['status' => 'error', "msg" => "Ayarlarınız Güncellenirken Bir Hata Oluştu.", "title" => "Hata!"]);
                    return redirect()->back();
                }
            }
        } else {
            $request->session()->flash("alert", ['status' => 'error', "msg" => "Böyle Bir Veri Bulunamadı.", "title" => "Hata!"]);
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        if (!empty($id)) {
            $data = ProductCategory::where("id", $id)->first();
            $data=json_decode($data->img_url);
            $delete = ProductCategory::where("id", $id)->delete();
            if ($delete) {
                foreach ( $data as $item) {
                    if (count(Storage::disk("public")->allFiles(Helpers::explodePath($item,2))) > 0) {
                        Storage::disk("public")->deleteDirectory(Helpers::explodePath($item,2));
                    }
                }
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

    public function datatable(Request $request)
    {

        if ($request->ajax()) {
            $data = ProductCategory::orderBy("rank")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        İşlemler
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . route("panel.productCategory.update", $row->id) . '">Kaydı Düzenle</a>
                        <a data-url="' . route("panel.productCategory.delete") . '" data-id="' . $row->id . '" class="dropdown-item delete-item" href="#">Kaydı Sil</a>
                      </div>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isActive', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isActive == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.productCategory.isactive") . '" type="checkbox" class="custom-control-input isActive" id="customSwitch' . $row->id . '">
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
                })->editColumn("title", function ($row) {
                    $btn = Helpers::DataTableJson($row->title);
                    return $btn;
                })->editColumn("img_url", function ($row) {
                    $btn = Helpers::DataTableJsonImage($row->img_url);
                    return $btn;
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
                $update = ProductCategory::where("id", $item["id"])->update(["rank" => $item["position"]]);
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

            $data = ProductCategory::where($data)->first();
            if ($data) {
                $isActive = ($data->isActive == 1 ? 0 : 1);
                $update = ProductCategory::where("id", $data->id)->update(["isActive" => $isActive]);
                if ($update) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Güncelleme İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Güncelleme İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
                }
            }

        endif;
    }
}
