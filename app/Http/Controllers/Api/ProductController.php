<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\UserCategory;
use App\Models\Product;
use App\Models\Allergy;
use Illuminate\Http\Request;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use stdClass;

class ProductController extends ApiController
{
    public $statusCode;
    public $status;
    public $message;
    public function __construct()
    {
        $this->status = TRUE;
        $this->statusCode = Response::HTTP_OK;
        $this->message = '';
        $this->objCategory = new Category();
        $this->objUserCategory = new UserCategory();
        $this->objProduct = new Product();
        $this->objAllergy = new Allergy();
        $this->user = JWTAuth::parseToken()->authenticate();
        $this->productMainImagePath = public_path('uploads/product/');
    }

    public function getUserSelectedCategoriesProducts($appLanguage='en'){
        $responseData= array();
        try {
            $userId = $this->user->id;
            $responseCategories = $this->objUserCategory->getUserSelectedCategories($userId);
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
                            if(!empty($productInfo->product_main_image)){
                                $responseProducts[$productKey]->productMainImageUrl = url('uploads/product/').'/'.$productInfo->product_main_image;
                            }
                            else{
                                $responseProducts[$productKey]->productMainImageUrl = "";
                            }
                            $responseProducts[$productKey]->product_price = _number_format($productInfo->product_price);
                            $responseProducts[$productKey]->product_topa = _number_format($productInfo->product_topa);
                            $responseProducts[$productKey]->product_1r = _number_format($productInfo->product_1r);
                            $responseProducts[$productKey]->product_12r = _number_format($productInfo->product_12r);
                            $responseAllergies = $this->objAllergy->getProductAllergies($productInfo->product_id);
                            $allergyIdArray = array();
                            if($responseAllergies){
                                foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                    $tempObj = new stdClass;
                                    $tempObj->id = (int)$allergyInfo->allergy_id;
                                    $tempObj->name = $allergyInfo->name;
                                    array_push($allergyIdArray, $tempObj);
                                    // array_push($allergyIdArray, (string)$allergyInfo->allergy_id);
                                }
                            }
                            $responseProducts[$productKey]->responseAllergies = $responseAllergies;
                            $responseProducts[$productKey]->allergyIdArray = $allergyIdArray;
                        }
                    }

                    $responseCategories[$key]->responseProducts = $responseProducts;
                }
                // _pre($responseCategories);
                $responseData['products'] = $responseCategories;
            }else{
                $this->status = false;
                $this->message = __('api.common_empty',['module' => __('api.module_product')]);
            }
            return response()->json([
                'status' => $this->status,
                'message' => $this->message,
                'data' => $responseData
            ], $this->statusCode);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => __('api.common_error_500'),
            ], 500);
        }
    }

    public function store(Request $request){
        // _pre($request->all());
        $data = $request->only('categoryId', 'productName', 'productDescription', 'productTopa', 'product1r', 'product12r', 'productPrice', 'allergyId', 'status');
        $validator = Validator::make($data, [
            'categoryId' => 'required',
            'productName' => 'required',
            'productDescription' => 'required',
            'productTopa' => 'required',
            'product1r' => 'required',
            'product12r' => 'required',
            'productPrice' => 'required',
            /*'allergyId' => [
                'required',function ($attribute, $value, $fail){
                    if(empty($value)){
                        $fail($attribute. ' is required.');
                    }
                    else{
                        $arr = json_decode($value, true);
                        if(is_array($arr)){
                            $value = array_filter($arr);
                            if(empty($value)){
                                $fail($attribute. ' is required.');
                            }
                        }
                        else{
                            $fail($attribute. ' is required.');
                        }
                    }
                },
            ],*/
            'status' => 'required',
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            $this->status = false;
            $this->statusCode = Response::HTTP_BAD_REQUEST;
            $this->message = _lvValidations($validator->messages()->get('*'));
            $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
            return response()->json($responseData,$this->statusCode);
        }
        $userId = $this->user->id;
        //Request is valid, create new category
        $appLanguage = trim($request->appLanguage);
        $categoryId = trim($request->categoryId);
        $productName = trim($request->productName);
        $productDescription = trim($request->productDescription);
        $productTopa = trim($request->productTopa);
        $product1r = trim($request->product1r);
        $product12r = trim($request->product12r);
        $productPrice = trim($request->productPrice);
        $allergyIdJson = ($request->allergyId);
        $allergyId = json_decode($allergyIdJson, true);
        $status = trim($request->status);
        $currentDateTime = getCurrentDateTime();
        $storeFileName = NULL;
        $productMainImage = ($request->productMainImage);
        if(!empty($productMainImage)){
            $fileName = $productMainImage->getClientOriginalName(); // 3b8ad2c7b1be2caf24321c852103598a.jpg
            $fileExtension = $productMainImage->getClientOriginalExtension(); // jpg
            $fileRealPath = $productMainImage->getRealPath(); // C:\xampp\tmp\phpAC2F.tmp
            $fileSize = $productMainImage->getSize(); // 951640
            $fileMimeType = $productMainImage->getMimeType(); // image/jpeg
            $storeFileName = time().'-'.$fileName;
            $productMainImage->move($this->productMainImagePath,$storeFileName);
        }
        $crudData = array(
            'category_id' => $categoryId,
            'user_id' => $userId,
            'product_type' => NULL,
            'product_name' => $productName,
            'product_description' => $productDescription,
            'product_main_image' => $storeFileName,
            'product_price' => $productPrice,
            'product_topa' => $productTopa,
            'product_1r' => $product1r,
            'product_12r' => $product12r,
            'product_multiple_image' => NULL,
            'product_order' => NULL,
            'status' => $status,
            'created_at' => $currentDateTime,
        );
        $createdID = $this->objProduct->createRecord($crudData);
        if($createdID){
            $productOrder = $this->objProduct->getMaxProductOrder($categoryId, $userId);
            $crudData = array( 'product_order' => $productOrder, 'updated_at' => $currentDateTime );
            $where = array('product_id' => $createdID);
            $responseUpdate = $this->objProduct->updateRecord($crudData,$where);
            if($responseUpdate){
                $insertRecords = array();
                if(!empty($allergyId)){
                    for($i=0; $i < count($allergyId); $i++){
                        $insertRecords[] = array(
                            'product_id' => $createdID,
                            'allergy_id' => $allergyId[$i]["id"],
                            'created_at' => $currentDateTime
                        );
                    }
                    $responseBulkInsert = $this->objProduct->createBulkRecord($insertRecords);
                    if($responseBulkInsert){
                    }else{
                    }
                }
            }else{
            }
            /*-----*/
            $appendCategoryIndex = NULL;
            $responseCategories = $this->objUserCategory->getUserSelectedCategories($userId);
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
                    if($categoryInfo->id == $categoryId){
                        $appendCategoryIndex = $key;
                    }
                }
            }else{
                // $this->status = false;
                // $this->message = __('api.common_empty',['module' => __('api.module_product')]);
            }
            $appendProduct = NULL;
            $responseProducts = $this->objProduct->getProductData($categoryId, $userId);
            if($responseProducts){
                foreach ($responseProducts as $productKey => $productInfo)
                {
                    if($productInfo->product_id == $createdID)
                    {   
                        $responseProducts[$productKey]->productMainImageUrl = url('uploads/product/').'/'.$productInfo->product_main_image;
                        $responseProducts[$productKey]->product_price = _number_format($productInfo->product_price);
                        $responseProducts[$productKey]->product_topa = _number_format($productInfo->product_topa);
                        $responseProducts[$productKey]->product_1r = _number_format($productInfo->product_1r);
                        $responseProducts[$productKey]->product_12r = _number_format($productInfo->product_12r);
                        $responseAllergies = $this->objAllergy->getProductAllergies($productInfo->product_id);
                        $allergyIdArray = array();
                        if($responseAllergies){
                            foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                $tempObj = new stdClass;
                                $tempObj->id = (int)$allergyInfo->allergy_id;
                                $tempObj->name = $allergyInfo->name;
                                array_push($allergyIdArray, $tempObj);
                            }
                        }
                        $responseProducts[$productKey]->responseAllergies = $responseAllergies;
                        $responseProducts[$productKey]->allergyIdArray = $allergyIdArray;
                        $appendProduct = $responseProducts[$productKey];
                    }
                }
            }
            $data = array(
                'appendCategoryIndex'=>$appendCategoryIndex,
                'appendProduct'=>$appendProduct,
            );
            /*-----*/
            $this->message = __('api.common_add',['module'=>__('api.module_product', [], $appLanguage)], $appLanguage);
        }else{
            //$this->statusCode = http_response_code(500);
            $this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $this->status = false;
            $this->message = __('api.common_add_error',['module'=> __('api.module_product', [], $appLanguage)], $appLanguage);
        }

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            'createdID' => $createdID,
            'data' => $data
            //'data' => $category
        ], Response::HTTP_OK);
    }
    // public function update(Product $product,Request $request){
    public function update(Request $request){
        // _pre($product);
        // _pre($request->all());
        // exit;
        // _pre($product->user_id);
        // if($product){
        if(1){
            $userId = $this->user->id;
            // if($product->user_id == $userId){
            if(1){
                $data = $request->only('categoryId', 'productName', 'productDescription', 'productTopa', 'product1r', 'product12r', 'productPrice', 'allergyId', 'status');
                $validator = Validator::make($data, [
                    'categoryId' => 'required',
                    'productName' => 'required',
                    'productDescription' => 'required',
                    'productTopa' => 'required',
                    'product1r' => 'required',
                    'product12r' => 'required',
                    'productPrice' => 'required',
                    /*'allergyId' => [
                        'required',function ($attribute, $value, $fail){
                            if(empty($value)){
                                $fail($attribute. ' is required.');
                            }
                            else{
                                $arr = json_decode($value, true);
                                if(is_array($arr)){
                                    $value = array_filter($arr);
                                    if(empty($value)){
                                        $fail($attribute. ' is required.');
                                    }
                                }
                                else{
                                    $fail($attribute. ' is required.');
                                }
                            }
                        },
                    ],*/
                    'status' => 'required',
                ]);
                //Send failed response if request is not valid
                if ($validator->fails()) {
                    $this->status = false;
                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                    $this->message = _lvValidations($validator->messages()->get('*'));
                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                    return response()->json($responseData,$this->statusCode);
                }
                //Request is valid, create new category
                $productId = trim($request->id);
                $product = $this->objProduct->getById($productId);
                if($product){
                    if($product->user_id == $userId){
                        $appLanguage = trim($request->appLanguage);
                        $categoryId = trim($request->categoryId);
                        $productName = trim($request->productName);
                        $productDescription = trim($request->productDescription);
                        $productTopa = trim($request->productTopa);
                        $product1r = trim($request->product1r);
                        $product12r = trim($request->product12r);
                        $productPrice = trim($request->productPrice);
                        $allergyIdJson = ($request->allergyId);
                        $allergyIdArr = json_decode($allergyIdJson, true);
                        $status = trim($request->status);
                        $productMainImage = ($request->productMainImage);
                        $currentDateTime = getCurrentDateTime();

                        $crudData = array(
                            'category_id' => $categoryId,
                            // 'user_id' => $userId,
                            'product_type' => NULL,
                            'product_name' => $productName,
                            'product_description' => $productDescription,
                            'product_price' => $productPrice,
                            'product_topa' => $productTopa,
                            'product_1r' => $product1r,
                            'product_12r' => $product12r,
                            'product_multiple_image' => NULL,
                            'status' => $status,
                            'updated_at' => $currentDateTime,
                        );
                        $where = array('product_id' => $product->product_id);

                        if( isset($productMainImage) ){
                            if( !empty($productMainImage) ){
                                if(!$productMainImage->isValid())
                                {
                                    $this->status = false;
                                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                                    $this->message = 'Error on upload file: '.$productMainImage->getErrorMessage();
                                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                                    return response()->json($responseData,$this->statusCode);
                                }

                                $fileName = $productMainImage->getClientOriginalName(); // 3b8ad2c7b1be2caf24321c852103598a.jpg
                                $fileExtension = $productMainImage->getClientOriginalExtension(); // jpg
                                $fileRealPath = $productMainImage->getRealPath(); // C:\xampp\tmp\phpAC2F.tmp
                                $fileSize = $productMainImage->getSize(); // 951640
                                $fileMimeType = $productMainImage->getMimeType(); // image/jpeg

                                $storeFileName = time().'-'.$fileName;
                                $productMainImage->move($this->productMainImagePath,$storeFileName);

                                $crudData["product_main_image"] = $storeFileName;

                                if(!empty($product->product_main_image)){
                                    $currentProductMainImage = $product->product_main_image;
                                    @unlink($this->productMainImagePath.$currentProductMainImage);
                                }
                            }
                        }
                        
                        $responseUpdate = $this->objProduct->updateRecord($crudData,$where);
                        if($responseUpdate){
                            $currAllergyIdArr = $this->objProduct->getProductAllergyIds($product->product_id);
                            $allergyId=array();
                            if(!empty($allergyIdArr)) foreach ($allergyIdArr as $key => $value) array_push($allergyId, $value["id"]);
                            $newAllergyIdArr = array_map('intval', $allergyId);
                            $needDeleteArr = array_diff($currAllergyIdArr,$newAllergyIdArr);
                            $needInsertArr = array_diff($newAllergyIdArr,$currAllergyIdArr);
                            if(!empty($needDeleteArr)){
                                $needDeleteArr = array_values(array_filter($needDeleteArr));
                                $this->objProduct->deleteProductAllergy($product->product_id, $needDeleteArr); // Delete
                            }
                            if(!empty($needInsertArr)){
                                $needInsertArr = array_values(array_filter($needInsertArr));
                                $insertRecords = array();
                                for($i=0; $i < count($needInsertArr); $i++){
                                    $insertRecords[] = array(
                                        'product_id' => $product->product_id,
                                        'allergy_id' => $needInsertArr[$i],
                                        'created_at' => $currentDateTime
                                    );
                                }
                                $responseBulkInsert = $this->objProduct->createBulkRecord($insertRecords); // Insert
                                if($responseBulkInsert){
                                }else{
                                }
                            }
                            $responseProduct = $this->objProduct->getProductInfo($product->product_id);
                            if($responseProduct){
                                if(!empty($responseProduct->product_main_image)){
                                    $responseProduct->productMainImageUrl = url('uploads/product/').'/'.$responseProduct->product_main_image;
                                }
                                else{
                                    $responseProduct->productMainImageUrl = "";
                                }
                                $responseProduct->product_price = _number_format($responseProduct->product_price);
                                $responseProduct->product_topa = _number_format($responseProduct->product_topa);
                                $responseProduct->product_1r = _number_format($responseProduct->product_1r);
                                $responseProduct->product_12r = _number_format($responseProduct->product_12r);
                                $responseAllergies = $this->objAllergy->getProductAllergies($responseProduct->product_id);
                                $allergyIdArray = array();
                                if($responseAllergies){
                                    foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                        $tempObj = new stdClass;
                                        $tempObj->id = (int)$allergyInfo->allergy_id;
                                        $tempObj->name = $allergyInfo->name;
                                        array_push($allergyIdArray, $tempObj);
                                        // array_push($allergyIdArray, (string)$allergyInfo->allergy_id);
                                    }
                                }
                                $responseProduct->responseAllergies = $responseAllergies;
                                $responseProduct->allergyIdArray = $allergyIdArray;
                            }
                            $this->message = __('api.common_update',['module'=> __('api.module_product', [], $appLanguage)], $appLanguage);
                        }else{
                            $this->status = false;
                            $this->message = __('api.common_update_error',['module'=> __('api.module_product', [], $appLanguage)], $appLanguage);
                        }
                    }
                    else{
                        $this->status = false;
                        $this->message = __('api.common_error_access_denied', [], $appLanguage);
                    }
                }
                else{
                    #$this->statusCode = Response::HTTP_NOT_FOUND;
                    $this->status = false;
                    $this->message = __('api.common_not_found',['module'=> __('api.module_product', [], $appLanguage)], $appLanguage);
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied', [], $appLanguage);
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_product', [], $appLanguage)], $appLanguage);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            'data' => $responseProduct,
        ], $this->statusCode);
    }
    public function destroy(Product $product, $appLanguage='en')
    {
        if($product){
            $userId = $this->user->id;
            if($product->user_id == $userId){
                $categoryId = $product->category_id;
                if(!empty($product->product_main_image)){
                    $currentProductMainImage = $product->product_main_image;
                    @unlink($this->productMainImagePath.$currentProductMainImage);
                }
                $responseDelete = $product->delete();
                $this->objProduct->deleteRecordByProductId($product->product_id);
                $responseProducts = $this->objProduct->getProductData($categoryId, $userId);
                if($responseProducts){
                    foreach ($responseProducts as $productKey => $productInfo)
                    {
                        $responseProducts[$productKey]->product_price = _number_format($productInfo->product_price);
                        $responseProducts[$productKey]->product_topa = _number_format($productInfo->product_topa);
                        $responseProducts[$productKey]->product_1r = _number_format($productInfo->product_1r);
                        $responseProducts[$productKey]->product_12r = _number_format($productInfo->product_12r);
                        $responseAllergies = $this->objAllergy->getProductAllergies($productInfo->product_id);
                        $allergyIdArray = array();
                        if($responseAllergies){
                            foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                array_push($allergyIdArray, (string)$allergyInfo->allergy_id);
                            }
                        }
                        $responseProducts[$productKey]->responseAllergies = $responseAllergies;
                        $responseProducts[$productKey]->allergyIdArray = $allergyIdArray;
                    }
                }
                $this->message = __('api.common_delete',['module'=> __('api.module_product',[],$appLanguage)],$appLanguage);
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied',[],$appLanguage);
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_product', [], $appLanguage)], $appLanguage);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            'data' => $responseProducts
        ], $this->statusCode);
        //$product->delete();

        /*return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], Response::HTTP_OK);*/
    }
    /*public function storeProductImage(Request $request){
        $data = $request->only('productId', 'productMainImage');

        $validator = Validator::make($data, [
            'productId' => 'required',
            'productMainImage' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            $this->status = false;
            $this->statusCode = Response::HTTP_BAD_REQUEST;
            $this->message = _lvValidations($validator->messages()->get('*'));
            $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
            return response()->json($responseData,$this->statusCode);
        }

        $productId = $request->productId;
        $product = $this->objProduct->getById($productId);
        if($product){
            $userId = $this->user->id;
            
            if($product->user_id == $userId){
                $productMainImage = $request->file('productMainImage');
        
                if (!$productMainImage->isValid()) {
                    $this->status = false;
                    $this->statusCode = Response::HTTP_BAD_REQUEST;
                    $this->message = 'Error on upload file: '.$image->getErrorMessage();
                    $responseData = array('status'=>$this->status,'message'=>$this->message,'statusCode'=>$this->statusCode,'data'=>array());
                    return response()->json($responseData,$this->statusCode);
                }

                if(!empty($product->product_main_image)){
                    $currentProductMainImage = $product->product_main_image;
                    $productFolderPath = $this->productMainImagePath;
                    @unlink($productFolderPath.$currentProductMainImage);
                }

                $fileName = $productMainImage->getClientOriginalName(); // 3b8ad2c7b1be2caf24321c852103598a.jpg
                $fileExtension = $productMainImage->getClientOriginalExtension(); // jpg
                $fileRealPath = $productMainImage->getRealPath(); // C:\xampp\tmp\phpAC2F.tmp
                $fileSize = $productMainImage->getSize(); // 951640
                $fileMimeType = $productMainImage->getMimeType(); // image/jpeg
                $storeFileName = time().'-'.$fileName;
                $destinationPath = 'uploads/product';
                $productMainImage->move($destinationPath,$storeFileName);

                $currentDateTime = getCurrentDateTime();
                $crudData = array( 'product_main_image' => $storeFileName, 'updated_at' => $currentDateTime );
                $where = array('product_id' => $productId);
                $responseUpdate = $this->objProduct->updateRecord($crudData,$where);
                if($responseUpdate){

                    $responseProduct = $this->objProduct->getProductInfo($product->product_id);
                    if($responseProduct){

                        $productMainImageList = [];
                        $productMainImage = $responseProduct->product_main_image;
                        if(!empty($productMainImage)){
                            $filePath = $this->productMainImagePath.$productMainImage;
                            if(file_exists($filePath)){
                                $size = filesize($filePath);
                                $fileUrl = url('uploads/product/').'/'.$productMainImage;
                                $productMainImageList[] = ['name'=>$productMainImage, 'size'=>$size, 'path'=>$filePath, 'url'=>$fileUrl, 'id'=>$responseProduct->product_id];
                            }
                        }

                        $responseProduct->productMainImageList = $productMainImageList;
                        $responseProduct->product_price = _number_format($responseProduct->product_price);
                        $responseProduct->product_topa = _number_format($responseProduct->product_topa);
                        $responseProduct->product_1r = _number_format($responseProduct->product_1r);
                        $responseProduct->product_12r = _number_format($responseProduct->product_12r);
                        $responseAllergies = $this->objAllergy->getProductAllergies($responseProduct->product_id);
                        $allergyIdArray = array();
                        if($responseAllergies){
                            foreach ($responseAllergies as $allergyKey => $allergyInfo){
                                array_push($allergyIdArray, (string)$allergyInfo->allergy_id);
                            }
                        }
                        $responseProduct->responseAllergies = $responseAllergies;
                        $responseProduct->allergyIdArray = $allergyIdArray;
                    }

                    $this->message = __('api.common_add',['module'=>__('api.module_product')]);
                }else{
                    $this->status = false;
                    $this->message = __('api.common_add_error',['module'=> __('api.module_product')]);
                }
            }
            else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }
        else{
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
        }

        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            'data' => $responseProduct,
        ], $this->statusCode);
    }*/
    public function updateUserCategoryProductOrder(Request $request){
        /*Array
        (
            [categoryId] => 11
            [newProductOrder] => Array
                (
                    [0] => 511
                    [1] => 513
                    [2] => 512
                )

        )*/
        $data = $request->only('categoryId','newProductOrder');
        // TODO: Validation
        $userId = $this->user->id;
        $categoryId = $request->categoryId;
        $newProductOrder = $request->newProductOrder;
        if(isset($newProductOrder) && !empty($newProductOrder)){
            foreach ($newProductOrder as $key => $productId) {
                $productOrder = ($key+1);
                $crudData = array(
                    'product_order' => $productOrder,
                    'updated_at' => getCurrentDateTime()
                );
                $where = array( 'user_id' => $userId, 'category_id' => $categoryId, 'product_id' => $productId );
                $this->objProduct->updateRecord($crudData,$where);
            }
            $this->message = __('api.common_update',['module'=> __('api.module_product')]);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
            //'data' => $category
        ], Response::HTTP_OK);
    }
    public function removeProductMainImage(Product $product){
        if($product){
            $userId = $this->user->id;
            if($product->user_id == $userId){
                $currentDateTime = getCurrentDateTime();
                $currentProductMainImage = $product->product_main_image;
                if(!empty($product->product_main_image)){
                    $where = array(
                        'product_id' => $product->product_id,
                    );
                    $crudData = array(
                        'product_main_image' => NULL,
                        'updated_at' => $currentDateTime,
                    );
                    $responseUpdate = $this->objProduct->updateRecord($crudData,$where);
                    if($responseUpdate){
                        if(!empty($product->product_main_image)){
                            @unlink($this->productMainImagePath.$currentProductMainImage);
                        }
                        $this->message = __('api.common_update',['module'=> __('api.module_product')]);
                    }
                    else{
                        $this->status = false;
                        $this->message = __('api.common_update_error',['module'=> __('api.module_product')]);
                    }
                }
                else{
                    $this->status = false;
                    $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
                }
            }else{
                $this->status = false;
                $this->message = __('api.common_error_access_denied');
            }
        }else{
            #$this->statusCode = Response::HTTP_NOT_FOUND;
            $this->status = false;
            $this->message = __('api.common_not_found',['module'=> __('api.module_product')]);
        }
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'statusCode' => $this->statusCode,
        ], $this->statusCode);
    }
}
