<?php
use Illuminate\Support\Facades\Artisan;
use App\Helpers\helpers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/setstorage', function () {
    Artisan::call('storage:link');
});
Route::get('/', function (\Illuminate\Http\Request $request) {
    $lang = Helpers::getLang();
    if (!empty($lang)) {
        return redirect($lang);
    } else {
        $lang = explode(",", $request->server('HTTP_ACCEPT_LANGUAGE'))[0];
        $lang = explode("-", $lang)[0];
        \Illuminate\Support\Facades\Session::put("lang", $lang);
        return redirect($lang);
    }
});
$languages = \App\Models\Panel\Settings::where("isActive", 1)->get();
foreach ($languages as $lang):
    $json = Helpers::jsonGet($lang->id);
    Route::group(['namespace' => 'theme', "as" => "theme.", "prefix" => $lang->language], function () use ($json, $lang) {
        Route::group(["lang" => $lang->language], function () use ($json) {
            Route::get("/", [\App\Http\Controllers\Theme\Home\indexController::class, "index"])->name($json->routes->home);
            Route::get("/{$json->routes->product}/{seo_url}", [\App\Http\Controllers\Theme\Product\indexController::class, "index"])->name($json->routes->product);
            Route::get("/{$json->routes->corporate}/{seo_url}", [\App\Http\Controllers\Theme\Corporate\indexController::class, "index"])->name($json->routes->corporate);
            Route::get("/{$json->routes->contact}", [\App\Http\Controllers\Theme\Contact\indexController::class, "index"])->name($json->routes->contact);
            Route::get("/{$json->routes->category}/{seo_url}", [\App\Http\Controllers\Theme\Category\indexController::class, "index"])->name($json->routes->category);
            Route::post("/{$json->routes->render_category}/{seo_url}", [\App\Http\Controllers\Theme\Category\indexController::class, "order"])->name($json->routes->render_category);
            Route::get("/{$json->routes->search}", [\App\Http\Controllers\Theme\Search\indexController::class, "index"])->name($json->routes->search);
            Route::get("/{$json->routes->basket}", [\App\Http\Controllers\Theme\Basket\indexController::class, "index"])->name($json->routes->basket);
            Route::post("/{$json->routes->render_search}", [\App\Http\Controllers\Theme\Search\indexController::class, "order"])->name($json->routes->render_search);
            Route::post("/{$json->routes->basket_add}", [\App\Http\Controllers\Theme\Basket\indexController::class, "basketAdd"])->name($json->routes->basket_add);
            Route::post("/{$json->routes->basket_delete}", [\App\Http\Controllers\Theme\Basket\indexController::class, "basketDelete"])->name($json->routes->basket_delete);
            Route::middleware("guest-status")->group(function () use ($json) {
                Route::get("/{$json->routes->login}", [\App\Http\Controllers\Theme\Login\indexController::class, "index"])->name($json->routes->login);
                Route::get("/{$json->routes->register}", [\App\Http\Controllers\Theme\Register\indexController::class, "index"])->name($json->routes->register);
                Route::post("/{$json->routes->login}", [\App\Http\Controllers\Theme\Login\indexController::class, "login"])->name($json->routes->login);
                Route::post("/{$json->routes->register}", [\App\Http\Controllers\Theme\Register\indexController::class, "register"])->name($json->routes->register);
            });
            Route::middleware("user-status-theme")->group(function () use ($json) {
                Route::post("/{$json->routes->add_favourite}", [\App\Http\Controllers\Theme\Product\indexController::class, "addFavourite"])->name($json->routes->add_favourite);
                Route::post("/{$json->routes->delete_favourite}", [\App\Http\Controllers\Theme\Product\indexController::class, "deleteFavourite"])->name($json->routes->delete_favourite);
                Route::get("/{$json->routes->account}", [\App\Http\Controllers\Theme\Account\indexController::class, "index"])->name($json->routes->account);
                Route::post("/{$json->routes->account}", [\App\Http\Controllers\Theme\Account\indexController::class, "update"])->name($json->routes->account);
                Route::get("/{$json->routes->logout}", [\App\Http\Controllers\Theme\Login\indexController::class, "logout"])->name($json->routes->logout);
            });
        });
    });
endforeach;

Route::group(['namespace' => 'panel', "as" => "panel.", "prefix" => "panel", "middlewareGroups" => ["web"]], function () {
    Route::post("/", [\App\Http\Controllers\Panel\Login\indexController::class, "login"])->name("login");
    Route::middleware('user-status')->group(function () {
        Route::group(["role" => "create"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\Login\indexController::class, "index"])->name("login");
        });
    });
    Route::middleware('admin-status')->group(function () {
        Route::get("/home", [\App\Http\Controllers\Panel\Home\indexController::class, "index"])->name("home");
        Route::get("/logout", [\App\Http\Controllers\Panel\Login\indexController::class, "logout"])->name("logout");
        Route::middleware('user-role')->group(function () {
            Route::group(["namespace" => "settings", "as" => "settings.", "prefix" => "settings", "title" => "Ayarlar"], function () {
                Route::group(["role" => "update"], function () {
                    Route::post("/ranksetter", [\App\Http\Controllers\Panel\Settings\indexController::class, "rankSetter"])->name("ranksetter");
                    Route::post("/isactive", [\App\Http\Controllers\Panel\Settings\indexController::class, "isActiveSetter"])->name("isactive");
                    Route::get("/update/{id}", [\App\Http\Controllers\Panel\Settings\indexController::class, "edit"])->name("edit");
                    Route::post("/update/{id}", [\App\Http\Controllers\Panel\Settings\indexController::class, "update"])->name("update");
                    Route::get("/json/{id}", [\App\Http\Controllers\Panel\Settings\indexController::class, "jsonGet"])->name("json");
                    Route::post("/json/{id}", [\App\Http\Controllers\Panel\Settings\indexController::class, "jsonPost"])->name("json");
                });
                Route::group(["role" => "create"], function () {
                    Route::get("/create", [\App\Http\Controllers\Panel\Settings\indexController::class, "create"])->name("add");
                    Route::post("/create", [\App\Http\Controllers\Panel\Settings\indexController::class, "save"])->name("save");
                });
                Route::group(["role" => "delete"], function () {
                    Route::post("/delete", [\App\Http\Controllers\Panel\Settings\indexController::class, "delete"])->name("delete");
                });
                Route::group(["role" => "list"], function () {
                    Route::get("/", [\App\Http\Controllers\Panel\Settings\indexController::class, "index"])->name("index");
                    Route::get("/datatable", [\App\Http\Controllers\Panel\Settings\indexController::class, "datatable"])->name("datatable");
                });

            });
        });
        Route::group(["namespace" => "emailSettings", "as" => "emailSettings.", "prefix" => "email-settings", "title" => "E-mail Ayarları"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\EmailSettings\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "corporate", "as" => "corporate.", "prefix" => "corporate", "title" => "Kurumsal"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\Corporate\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\Corporate\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\Corporate\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\Corporate\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\Corporate\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\Corporate\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\Corporate\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\Corporate\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\Corporate\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "slider", "as" => "slider.", "prefix" => "slider", "title" => "Sliderlar"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\Slider\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\Slider\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\Slider\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\Slider\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\Slider\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\Slider\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\Slider\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\Slider\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\Slider\indexController::class, "isActiveSetter"])->name("isactive");
        });
            Route::group(["namespace" => "discountCoupon", "as" => "discountCoupon.", "prefix" => "discountCoupon", "title" => "İndirim Kuponları"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\DiscountCoupon\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "productCategory", "as" => "productCategory.", "prefix" => "product-category", "title" => "Ürün Kategorileri"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\ProductCategory\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "product", "as" => "product.", "prefix" => "product", "title" => "Ürünler"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\Product\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\Product\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\Product\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\Product\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\Product\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\Product\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\Product\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\Product\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\Product\indexController::class, "isActiveSetter"])->name("isactive");
            Route::post("/ishome", [\App\Http\Controllers\Panel\Product\indexController::class, "isHomeSetter"])->name("ishome");
            Route::post("/isdiscount", [\App\Http\Controllers\Panel\Product\indexController::class, "isDiscountSetter"])->name("isdiscount");
        });
        Route::group(["namespace" => "productImage", "as" => "productImage.", "prefix" => "product-image", "title" => "Ürün Resimleri"], function () {
            Route::get("/{id}", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "index"])->name("index");
            Route::post("/file-upload/{lang}", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "fileUpload"])->name("fileUpload");
            Route::get("/create", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "delete"])->name("delete");
            Route::get("/datatable/{id}", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "isActiveSetter"])->name("isactive");
            Route::post("/iscover", [\App\Http\Controllers\Panel\ProductImage\indexController::class, "isCoverSetter"])->name("iscover");
        });
        Route::group(["namespace" => "userRole", "as" => "userRole.", "prefix" => "user-role", "title" => "Kullanıcı Yetkileri"], function () {
            Route::middleware('user-role')->group(function () {

                Route::group(["role" => "list"], function () {
                    Route::get("/", [\App\Http\Controllers\Panel\UserRole\indexController::class, "index"])->name("index");
                    Route::get("/datatable", [\App\Http\Controllers\Panel\UserRole\indexController::class, "datatable"])->name("datatable");
                });
                Route::group(["role" => "create"], function () {
                    Route::post("/create", [\App\Http\Controllers\Panel\UserRole\indexController::class, "save"])->name("save");
                    Route::get("/create", [\App\Http\Controllers\Panel\UserRole\indexController::class, "create"])->name("add");
                });
                Route::group(["role" => "delete"], function () {
                    Route::post("/delete", [\App\Http\Controllers\Panel\UserRole\indexController::class, "delete"])->name("delete");
                });
                Route::group(["role" => "update"], function () {
                    Route::get("/update/{id}", [\App\Http\Controllers\Panel\UserRole\indexController::class, "edit"])->name("edit");
                    Route::post("/update/{id}", [\App\Http\Controllers\Panel\UserRole\indexController::class, "update"])->name("update");
                    Route::post("/ranksetter", [\App\Http\Controllers\Panel\UserRole\indexController::class, "rankSetter"])->name("ranksetter");
                    Route::post("/isactive", [\App\Http\Controllers\Panel\UserRole\indexController::class, "isActiveSetter"])->name("isactive");
                });
            });
        });
        Route::group(["namespace" => "user", "as" => "user.", "prefix" => "user", "title" => "Kullanıcılar"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\User\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\User\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\User\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\User\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\User\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\User\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\User\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\User\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\User\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "banner", "as" => "banner.", "prefix" => "banner", "title" => "Banner"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\Banner\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\Banner\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\Banner\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\Banner\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\Banner\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\Banner\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\Banner\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\Banner\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\Banner\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "galleries", "as" => "galleries.", "prefix" => "galleries", "title" => "Galeriler"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\Galleries\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\Galleries\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\Galleries\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\Galleries\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\Galleries\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\Galleries\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\Galleries\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\Galleries\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\Galleries\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "galleryContent", "as" => "galleryContent.", "prefix" => "gallery-content", "title" => "Galeri Resimleri"], function () {
            Route::get("/{id}", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "index"])->name("index");
            Route::post("/file-upload/{lang}", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "fileUpload"])->name("fileUpload");
            Route::get("/create", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "delete"])->name("delete");
            Route::get("/datatable/{id}", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\GalleryContent\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "optionCategory", "as" => "optionCategory.", "prefix" => "option-category", "title" => "Varyasyon Kategorileri"], function () {
            Route::get("/", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "index"])->name("index");
            Route::get("/create", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "update"])->name("update");
            Route::post("/create", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "delete"])->name("delete");
            Route::get("/datatable", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\OptionCategory\indexController::class, "isActiveSetter"])->name("isactive");
        });
        Route::group(["namespace" => "option", "as" => "option.", "prefix" => "option", "title" => "Varyasyonlar"], function () {
            Route::get("/{id}", [\App\Http\Controllers\Panel\Option\indexController::class, "index"])->name("index");
            Route::get("/create/{id}", [\App\Http\Controllers\Panel\Option\indexController::class, "create"])->name("add");
            Route::get("/update/{id}", [\App\Http\Controllers\Panel\Option\indexController::class, "edit"])->name("edit");
            Route::post("/update/{id}", [\App\Http\Controllers\Panel\Option\indexController::class, "update"])->name("update");
            Route::post("/create/{id}", [\App\Http\Controllers\Panel\Option\indexController::class, "save"])->name("save");
            Route::post("/delete", [\App\Http\Controllers\Panel\Option\indexController::class, "delete"])->name("delete");
            Route::get("/datatable/{id}", [\App\Http\Controllers\Panel\Option\indexController::class, "datatable"])->name("datatable");
            Route::post("/ranksetter", [\App\Http\Controllers\Panel\Option\indexController::class, "rankSetter"])->name("ranksetter");
            Route::post("/isactive", [\App\Http\Controllers\Panel\Option\indexController::class, "isActiveSetter"])->name("isactive");
        });
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
