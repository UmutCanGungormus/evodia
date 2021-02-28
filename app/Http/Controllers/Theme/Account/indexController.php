<?php

namespace App\Http\Controllers\Theme\Account;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Theme\City;
use App\Models\Theme\Corporate;
use App\Models\Theme\DiscountCoupon;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use App\Models\Theme\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Help;

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
        $this->page = "account";
        $this->cart = \Cart::getContent();

    }

    public function index(Request $request)
    {
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());
        $this->viewData->cities = City::all();
        $user = User::with("Address")->with("Favourite")->where("id", Session::get("user")->id)->first();
        $this->viewData->address = $user->address;
        $this->viewData->favourites = Helpers::JsonDecodeRecursiveTheme1(Helpers::objectToArray($user->favourite));
        $this->viewData->favourites = Helpers::array_to_object($this->viewData->favourites);
        $this->viewData->coupons = DiscountCoupon::where(function ($query) {
            return $query->where("user_id", Session::get("user")->id)
                ->orwhere("user_id", 0);
        })->where("isActive", 1)->get();
        return view("theme.account.index")->with
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => "confirmed",
            "email" => "required|email" . ($request->email != Session::get("user")->email ? "|unique:users" : "") . "",
            "full_name" => "required",
            "phone" => "required",
            "user_name" => "unique:users"
        ]);
        if ($validator->fails()) {
            $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->validator, "title" => $this->langJson->alert->success]);
            return redirect()->back();
        } else {
            $data = $request->except("_token");
            if (!empty($data["password"])) {
                $data["password"] = Hash::make($data["password"]);
                unset($data["password_confirmation"]);
            } else {
                unset($data["password_confirmation"]);
                unset($data["password"]);
            }
            $update = User::where("id", Session::get("user")->id)->update($data);
            if ($update) {
                $user = User::where("id", Session::get("user")->id)->first();
                Session::put("user", $user);
                $request->session()->flash("alert", ['status' => 'success', "msg" => $this->langJson->alert->account_update_success, "title" => $this->langJson->alert->success]);
                return redirect()->back();
            } else {
                $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->account_update_error, "title" => $this->langJson->alert->success]);
                return redirect()->back();
            }
        }

    }
}
