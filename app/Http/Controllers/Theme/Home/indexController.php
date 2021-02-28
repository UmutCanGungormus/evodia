<?php

namespace App\Http\Controllers\Theme\Home;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Theme\Banner;
use App\Models\Theme\Corporate;
use App\Models\Theme\Product;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use App\Models\Theme\Slider;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;
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
        $this->setting = Settings::where("isActive", 1)->where("language",$this->lang)->first();
        $this->page = "home";
        $this->cart = \Cart::getContent();

    }

    public function index(Request $request)
    {
        $lang = $this->lang;
        $this->viewData->slider = Helpers::JsonDecodeRecursiveTheme(Slider::where("isActive", 1)->get());
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());
        $this->viewData->banners = Helpers::JsonDecodeRecursiveTheme(Banner::where("isActive", 1)->get());
        $this->viewData->homeProduct = Helpers::JsonDecodeRecursiveTheme1(Product::where("isActive", 1)->with("FavouriteControl")->where("isHome",1)->with(array('CoverPhoto' => function ($query) use ($lang) {
            $query->where('lang', $lang);
        }))->with("category")->where("isDiscount", 1)->get()->toArray());
        $this->viewData->homeProduct = Helpers::array_to_object($this->viewData->homeProduct);
        $this->viewData->discountProduct = Helpers::JsonDecodeRecursiveTheme1(Product::where("isActive", 1)->with("FavouriteControl")->where("isDiscount",1)->with(array('CoverPhoto' => function ($query) use ($lang) {
            $query->where('lang', $lang);
        }))->with("category")->where("isDiscount", 1)->get()->toArray());
        $this->viewData->discountProduct = Helpers::array_to_object($this->viewData->discountProduct);
        return view("theme.home.index")->with
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
}
