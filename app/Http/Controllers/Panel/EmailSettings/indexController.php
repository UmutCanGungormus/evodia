<?php

namespace App\Http\Controllers\Panel\EmailSettings;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\EmailSettings;
use App\Models\Panel\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public $viewData;

    public function __construct(Session $session, Request $request)
    {
        $this->viewData = new \stdClass();
        $this->viewData->admin = Session::get("admin");
        $this->viewData->page = new \stdClass();
        $this->viewData->segment = $request->segment(2);
        $this->viewData->page->title = "E-posta Ayarları";
        $this->viewData->page->description = "Bu Sayfada Sitenizin E-Posta Ayarlarını Görebilirsiniz.";
        $this->viewData->settings = Settings::where("isActive", 1)->first();
    }

    public function index()
    {
        return view("panel.emailSettings.list.index")->with("data", $this->viewData);
    }

    public function create()
    {
        $this->viewData->page->title = "E-posta Ayarları Ekle";
        $this->viewData->page->description = "Sitenize Yeni Bir E-Posta Ayarı Ekleyin.";
        $this->viewData->settings_all = Settings::where("isActive", 1)->get();

        return view("panel.emailsettings.add.index")->with("data", $this->viewData);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "to" => "required",

        ]);
        if ($validator->fails()) {
            $this->viewData->languages = DB::table("languages")->get();
            $request->session()->flash("validator", ['status' => 'error', "msg" => $validator->messages(), "title" => "Hata!"]);
            return redirect()->back();
        } else {
            $data = $request->except("_token");
            $data = Helpers::makeJson($data);
            $data["rank"] = EmailSettings::count() + 1;
            $data["isActive"] = 1;

            $add = EmailSettings::insert($data);
            if ($add) {
                $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Eklendi.", "title" => "Başarılı!"]);
                return redirect()->route("panel.settings.index");
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
            $this->viewData->item = EmailSettings::where("id", $id)->first();
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            if (!empty($this->viewData->item)) {
                $this->viewData->settings_all = Settings::where("isActive", 1)->get();
                $this->viewData->languages = DB::table("languages")->get();
                $this->viewData->page->title = $this->viewData->item->user_name->tr . " Ayarını Düzenle";
                $this->viewData->page->description = $this->viewData->item->user_name->tr . " Ayarını Düzenleyin";
                return view("panel.emailSettings.update.index")->with("data", $this->viewData);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Böyle Bir Kayıt Bulunamadı.", "title" => "Hata!"]);
                return redirect()->back();
            }

        }

    }

    public function update(Request $request, $id = null)
    {

        $item = EmailSettings::where("id", $id)->first();
        if ($item) {
            $validator = Validator::make($request->all(), [

            ]);
            if ($validator->fails()) {
                $this->viewData->languages = DB::table("languages")->get();
                $request->session()->flash("validator", ['status' => 'error', "msg" => $validator->messages(), "title" => "Hata!"]);
                return redirect()->back();
            } else {

                $data = $request->except("_token");
                $data = Helpers::makeJson($data);

                $update = EmailSettings::where("id", $id)->update($data);
                if ($update) {
                    $request->session()->flash("alert", ['status' => 'success', "msg" => "Ayarlarınız Başarıyla Güncellendi.", "title" => "Başarılı!"]);
                    return redirect()->route("panel.emailSettings.index");
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
        if (EmailSettings::count() > 1) {
            if (!empty($id)) {
                $delete = EmailSettings::where("id", $id)->delete();
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
                return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Bu Kayıdı Silemezsiniz"], 200, [], JSON_UNESCAPED_UNICODE);
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Bu Kayıdı Silemezsiniz.", "title" => "Hata!"]);
                return redirect()->back();
            }
        }

    }

    public function jsonGet($id)
    {
        $item = EmailSettings::where("id", $id)->first();
        $this->viewData->lang = $item->language;
        $this->viewData->page->title = "Ayar Ekle";
        $this->viewData->page->description = "Sitenize Yeni Bir Ayar Ekleyin.";
        $this->viewData->languages = DB::table("languages")->get();
        $this->viewData->content = json_decode(file_get_contents(public_path("language/" . $item->language . ".json"), "r"));
        return view("panel.settings.json.index")->with("data", $this->viewData);
    }

    public function jsonPost(Request $request, $language = null)
    {

        $data = $request->except("_token");
        $create = fopen(public_path("language/" . $language . ".json"), "w");
        $create = fwrite($create, json_encode($data, JSON_UNESCAPED_UNICODE));

        if ($create) {
            $request->session()->flash("alert", ['status' => 'status', "msg" => "Dil Dosyanız Başarıyla Oluşturuldu.", "title" => "Hata!"]);
            return redirect()->back();
        } else {
            $request->session()->flash("alert", ['status' => 'error', "msg" => "Dil Dosyanız Kayıt Edilemedi.", "title" => "Hata!"]);
            return redirect()->back();
        }
    }

    public function datatable(Request $request)
    {

        if ($request->ajax()) {
            $data = EmailSettings::orderBy("rank")->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                     <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        İşlemler
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . route("panel.emailSettings.update", $row->id) . '">Kaydı Düzenle</a>
                        <a data-url="' . route("panel.emailSettings.delete") . '" data-id="' . $row->id . '" class="dropdown-item delete-item" href="#">Kaydı Sil</a>
                      </div>
                    </div>
                    ';
                    return $btn;
                })
                ->addColumn('isActive', function ($row) {
                    $btn = '
                    <div class="custom-control custom-switch">
                      <input ' . ($row->isActive == 1 ? " checked " : "") . ' data-id="' . $row->id . '" data-url="' . route("panel.emailSettings.isactive") . '" type="checkbox" class="custom-control-input isActive" id="customSwitch' . $row->id . '">
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
                })->editColumn("to", function ($row) {
                    $btn = Helpers::DataTableJson($row->to);
                    return $btn;
                })->editColumn("user_name", function ($row) {
                    $btn = Helpers::DataTableJson($row->to);
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
                $update = EmailSettings::where("id", $item["id"])->update(["rank" => $item["position"]]);
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

            $data = EmailSettings::where($data)->first();
            if ($data) {
                $isActive = ($data->isActive == 1 ? 0 : 1);
                $update = EmailSettings::where("id", $data->id)->update(["isActive" => $isActive]);
                if ($update) {
                    return response()->json(["success" => true, "title" => "Başarılı!", "msg" => "Güncelleme İşlemi Başarılı"], 200, [], JSON_UNESCAPED_UNICODE);
                } else {
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Güncelleme İşlemi Sırasında Bir Hata Oluştu!"], 200, [], JSON_UNESCAPED_UNICODE);
                }
            }

        endif;
    }
}
