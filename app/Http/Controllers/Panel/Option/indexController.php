<?php

namespace App\Http\Controllers\Panel\Option;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\Option;
use App\Models\Panel\OptionCategory;
use App\Models\Panel\Product;
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
        $this->viewData->page->title = "Ürün Listesi";
        $this->viewData->page->description = "Bu Sayfada Sitenizin Ürün Görebilirsiniz.";
        $this->viewData->settings = Settings::where("isActive", 1)->first();
    }

    public function index($id=null)
    {
        $this->viewData->id=$id;
        return view("panel.option.list.index")->with("data", $this->viewData);
    }

    public function create($id=null)
    {
        $this->viewData->categories=OptionCategory::where("isActive",1)->get();
        $this->viewData->page->title = "Ürün Kategorisi Ekle";
        $this->viewData->page->description = "Sitenize Yeni Bir Ürün Kategorisi Ekleyin.";
        $this->viewData->settings_all = Settings::where("isActive", 1)->get();
        $this->viewData->id=$id;
        return view("panel.option.add.index")->with("data", $this->viewData);
    }

    public function save(Request $request,$id=null)
    {
        $validator = Validator::make($request->all(), [
            "price" => "required",

        ]);
        $languages = DB::table("languages")->get();
        $all_settings = Settings::where("isActive", 1)->get();
        if ($validator->fails()) {
            $this->viewData->languages = $languages;
            $request->session()->flash("validator", ['status' => 'error', "msg" => $validator->messages(), "title" => "Hata!"]);
            return redirect()->back();
        } else {
            $product=Product::where("id",$id)->first();
            $data = $request->except("_token");
            $data["product_id"]=$product->id;
            foreach ($request->file() as $key => $file):
                foreach ($file as $k => $v) {
                    $strFileName = json_decode($product->seo_url, true)[$k];
                    $extension = $v->extension();
                    $fileNameWithExtension = $strFileName . "-" . rand(0, 99999999999) . "-" . time() . "." . $extension;
                    $path = $v->storeAs("uploads/options/{$strFileName}", $fileNameWithExtension, "public");
                        $data["img_url"][$k] = $path;

                    if (!$path) {
                        $status = 0;
                    }
                }
                endforeach;
            $data = Helpers::makeJson($data);
            $data["rank"] = Option::count() + 1;
            $data["isActive"] = 1;

            $add = Option::insertGetId($data);
            if ($add) {
                $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Eklendi.", "title" => "Başarılı!"]);
                return redirect()->route("panel.option.index",$product->id);
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
            $this->viewData->item=Option::where("id",$id)->first();
            $this->viewData->products=Product::where("id",$this->viewData->item->product_id)->first();
            $this->viewData->categories=OptionCategory::where("isActive",1)->get();
            $this->viewData->product=$this->viewData->item;
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            $this->viewData->products = Helpers::JsonDecodeRecursive($this->viewData->products);
            if (!empty($this->viewData->item)) {
                $this->viewData->settings_all = Settings::where("isActive", 1)->get();
                $this->viewData->languages = DB::table("languages")->get();
                $this->viewData->page->title = $this->viewData->products->title->tr . " Sayfasını Düzenle";
                $this->viewData->page->description = $this->viewData->products->title->tr . " Sayfasını Düzenleyin";
                return view("panel.option.update.index")->with("data", $this->viewData);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Böyle Bir Kayıt Bulunamadı.", "title" => "Hata!"]);
                return redirect()->back();
            }

        }

    }

    public function update(Request $request, $id = null)
    {

        $item = Option::where("id", $id)->first();
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
                $product=Product::where("id",$item->product_id)->first();
                $seo_url = Helpers::seoJson($product->title, $all_settings);
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
                                $fileNameWithExtension = $strFileName . "-" . rand(0, 99999999999) . "-" . time() . "." . $extension;
                                $path = $v->storeAs("uploads/options/{$strFileName}", $fileNameWithExtension, "public");
                                if (!empty($data["img_url"]->$k)) {
                                    $data["img_url"]->$k = $path;
                                } else {
                                    $data["img_url"]->$k = $path;
                                }
                                if (!$path) {
                                    $status = 0;
                                }
                            }
                        endforeach;
                    }
                }
                $data["img_url"] = (array)$data["img_url"];
                $data = Helpers::makeJson($data);
                $update = Option::where("id", $id)->update($data);
                if ($update) {
                    $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Güncellendi.", "title" => "Başarılı!"]);
                    return redirect()->route("panel.option.index",$item->product_id);
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
            $data = Product::where("id", $id)->first();
            $data=json_decode($data->seo_url);
            $delete = Option::where("id", $id)->delete();
            if ($delete) {
                foreach ( $data as $item) {
                    if (count(Storage::disk("public")->allFiles("uploads/options/".$item)) >= 0) {
                        Storage::disk("public")->deleteDirectory("uploads/options/".$item);
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

    public function datatable(Request $request,$id=null)
    {

        if ($request->ajax()) {
            $data = Option::orderBy("rank")->where("product_id",$id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        İşlemler
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . route("panel.option.update", $row->id) . '"> <i class="fas fa-pen"></i> Kaydı Düzenle</a>
                        <a data-url="' . route("panel.option.delete") . '" data-id="' . $row->id . '" class="dropdown-item delete-item" href="#"><i class="fas fa-trash"></i> Kaydı Sil</a>
                      </div>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isActive', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isActive == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.option.isactive") . '" type="checkbox" class="custom-control-input isActive" id="customSwitch' . $row->id . '">
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
                })->editColumn("price", function ($row) {
                    $btn = Helpers::DataTableJson($row->price);
                    return $btn;
                })->editColumn("stock", function ($row) {
                    $btn = Helpers::DataTableJson($row->stock);
                    return $btn;
                })
                ->editColumn("img_url", function ($row) {
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
                $update = Option::where("id", $item["id"])->update(["rank" => $item["position"]]);
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

            $data = Option::where($data)->first();
            if ($data) {
                $isActive = ($data->isActive == 1 ? 0 : 1);
                $update = Option::where("id", $data->id)->update(["isActive" => $isActive]);
                if ($update) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Güncelleme İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Güncelleme İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
                }
            }

        endif;
    }
}
