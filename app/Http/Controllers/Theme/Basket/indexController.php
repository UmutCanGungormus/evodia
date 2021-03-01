<?php

namespace App\Http\Controllers\Theme\Basket;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Theme\Corporate;
use App\Models\Theme\DiscountCoupon;
use App\Models\Theme\Option;
use App\Models\Theme\Product;
use App\Models\Theme\ProductCategory;
use App\Models\Theme\Settings;
use App\Models\Theme\UserCopuon;
use Darryldecode\Cart\CartCondition;
use Illuminate\Routing\Route;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\TextUI\Help;
use Yajra\DataTables\Utilities\Helper;

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
        $this->page = "basket";
        $lang = $this->lang;
        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
		$this->viewData->mobileCategories = Helpers::MobileCategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang, langJson: $this->langJson);
        $this->viewData->corporates = Helpers::JsonDecodeRecursiveTheme(Corporate::where("isActive", 1)->get());
        $this->cart = \Cart::getContent();
    }
    public function index(){
        $lang = $this->lang;

        $this->viewData->categories = Helpers::JsonDecodeRecursiveTheme(ProductCategory::where("isActive", 1)->where("top_id", 0)->get());
        $this->viewData->categories = Helpers::CategoryRecrusive($this->viewData->categories, lang: $lang,langJson:$this->langJson);

        return view("theme.basket.index")->with
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
    public function basketAdd(Request $request)
    {
        $lang = $this->lang;
        $product = Product::where("id", $request->id)->with("CoverPhoto")->first()->toArray();
        $product = Helpers::JsonDecodeRecursiveTheme1($product);
        $product = Helpers::array_to_object($product);
        if (!empty($request->options)):
            $attr = Option::whereIn("id", $request->options)->get();
            $attr = Helpers::JsonDecodeRecursiveTheme1($attr);
            $attr = Helpers::array_to_object($attr);
        else:
            $attr = null;
        endif;
        \Cart::add([
            'id' => rand(1000000, 9999999),
            'name' => $product->title,
            'price' => $product->price->$lang,
            'quantity' => (int)$request->count,
            'attributes' => $attr,
            'associatedModel' => $product
        ]);
        $items = \Cart::getContent();

        return response()->json(
            [
                "alert" => $this->langJson->alert->basket_add,
                "count" => $items->count(),
                "data" => view("theme.basket.render")->with([
                    "cart" => $items,
                    "langJson" => $this->langJson,
                    "lang" => $this->lang
                ])->render()
            ]);
    }

    public function basketDelete(Request $request)
    {
        \Cart::remove($request->id);
        $items = \Cart::getContent();
        return response()->json(
            [
                "alert" => $this->langJson->alert->basket_delete,
                "count" => $items->count(),
                "data" => view("theme.basket.render")->with([
                    "cart" => $items,
                    "langJson" => $this->langJson,
                    "lang" => $this->lang
                ])->render()
            ]);
    }
    public function basketUpdate(Request $request){
        if(!empty($request->qty) && !empty($request->id)){
            \Cart::update($request->id,[
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->qty
                ),
            ]);
        }
        $items = \Cart::getContent();
        return response()->json(
            [
                "alert" => $this->langJson->alert->basket_update,
                "data" => view("theme.basket.render-basket")->with([
                    "langJson" => $this->langJson
                ])->render(),
                "mini_cart_data"=>view("theme.basket.render")->with([
                    "cart" => $items,
                    "langJson" => $this->langJson,
                    "lang" => $this->lang
                ])->render()
            ]);
    }
    public function applyCoupon(Request $request){
        $user=Session::get("user");
        $coupon=DiscountCoupon::where("title->{$this->lang}",$request->coupon)->where(function ($query)use($user){
            return $query->where("user_id",$user->id)->orWhere("user_id",0);
        })->first();
        if(!empty($user)&&!empty($coupon)){
            $control=UserCopuon::where("coupon_id",$coupon->id)->where("user_id",$user->id)->first();
            if(!empty($control)){
                return response()->json(["success"=>false,"title"=>$this->langJson->alert->error,"msg"=>$this->langJson->alert->used_code]);
            }else{
                $lang=$this->lang;
                $coupon=Helpers::JsonDecodeRecursiveTheme1(Helpers::objectToArray($coupon));
                $coupon=Helpers::array_to_object($coupon);
                $apply = new \Darryldecode\Cart\CartCondition(array(
                    'name' => $coupon->title->$lang,
                    'type' => 'sale',
                    'target' => 'total',
                    'value' => "-".$coupon->discount_rate."%",
                    'order' => 2
                ));
                \Cart::condition($apply);
                return response()->json(["success"=>true,"title"=>$this->langJson->alert->success,"msg"=>$this->langJson->alert->apply_coupon]);
            }
        }else{
            return response()->json(["success"=>false,"title"=>$this->langJson->alert->error,"msg"=>$this->langJson->alert->validator]);

        }
    }
    public function removeCoupon(Request $request){
      if(!empty($request->name)){
          \Cart::removeCartCondition($request->name);
          return response()->json(["success"=>true,"title"=>$this->langJson->alert->error,"msg"=>$this->langJson->alert->removed_code]);

      }else{
          return response()->json(["success"=>false,"title"=>$this->langJson->alert->error,"msg"=>$this->langJson->alert->validator]);
      }
    }
}
