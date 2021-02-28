<?php

namespace App\Http\Controllers\Panel\Home;

use App\Http\Controllers\Controller;
use App\Models\Panel\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class indexController extends Controller
{
    public $viewData;

    public function __construct(Session $session ,Request $request)
    {
        $this->viewData = new \stdClass();
        $this->viewData->admin=Session::get("admin");
        $this->viewData->segment = $request->segment(2);

    }

    public function index(){
        $this->viewData->page=new \stdClass();
        $this->viewData->page->title="Anasayfa";
        $this->viewData->page->description="Bu Sayfada Sitenizin İstatistiklerini Görebilirsiniz.";
        $this->viewData->settings = Settings::where("isActive", 1)->first();
        return view("panel.dashboard.index")->with("data",$this->viewData);
    }
}
