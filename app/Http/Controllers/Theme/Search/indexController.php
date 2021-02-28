<?php

namespace App\Http\Controllers\Theme\Search;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\ProductCategories;
use App\Models\Theme\Corporate;
use App\Models\Theme\OptionCategory;
use App\Models\Theme\Product;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Tags\Version;

class indexController extends Controller
{
    public $lang;
    public $viewData;
    public $langJson;
    public $settings;
    public $setting;
    public $page;
    public $parameter;
    public $search;
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
        $this->page = "search";
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());
        $this->cart = \Cart::getContent();

    }
    public function index(Request $request)
    {
        if(!empty($request->search)){
            $this->page = "search";
            $this->search=$request->search;

            if (empty($request->cookie("search_order")) || empty($request->cookie("search_column"))) {
                $column = "id";
                $order = "DESC";
            } else {
                $column = $request->cookie("search_column");
                $order = $request->cookie("search_order");
            }

            $lang = $this->lang;
            $this->viewData->products = Product::where("isActive", 1)->with("category")->with(array("CoverPhoto" => function ($query) use ($lang) {
                $query->where("lang", $lang);
            }))->where("title->{$lang}", "like", "%{$request->search}%")->with("OptionCategories")->orderBy($column, $order)->paginate(1);
            $links = $this->viewData->products->appends(["search"=>$request->search])->links();
            $this->viewData->products = $this->viewData->products->toArray();
            $this->viewData->products = Helpers::JsonDecodeRecursiveTheme1($this->viewData->products);
            if (!empty($this->viewData->products)) {
                $this->viewData->products = Helpers::array_to_object($this->viewData->products);
            }
            return view("theme.search.index")->with
            ([
                "viewData" => $this->viewData,
                "lang" => $this->lang,
                "langJson" => $this->langJson,
                "settings" => $this->settings,
                "thisSetting" => $this->setting,
                "page" => $this->page,
                "parameter" => $this->parameter,
                "links" => $links,
                "search"=>$this->search,
                "cart"=>$this->cart
            ]);
        }else{
            $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->pageNotFound, "title" => $this->langJson->alert->error]);
            return redirect()->back();
        }

    }
    public function order(Request $request)
    {
        Cookie::queue('search_order', $request->search_order);
        Cookie::queue('search_column', $request->search_column);
        if (empty($request->cookie("search_order")) || empty($request->cookie("search_column"))) {
            $column = "id";
            $order = "DESC";
        } else {
            $column = $request->cookie("search_column");
            $order = $request->cookie("search_order");
        }


        $lang = $this->lang;
        $this->viewData->products = Product::where("isActive", 1)->with("category")->with(array("CoverPhoto" => function ($query) use ($lang) {
            $query->where("lang", $lang);
        }))->where("title->{$lang}", "like", "%{$request->search}%")->with("OptionCategories")->orderBy($column,$order)->paginate(1);
        $links = $this->viewData->products->links();
        $this->viewData->products = $this->viewData->products->toArray();
        $this->viewData->products = Helpers::JsonDecodeRecursiveTheme1($this->viewData->products);
        if (!empty($this->viewData->products)) {
            $this->viewData->products = Helpers::array_to_object($this->viewData->products);
        }
        echo view("theme.search.order")->with
        ([
            "viewData" => $this->viewData,
            "lang" => $this->lang,
            "langJson" => $this->langJson,
            "settings" => $this->settings,
            "thisSetting" => $this->setting,
            "page" => $this->page,
            "parameter" => $this->parameter,
            "links" => $links
        ])->render();
    }
}
