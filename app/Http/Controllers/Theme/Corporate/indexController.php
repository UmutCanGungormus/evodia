<?php

namespace App\Http\Controllers\Theme\Corporate;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Theme\Corporate;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
        $this->setting = Settings::where("isActive", 1)->where("language",$this->lang)->first();
        $this->page = "corporate";
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());
        $this->cart = \Cart::getContent();

    }

    public function index($seo_url,Request $request)
    {

        $this->viewData->item=Corporate::where("isActive",1)->where("seo_url->$this->lang",$seo_url)->first();
        if(!empty($this->viewData->item)){
            $this->viewData->item=Helpers::JsonDecodeRecursive($this->viewData->item);
            $this->parameter=$this->viewData->item->seo_url;
        }else{
            $request->session()->flash("alert", ['status' => 'error', "msg" => $this->langJson->alert->pageNotFound, "title" => $this->langJson->alert->error]);
            return redirect()->back();
        }
        return view("theme.corporate.index")->with
        ([
            "viewData" => $this->viewData,
            "lang" => $this->lang,
            "langJson" => $this->langJson,
            "settings" => $this->settings,
            "thisSetting"=>$this->setting,
            "page" => $this->page,
            "parameter"=>$this->parameter,
            "cart"=>$this->cart
        ]);
    }
}
