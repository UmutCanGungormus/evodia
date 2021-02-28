<?php

namespace App\Http\Controllers\Panel\Login;

use App\Http\Controllers\Controller;
use App\Models\Panel\Admin;
use App\Models\Panel\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class indexController extends Controller
{
    public $viewData;

    public function __construct()
    {
        $this->viewData = new \stdClass();
    }

    public function index()
    {
        $this->viewData->settings = Settings::where("isActive", 1)->first();
        return view("panel.login.index")->with("data",$this->viewData);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => "required|min:6",
            "email" => "required|email",
        ]);
        if ($validator->fails()) {
            $request->session()->flash("validator", ['status' => 'error', "msg" => $validator->messages(), "title" => "Hata!"]);
            return redirect()->back();
        } else {
            $admin = Admin::where("email", $request->email)->where("isActive",1)->where("role","admin")->first();

            if (!empty($admin)) {
                if (Hash::check($request->password, $admin->password)) {
                    Session::put("admin", $admin);
                    $request->session()->flash("alert", ['status' => 'success', "msg" => "Sayın {$admin->full_name} Yönetim Paneline Hoşgeldiniz.", "title" => "Başarılı!"]);
                    return redirect(route("panel.home"));
                } else {
                    $request->session()->flash("alert", ['status' => 'error', "msg" => "Şifreniz Hatalıdır.", "title" => "Hata!"]);
                    return redirect()->back();
                }
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => "Bu E-posta Adresi İle Kayıtlı Bir Admin Yoktur.", "title" => "Hata!"]);
                return redirect()->back();
            }
        }
    }
    public function logout(Request $request){
        Session::remove("admin");
        $request->session()->flash("alert", ['status' => 'success', "msg" => "Başarıyla Çıkış Yaptınız Yine Bekleriz.", "title" => "Başarılı!"]);
        return redirect(route("panel.login"));
    }
}
