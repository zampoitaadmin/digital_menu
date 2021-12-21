<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Product;
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

class AboutController extends Controller
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
        $this->objCart = new Cart();
        $this->objProducts = new Product();
        $this->status = TRUE;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        #Log::channel('placeOrder')->info('Before Request Data : ',['cardDetail' => $cartDetail ]);
    }

    public function index(Request $request)
    {
        return "About Us Page";
        #return view("front.views.cart.order");
    }
}