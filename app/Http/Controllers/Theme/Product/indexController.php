<?php

namespace App\Http\Controllers\Theme\Product;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Panel\ProductCategories;
use App\Models\Theme\Corporate;
use App\Models\Theme\FavouriteProduct;
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
        $this->page = "product";
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());
        $this->cart = \Cart::getContent();

    }

    public function index($seo_url, Request $request)
    {
        $this->viewData->item = Product::where("isActive", 1)->where("seo_url->$this->lang", $seo_url)->first();
        if (!empty($this->viewData->item)) {
            $lang = $this->lang;
            $this->viewData->item = Helpers::JsonDecodeRecursive($this->viewData->item);
            $id = $this->viewData->item->id;
            $this->viewData->optionCategory = OptionCategory::where("isActive", 1)->where("top_id", 0)->get()->toArray();
            $this->viewData->optionCategory = Helpers::array_to_object(Helpers::JsonDecodeRecursiveTheme1($this->viewData->optionCategory));
            $this->viewData->optionCategory = Helpers::array_to_object($this->viewData->optionCategory);
            $this->viewData->products = new Product;
            $this->viewData->products = $this->viewData->products->where("isActive", 1)->where("seo_url->$this->lang", $seo_url)->with("category")->with(array("Photos" => function ($query) use ($lang) {
                $query->where("lang", $lang);
            }))->with("OptionCategories")->with("Options")->first()->toArray();
            $this->viewData->products = Helpers::JsonDecodeRecursiveTheme1($this->viewData->products);
            if (!empty($this->viewData->products)) {
                $this->viewData->products = Helpers::array_to_object($this->viewData->products);
            }
            $this->viewData->homeProduct = Helpers::JsonDecodeRecursiveTheme1(Product::where("isActive", 1)->with(array('CoverPhoto' => function ($query) use ($lang) {
                $query->where('lang', $lang);
            }))->with("category")->where("isDiscount", 1)->get()->toArray());
            $this->viewData->homeProduct = Helpers::array_to_object($this->viewData->homeProduct);
            $this->viewData->discountProduct = Helpers::JsonDecodeRecursiveTheme1(Product::where("isActive", 1)->with(array('CoverPhoto' => function ($query) use ($lang) {
                $query->where('lang', $lang);
            }))->with("category")->where("isDiscount", 1)->get()->toArray());
            $this->viewData->discountProduct = Helpers::array_to_object($this->viewData->discountProduct);
            $this->parameter = $this->viewData->item->seo_url;
        } else {
            $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->pageNotFound, "title" => $this->langJson->alert->error]);
            return redirect()->back();
        }
        return view("theme.product.index")->with
        ([
            "viewData" => $this->viewData,
            "lang" => $this->lang,
            "langJson" => $this->langJson,
            "settings" => $this->settings,
            "thisSetting" => $this->setting,
            "page" => $this->page,
            "parameter" => $this->parameter,
            "cart" => $this->cart
        ]);
    }

    public function deleteFavourite(Request $request)
    {
        if(Session::has("user")){
            $data=FavouriteProduct::where("user_id",Session::get("user")->id)->where("products_id",$request->id)->first();
            if(empty($data)){
                return response()->json(["status"=>false,"msg"=>$this->langJson->alert->notExist,"title"=>$this->langJson->alert->error]);
            }else{
                $delete=FavouriteProduct::where("user_id",Session::get("user")->id)->where("products_id",$request->id)->delete();
                if($delete){
                    return response()->json(["status"=>true,"msg"=>$this->langJson->alert->deleteFavourite,"title"=>$this->langJson->alert->success]);
                }else{
                    return response()->json(["status"=>false,"msg"=>$this->langJson->alert->notDeleteFavourite,"title"=>$this->langJson->alert->error]);
                }
            }
        }else{
            return response()->json(["status"=>false,"msg"=>$this->langJson->alert->user_null,"title"=>$this->langJson->alert->error]);
        }
    }

    public function addFavourite(Request $request)
    {
        if(Session::has("user")){
            $data=FavouriteProduct::where("user_id",Session::get("user")->id)->where("products_id",$request->id)->first();
            if(!empty($data)){
                return response()->json(["status"=>false,"msg"=>$this->langJson->alert->allready_exist,"title"=>$this->langJson->alert->error]);
            }else{
                $add=FavouriteProduct::insert(["products_id"=>$request->id,"user_id"=>Session::get("user")->id]);
                if($add){
                    return response()->json(["status"=>true,"msg"=>$this->langJson->alert->addFavourite,"title"=>$this->langJson->alert->success]);
                }else{
                    return response()->json(["status"=>false,"msg"=>$this->langJson->alert->nothingFavourite,"title"=>$this->langJson->alert->error]);
                }
            }
        }else{
            return response()->json(["status"=>false,"msg"=>$this->langJson->alert->user_null,"title"=>$this->langJson->alert->error]);
        }
    }
}
