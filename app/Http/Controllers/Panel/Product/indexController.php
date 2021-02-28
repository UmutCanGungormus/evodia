<?php

namespace App\Http\Controllers\Panel\Product;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\Product;
use App\Models\Panel\ProductCategories;
use App\Models\Panel\ProductCategory;
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
        $this->viewData->page->title = "Ürün Listesi";
        $this->viewData->page->description = "Bu Sayfada Sitenizin Ürün Görebilirsiniz.";
        $this->viewData->settings = Settings::where("isActive", 1)->first();
    }

    public function index()
    {
        return view("panel.product.list.index")->with("data", $this->viewData);
    }

    public function create()
    {
        $this->viewData->categories = ProductCategory::where("isActive", 1)->get();
        $this->viewData->page->title = "Ürün Kategorisi Ekle";
        $this->viewData->page->description = "Sitenize Yeni Bir Ürün Kategorisi Ekleyin.";
        $this->viewData->settings_all = Settings::where("isActive", 1)->get();

        return view("panel.product.add.index")->with("data", $this->viewData);
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
            $category_ids = $data["category_id"];
            unset($data["category_id"]);
            foreach ($data["price"] as $k=>$price){
                $data["price"][$k]=floatval($price);
            }
            $data = Helpers::makeJson($data);
            $data["seo_url"] = $seo_url;
            $data["rank"] = Product::count() + 1;
            $data["isActive"] = 1;
            $add = Product::insertGetId($data);
            if ($add) {
                foreach ($category_ids as $id) {
                    $category = ProductCategory::where("id", $id)->first();
                    if (!empty($category)) {
                        $insert = ProductCategories::insert(["product_id" => $add, "category_id" => $category->id]);
                    }

                }
                $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Eklendi.", "title" => "Başarılı!"]);
                return redirect()->route("panel.product.index");
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
            /* $this->viewData->item = DB::table("products")->
                select("products.*","product_category.*","product_categories.id as categories_id","product_categories.title as category_title ")->
            join("product_category","product_category.product_id","=","products.id","left")->
                join("product_categories","product_category.category_id","=","product_categories.id","left")->where("products.id",$id)->get();
            */
            $this->viewData->item = Product::where("id", $id)->with("product")->first();
            $this->viewData->categories = ProductCategory::where("isActive", 1)->get();
            $this->viewData->product = $this->viewData->item;
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            if (!empty($this->viewData->item)) {
                $this->viewData->settings_all = Settings::where("isActive", 1)->get();
                $this->viewData->languages = DB::table("languages")->get();
                $this->viewData->page->title = $this->viewData->item->title->tr . " Sayfasını Düzenle";
                $this->viewData->page->description = $this->viewData->item->title->tr . " Sayfasını Düzenleyin";
                return view("panel.product.update.index")->with("data", $this->viewData);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Böyle Bir Kayıt Bulunamadı.", "title" => "Hata!"]);
                return redirect()->back();
            }

        }

    }

    public function update(Request $request, $id = null)
    {

        $item = Product::where("id", $id)->first();
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
                $delete=ProductCategories::where("product_id",$id)->delete();
                foreach ($data["category_id"] as $category) {
                    $category = ProductCategory::where("id", $category)->first();
                    if (!empty($category)) {
                        $insert = ProductCategories::insert(["product_id" => $id, "category_id" => $category->id]);
                    }

                }
                unset($data["category_id"]);
                foreach ($data["price"] as $k=>$price){
                    $data["price"][$k]=floatval($price);
                }
                $data = Helpers::makeJson($data);
                $data["seo_url"] = $seo_url;
                $update = Product::where("id", $id)->update($data);
                if ($update) {
                    $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Güncellendi.", "title" => "Başarılı!"]);
                    return redirect()->route("panel.product.index");
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
            $data = json_decode($data->seo_url);
            $delete = Product::where("id", $id)->delete();
            if ($delete) {
                foreach ($data as $item) {
                    if (count(Storage::disk("public")->allFiles("uploads/product/" . $item)) >= 0) {
                        Storage::disk("public")->deleteDirectory("uploads/product/" . $item);
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
            $data = Product::orderBy("rank")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        İşlemler
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . route("panel.product.update", $row->id) . '"> <i class="fas fa-pen"></i> Kaydı Düzenle</a>
                        <a class="dropdown-item" href="' . route("panel.productImage.index", $row->id) . '"><i class="fas fa-images"></i> Resim İşlemleri</a>
                        <a class="dropdown-item" href="' . route("panel.option.index", $row->id) . '"><i class="fas fa-list"></i> Varyasyon İşlemleri</a>
                        <a data-url="' . route("panel.product.delete") . '" data-id="' . $row->id . '" class="dropdown-item delete-item" href="#"><i class="fas fa-trash"></i> Kaydı Sil</a>
                      </div>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isActive', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isActive == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.product.isactive") . '" type="checkbox" class="custom-control-input isActive" id="customSwitch' . $row->id . '">
                      <label class="custom-control-label" for="customSwitch' . $row->id . '"></label>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isHome', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isHome == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.product.ishome") . '" type="checkbox" class="custom-control-input isHome" id="isHome' . $row->id . '">
                      <label class="custom-control-label" for="isHome' . $row->id . '"></label>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isDiscount', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isDiscount == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.product.isdiscount") . '" type="checkbox" class="custom-control-input isDiscount" id="isDiscount' . $row->id . '">
                      <label class="custom-control-label" for="isDiscount' . $row->id . '"></label>
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
                })->editColumn("description", function ($row) {
                    $btn = Helpers::DataTableJson($row->description);
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
                $update = Product::where("id", $item["id"])->update(["rank" => $item["position"]]);
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

            $data = Product::where($data)->first();
            if ($data) {
                $isActive = ($data->isActive == 1 ? 0 : 1);
                $update = Product::where("id", $data->id)->update(["isActive" => $isActive]);
                if ($update) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Güncelleme İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Güncelleme İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
                }
            }

        endif;
    }

    public function isHomeSetter(Request $request)
    {
        $data = $request->except("_token");
        if (!empty($data)):

            $data = Product::where($data)->first();
            if ($data) {
                $isHome = ($data->isHome == 1 ? 0 : 1);
                $update = Product::where("id", $data->id)->update(["isHome" => $isHome]);
                if ($update) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Güncelleme İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Güncelleme İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
                }
            }

        endif;
    }

    public function isDiscountSetter(Request $request)
    {
        $data = $request->except("_token");
        if (!empty($data)):
            $data = Product::where($data)->first();
            if ($data) {
                $isDiscount = ($data->isDiscount == 1 ? 0 : 1);
                $update = Product::where("id", $data->id)->update(["isDiscount" => $isDiscount]);
                if ($update) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Güncelleme İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Güncelleme İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
                }
            }

        endif;
    }
}
