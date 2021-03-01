<?php

namespace App\Helpers;

use App\Models\Panel\ProductCategories;
use App\Models\Panel\Settings;
use App\Models\Theme\OptionCategory;
use App\Models\Theme\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Config;
use function PHPUnit\Framework\isJson;
use function PHPUnit\Framework\returnValueMap;

class Helpers
{
    public static function topOption($id = "")
    {
        if (!empty($id)) {
            $response = OptionCategory::where("id", $id)->first();
            if ($response->top_id != 0) {
                $response = Helpers::topOption($response->top_id);
            } else {
                $response = $response->toArray();
                return Helpers::array_to_object(Helpers::JsonDecodeRecursiveTheme1($response));
            }
        } else {
            return false;
        }
    }

    public static function explodePath($path = null, $top = 3)
    {
        if (!empty($path)) {
            $response = "";
            $path = explode("/", $path);
            for ($i = 0; $i <= $top; $i++) {
                $response = $response . "/" . $path[$i];
            }
            return $response;
        } else {
            return "Dosya Yolu Boş";
        }

    }

    public static function jsonRecursivee($data = null, $v_key = null, $title = null)
    {

        if (!empty($data)) {
            foreach ($data as $key => $item) {
                if (is_object($item)) {
                    if (!empty($v_key)) {
                        $v_key = $v_key . "[" . $key . "]";
                    } else {
                        $v_key = $key;
                    }
                    Helpers::jsonRecursive($item, $v_key, $item);
                } else {
                    if ($key != "title_top") {
                        if (!empty($title->title_top)) {
                            $html = ' <label for="">' . $title->title_top . '</label>';
                            $html .= ' <input class="form-control" type="text" name="' . $v_key . '[' . $key . ']" value="' . $item . '">';
                        } else {
                            $html = ' <label for="">' . $key . '</label>';
                            $html .= ' <input class="form-control" type="text" name="' . $v_key . '[' . $key . ']" value="' . $item . '">';
                        }
                        print_r($html);
                    }
                }
            }
        } else {
            return false;
        }

    }

    public static function subCategoryRecursive($id)
    {
        $ids = "";

        if (!empty($id)) {
            $category = ProductCategory::where("id", $id)->where("isActive", 1)->first();
            $ids .= $category->id . ",";
            $sub = ProductCategory::where("top_id", $category->id)->where("isActive", 1)->first();
            if (!empty($sub)) {
                $ids .= Helpers::subCategoryRecursive($sub->id);
            }
        } else {
            return false;
        }
        return $ids;
    }

    public static function jsonRecursive($data = null, $v_key = null, $title = null)
    {

        if (!empty($data)) {
            foreach ($data as $key => $item) {
                if (is_object($item)) {
                    if (empty($v_key)) {
                        $v_key[0] = $key;
                    } else {
                        array_push($v_key, $key);
                    }
                    if (in_array($key, $v_key)) {
                        print_r($key);
                    }
                    print_r($v_key);
                    foreach ($item as $v) {
                        print_r($v);
                    }
                    Helpers::jsonRecursive($item, $v_key, $item);
                } else {
                    if ($key != "title_top") {
                        if (!empty($title->title_top)) {
                            $html = ' <label for="">' . $title->title_top . '</label>';
                            $html .= ' <input class="form-control" type="text" name="' . $v_key[1] . '[' . $key . ']" value="' . $item . '">';
                        } else {
                            $html = ' <label for="">' . $key . '</label>';
                            $html .= ' <input class="form-control" type="text" name="' . $v_key[1] . '[' . $key . ']" value="' . $item . '">';
                        }
                        print_r($html);
                    }
                }
            }
        } else {
            return false;
        }

    }

    public static function JsonDecodeRecursive($data)
    {
        if (!empty($data)) {
            $data = json_decode($data);
            foreach ($data as $key => $item) {
                if (is_string($item)) {
                    if (json_decode($item) == null) {
                        $data->key = $item;
                    } else {
                        $data->$key = json_decode($item);
                    }
                } else {
                    $data->key = $item;
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    public static function JsonDecodeRecursiveTheme($data)
    {

        if (!is_array($data) && is_string($data)) {
            $data = json_decode($data);
        }
        if (!empty($data)) {
            foreach ($data as $key => $item) {
                if (is_array($item) || is_object($item)) {
                    $data[$key] = Helpers::JsonDecodeRecursive($item);
                } else {
                    $data[$key] = json_decode($item);
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    public static function isJson($string)
    {
        return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
    }

    public static function webpConverter($extension, $path, $strFileName, $name, $quality = 80)
    {
        if ($extension !== "webp") :
            if ($extension == "jpeg" || $extension == "jpg") :
                $img = @imagecreatefromjpeg(asset("storage/" . $path));
                if (!$img) :
                    $img = imagecreatefromstring(file_get_contents(asset("storage/" . $path)));
                endif;
            elseif ($extension == "gif") :
                $img = @imagecreatefromgif(asset("storage/" . $path));
                if (!$img) :
                    $img = imagecreatefromstring(file_get_contents(asset("storage/" . $path)));
                endif;
            elseif ($extension == "png") :
                $img = @imagecreatefrompng(asset("storage/" . $path));
                if (!$img) :
                    $img = imagecreatefromstring(file_get_contents(asset("storage/" . $path)));
                endif;
            else:
                $img = imagecreatefromstring(file_get_contents(asset("storage/" . $path)));
            endif;
        endif;
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        $convert = imagewebp($img, storage_path("app/public/{$strFileName}/{$name}" . ".webp"), $quality);
        imagedestroy($img);
        if ($convert) {
            return $strFileName . "/" . $name . ".webp";
        } else {
            return $path;

        }

    }

    public static function CategoryRecrusive($categories, $lang = "tr", $langJson = "")
    {
        $html = '';
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $sub = ProductCategory::where("top_id", $category->id)->get()->toArray();
                if (!empty($sub)) {
                    $sub = Helpers::JsonDecodeRecursiveTheme1($sub);
                    $sub = Helpers::array_to_object($sub);
                    $html .= '<li class="menu-item-has-children">';
                    $html .= '<a  class="item-link" href="' . route("theme.{$langJson->routes->category}", $category->seo_url->$lang) . '">' . $category->title->$lang . '</a>';
                    $html .= '<ul>';
                    $html .= Helpers::CategoryRecrusive($sub, $lang, $langJson);
                    $html .= "</ul>";
                    $html .= '</li>';
                } else {
                    $html .= '<li>';
                    $html .= '<a  class="item-link" href="' . route("theme.{$langJson->routes->category}", $category->seo_url->$lang) . '">' . $category->title->$lang . '</a>';
                    $html .= '</li>';
                }
            }
            return $html;
        } else {
            return false;
        }
    }

    public static function MobileCategoryRecrusive($categories, $lang = "tr", $langJson = "")
    {
        $html = '';
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $sub = ProductCategory::where("top_id", $category->id)->get()->toArray();
                if (!empty($sub)) {
                    $sub = Helpers::JsonDecodeRecursiveTheme1($sub);
                    $sub = Helpers::array_to_object($sub);
                    $html .= '<li class="menu-item-has-children">';
                    $html .= '<a  class="item-link" href="' . route("theme.{$langJson->routes->category}", $category->seo_url->$lang) . '">' . $category->title->$lang . '</a>';
                    $html .= '<ul class="submenu2">';
                    $html .= Helpers::CategoryRecrusive($sub, $lang, $langJson);
                    $html .= "</ul>";
                    $html .= '</li>';
                } else {
                    $html .= '<li>';
                    $html .= '<a  class="item-link" href="' . route("theme.{$langJson->routes->category}", $category->seo_url->$lang) . '">' . $category->title->$lang . '</a>';
                    $html .= '</li>';
                }
            }
            return $html;
        } else {
            return false;
        }
    }
    public static function objectToArray(&$object)
    {
        return json_decode(json_encode($object), true);
    }
    public static function SubCategoryRecrusive($categories, $lang = "tr", $langJson = "")
    {
        $html = '';
        if (!empty($categories)) {
            foreach ($categories as $key => $category) {
                $sub = ProductCategory::where("top_id", $category->id)->get()->toArray();
                if (!empty($sub)) {
                    $sub = Helpers::JsonDecodeRecursiveTheme1($sub);
                    $sub = Helpers::array_to_object($sub);
                    $html .= '<li  class="widget_sub_categories sub_categories1">';
                    $html .= '<a href="javascript:void(0)">' . $category->title->$lang . '</a>';
                    $html .= '<ul class="widget_dropdown_categories dropdown_categories1">';
                    $html .= Helpers::SubCategoryRecrusive($sub, $lang, $langJson);
                    $html .= "</ul>";
                    $html .= '</li>';
                } else {

                    $html .= '<li>';
                    $html .= '<a href="' . route("theme.{$langJson->routes->category}", $category->seo_url->$lang) . '">' . $category->title->$lang . '</a>';
                    $html .= '</li>';
                }
            }
            return $html;
        } else {
            return false;
        }
    }

    public
    static function array_to_object($array)
    {
        $obj = new \stdClass();
        if (is_array($array) && !empty($array)) {
            foreach ($array as $k => $v) {
                if (strlen($k)) {
                    if (is_array($v)) {
                        $obj->{$k} = Helpers::array_to_object($v);
                    } else {
                        $obj->{$k} = $v;
                    }
                }
            }
        }

        return $obj;
    }

    public
    static function JsonDecodeRecursiveTheme1($data)
    {

        if (!is_array($data) && is_string($data)) {
            $data = json_decode($data);
        }
        if (!empty($data)) {
            foreach ($data as $key => $item) {
                if (!empty($old) && $old > 0) {
                    if (is_array($item) || is_object($item)) {
                        $data[$key] = Helpers::JsonDecodeRecursiveTheme1($item);
                    } else {
                        if (Helpers::isJson($item)) {
                            $data[$key] = json_decode($item);
                        } else {
                            $data[$key] = $item;
                        }
                    }
                } else {
                    if (is_array($item) || is_object($item)) {
                        $data[$key] = Helpers::JsonDecodeRecursiveTheme1($item);
                    } else {
                        if (Helpers::isJson($item)) {
                            $data[$key] = json_decode($item);
                        } else {
                            $data[$key] = $item;
                        }
                    }
                }

            }
            return $data;
        } else {
            return false;
        }
    }

    public
    static function getLang()
    {
        $lang = explode(",", \request()->server('HTTP_ACCEPT_LANGUAGE'))[0];
        $lang = explode("-", $lang)[0];
        $response = (!empty(Session::get("lang")) ? Session::get("lang") : $lang);
        return $response;
    }

    public
    static function jsonGet($id)
    {
        $item = Settings::where("id", $id)->first();
        $response = json_decode(file_get_contents(public_path("language/" . $item->language . ".json"), "r"));
        return $response;
    }

    public
    static function thisPageUrl($language, $langJson, $page)
    {
        $jsonFile = $langJson->$language;
        $url = $jsonFile->routes->$page;
        return $url;
    }

    public
    static function seoJson($data = null, $languages = null)
    {
        if (!is_array($data)) {
            $data = json_decode($data);
        }
        if (!empty($data)) {
            if (is_array($data)) {
                foreach ($languages as $key => $item) {
                    $response[$item->language] = Str::slug($data[$item->language], "-");
                }
            } else if (is_object($data)) {
                foreach ($languages as $key => $item) {
                    $lang = $item->language;
                    $response[$item->language] = Str::slug($data->$lang, "-");
                }
            } else {

                $response[$languages->language] = $data;
            }

            return json_encode($response);
        } else {
            return false;
        }
    }

    public
    static function DataTableJson($data = "")
    {
        if (!empty($data)) {
            $return = $data;
            if (!is_array($data) || !is_object($data)) {
                $data = json_decode($data, true);
            }
            $response = '<table class="table table-striped table-hover table-bordered ">';
            if (is_array($data) || is_object($data)) {
                foreach ($data as $k => $v) {
                    $response .= "<tr>";
                    $response .= "<td>" . $k . "</td><td> " . $v . " </td>";
                    $response .= "</tr>";
                }
                $response .= "</table>";
                return $response;
            } else {
                return $return;
            }
        } else {
            return false;
        }
    }

    public
    static function DataTableJsonImage($data = "")
    {
        if (!empty($data)) {
            $return = $data;
            if (!is_array($data) || !is_object($data)) {
                $data = json_decode($data, true);
            }
            $response = '<table class="table table-striped table-hover table-bordered ">';
            if (is_array($data) || is_object($data)) {
                foreach ($data as $k => $v) {
                    $response .= "<tr>";
                    $response .= "<td>" . $k . '</td><td><img class="img-fluid" style="max-width: 100px"  src="' . asset("storage/" . $v) . '"></td>';
                    $response .= "</tr>";
                }
                $response .= "</table>";
                return $response;
            } else {
                return $return;
            }
        } else {
            return false;
        }
    }

    public
    static function makeJson($array)
    {
        $makedArray = [];
        foreach ($array as $key => $value) {
            if (!is_array($value) && isJson($value)):
                $value = trim($value, '"');
            elseif (!is_array($value) && !isJson($value)):
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            else:
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            endif;
            $makedArray[$key] = $value;
        }
        return $makedArray;

    }

    public
    static function UserRole()
    {
        $controllers = [];
        $i = 0;
        foreach (Route::getRoutes()->getRoutes() as $key => $route) {
            $action = $route->getAction();

            if (array_key_exists('controller', $action) && str_contains($action["prefix"], "panel")) {
                if (!empty($action["role"])):
                    $role = $action["role"];
                else:
                    $role = "next";
                endif;
                if (!empty($action["title"])) {
                    $controllerTitle = $action["title"];
                }
                $controllerName = explode("\\", $action["controller"]);
                if (!empty($controllerName[4])) {
                    $controllerName = $controllerName[4];
                } else {
                    continue;
                }
                $methodName = explode("\\", $action["controller"]);
                if (!empty($methodName[5])) {
                    $methodName = $methodName[5];
                } else {
                    continue;
                }
                $methodName = explode("@", $methodName);
                if (!empty($methodName[1])) {
                    $methodName = $methodName[1];
                } else {
                    continue;
                }
                if (!array_key_exists(strtolower($controllerName), $controllers)):
                    $i = 0;
                    $controllers[strtolower($controllerName)]["title"] = (!empty($controllerTitle) ? $controllerTitle : $controllerName);
                    $controllers[strtolower($controllerName)][$role][$i] = $methodName;
                else:
                    $controllers[strtolower($controllerName)][$role][$i] = $methodName;
                endif;
                $i++;
            }
        }
        return $controllers;
    }

    function ObjtoArray($objOrArray = [])
    {
        foreach ($objOrArray as $key => &$value) {
            if (is_array($value) || is_object($value)) {
                ObjtoArray($value);
            } else {
                return $value;
            }
        }
    }
}
