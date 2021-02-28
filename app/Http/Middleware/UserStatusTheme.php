<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Models\Theme\Settings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserStatusTheme
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
        $lang = Helpers::getLang();
        $languages = Settings::where("isActive", 1)->where("language", $lang)->first();
        $json = Helpers::jsonGet($languages->id);
        if (!Session::has("user")) {
            $request->session()->flash("alert", ['status' => 'error', "msg" => $json->alert->no_status, "title" => $json->alert->error]);
            return redirect()->back();
        } else {
            return $next($request);
        }
    }
}
