<?php
namespace App\Http\Controllers;
use App\Models\Admin, App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator, Auth, Session, DB, Mail, Hash, URL, DateTime;
use Illuminate\Support\Facades\Artisan;
class MenuController extends Controller{
    protected $objUser;
    public function __construct(){
        $this->objUser = new User();
    }
    public function index(Request $request){
        return "Under Development";
        #return view("front.views.index");
    }
    public function menu($slug)
    {
        $userInfo = $this->objUser->getInfoBySlug($slug);
        // _pre($userInfo);
        return view("front.views.menu", array('userInfo' => $userInfo));
    }
}
