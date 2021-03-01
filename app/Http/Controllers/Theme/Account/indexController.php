<?php

namespace App\Http\Controllers\Theme\Account;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Theme\City;
use App\Models\Theme\Corporate;
use App\Models\Theme\DiscountCoupon;
use App\Models\Theme\District;
use App\Models\Theme\Quarter;
use App\Models\Theme\Neighborhood;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use App\Models\Theme\User;
use App\Models\Theme\UserAddress;
use Carbon\Carbon;
use Faker\Provider\UserAgent;
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
        foreach ($this->settings as $setting) :
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
        $today=Carbon::today()->format('Y-m-d');
        $this->viewData->coupons = Helpers::JsonDecodeRecursiveTheme1(DiscountCoupon::where(function ($query) {
            return $query->where("user_id", Session::get("user")->id)
                ->orwhere("user_id", 0);
        })->where("isActive", 1)->where("time",">=",$today)->with("UserCoupon")->has("UserCoupon","=",0)->get()->toArray());
        $this->viewData->coupons=Helpers::array_to_object($this->viewData->coupons);
        return view("theme.account.index")->with([
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
    public function changeCity(Request $request)
    {
        if (!empty($request->city_id)) {
            $data = District::where("il_id", $request->city_id)->get();
            return response()->json($data);
        }
    }
    public function changeDistrict(Request $request)
    {
        if (!empty($request->district_id)) {
            $data = Neighborhood::where("ilce_id", $request->district_id)->get();
            return response()->json($data);
        }
    }
    public function changeNeighborhood(Request $request)
    {
        if (!empty($request->neighborhood_id)) {
            $data = Quarter::where("semt_id", $request->neighborhood_id)->get();
            return response()->json($data);
        }
    }
    public function addAddress(Request $request)
    {
        $data = $request->except("_token");
        $data["user_id"] = Session::get("user")->id;
        $add = UserAddress::insert($data);
        if ($add) {
            return response()->json(["success" => true, "title" => $this->langJson->alert->success, "msg" => $this->langJson->alert->add_address]);
        } else {
            return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->address_error]);
        }
    }
    public function editAddress(Request $request)
    {

        if ($request->process == "update") {
            if (!empty($request->id)) {
                $data = UserAddress::where("id", $request->id)->first();
                if (!empty($data)) {
                    $updateData =  $request->except("_token");
                    unset($updateData["id"]);
                    unset($updateData["process"]);
                    $update = UserAddress::where("id", $request->id)->update($updateData);
                    if ($update) {
                        return response()->json(["success" => true, "title" => $this->langJson->alert->success, "msg" => $this->langJson->alert->address_updated]);
                    } else {
                        return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->address_update_nothing]);
                    }
                } else {
                    return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->address_nothing]);
                }
            }
        } else {
            if (!empty($request->id)) {
                $data = UserAddress::where("id", $request->id)->first();
                if (!empty($data)) {
                    $cities = City::all();
                    $districts = District::where("il_id", $data->city_id)->get();
                    $neighborhoods = Neighborhood::where("ilce_id", $data->district_id)->get();
                    $quarters = Quarter::where("semt_id", $data->neighborhood_id)->get();
                    return response()->json(
                        [
                            "success" => true,
                            "render" => view("theme.account.address-edit")->with([
                                "cities" => $cities,
                                "districts" => $districts,
                                "neighborhoods" => $neighborhoods,
                                "quarters" => $quarters,
                                "data" => $data,
                                "langJson" => $this->langJson
                            ])->render(),
                            "title" => $data->title,
                            "message" => $this->langJson->account->edit_address
                        ]
                    );
                } else {
                    return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->address_nothing]);
                }
            }
        }
    }

    public function deleteAddress(Request $request)
    {
        if (!empty($request->id)) {
            $data = UserAddress::where("id", $request->id)->first();
            if (!empty($data)) {
                $delete = UserAddress::where("id", $request->id)->delete();
                if ($delete) {
                    return response()->json(
                        [
                            "success" => true,
                            "title" => $this->langJson->alert->success,
                            "msg" => $this->langJson->account->delete_address
                        ]
                    );
                } else {
                    return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->address_nothing]);
                }
            } else {
                return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->address_nothing]);
            }
        } else {
            return response()->json(["success" => false, "title" => $this->langJson->alert->error, "msg" => $this->langJson->alert->address_nothing]);
        }
    }

    public function renderAddress()
    {
        $user = User::with("Address")->where("id", Session::get("user")->id)->first();
        $this->viewData->address = $user->address;
        return response()->json([
            "data" => view("theme.account.address")->with([
                "viewData" => $this->viewData,
                "langJson" => $this->langJson,
            ])->render()
        ]);
    }
}
