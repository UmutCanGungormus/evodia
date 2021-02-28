<?php

namespace App\Http\Controllers\Theme\Register;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Theme\Corporate;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use App\Models\Theme\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
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
        $this->setting = Settings::where("isActive", 1)->where("language", $this->lang)->first();
        $this->page = "register";
        $this->cart = \Cart::getContent();

    }

    public function index(Request $request)
    {
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());

        return view("theme.login.index")->with
        ([
            "viewData" => $this->viewData,
            "lang" => $this->lang,
            "langJson" => $this->langJson,
            "settings" => $this->settings,
            "thisSetting" => $this->setting,
            "page" => $this->page,
            "cart" => $this->cart
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => "required|confirmed",
            "email" => "required|email|unique:users",
            "password_confirmation" => "required",
            "full_name" => "required",
            "phone" => "required",
            "user_name" => "unique:users"

        ]);
        if ($validator->fails()) {
            return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->validator], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            $count=User::where("role","user")->count();
            $user = new User;
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->full_name);
            $user->phone = $request->phone;
            $user->role = "user";
            $user->isActive=1;
            $user->rank=$count+1;
            $user->user_name = empty($request->user_name) ? $request->email : $request->user_name;

            if ($user->save()) {
                Session::put("user", $user);
                return response()->json(['success' => true, "msg" => "{$user->full_name}, " . $this->langJson->alert->welcome . " .", "title" => $this->langJson->alert->success, "url" => route("theme.{$this->langJson->routes->home}")], 200, [], JSON_UNESCAPED_UNICODE);

            } else {
                return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->error_pass], 200, [], JSON_UNESCAPED_UNICODE);

            }


        }
    }
}
