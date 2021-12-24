<?php
namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator, Auth, Session, DB, Mail, Hash, URL, DateTime;
use Illuminate\Support\Facades\Artisan;
class MenuController extends Controller{


    public function __construct()
    {

    }
    public function index(Request $request){
        return "Under Development";
        #return view("front.views.index");
    }
    public function menu($slug)
    {
        return view("front.views.menu");
    }
}
