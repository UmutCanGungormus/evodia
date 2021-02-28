<?php

namespace App\Http\Controllers\Panel\UserRole;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\Product;
use App\Models\Panel\ProductCategories;
use App\Models\Panel\ProductCategory;
use App\Models\Panel\Settings;
use App\Models\Panel\User;
use App\Models\Panel\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function __construct(Session $session, Request $request)
    {
        $this->viewData = new \stdClass();
        $this->viewData->admin = Session::get("admin");
        $this->viewData->page = new \stdClass();
        $this->viewData->segment = $request->segment(2);
        $this->viewData->page->title = "Kullanıcı Yetkileri Listesi";
        $this->viewData->page->description = "Bu Sayfada Sitenizin Kullanıcı Yetkilerini Görebilirsiniz.";
        $this->viewData->settings = Settings::where("isActive", 1)->first();
    }

    public function index()
    {
        return view("panel.userRole.list.index")->with("data", $this->viewData);
    }

    public function create(Route $route)
    {
        $this->viewData->controllers = Helpers::UserRole();
        $this->viewData->page->title = "Kullanıcı Yetkisi Ekle";
        $this->viewData->page->description = "Sitenize Yeni Bir Kullanıcı Yetkisi Ekleyin.";
        $this->viewData->settings_all = Settings::where("isActive", 1)->get();

        return view("panel.userRole.add.index")->with("data", $this->viewData);
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
            $get_data = $request->except("_token");
            $permissions = $get_data;
            unset($permissions["title"]);
            foreach (Helpers::UserRole() as $key => $item) {
                if (empty($permissions[$key]["list"])) {
                    $permissions[$key]["list"] = "off";
                }
                if (empty($permissions[$key]["create"])) {
                    $permissions[$key]["create"] = "off";
                }
                if (empty($permissions[$key]["update"])) {
                    $permissions[$key]["update"] = "off";
                }
                if (empty($permissions[$key]["delete"])) {
                    $permissions[$key]["delete"] = "off";
                }
            }
            $data["title"] = $get_data["title"];
            $data["seo_url"] = Str::slug($data["title"], "-");
            $data["permissions"] = json_encode($permissions);
            $data["rank"] = UserRole::count() + 1;
            $data["isActive"] = 1;
            $add = UserRole::insert($data);
            if ($add) {

                $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Eklendi.", "title" => "Başarılı!"]);
                return redirect()->route("panel.userRole.index");
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

            $this->viewData->item = UserRole::where("id", $id)->first();
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            $this->viewData->controllers = Helpers::UserRole();
            if (!empty($this->viewData->item)) {
                $this->viewData->page->title = $this->viewData->item->title . " Yetkisini Düzenle";
                $this->viewData->page->description = $this->viewData->item->title . " Yetkisini Düzenleyin";
                return view("panel.userRole.update.index")->with("data", $this->viewData);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Böyle Bir Kayıt Bulunamadı.", "title" => "Hata!"]);
                return redirect()->back();
            }

        }

    }

    public function update(Request $request, $id = null)
    {

        $item = UserRole::where("id", $id)->first();
        if ($item) {
            $validator = Validator::make($request->all(), [

            ]);
            if ($validator->fails()) {
                $this->viewData->languages = DB::table("languages")->get();
                $request->session()->flash("validator", ['status' => 'error', "msg" => $validator->messages(), "title" => "Hata!"]);
                return redirect()->back();
            } else {
                $data = $request->except("_token");
                $seo_url = Str::slug($data["title"], "-");
                $permissions = $data;
                unset($permissions["title"]);
                foreach (Helpers::UserRole() as $key => $item) {
                    if (empty($permissions[$key]["list"])) {
                        $permissions[$key]["list"] = "off";
                    }
                    if (empty($permissions[$key]["create"])) {
                        $permissions[$key]["create"] = "off";
                    }
                    if (empty($permissions[$key]["update"])) {
                        $permissions[$key]["update"] = "off";
                    }
                    if (empty($permissions[$key]["delete"])) {
                        $permissions[$key]["delete"] = "off";
                    }
                }
                $permissions = json_encode($permissions);
                $insertData["seo_url"] = $seo_url;
                $insertData["title"] = $data["title"];
                $insertData["permissions"] = $permissions;
                $update = UserRole::where("id", $id)->update($insertData);
                if ($update) {
                    $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Güncellendi.", "title" => "Başarılı!"]);
                    return redirect()->route("panel.userRole.index");
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
        $data = UserRole::where("id", $id)->first();
        $count = User::where("role", $data->seo_url)->count();
        if ($count == 0) {
            if (!empty($id)) {
                $delete = UserRole::where("id", $id)->delete();
                if ($delete) {
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

        } else {
            if ($request->ajax()) {
                return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Bu Kayıdı Silmek İçin Önce Bu Kayıttaki Kullanıcıları Silmeniz Gerekir."], 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Bu Kayıdı Silmek İçin Önce Bu Kayıttaki Kullanıcıları Silmeniz Gerekir.", "title" => "Hata!"]);
                return redirect()->back();
            }
        }

    }

    public function datatable(Request $request)
    {

        if ($request->ajax()) {
            $data = UserRole::orderBy("rank")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        İşlemler
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . route("panel.userRole.update", $row->id) . '"> <i class="fas fa-pen"></i> Kaydı Düzenle</a>
                        <a data-url="' . route("panel.userRole.delete") . '" data-id="' . $row->id . '" class="dropdown-item delete-item" href="#"><i class="fas fa-trash"></i> Kaydı Sil</a>
                      </div>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isActive', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isActive == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.userRole.isactive") . '" type="checkbox" class="custom-control-input isActive" id="customSwitch' . $row->id . '">
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
}
