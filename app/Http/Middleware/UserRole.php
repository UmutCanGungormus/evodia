<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Models\Panel\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty($request->route()->action["role"])) {
            $url = explode(".", $request->route()->action["as"]);
            $c = count($url);
            $controllerName = strtolower($url[$c - 2]);
            $user = Admin::where("id", Session::get("admin")->id)->first();
            $data = json_decode($user->Adminrole->permissions);
            $role = $request->route()->action["role"];
            if ($data->$controllerName->$role == "on") {
                return $next($request);
            } else {
                if ($request->ajax()):
                    return response()->json(["success" => false, "title" => "Başarısız!", "msg" => "Bu İşlemi Yapma Yetkiniz Yoktur."], 200, [], JSON_UNESCAPED_UNICODE);
                else:
                    $request->session()->flash("alert", ['status' => 'error', "msg" => "Bu Sayfaya Giriş Yetkiniz Yoktur.", "title" => "Hata!"]);
                    return redirect()->back();
                endif;
            }
        } else {
            return $next($request);
        }


    }
}
