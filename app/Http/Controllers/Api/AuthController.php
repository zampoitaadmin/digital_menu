<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use JWTAuth;
use App\Models\User, App\Models\MenuBranding, App\Models\UserCategory, App\Models\Allergy, App\Models\Product;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use DB, stdClass;

class AuthController extends ApiController
{
    public $statusCode;
    public $status;
    public $message;
    public function __construct()
    {
        $this->status = TRUE;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        $this->objUser = new User();
        $this->objMenuBranding = new MenuBranding();
        $this->objUserCategory = new UserCategory();
        $this->objAllergy = new Allergy();
        $this->objProduct = new Product();
        $this->productMainImageUrl = url('uploads/product/');
        $this->productFixedStarterUrl = url('uploads/product_fixed/starter/');
        $this->productFixedCourseUrl = url('uploads/product_fixed/course/');
        $this->productFixedDesertUrl = url('uploads/product_fixed/desert/');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('sso');

        //valid credential
        $validator = Validator::make($credentials, [
            'sso' => 'required'
        ]);

          /*

            */
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        /*$user = User::where('email', '=', $credentials['email'])->first();
        #dd($user );
        $jwt_token = JWTAuth::customClaims([])->fromUser($user);
        #_pre($jwt_token);
        //$jwt_token = JWTAuth::fromUser($user,$payloadable);
        return response()->json([
            'success' => true,
            #'data' => array('userData'=>$loginUserDetail),
            'data' => $user,
            'token' => @$jwt_token,
        ]);*/

        #_pre($credentials);
        //Request is validated
        //Crean token
        $token = '';
        try {
            $onjUserToken = new UserToken();
            $responseUserSSO = $onjUserToken->checkSSO($credentials['sso']);
            if($responseUserSSO){
                $responseUser = User::where('id', '=', $responseUserSSO->user_id)->first();
                if($responseUser){
                    $token = JWTAuth::customClaims([])->fromUser($responseUser);
                    //Token created, return with success response and jwt token
                    return response()->json([
                        'success' => true,
                        'token' => $token,
                    ]);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => __('api.api_credentials_invalid'),
                    ], 400);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => __('api.api_credentials_invalid'),
                ], 400);
            }
            /*if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }*/
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => __('api.common_error_500'),
            ], 500);
        }


    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

    public function getMenu(User $user, $appLanguage='en'){
        $appLanguage = _getAppLang();
        $responseData= array();
        try {
            if($user){
                // $userId = $this->user->id;
                // _pre($user);
                $userId = $user->id;
                $attachmentArray = json_decode($user->attachment, true);

                $responseBranding = $this->objMenuBranding->getOneByUserId($userId);
                if($responseBranding){
                    unset($responseBranding->user_id);
                    if(!empty($responseBranding->brand_logo)){
                        $responseBranding->brandLogoUrl = url('uploads/menu_branding/').'/'.$responseBranding->brand_logo;
                    }
                    else if( !empty($attachmentArray) && !empty(@$attachmentArray['logo']) ){
                        $responseBranding->brandLogoUrl = _getHomeUrl('assets/uploads/merchant/').$userId.'/'.$attachmentArray['logo'];
                    }
                    else{
                        $responseBranding->brandLogoUrl = "";
                    }
                }

                // DB::enableQueryLog();
                $responseCategories = $this->objUserCategory->getUserSelectedCategories1($userId);
                // _pre(DB::getQueryLog());
                if($responseCategories){
                    foreach($responseCategories as $key => $categoryInfo)
                    {
                        $responseCategories[$key]->originalName = $categoryInfo->name;
                        if($appLanguage=="en"){
                            $responseCategories[$key]->name = $categoryInfo->name;
                        }
                        else if($appLanguage=="es"){
                            $responseCategories[$key]->name = $categoryInfo->spanish;
                        }
                        
                        $responseCategories[$key]->slug = _generateSeoURL($categoryInfo->name);
                        $responseProducts = $this->objProduct->getProductData($categoryInfo->category_id, $userId);

                        if($responseProducts){
                            foreach ($responseProducts as $productKey => $productInfo)
                            {
                                if($categoryInfo->category_type == "Normal"){
                                    if(!empty($productInfo->product_main_image)){
                                        $responseProducts[$productKey]->productMainImageUrl = $this->productMainImageUrl.'/'.$productInfo->product_main_image;
                                    }
                                    else{
                                        $responseProducts[$productKey]->productMainImageUrl = "";
                                    }
                                }
                                else if($categoryInfo->category_type == "Fixed"){
                                    if($productInfo->product_type == "starter"){
                                        if(!empty($productInfo->product_main_image)){
                                            $responseProducts[$productKey]->productMainImageUrl = $this->productFixedStarterUrl.'/'.$productInfo->product_main_image;
                                        }
                                        else{
                                            $responseProducts[$productKey]->productMainImageUrl = "";
                                        }
                                    }
                                    else if($productInfo->product_type == "course"){
                                        if(!empty($productInfo->product_main_image)){
                                            $responseProducts[$productKey]->productMainImageUrl = $this->productFixedCourseUrl.'/'.$productInfo->product_main_image;
                                        }
                                        else{
                                            $responseProducts[$productKey]->productMainImageUrl = "";
                                        }
                                    }
                                    else if($productInfo->product_type == "desert"){
                                        if(!empty($productInfo->product_main_image)){
                                            $responseProducts[$productKey]->productMainImageUrl = $this->productFixedDesertUrl.'/'.$productInfo->product_main_image;
                                        }
                                        else{
                                            $responseProducts[$productKey]->productMainImageUrl = "";
                                        }
                                    }
                                }
                                if(!empty($productInfo->product_description)){
                                    $responseProducts[$productKey]->product_description = mb_strimwidth($productInfo->product_description, 0, 97, '...');
                                }
                                $responseProducts[$productKey]->product_price = _number_format($productInfo->product_price);
                                $responseProducts[$productKey]->product_topa = _number_format($productInfo->product_topa);
                                $responseProducts[$productKey]->product_1r = _number_format($productInfo->product_1r);
                                $responseProducts[$productKey]->product_12r = _number_format($productInfo->product_12r);
                                $responseAllergies = $this->objAllergy->getProductAllergies($productInfo->product_id);
                                if($responseAllergies){
                                    foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                        $responseAllergies[$allergyKey]->originalName = $allergyInfo->name;
                                        if($appLanguage=="en"){
                                            $responseAllergies[$allergyKey]->name = $allergyInfo->name;
                                        }
                                        else if($appLanguage=="es"){
                                            $responseAllergies[$allergyKey]->name = $allergyInfo->spanish;
                                        }
                                    }
                                }
                                $responseProducts[$productKey]->responseAllergies = $responseAllergies;
                            }
                        }

                        $responseCategories[$key]->responseProducts = $responseProducts;
                    }
                    // _pre($responseCategories);
                }

                $responseAllergies = $this->objAllergy->getAllAllergies();
                if($responseAllergies){
                    foreach ($responseAllergies as $key => $value) {
                        $responseAllergies[$key]->originalName = $value->name;
                        if($appLanguage=="en"){
                            $responseAllergies[$key]->name = $value->name;
                        }
                        else if($appLanguage=="es"){
                            $responseAllergies[$key]->name = $value->spanish;
                        }
                    }
                }

                $responseData = array(
                    'userInfo' => $user,
                    'branding' => $responseBranding,
                    'categories' => $responseCategories,
                    // 'allAllergies' => $responseAllergies,
                );
                // _pre($responseData);
                return response()->json([
                    'status' => $this->status,
                    'message' => $this->message,
                    'data' => $responseData
                ], $this->statusCode);
            }
            else{
                $this->status = false;
                $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => __('api.common_error_500'),
            ], 500);
        }
    }

    public function searchItem(Request $request)
    {
        // _pre($request->all());
        $data = $request->only('slug', 'searchText');
        $validator = Validator::make($data, [
            'slug' => 'required',
        ]);
        if ($validator->fails()) {
            $this->status = false;
            $this->statusCode = Response::HTTP_BAD_REQUEST;
            $this->message = _lvValidations($validator->messages()->get('*'));
            $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
            return response()->json($responseData,$this->statusCode);
        }
        $slug = $request->slug;
        $searchText = $request->searchText;
        $appLanguage = _getAppLang();
        $responseData= array();
        try {
            $user = $this->objUser->getInfoBySlug($slug);
            if($user){
                // _pre($user);
                $userId = $user->id;
                $responseBranding = $this->objMenuBranding->getOneByUserId($userId);
                if($responseBranding){
                    unset($responseBranding->user_id);
                    if(!empty($responseBranding->brand_logo)){
                        $responseBranding->brandLogoUrl = url('uploads/menu_branding/').'/'.$responseBranding->brand_logo;
                    }
                    else{
                        $responseBranding->brandLogoUrl = "";
                    }
                }
                
                $responseCategories = $this->objUserCategory->getUserSelectedCategories1($userId);
                $categoryIdsArray = array();
                if($responseCategories){
                    foreach($responseCategories as $key => $categoryInfo){
                        array_push($categoryIdsArray, $categoryInfo->category_id);
                    }
                    $responseProducts = $this->objProduct->searchProduct($categoryIdsArray, $userId, $searchText);
                    if($responseProducts){
                        foreach($responseCategories as $key => $categoryInfo)
                        {
                            $responseCategories[$key]->originalName = $categoryInfo->name;
                            if($appLanguage=="en"){
                                $responseCategories[$key]->name = $categoryInfo->name;
                            }
                            else if($appLanguage=="es"){
                                $responseCategories[$key]->name = $categoryInfo->spanish;
                            }
                            
                            $responseCategories[$key]->slug = _generateSeoURL($categoryInfo->name);

                            $responseCategories[$key]->responseProducts = array();
                            $productArr = $this->_objectArraySearch($responseProducts, 'category_id', $categoryInfo->category_id, $categoryInfo);
                            $responseCategories[$key]->responseProducts = $productArr;
                        }
                        $responseData = array(
                            'categories' => $responseCategories,
                        );
                        // _pre($responseData);
                        return response()->json([
                            'status' => $this->status,
                            'message' => $this->message,
                            'data' => $responseData
                        ], $this->statusCode);
                    }
                    else{
                        $this->status = false;
                        $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
                    }
                }
                else{
                    $this->status = false;
                    $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
                }
            }
            else{
                $this->status = false;
                $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => __('api.common_error_500'),
            ], 500);
        }
    }

    public function _objectArraySearch($array, $index, $value, $categoryInfo)
    {
        $appLanguage = _getAppLang();
        $productArr = array();
        foreach($array as $key => $arrayInf) {
            if($arrayInf->{$index} == $value) {
                if($categoryInfo->category_type == "Normal"){
                    if(!empty($arrayInf->product_main_image)){
                        $arrayInf->productMainImageUrl = $this->productMainImageUrl.'/'.$arrayInf->product_main_image;
                    }
                    else{
                        $arrayInf->productMainImageUrl = "";
                    }
                }
                else if($categoryInfo->category_type == "Fixed"){
                    if($arrayInf->product_type == "starter"){
                        if(!empty($arrayInf->product_main_image)){
                            $arrayInf->productMainImageUrl = $this->productFixedStarterUrl.'/'.$arrayInf->product_main_image;
                        }
                        else{
                            $arrayInf->productMainImageUrl = "";
                        }
                    }
                    else if($arrayInf->product_type == "course"){
                        if(!empty($arrayInf->product_main_image)){
                            $arrayInf->productMainImageUrl = $this->productFixedCourseUrl.'/'.$arrayInf->product_main_image;
                        }
                        else{
                            $arrayInf->productMainImageUrl = "";
                        }
                    }
                    else if($arrayInf->product_type == "desert"){
                        if(!empty($arrayInf->product_main_image)){
                            $arrayInf->productMainImageUrl = $this->productFixedDesertUrl.'/'.$arrayInf->product_main_image;
                        }
                        else{
                            $arrayInf->productMainImageUrl = "";
                        }
                    }
                }
                if(!empty($arrayInf->product_description)){
                    $arrayInf->product_description = mb_strimwidth($arrayInf->product_description, 0, 97, '...');
                }
                $allergies = array();
                $allergies = $this->objAllergy->getProductAllergies($arrayInf->product_id);
                if($allergies){
                    foreach ($allergies as $allergyKey => $allergyValue) {
                        $allergies[$allergyKey]->originalName = $allergyValue->name;
                        if($appLanguage=="en"){
                            $allergies[$allergyKey]->name = $allergyValue->name;
                        }
                        else if($appLanguage=="es"){
                            $allergies[$allergyKey]->name = $allergyValue->spanish;
                        }
                    }
                }
                $arrayInf->responseAllergies = $allergies;
                array_push($productArr, $arrayInf);
            }
        }
        return $productArr;
    }           
}