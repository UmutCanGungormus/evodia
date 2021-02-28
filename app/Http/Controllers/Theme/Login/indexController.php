<?php

namespace App\Http\Controllers\Theme\Login;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Theme\Corporate;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use App\Models\Theme\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class indexController extends Controller
{
    public $lang;
    public $viewData;
    public $langJson;
    public $settings;
    public $setting;
    public $page;
    public $cart;

    public function __construct(Route $route, Request $request)
    {
        $this->viewData = new \stdClass();
        $this->lang = $route->action["lang"];
        Session::pull("lang");
        Session::put("lang", $this->lang);
        $this->langJson = json_decode(file_get_contents(public_path("language/" . $this->lang . ".json"), "r"));
        $this->settings = Settings::where("isActive", 1)->get();
        foreach ($this->settings as $setting):
            $language = $setting->language;
            $this->langJson->$language = json_decode(file_get_contents(public_path("language/" . $language . ".json"), "r"));
        endforeach;
        $this->setting = Settings::where("isActive", 1)->where("language",$this->lang)->first();
        $this->page = "login";
        $this->cart = \Cart::getContent();

    }

    public function index(Request $request)
    {
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());

        return view("theme.login.index")->with
        ([
            "viewData" => $this->viewData,
            "lang" => $this->lang,
            "langJson" => $this->langJson,
            "settings" => $this->settings,
            "thisSetting"=>$this->setting,
            "page" => $this->page,
            "cart"=>$this->cart
        ]);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "email" => "required|email",
        ]);
        if ($validator->fails()) {
            return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->validator], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            $user=new User;
            $user=$user->where("role","user");
            $user=$user->where("email",$request->email)->orWhere("user_name",$request->email)->orWhere("phone",$request->email)->first();
            if(empty($user)){
                return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->user_empty], 200, [], JSON_UNESCAPED_UNICODE);
            }else{
                if(Hash::check($request->password, $user->password)){
                    Session::put("user",$user);
                    return response()->json(['success' => true, "msg" => "{$user->full_name}, ".$this->langJson->alert->welcome." .", "title" => $this->langJson->alert->success,"url"=>route("theme.{$this->langJson->routes->home}")], 200, [], JSON_UNESCAPED_UNICODE);

                }else{
                    return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->error_pass], 200, [], JSON_UNESCAPED_UNICODE);

                }
            }

        }
    }
    public function logout(Request $request)
    {
        Session::pull("user");
        if(!Session::has("user")){
            $request->session()->flash("alert", ['status' => 'success', "msg" => $this->langJson->alert->logout, "title" => $this->langJson->alert->success]);
            return redirect(route("theme.{$this->langJson->routes->home}"));
        }else{
            $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->unlogout, "title" => $this->langJson->alert->error]);
            return redirect(route("theme.{$this->langJson->routes->home}"));
        }
    }
}
