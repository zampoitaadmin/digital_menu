<?php
namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator, Auth, Session, DB, Mail, Hash, URL, DateTime;
use Illuminate\Support\Facades\Artisan;
class HomeController extends Controller{


    public function __construct()
    {

    }
    public function index(Request $request){
        if(!Auth::check()){
            return redirect(route('logout'));
        }
        return "Under Development";
        #return view("front.views.index");
    }
    public function sso($token=null)
    {
        if(\Session::get('is_front_active') == 1){
            return redirect()->route('custom-menu');
        }
        //return "ss o manageCustomMenu Us Page";
        #return view("front.views.cart.order");
        if($token){
            $onjUserToken = new UserToken();
            $responseUserSSO = $onjUserToken->checkSSO($token);
            if($responseUserSSO){
                #$auth_details = ["id" => $responseUserSSO->user_id];
                $auth = auth()->loginUsingId($responseUserSSO->user_id);
                if($auth){
                    $loggedUser = auth()->user();
                    //$loginUserId = $loggedUser->id;
                    session(["sso_token" => $token]);
                    session(["is_admin_login" => false]);
                    session(["is_front_active" => 1]);
                    session(["login_details" => $loggedUser]);
                    return view("front.views.sso",['sso' => $token]);
                }else{
                    #$validator->getMessageBag()->add('error', __('message_lang.INVALID_CREDENTIALS'));
                    //return redirect()->back()->withErrors('NA')->withInput();
                    return view("front.views.sso",['sso' => $token]);
                }
            }else{
                //return redirect()->back()->withErrors('NA')->withInput();
                return view("front.views.sso",['sso' => $token]);
            }
        }else{
            //return redirect()->back()->withErrors('NA')->withInput();
            return view("front.views.sso",['sso' => $token]);
        }

        //return view("front.views.sso",['sso' => $token]);
        //return view("front.views.ngindex");
    }
    public function logout(Request $request){
        // $request->session()->forget(['is_front_active', 'login_details']);
        $request->session()->forget(['is_front_active', 'login_details', 'cart_user_id','userId']);
        \Session::flush();

        Auth::logout();
        // return redirect()->route('/');
        return redirect(_getLogoutUrl());
    }
}
