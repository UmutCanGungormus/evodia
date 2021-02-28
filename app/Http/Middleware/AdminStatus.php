<?php

namespace App\Http\Middleware;

use App\Models\Panel\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has("admin")) {
            $admin = Admin::where("email", Session::get("admin")->email)->first();
            if (!$admin) {
                $request->session()->flash("alert",['status'=>'error',"msg"=> "Bu Sayfaya Giriş Yapabilmek İçin Giriş Yapınız.","title"=>"Hata!"]);
                return redirect()->route('panel.login');
            } else {
                return $next($request);
            }
        }else{
            $request->session()->flash("alert",['status'=>'error',"msg"=> "Bu Sayfaya Giriş Yapabilmek İçin Giriş Yapınız.","title"=>"Hata!"]);
            return redirect()->route('panel.login');
        }
    }
}
