<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
#use PixelCaffeine\Logs\Entity\Log;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\Rule;
use Validator;
use Auth;
use Session;
use DB;
use Hash;
use Mail;

#use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Models\UserCategory, App\Models\Category;
class CustomMenuController extends Controller
{

    protected $objCategory;
    protected $objProducts;
    public $currency;
    public $userId;
    public $statusCode;
    public $status;
    public $message;
    protected $stripeLib;


    public function __construct()
    {
        #parent::__construct();
        $this->currency = config('constants.currency');//'£';
        #$this->objCart = new Cart();
        //$this->objProducts = new Product();
        $this->status = TRUE;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        #Log::channel('placeOrder')->info('Before Request Data : ',['cardDetail' => $cartDetail ]);
    }

    public function index(Request $request)
    {
        return "manageCustomMenu Us Page";
        #return view("front.views.cart.order");
    }

    public function manageCustomMenu(Request $request,$type=null)
    {
        /*if(!Auth::check()){
            return redirect(route('logout'));
        }*/
        return view("front.views.custom-menu.custom-menu");
    }

    /*public function test1()
    {
        // chooseCategory code
        $userId = 2930;
        $objUserCategory = new UserCategory();
        $currCategoryIdArr = $objUserCategory->getUserSelectedCategoryIds($userId);
        $newCategoryIdArr = [69, 38, 63, 64, 72, 11, 12, 22, 1, 2];
        
        $needDeleteArr = array_diff($currCategoryIdArr,$newCategoryIdArr);
        $needInsertArr = array_diff($newCategoryIdArr,$currCategoryIdArr);

        $objUserCategory->deleteUserCategory($userId, $needDeleteArr);

        $currentDateTime = getCurrentDateTime();
        foreach($needInsertArr as $key => $categoryId)
        {
            $crud = array(
                'user_id' => $userId,
                'category_id' => $categoryId,
                'created_at' => $currentDateTime
            );
            $objUserCategory->insertUserCategory($crud);
        }
    }*/

    /*public function test2()
    {
        addCategory
        -category name unique for both english and spanish
        -category name required
        -
        $userId = 2930;
        $objCategory = new Category();
        $objUserCategory = new UserCategory();
        $currentDateTime = getCurrentDateTime();
        $crud = array(
            'user_id' => $userId,
            'name' => $categoryNameEn,
            'spanish' => $categoryNameSp,
            'status' => 'active',
            'created_on' => $currentDateTime,
            'created_by' => $userId,
        );
        $categoryId = $objCategory->insertCategory($crud);
        $newUserCategoryOrder = $objUserCategory->getNewUserCategoryOrder($userId);
        $crud = array(
            'user_id' => $userId,
            'category_id' => $categoryId,
            'user_category_order' => $newUserCategoryOrder,
            'created_at' => $currentDateTime,
        );
        $objUserCategory->insertUserCategory($crud);
    }*/
}