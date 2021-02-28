<?php

namespace App\Http\Controllers\Theme\Category;

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
        $this->page = "category";
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());
        $this->cart = \Cart::getContent();
    }

    public function index($seo_url, Request $request)
    {

        if (empty($request->cookie("order")) || empty($request->cookie("column"))) {
            $column = "id";
            $order = "DESC";
        } else {
            $column = $request->cookie("column");
            $order = $request->cookie("order");
        }

        $this->viewData->item = ProductCategory::where("isActive", 1)->where("seo_url->$this->lang", $seo_url)->first();
        if (!empty($this->viewData->item)) {
            $lang = $this->lang;
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            $id = $this->viewData->item->id;
            $sub_ids = Helpers::subCategoryRecursive($this->viewData->item->id);
            $sub_ids = array_filter(explode(",", $sub_ids));
            $sub = ProductCategory::where("top_id", $id)->get()->toArray();
            if (!empty($sub)) {
                $sub = Helpers::array_to_object(Helpers::JsonDecodeRecursiveTheme1($sub));
            }
            //$this->viewData->sub = Helpers::SubCategoryRecrusive($sub, $lang, $this->langJson);
            $this->viewData->sub = $sub;
            //$this->viewData->optionCategory=OptionCategory::where("isActive",1)->where("top_id",0)->get()->toArray();
            //$this->viewData->optionCategory= Helpers::array_to_object(Helpers::JsonDecodeRecursiveTheme1($this->viewData->optionCategory));
            // $this->viewData->optionCategory=Helpers::array_to_object($this->viewData->optionCategory);
            $this->viewData->products = Product::where("isActive", 1)->with("category")->with(array("CoverPhoto" => function ($query) use ($lang) {
                $query->where("lang", $lang);
            }))->whereHas('category', function ($query) use ($sub_ids) {
                return $query->whereIn('category_id', $sub_ids);
            })->with("OptionCategories")->with("FavouriteControl")->orderBy($column, $order)->paginate(1);
            $links = $this->viewData->products->links();
            $this->viewData->products = $this->viewData->products->toArray();
            $this->viewData->products = Helpers::JsonDecodeRecursiveTheme1($this->viewData->products);
            if (!empty($this->viewData->products)) {
                $this->viewData->products = Helpers::array_to_object($this->viewData->products);
            }


            $this->parameter = $this->viewData->item->seo_url;
        } else {
            $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->pageNotFound, "title" => $this->langJson->alert->error]);
            return redirect()->back();
        }
		if(!$this->viewData->products->data){
			$this->viewData->products->data = [];
		}
		//dd($this->viewData->products);
        return view("theme.category.index")->with
        ([
            "viewData" => $this->viewData,
            "lang" => $this->lang,
            "langJson" => $this->langJson,
            "settings" => $this->settings,
            "thisSetting" => $this->setting,
            "page" => $this->page,
            "parameter" => $this->parameter,
            "links" => $links,
            "cart"=>$this->cart
        ]);
    }

    public function order($seo_url, Request $request)
    {
        Cookie::queue('order', $request->order);
        Cookie::queue('column', $request->column);

        $this->viewData->item = ProductCategory::where("isActive", 1)->where("seo_url->$this->lang", $seo_url)->first();
        if (!empty($this->viewData->item)) {
            $lang = $this->lang;
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            $id = $this->viewData->item->id;
            $sub_ids = Helpers::subCategoryRecursive($this->viewData->item->id);
            $sub_ids = array_filter(explode(",", $sub_ids));
            $this->viewData->products = Product::where("isActive", 1)->with("category")->with(array("CoverPhoto" => function ($query) use ($lang) {
                $query->where("lang", $lang);
            }))->whereHas('category', function ($query) use ($sub_ids) {
                return $query->whereIn('category_id', $sub_ids);
            })->with("OptionCategories")->orderBy($request->column, $request->order)->paginate(1);
            $links = $this->viewData->products->links();
            $this->viewData->products = $this->viewData->products->toArray();
            $this->viewData->products = Helpers::JsonDecodeRecursiveTheme1($this->viewData->products);
            if (!empty($this->viewData->products)) {
                $this->viewData->products = Helpers::array_to_object($this->viewData->products);
            }
			if(!$this->viewData->products->data){
				$this->viewData->products->data = [];
			}
            $this->parameter = $this->viewData->item->seo_url;
        } else {
            $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->pageNotFound, "title" => $this->langJson->alert->error]);
            return redirect()->back();
        }
        echo view("theme.category.order")->with
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
